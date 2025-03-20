<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Burger;
use App\Models\Restaurant;

class PanierController extends Controller
{
    public function index()
    {
        $restaurant = Restaurant::first();
        $panier = session()->get('panier', []);
        $burgers = [];
        $total = 0;
        
        if (!empty($panier)) {
            foreach ($panier as $id => $details) {
                $burger = Burger::find($id);
                
                if ($burger) {
                    $burgers[] = [
                        'burger' => $burger,
                        'quantite' => $details['quantite']
                    ];
                    
                    $total += $burger->prix * $details['quantite'];
                }
            }
        }
        
        return view('panier.index', compact('restaurant', 'burgers', 'total'));
    }

    public function ajouter(Request $request)
    {
        $request->validate([
            'burger_id' => 'required|exists:burgers,id',
            'quantite' => 'required|integer|min:1'
        ]);
        
        $burger_id = $request->burger_id;
        $quantite = $request->quantite;
        
        
        $burger = Burger::find($burger_id);
        
        if (!$burger || $burger->quantite < $quantite) {
            return redirect()->back()->with('error', 'Ce burger n\'est pas disponible en quantité suffisante.');
        }
        
        
        $panier = session()->get('panier', []);
        
        
        if (isset($panier[$burger_id])) {
            $panier[$burger_id]['quantite'] += $quantite;
        } else {
            $panier[$burger_id] = [
                'quantite' => $quantite
            ];
        }
        
        
        session()->put('panier', $panier);
        
        return redirect()->back()->with('success', 'Burger ajouté au panier avec succès!');
    }

    public function modifier(Request $request)
    {
        $request->validate([
            'burger_id' => 'required|exists:burgers,id',
            'quantite' => 'required|integer|min:1'
        ]);
        
        $burger_id = $request->burger_id;
        $quantite = $request->quantite;
        
        
        $burger = Burger::find($burger_id);
        
        if (!$burger || $burger->quantite < $quantite) {
            return redirect()->back()->with('error', 'Ce burger n\'est pas disponible en quantité suffisante.');
        }
        
        $panier = session()->get('panier', []);
        
        if (isset($panier[$burger_id])) {
            $panier[$burger_id]['quantite'] = $quantite;
            session()->put('panier', $panier);
            return redirect()->back()->with('success', 'Panier mis à jour avec succès!');
        }
        
        return redirect()->back()->with('error', 'Burger non trouvé dans le panier.');
    }

    public function supprimer($id)
    {
        $panier = session()->get('panier', []);
        
        if (isset($panier[$id])) {
            unset($panier[$id]);
            session()->put('panier', $panier);
            return redirect()->back()->with('success', 'Burger retiré du panier avec succès!');
        }
        
        return redirect()->back()->with('error', 'Burger non trouvé dans le panier.');
    }

    public function vider()
    {
        session()->forget('panier');
        return redirect()->back()->with('success', 'Panier vidé avec succès!');
    }
}
