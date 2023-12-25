<?php

namespace App\Http\Controllers\Auth;
// ssh password:y%EUbuAhj6P3JX+*
//THE ACTUL KEY: ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQCgpTxxfD0dK9TB0kTb0pXE4RlwVB0OMHT7chsd+wMyQ1cG6QyHTSd361ZpTKrPShiCbuIrIcqv+CaydKfIktMvGG608CJukBV/q6/0hpmywwhqrbQNiyEGs+prDAw39uIVjOyp9KmASeEnkQNMD5LVvetG7/t7uRio35VknkYKb0ptmqefzSshLeTH3HjKk973xTkEnI/5VtjIiRf47FbkcRbt8z3gGPh0x/GXHFRC27q2HVuo1Bu5mDRS4bqfIJ53A1O8UQG54AJP1Ja4PmqGn5IiebcT1KC5WOFXkUa4q77Usw0MMhzduFrdxwjp8Y3AWGpUDU+l3Pf/FoAtRhOx rsa-key-20231219
use App\Enums\CustomerStatus;
use App\Helpers\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\CartItem;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        Cart::moveCartItemsIntoDb();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
