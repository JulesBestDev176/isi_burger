<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Restaurant;
use App\Models\User;

class FactureController extends Controller
{
    public function index($id) {
        $commande = Commande::find($id);
        $user = User::find($commande->user_id);
        return view('factures.facture', compact('commande', 'user'));
    }

    public function show($id) {
        $commande = Commande::find($id);
        $restaurant = Restaurant::first();  
        $client = User::find($commande->user_id);
        return view('factures.show', compact('commande', 'restaurant', 'client'));
    }
}
