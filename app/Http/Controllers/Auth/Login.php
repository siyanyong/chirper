<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        {
            // Validate the input
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Attempt to log in:
            // Build a database query from the non-password fields
            // Fetch the user record
            // Verify the password
            // Adds a long-lived remember_token cookie (5 years) that re-authenticate the user even after session expires (120 mins in config/session.php)
            // Every time user has activity the timer resets back to two hours
            // Closing browser does not log you out by default - expire_on_close is false

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                // Regenerate session for security by only swapping session id - lifetime still the same
                // Prevents session fixation attack
                $request->session()->regenerate();

                // Redirect to intended page (page they were trying to access) or home as fallback
                return redirect()->intended('/')->with('success', 'Welcome back!');
            }

            // If login fails, redirect back with error to email field with ONLY email field filled in
            return back()
                ->withErrors(['email' => 'The provided credentials do not match our records.'])
                ->onlyInput('email');
        }
    }
}
