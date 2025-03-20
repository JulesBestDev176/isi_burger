<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Burger;
use Illuminate\Support\Facades\Storage;

class BurgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $burgers = Burger::paginate(6);
        return view('burgers.index', compact('burgers'));
    }


    
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255|unique:burgers,nom',
                'prix' => 'required|numeric|min:0',
                'quantite' => 'required|integer|min:0',
                'description' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('burgers', 'public');
        
                Burger::create([
                    'nom' => $request->nom,
                    'prix' => $request->prix,
                    'quantite' => $request->quantite,
                    'description' => $request->description,
                    'image' => $imagePath,
                ]);
        
                return redirect()->route('burgers.index')->with('success', 'Burger ajouté avec succès');
            } else {
                return redirect()->route('burgers.index')->with('erreur', 'Aucune image fournie.');
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('burgers.index')->with('erreur', 'Erreur de validation.')->withInput();
        } catch (\Exception $e) {
            return redirect()->route('burgers.index')->with('erreur', 'Une erreur s\'est produite lors de l\'ajout du burger.')->withInput();
        }
    }

    
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       

        try {
            
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255|unique:burgers,nom,' . $id,
                'prix' => 'required|numeric|min:0',
                'quantite' => 'required|integer|min:0',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $burger = Burger::findOrFail($id);

            if ($request->hasFile('image')) {
                \Log::info('Nouvelle image fournie');
                if ($burger->image && Storage::exists('public/' . $burger->image)) {
                    Storage::delete('public/' . $burger->image);
                }
                $imagePath = $request->file('image')->store('burgers', 'public');
            } else {
                \Log::info('Aucune nouvelle image fournie');
                $imagePath = $burger->image;
            }

            $burger->update([
                'nom' => $request->nom,
                'prix' => $request->prix,
                'quantite' => $request->quantite,
                'description' => $request->description,
                'image' => $imagePath,
            ]);


            return redirect()->route('burgers.index')->with('success', 'Burger modifié avec succès.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('burgers.index')
                            ->withErrors($e->validator)
                            ->withInput();
        } catch (\Exception $e) {
            return redirect()->route('burgers.index')
                            ->with('erreur', 'Une erreur s\'est produite lors de la modification du burger.')
                            ->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $burger = Burger::findOrFail($id);
    
            if ($burger->image && Storage::exists('public/' . $burger->image)) {
                Storage::delete('public/' . $burger->image);
            }
    
            $burger->delete();
    
            return redirect()->route('burgers.index')->with('success', 'Burger supprimé avec succès.');
    
        } catch (\Exception $e) {
            return redirect()->route('burgers.index')
                             ->with('erreur', 'Une erreur s\'est produite lors de la suppression du burger.');
        }
    }
}
