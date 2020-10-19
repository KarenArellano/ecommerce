<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
     */

    use ResetsPasswords;

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @return string
     */
    protected function redirectTo()
    {
        return auth()->user()->is_administrator ? url('dashboard') : url('/');
    }
}
