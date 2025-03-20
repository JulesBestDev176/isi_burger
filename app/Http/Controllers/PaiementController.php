<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Burger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PaiementController extends Controller
{
    public function index()
    {
        $commandes = Commande::where('statut', 'payée')->paginate(6);
        $burgers = Burger::all();
        return view('paiements.index',compact('commandes','burgers'));
    }
}
