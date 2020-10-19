<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Product instance
     *
     * @var App\Models\Product
     */
    protected $product;

    /**
     * Creates a new controler instance
     *
     * @param App\Models\Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->latest()->get();

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::latest()->get();

        return view('dashboard.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:products,name,NULL,id,deleted_at,NULL'], 
            'description' => ['required', 'string', 'max:255'],
            'unit_price' => ['required', 'numeric', 'min:1'],
            'price' => ['required', 'numeric', 'min:1', 'gte:unit_price'],
            'track_stock' => ['nullable', 'boolean'],
            'stock' => ['nullable', 'numeric', 'min:1'],
            'related' => ['nullable', 'array'],
            'cover_image' => ['required', 'image', 'max:5000'],
            'categories_id' => ['nullable', 'array']
        ]);

        return DB::transaction(function () use ($request) {
            $product = $this->product->create($request->all());

            $product->cover()->create([
                'url' => $request->file('cover_image')->store(config('app.env') . '/products', 'gcs'),
            ]);

            $product->categories()->sync($request->input('categories_id', []));

            return redirect()->route('dashboard.products.edit', $product);
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::latest()->get();

        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // dd($request);

        $request->validate([
            'name' => ['filled', 'string', 'max:255', "unique:products,name,$product->id,id,deleted_at,NULL"],
            'description' => ['filled', 'string', 'max:255'],
            'unit_price' => ['filled', 'numeric', 'min:1'],
            'price' => ['filled', 'numeric', 'min:1', 'gte:unit_price'],
            'track_stock' => ['nullable', 'boolean'],
            'stock' => ['nullable', 'numeric', 'min:1'],
            'related' => ['nullable', 'array'],
            'cover_image' => ['filled', 'image', 'max:5000'],
            'categories_id' => ['filled', 'array'],
            'images.*' => ['filled', 'image'],
            'videos.*' => ['filled', 'mimetypes:video/*'],
        ]);

        return DB::transaction(function () use ($request, $product) {

            if ($request->has('images')) {
                foreach ($request->file('images') as $key => $image) {
                    $product->gallery()->create([
                        'position' => $key,
                        'url' => $image->store(config('app.env') . '/products', 'gcs'),
                    ]);
                }

                return $product->fresh()->images;
            }

            if ($request->has('videos')) {

                Log::info("On videos");

                foreach ($request->file('videos') as $key => $video) {

                    Log::info("On create videos");

                    $product->gallery()->create([
                        'position' => $key,
                        'url' => $video->store(config('app.env') . '/products', 'gcs'),
                        'mimetype' => 'video'
                    ]);
                }

                return $product->fresh()->images;
            }

            if ($request->hasFile('cover_image')) {

                app('filesystem')->cloud()->delete($product->cover->url);

                $product->cover()->update([
                    'url' => $request->file('cover_image')->store(config('app.env') . '/products', 'store'),
                ]);

            }

            $product->categories()->sync($request->input('categories_id', []));

            $product->update(
                $request->merge([
                    'track_stock' => $request->has('track_stock'),
                    'stock' => $request->has('track_stock') ? $request->stock : null,
                ])->all()
            );

            return redirect()->route('dashboard.products.index');
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        return DB::transaction(function () use ($request, $product) {
            if ($request->has('image')) {
                $image = $product->gallery()->where('id', $request->image)->first();

                app('filesystem')->cloud()->delete($image->url);

                $image->delete();

                return $product->fresh()->gallery;
            }

            $product->categories->each->delete();

            $product->delete();

            return redirect()->route('dashboard.products.index');
        });
    }
}
