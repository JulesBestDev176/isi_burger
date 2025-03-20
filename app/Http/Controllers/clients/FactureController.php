<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class FactureController extends Controller
{
    public function show($id)
    {
        $commande = Commande::with(['burgers' => function($query) {
            $query->withPivot('quantite');
        }, 'user'])->findOrFail($id);
        
        
        if ($commande->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403, 'Accès non autorisé à cette facture.');
        }
        
        
        if ($commande->statut !== 'payée') {
            return redirect()->back()->with('error', 'La facture est disponible uniquement pour les commandes payées.');
        }
        
        $restaurant = Restaurant::first();
        
        return view('factures.show', compact('commande', 'restaurant'));
    }
}
