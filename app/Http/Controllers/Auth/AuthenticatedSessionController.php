<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user
        $request->authenticate();

        // Create a new Sanctum token for the authenticated user
        $user = Auth::user();
        $token = $user->createToken('laravel')->plainTextToken;
        Log::info('Generated Token: ' . $token);

            // Store the token in the session explicitly
        session()->put('token', $token);
        // Attach the token to the session or send it back as a response (Here we're using a redirect with a session)
        return redirect()->intended(route('dashboard', absolute: false)); // Store the token in the session or send to the view
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Revoke all Sanctum tokens of the user upon logout
        $user = Auth::user();
        $user->tokens->each(function ($token) {
            $token->delete();  // Delete each token associated with the user
        });
        Log::info('Deleted Token for User: ' . $user->id);

        // Log the user out and invalidate the session
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
