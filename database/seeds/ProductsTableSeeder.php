<?php

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 15)->create()->each(function ($product) {
            $product->categories()->attach(
                Category::inRandomOrder()->take(
                    random_int(1, 3)
                )->pluck('id')
            );
        });
    }
}
