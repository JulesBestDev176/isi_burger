<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Restaurant;
use App\Models\Burger;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CommandeClientController extends Controller
{
    public function index()
    {
        $commandes = Commande::where('user_id', Auth::id())
            ->with(['burgers' => function($query) {
                $query->withPivot('quantite');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $restaurant = Restaurant::first();  
        
        return view('clients.commande', compact('commandes', 'restaurant'));
    }

    public function show(Commande $commande)
    {
       
        if ($commande->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cette commande.');
        }
        
        $commande->load(['burgers' => function($query) {
            $query->withPivot('quantite');
        }]);
        
        return view('commandes.show', compact('commande'));
    }

    public function create()
    {
        
        $panier = session()->get('panier', []);
        $restaurant = Restaurant::first();  
        
        if (empty($panier)) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide. Veuillez ajouter des articles avant de passer commande.');
        }
        
        
        $burgers = [];
        $total = 0;
        
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
        
        return view('clients.create', compact('burgers', 'total', 'restaurant'));
    }


    public function store(Request $request)
    {
        Log::info('Début de la fonction store', ['request' => $request->all()]);

        
        $validated = $request->validate([
            'mode_paiement' => 'required|in:espèces,carte bancaire,mobile money',
            'type' => 'required|in:emporte,sur place,livraison',
            'zone' => $request->input('type') === 'livraison' ? 'required' : 'nullable',
            'adresse_livraison' => $request->input('type') === 'livraison' ? 'required' : 'nullable',
        ]);
        Log::info('Données validées', ['validated' => $validated]);

        
        $panier = session()->get('panier', []);
        Log::info('Panier récupéré', ['panier' => $panier]);

        
        if (empty($panier)) {
            Log::warning('Panier vide détecté');
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
        }

        try {
            Log::info('Début de la transaction');
            DB::beginTransaction();

            $total = 0;
            $burgerData = [];
            $fraisLivraison = 0;

            if ($validated['type'] === 'livraison') {
                $zones = [
                    'dakar' => 1500,
                    'pikine' => 2000,
                    'guediawaye' => 2500,
                    'keur_massar' => 3000
                ];
                $fraisLivraison = $zones[$validated['zone']] ?? 0;
            }

            foreach ($panier as $burger_id => $details) {
                $burger = Burger::find($burger_id);
                Log::info('Burger trouvé', ['burger' => $burger]);

                if (!$burger) {
                    Log::error('Burger non trouvé', ['burger_id' => $burger_id]);
                    throw new \Exception("Le burger avec l'ID {$burger_id} n'existe pas.");
                }

                if ($burger->quantite < $details['quantite']) {
                    Log::error('Stock insuffisant', ['burger' => $burger, 'quantite_demandee' => $details['quantite']]);
                    throw new \Exception("Stock insuffisant pour {$burger->nom}.");
                }

                $total += $burger->prix * $details['quantite'];
                $burgerData[$burger_id] = ['quantite' => $details['quantite']];

                
                $burger->quantite -= $details['quantite'];
                $burger->save();
                Log::info('Stock mis à jour', ['burger' => $burger]);
            }

           
            $totalAvecLivraison = $total + $fraisLivraison;

            
            $commande = new Commande();
            $commande->user_id = Auth::id();
            $commande->statut = 'en attente';
            $commande->type = $validated['type'];
            $commande->total = $totalAvecLivraison;
            $commande->paiement_montant = $total; 
            $commande->date_commande = now();
            $commande->mode_paiement = $validated['mode_paiement'];
            $commande->numero_paiement = "PAY-" . now()->format('YmdHis');
            
            
            if ($validated['type'] === 'livraison') {
                $commande->adresse_livraison = $validated['adresse_livraison'];
            }
            
            $commande->save();
            Log::info('Commande créée', ['commande' => $commande]);

            
            $commande->burgers()->attach($burgerData);
            Log::info('Burgers associés à la commande', ['burgerData' => $burgerData]);

            
            session()->forget('panier');
            Log::info('Panier vidé');

            DB::commit();
            Log::info('Transaction commitée');

            return redirect()->route('factures.show', $commande)
                ->with('success', 'Votre commande a été passée avec succès! Numéro de commande: #' . $commande->id);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la création de la commande', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erreur lors de la création de la commande: ' . $e->getMessage());
        }
    }


    public function getUserById($userId)
    {
        return User::find($userId);
    }
}
