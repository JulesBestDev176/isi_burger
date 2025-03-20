@extends('layouts.app')

@section('title', 'Passer votre commande')

@section('content')
<div class="bg-white">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Finaliser votre commande</h1>
            
            <form action="{{ route('commande_client.store') }}" method="POST" class="space-y-8">
                @csrf
                
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Mode de commande</h2>
                    
                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <input 
                                type="radio" 
                                id="mode_sur_place" 
                                name="type" 
                                value="sur_place" 
                                required 
                                class="mr-2 focus:ring-primary-500 text-primary-600"
                                {{ old('type', 'sur_place') == 'sur_place' ? 'checked' : '' }}
                            >
                            <label for="mode_sur_place" class="inline-flex items-center">
                                <i class="fas fa-utensils mr-2 text-gray-600"></i>
                                Sur place
                            </label>
                        </div>
                        
                        <div>
                            <input 
                                type="radio" 
                                id="mode_emporter" 
                                name="type" 
                                value="emporter" 
                                required 
                                class="mr-2 focus:ring-primary-500 text-primary-600"
                                {{ old('type') == 'emporter' ? 'checked' : '' }}
                            >
                            <label for="mode_emporter" class="inline-flex items-center">
                                <i class="fas fa-shopping-bag mr-2 text-gray-600"></i>
                                À emporter
                            </label>
                        </div>
                        
                        <div>
                            <input 
                                type="radio" 
                                id="type" 
                                name="type" 
                                value="livraison" 
                                required 
                                class="mr-2 focus:ring-primary-500 text-primary-600"
                                {{ old('type') == 'livraison' ? 'checked' : '' }}
                            >
                            <label for="type" class="inline-flex items-center">
                                <i class="fas fa-truck mr-2 text-gray-600"></i>
                                Livraison
                            </label>
                        </div>
                    </div>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                
                <div id="zone-livraison" class="bg-white rounded-lg shadow-md p-6 hidden">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Zone de livraison</h2>
                    
                    <div>
                        <label for="zone" class="block text-sm font-medium text-gray-700 mb-1">Sélectionnez votre zone *</label>
                        <select 
                            id="zone" 
                            name="zone" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200"
                        >
                            <option value="">Choisissez une zone</option>
                            <option value="dakar" {{ old('zone') == 'dakar' ? 'selected' : '' }}>Dakar (1500 FCFA)</option>
                            <option value="pikine" {{ old('zone') == 'pikine' ? 'selected' : '' }}>Pikine (2000 FCFA)</option>
                            <option value="guediawaye" {{ old('zone') == 'guediawaye' ? 'selected' : '' }}>Guediawaye (2500 FCFA)</option>
                            <option value="keur_massar" {{ old('zone') == 'keur_massar' ? 'selected' : '' }}>Keur Massar (3000 FCFA)</option>
                        </select>
                        @error('zone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                
                <div id="adresse-livraison" class="bg-white rounded-lg shadow-md p-6 hidden">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Adresse de livraison</h2>
                    
                    <div>
                        <label for="adresse" class="block text-sm font-medium text-gray-700 mb-1">Adresse complète *</label>
                        <input 
                            type="text" 
                            id="adresse" 
                            name="adresse_livraison" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200"
                            value="{{ old('adresse_livraison') }}"
                        >
                        @error('adresse')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
               
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Récapitulatif de la commande</h2>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-2 text-left">Article</th>
                                    <th class="py-2 text-center">Quantité</th>
                                    <th class="py-2 text-right">Prix</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($burgers as $item)
                                    <tr class="border-b">
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                @if($item['burger']->image)
                                                    <img src="{{ Storage::url($item['burger']->image) }}" alt="{{ $item['burger']->nom }}" class="w-12 h-12 object-cover rounded mr-4">
                                                @endif
                                                <span>{{ $item['burger']->nom }}</span>
                                            </div>
                                        </td>
                                        <td class="py-2 text-center">{{ $item['quantite'] }}</td>
                                        <td class="py-2 text-right">{{ number_format($item['burger']->prix * $item['quantite'], 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="py-2 text-right">Sous-total</td>
                                    <td id="sous-total" class="py-2 text-right text-primary-600">{{ number_format($total, 0, ',', ' ') }} FCFA</td>
                                </tr>
                                <tr id="frais-livraison-row" class="hidden">
                                    <td colspan="2" class="py-2 text-right">Frais de livraison</td>
                                    <td id="frais-livraison" class="py-2 text-right text-primary-600">0 FCFA</td>
                                </tr>
                                <tr class="font-bold">
                                    <td colspan="2" class="py-2 text-right">Total</td>
                                    <td id="total-commande" class="py-2 text-right text-primary-600">{{ number_format($total, 0, ',', ' ') }} FCFA</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Méthode de paiement</h2>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <input 
                                type="radio" 
                                id="paiement_especes" 
                                name="mode_paiement" 
                                value="espèces" 
                                required 
                                class="mr-2 focus:ring-primary-500 text-primary-600"
                            >
                            <label for="paiement_especes" class="inline-flex items-center">
                                <i class="fas fa-money-bill-wave mr-2 text-gray-600"></i>
                                Paiement en espèces
                            </label>
                        </div>
                        
                        <div>
                            <input 
                                type="radio" 
                                id="paiement_mobile" 
                                name="mode_paiement" 
                                value="mobile money" 
                                required 
                                class="mr-2 focus:ring-primary-500 text-primary-600"
                            >
                            <label for="paiement_mobile" class="inline-flex items-center">
                                <i class="fas fa-mobile-alt mr-2 text-gray-600"></i>
                                Mobile Money
                            </label>
                        </div>
                        
                        <div>
                            <input 
                                type="radio" 
                                id="paiement_carte" 
                                name="mode_paiement" 
                                value="carte bancaire" 
                                required 
                                class="mr-2 focus:ring-primary-500 text-primary-600"
                            >
                            <label for="paiement_carte" class="inline-flex items-center">
                                <i class="fas fa-credit-card mr-2 text-gray-600"></i>
                                Carte bancaire
                            </label>
                        </div>
                    </div>
                    @error('mode_paiement')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                
                <div class="mt-6">
                    <button 
                        type="submit" 
                        class="w-full py-3 px-4 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition"
                    >
                        Confirmer et payer <span id="bouton-total">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modeOptions = document.querySelectorAll('input[name="type"]');
    const zoneLivraisonSection = document.getElementById('zone-livraison');
    const adresseLivraisonSection = document.getElementById('adresse-livraison');
    const zoneSelect = document.getElementById('zone');
    const adresseInput = document.getElementById('adresse');

   
    const zones = {
        'dakar': 1500,
        'pikine': 2000,
        'guediawaye': 2500,
        'keur_massar': 3000
    };

    const sousTotalElement = document.getElementById('sous-total');
    const fraisLivraisonRow = document.getElementById('frais-livraison-row');
    const fraisLivraisonElement = document.getElementById('frais-livraison');
    const totalCommandeElement = document.getElementById('total-commande');
    const boutonTotalElement = document.getElementById('bouton-total');

    
    function parsePrice(priceText) {
        return parseInt(priceText.replace(/\s/g, '').replace('FCFA', ''));
    }

    function formatPrice(price) {
        return price.toLocaleString('fr-FR') + ' FCFA';
    }

    function toggleLivraisonOptions() {
        const selectedMode = document.querySelector('input[name="type"]:checked').value;
        
        if (selectedMode === 'livraison') {
            zoneLivraisonSection.classList.remove('hidden');
            adresseLivraisonSection.classList.remove('hidden');
            zoneSelect.required = true;
            adresseInput.required = true;
        } else {
            zoneLivraisonSection.classList.add('hidden');
            adresseLivraisonSection.classList.add('hidden');
            zoneSelect.required = false;
            adresseInput.required = false;
            zoneSelect.value = ''; 
            
            
            const sousTotal = parsePrice(sousTotalElement.textContent);
            totalCommandeElement.textContent = formatPrice(sousTotal);
            boutonTotalElement.textContent = formatPrice(sousTotal);
            fraisLivraisonRow.classList.add('hidden');
        }
    }

  
    function updateLivraisonTotal() {
        const selectedZone = zoneSelect.value;
        const sousTotal = parsePrice(sousTotalElement.textContent);
        
        if (selectedZone && zones[selectedZone]) {
            const fraisLivraison = zones[selectedZone];
            const total = sousTotal + fraisLivraison;
            
            fraisLivraisonElement.textContent = formatPrice(fraisLivraison);
            totalCommandeElement.textContent = formatPrice(total);
            boutonTotalElement.textContent = formatPrice(total);
            
            fraisLivraisonRow.classList.remove('hidden');
        } else {
            fraisLivraisonRow.classList.add('hidden');
        }
    }

    
    toggleLivraisonOptions();

    
    modeOptions.forEach(option => {
        option.addEventListener('change', toggleLivraisonOptions);
    });

    
    zoneSelect.addEventListener('change', updateLivraisonTotal);
});
</script>
@endsection