<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logout extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Not needed
        // $user = $request->user();

        // Standard idiomatic way of logging out
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken(); // for CSRF

        return redirect('/')->with('success', 'You\'ve successfully logged out!');
    }
}
