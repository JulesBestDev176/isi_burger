<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
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
        // Authentification de l'utilisateur
        $request->authenticate();
        $request->session()->regenerate();

        // Récupération de l'utilisateur authentifié
        $user = Auth::user();

        // Redirection en fonction du rôle et du statut
        if ($user->hasRole('client')) {
            return redirect()->route('restaurant'); 
        } else {
            if ($user->statut === 'nouveau') {
                $status = Password::sendResetLink(['email' => $user->email]);

                if ($status === Password::RESET_LINK_SENT) {
                    Auth::logout();
                    return redirect()->route('login')->with('status', __($status));
                } else {
                    return redirect()->route('login')->with('error', __($status));
                }
            } else if ($user->statut === 'inactif') {
                return redirect()->route('login')->with('error', 'Votre compte est inactif.');
            } else {
                return redirect()->intended(route('dashboard', absolute: false));
            }
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
