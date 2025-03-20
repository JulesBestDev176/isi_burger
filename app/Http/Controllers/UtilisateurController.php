<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\UserCredentialsMail;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UtilisateurController extends Controller
{
    public function index()
    {
        $gestionnaires = User::role('gestionnaire')->get();
        $actifs = $this->getActifs();
        $inactifs = $this->getInactifs();
        $nouveaux = $this->getNouveaux();
        return view('utilisateurs.index', compact('gestionnaires', 'actifs', 'inactifs', 'nouveaux'));
    }

    public function getActifs() {
        $gestionnairesActifs = User::role('gestionnaire')
                                   ->where('statut', 'actif')
                                   ->get();
    
        return $gestionnairesActifs;
    }

    public function getInactifs() {
        $gestionnairesActifs = User::role('gestionnaire')
                                   ->where('statut', 'inactif')
                                   ->get();
    
        return $gestionnairesActifs;
    }

    public function getNouveaux() {
        $gestionnairesActifs = User::role('gestionnaire')
                                   ->where('statut', 'nouveau')
                                   ->get();
    
        return $gestionnairesActifs;
    }

    public function store(Request $request)
    {
        
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required|string|max:20',
        ]);

        $telephone = Str::startsWith($request->telephone, '+221') ? $request->telephone  : '+221' . $request->telephone; 

        
        $password = \Str::random(10);

        
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($password),
            'statut' => 'nouveau', 
        ]);

        
        $role = Role::firstOrCreate(['name' => 'gestionnaire']);
        $user->assignRole($role);

        
        try {
            Mail::to($user->email)->send(new UserCredentialsMail($user->email, $password));
        } catch (\Exception $e) {
            
            \Log::error('Erreur lors de l\'envoi de l\'e-mail : ' . $e->getMessage());
        }
        
        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur ajouté avec succès et informations envoyées par e-mail.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'statut' => 'required|in:actif,inactif',
        ]);

        $user->update([
            'statut' => $request->statut,
        ]);

        return redirect()->back()->with('success', 'Statut de l\'utilisateur mis à jour avec succès.');
    }

}
