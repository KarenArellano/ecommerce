<?php

namespace App\Http\Controllers\Landing;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        return view('landing.account.index', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'password' => $request->has('updates_password') ? ['required', 'string', 'min:8', 'confirmed'] : ['nullable'],
        ]);

        return DB::transaction(function () use ($request) {
            $request->user()->update(
                $request->merge([
                    'password' => $request->has('updates_password') ? bcrypt($request->password) : $request->user()->password,
                ])->only([
                    'first_name', 'last_name', 'email', 'password',
                ])
            );

            Session::flash('userStatus', 'La información de tu cuenta se ha actualizado'); 

            return back();
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        return DB::transaction(function () use ($request) {
            $user = $request->user();

            if (Hash::check($request->password, $user->password)) {
                $timestamp = now();

                $user->update([
                    'email' => "deleted-$timestamp-$user->email",
                ]);

                $user->delete();

                return redirect()->to('/');
            }

            return redirect(route('landing.account.index') . '#security')->withInput()->with('status-danger-password', trans('validation.password'));
        });
    }
}
