<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
        
        return view('profile.index');
    }
    

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        try {
            
            
            $validated = $request->validate([
                'prenom' => 'required|string|max:255',
                'nom' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
                'telephone' => 'nullable|string|max:20|unique:users,telephone,' . Auth::id(),
            ]);

            
            $user = Auth::user();
            
            
            $user->prenom = $validated['prenom'];
            $user->nom = $validated['nom'];
            $user->email = $validated['email'];
            $user->telephone = $validated['telephone'] ?? null;
            
            
            $user->save();
            
            
            return redirect()->route('profile.index')->with('success', 'Burger modifié avec succès.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('burgers.index')->with('error', 'Erreur de validation');
        } catch (\Exception $e) {
            return redirect()->route('burgers.index')->with('error', 'Une erreur est survenue');
        }
    }


    public function password(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.index')->with('status', 'Mot de passe mis à jour avec succès!');
    }

    /**
     * Delete the user's account.
     */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
}
