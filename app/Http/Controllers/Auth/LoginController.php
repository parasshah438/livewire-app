<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\CartService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->middleware('guest')->except('logout');
        $this->cartService = $cartService;
    }

    protected function authenticated(Request $request, $user)
    {
        // Store session ID for cart merging
        session(['cart_session_id' => session()->getId()]);
        
        // Merge session cart with user cart
        $this->cartService->mergeSessionCart();
        
        return redirect()->intended($this->redirectPath());
    }
}