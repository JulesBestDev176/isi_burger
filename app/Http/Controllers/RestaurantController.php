<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use App\Models\Restaurant;
use App\Models\Burger;

class RestaurantController extends Controller
{
    
    public function index() {
        $burgers = Burger::all();
        $restaurant = Restaurant::first();
        return view('clients.accueil', compact('restaurant', 'burgers'));
    }

    public function edit()
    {
        
        $restaurant = Restaurant::firstOrNew();

        return view('restaurant.edit', compact('restaurant'));
    }


    public function update(Request $request)
    {
        try {
            
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'tel' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'adresse' => 'nullable|string|max:255',
                'ville' => 'nullable|string|max:255',
                'code_postal' => 'nullable|string|max:10',
                'description' => 'nullable|string',
                // 'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            
            $restaurant = Restaurant::firstOrNew();
            \Log::info('Restaurant trouvé ou créé', ['restaurant' => $restaurant]);

            
            $restaurant->nom = $request->input('nom');
            $restaurant->tel = $request->input('tel');
            $restaurant->email = $request->input('email');
            $restaurant->adresse = $request->input('adresse');
            $restaurant->ville = $request->input('ville');
            $restaurant->code_postal = $request->input('code_postal');
            $restaurant->description = $request->input('description');

            
            // if ($request->hasFile('logo')) {
            //     \Log::info('Un fichier logo a été détecté dans la requête.');

            //     // Supprimer l'ancien logo s'il existe
            //     if ($restaurant->logo && Storage::disk('public')->exists($restaurant->logo)) {
            //         \Log::info('Suppression de l\'ancien logo', ['path' => $restaurant->logo]);
            //         Storage::disk('public')->delete($restaurant->logo);
            //     }

            //     // Enregistrer le nouveau logo
            //     $logoPath = $request->file('logo')->store('restaurant-logos', 'public');
            //     \Log::info('Nouveau logo enregistré', ['path' => $logoPath]);
            //     $restaurant->logo = $logoPath;
            // } else {
            //     \Log::info('Aucun fichier logo n\'a été téléchargé.');
            // }

            
            $restaurant->save();
            \Log::info('Restaurant sauvegardé avec succès', ['restaurant' => $restaurant]);

            
            return redirect()->route('restaurant.edit')->with('status', 'Les informations du restaurant ont été mises à jour avec succès.');

        } catch (\Illuminate\Validation\ValidationException $e) {
           
            return redirect()->route('restaurant.edit')
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            
            \Log::error('Erreur lors de la mise à jour du restaurant', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('restaurant.edit')
                ->with('erreur', 'Une erreur s\'est produite lors de la mise à jour du restaurant.')
                ->withInput();
        }
    }
}