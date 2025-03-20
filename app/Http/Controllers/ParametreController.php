<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParametreController extends Controller
{
    public function index()
    {
        return view('parametre.index');
    }

    public function update(Request $request, string $id)
    {
        // // Validation des données
        // $validatedData = $request->validate([
        //     'user_id' => 'required|exists:users,id', 
        //     'statut' => 'required|in:en attente,en préparation,prête,payée',
        //     'total' => 'required|numeric|min:0',
        //     'date_commande' => 'required|date',
        //     'date_paiement' => 'nullable|date',
        //     'paiement_montant' => 'nullable|numeric|min:0',
        //     'mode_paiement' => 'required|in:espèces,carte bancaire,virement',
        //     'burgers' => 'required|array', 
        //     'burgers.*.id' => 'required|exists:burgers,id', 
        //     'burgers.*.quantite' => 'required|integer|min:1', 
        // ]);

        // // Si le statut est "payée", on ajoute les informations de paiement
        // if ($validatedData['statut'] == 'payée') {
        //     $validatedData['date_paiement'] = now();
        //     $validatedData['paiement_montant'] = $validatedData['paiement_montant'] ?? 0;
        // }

        // // Récupération de la commande à mettre à jour
        // $commande = Commande::findOrFail($id);

        // // Mise à jour de la commande
        // $commande->update($validatedData);

        // // Mise à jour des burgers associés à la commande
        // // Utilisation de sync pour lier ou mettre à jour la relation many-to-many
        // $commande->burgers()->sync(
        //     collect($validatedData['burgers'])->mapWithKeys(function ($burger) {
        //         return [$burger['id'] => ['quantite' => $burger['quantite']]];
        //     })
        // );

        // // Retourner à la page des commandes avec un message de succès
        // return redirect()->route('commandes.index')->with('success', 'Commande mise à jour avec succès');
    }
}
