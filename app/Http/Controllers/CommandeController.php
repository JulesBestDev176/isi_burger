<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Burger;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandes = Commande::paginate(6);
        $nouveauCommande = $this->getNouveauCommande();
        $commandeEnAttente = $this->getCommandeEnAttente();
        $commandeEnPreparation = $this->getCommandeEnPreparation();
        $commandePrete = $this->getCommandePrete();
        $commandePaye = $this->getCommandePaye();
        $commandeAnnule = $this->getCommandeAnnule();
        $burgers = Burger::all();
        return view('commandes.index', compact('commandes','burgers', 'nouveauCommande', 'commandeEnAttente', 'commandeEnPreparation', 'commandePrete', 'commandePaye', 'commandeAnnule' ));
    }

    public function getNouveauCommande()
    {
        $commandes = Commande::whereDate('date_commande', Carbon::today())
            ->where('statut', 'en attente')
            ->orderBy('date_commande', 'desc')
            ->get();

        return $commandes;
    }

    public function getCommandeEnAttente()
    {
        return Commande::where('statut', 'en attente')
            ->orderBy('date_commande', 'desc')
            ->get();
    }

    public function getCommandeEnPreparation()
    {
        return Commande::where('statut', 'en préparation')
            ->orderBy('date_commande', 'desc')
            ->get();
    }

    public function getCommandePrete()
    {
        return Commande::where('statut', 'prête')
            ->orderBy('date_commande', 'desc')
            ->get();
    }

    public function getCommandePaye()
    {
        return Commande::where('statut', 'payée')
            ->orderBy('date_commande', 'desc')
            ->get();
    }

    public function getCommandeAnnule()
    {
        return Commande::where('statut', 'annulé')
            ->orderBy('date_commande', 'desc')
            ->get();
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $commande = new Commande();
        return view('commandes.create', compact('commande'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
 * Enregistre une nouvelle commande dans la base de données.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function store(Request $request)
    {
        try {
            
            
            $request->merge([
                'user_id' => auth()->id(),
                'statut' => 'en attente',
                'date_commande' => now(),
                'numero_paiement' => "PAY-" . now()->format('YmdHis')
            ]);
            
            
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'total' => 'required|integer|min:1',
                'mode_paiement' => 'required|in:espèces,carte bancaire,virement',
                'statut' => 'required|in:en attente,en préparation,prête,payée,annulé',
                'burgers' => 'required|array',
                'burgers.*.quantite' => 'required|integer|min:0',
                'date_commande' => 'required|date',
                'type' => 'required|in:emporte, sur place',
                'numero_paiement' => 'required',
            ]);

           
            $burgerSelectionnes = false;
            foreach ($request->burgers as $burgerId => $details) {
                if ($details['quantite'] > 0) {
                    $burgerSelectionnes = true;
                    break;
                }
            }

            if (!$burgerSelectionnes) {
                return redirect()->back()->with('error', 'Vous devez sélectionner au moins un burger.');
            }

            
            DB::beginTransaction();
            
           
            $commande = new Commande();
            $commande->user_id = $request->user_id;
            $commande->statut = $request->statut;
            $commande->total = $request->total;
            $commande->date_commande = $request->date_commande;
            $commande->mode_paiement = $request->mode_paiement;
            $commande->type = $request->type;
            $commande->numero_paiement = $request->numero_paiement;
            $commande->save();

            
            foreach ($request->burgers as $burgerId => $details) {
                if ($details['quantite'] > 0) {
                    $burger = Burger::findOrFail($burgerId);
                    
                    if ($burger->quantite < $details['quantite']) {
                        throw new \Exception("Stock insuffisant pour {$burger->nom}");
                    }

                    
                    $commande->burgers()->attach($burgerId, [
                        'quantite' => $details['quantite'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                   
                    $burger->quantite -= $details['quantite'];
                    $burger->save();
                }
            }

            DB::commit();
            
            return redirect()->route('commandes.index')->with('success', 'Commande créée avec succès!');
                
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur de validation: ' . $e->getMessage())->withErrors($e->errors())->withInput();
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erreur lors de la création de la commande: ' . $e->getMessage())->withInput();
        }
    }

    public function getUserById($id) {
        $user = User::find($id);
        return $user;
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $commande = Commande::find($id);

        if (!$commande) {
            return redirect()->route('commandes.index')->with('error', 'Commande non trouvée');
        }

        return view('commandes.show', compact('commande'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $commande = new Commande();
        return view('commande.edit', compact('commande'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);

        $validTransitions = [
            'en attente' => ['en préparation', 'annulé'],
            'en préparation' => ['prête', 'annulé'],
            'prête' => ['payée'],
            'payée' => [], 
            'annulé' => [], 
        ];

        $validated = $request->validate([
            'statut' => 'required|in:en attente,en préparation,prête,payée,annulé',
        ]);

        $newStatus = $validated['statut'];

        if (!in_array($newStatus, $validTransitions[$commande->statut])) {
            return redirect()->route('commandes.index')->with('error', 'La transition de statut est invalide.');
        }

        $commande->statut = $newStatus;

        if ($newStatus === 'payée') {
            $commande->date_paiement = now();
        }

        $commande->save();

        return redirect()->route('commandes.index')->with('success', 'Le statut a été mis à jour avec succès');
    }




    /**
     * Modifier le statut d'une commande
     */
    public function updateStatus(string $id, string $statut)
    {
        
        $commande = Commande::findOrFail($id);

        
        $validStatuts = ['en attente', 'en préparation', 'prête', 'payée'];
        
        if (!in_array($statut, $validStatuts)) {
            return redirect()->route('commandes.index')->with('error', 'Statut invalide.');
        }

        
        $commande->statut = $statut;

        
        if ($statut === 'payée') {
            $commande->date_paiement = now();
            $commande->paiement_montant = $commande->paiement_montant ?? 0; 
        }

        
        $commande->save();

       
        return redirect()->route('commandes.index')->with('success', 'Statut de la commande mis à jour avec succès.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $commande =new Burger();
        $commande->find($id)->delete();
        return to_route('burgers.index');
    }
}
