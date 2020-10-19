<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @return string
     */
    protected function redirectTo()
    {
        return auth()->user()->is_administrator ? url('dashboard') : url('/');
    }

    /**
     * Override logout method and redirect to Shop
     *
     * @return redirect
     */
    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
