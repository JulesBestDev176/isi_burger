@extends('dashboard')

@section('title', 'Gestion des commandes')
@section('content')

<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Gestion des Commandes</h1>
            <p class="mt-1 text-sm text-gray-500">Consultez et gérez toutes les commandes en cours et passées</p>
        </div>
        <div class="mt-4 md:mt-0">
        @auth
            @if(!Auth::user()->hasRole('admin'))
                <button class="px-4 py-2 bg-primary-600 text-white rounded-lg shadow hover:bg-primary-700 transition-colors flex items-center">
                    <i class="fas fa-plus mr-2"></i> Nouvelle commande
                </button>

            @endif
        @endauth
            
        </div>
    </div>

    <div class="bg-white rounded-lg shadow mb-6">
        <div class="border-b">
            <nav class="flex -mb-px">
                <a href="#" class="border-primary-500 text-primary-600 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Toutes ({{ $commandes->count() }})
                </a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Nouvelles ({{ $nouveauCommande->count() }})
                </a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    En attente ({{ $commandeEnAttente->count() }})
                </a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    En préparation ({{ $commandeEnPreparation->count() }})
                </a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Prête ({{ $commandePrete->count() }})
                </a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Payée ({{ $commandePaye->count() }})
                </a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Annulée ({{ $commandeAnnule->count() }})
                </a>
            </nav>
        </div>

        <div class="p-4">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-search text-gray-400"></i>
                        </span>
                        <input type="text" class="pl-10 pr-4 py-2 w-full rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Rechercher par numéro, client ou adresse...">
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Commande #
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Client
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($commandes as $commande)
                        @php
                            $user = app(\App\Http\Controllers\CommandeController::class)->getUserById($commande->user_id);
                        @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-primary-600">#ORD-{{ $commande->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->prenom }} {{ $user->nom }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->telephone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($commande->date_commande)->format('d M, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($commande->date_commande)->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $commande->total }} FCFA</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $commande->type }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('commandes.update', $commande->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    @php
                                        
                                        $statusColors = [
                                            'en attente' => 'bg-yellow-100 text-yellow-800',
                                            'en préparation' => 'bg-blue-100 text-blue-800',
                                            'prête' => 'bg-green-100 text-green-800',
                                            'payée' => 'bg-gray-100 text-gray-800',
                                            'annulé' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    
                                    @auth
                                        @if(!Auth::user()->hasRole('admin'))
                                            <select name="statut" class="px-2 py-1 text-xs leading-5 font-semibold rounded-full {{ $statusColors[$commande->statut] }}">
                                                <option value="en attente" {{ $commande->statut == 'en attente' ? 'selected' : '' }}>En attente</option>
                                                <option value="en préparation" {{ $commande->statut == 'en préparation' ? 'selected' : '' }}>En préparation</option>
                                                <option value="prête" {{ $commande->statut == 'prête' ? 'selected' : '' }}>Prête</option>
                                                <option value="payée" {{ $commande->statut == 'payée' ? 'selected' : '' }}>Payée</option>
                                                <option value="annulé" {{ $commande->statut == 'annulé' ? 'selected' : '' }}>Annulée</option>
                                            </select>
                                            <button type="submit" class="ml-2 text-sm text-blue-600 hover:text-blue-800">Mettre à jour</button>
                                        @else
                                            <p class="text-center px-2 py-1 text-xs leading-5 font-semibold rounded-full {{ $statusColors[$commande->statut] }}">{{ $commande->statut }}</p>
                                        @endif
                                    @endauth

                                    
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    @if($commande->statut == 'payée')
                                    <a href="{{ route('factures.show', ['id' => $commande->id]) }}" class="text-primary-600 hover:text-primary-900"><i class="fas fa-print"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>


            </table>
        </div>

        
        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $commandes->links('pagination::tailwind') }}
        </div>

    
    </div>
    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



    
    
    <div class="hidden bg-white rounded-lg shadow p-8 text-center mt-6">
        <div class="mx-auto w-24 h-24 bg-primary-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-shopping-bag text-4xl text-primary-600"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune commande trouvée</h3>
        <p class="text-sm text-gray-500 mb-6">Aucune commande ne correspond à vos critères de recherche actuels.</p>
        <button class="px-4 py-2 bg-primary-600 text-white rounded-lg shadow hover:bg-primary-700 transition-colors">
            Réinitialiser les filtres
        </button>
    </div>

    <div id="modalNouvelleCommande" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <form id="formNouvelleCommande" method="POST" action="{{ route('commandes.store') }}">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Nouvelle Commande</h3>
                                
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Client</label>
                                    <div class="flex items-center p-2 border border-gray-300 rounded-md bg-gray-50">
                                        <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 mr-3">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                                            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="user_id" name="user_id" value="{{ Auth::id() }}">
                                </div>

                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Sélection des Burgers</label>
                                    
                                    
                                    <div class="mb-3">
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                                <i class="fas fa-search text-gray-400"></i>
                                            </span>
                                            <input 
                                                type="text" 
                                                id="rechercheBurger" 
                                                class="pl-10 pr-4 py-2 w-full rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500" 
                                                placeholder="Rechercher un burger..."
                                            >
                                        </div>
                                    </div>
                                    
                                    <div id="listeSelectionBurgers" class="bg-gray-50 rounded-lg p-4 max-h-60 overflow-y-auto">
                                    @foreach($burgers as $burger)
                                        <div class="flex items-center justify-between p-2 border-b border-gray-200 burger-item" data-nom="{{ strtolower($burger->nom) }}">
                                            <div class="flex items-center">
                                                <img src="{{ asset('storage/' . $burger->image) }}" alt="{{ $burger->nom }}" class="h-12 w-12 object-cover rounded-md mr-3">
                                                <div>
                                                    <h4 class="font-medium text-gray-900">{{ $burger->nom }}</h4>
                                                    <p class="text-sm text-gray-500">{{ $burger->prix }} FCFA - Stock: {{ $burger->quantite }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="w-24">
                                                    <input 
                                                        type="number" 
                                                        name="burgers[{{ $burger->id }}][quantite]" 
                                                        id="quantiteBurger{{ $burger->id }}" 
                                                        value="0" 
                                                        min="0" 
                                                        max="{{ $burger->quantite }}" 
                                                        class="w-full py-2 px-3 text-center border border-gray-300 rounded-md bg-white focus:ring-primary-500 focus:border-primary-500" 
                                                        data-burger-id="{{ $burger->id }}" 
                                                        data-burger-prix="{{ $burger->prix }}">
                                                </div>
                                                <div class="ml-2 text-xs text-gray-500">
                                                    Max: {{ $burger->quantite }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                </div>

                                <div class="mb-4 bg-gray-50 rounded-lg p-4">
                                    <h4 class="font-medium text-gray-900 mb-2">Récapitulatif</h4>
                                    <div id="recapitulatifCommande" class="space-y-2 mb-3">
                                        <p class="text-gray-500 text-sm italic">Aucun article sélectionné</p>
                                    </div>
                                    <div class="flex justify-between font-medium">
                                        <span>Total:</span>
                                        <span id="montantTotal">0 FCFA</span>
                                        <input type="hidden" name="total" id="total" value="0">
                                    </div>
                                </div>

                                
                              
                                <div class="mb-4">
                                    <label for="mode_paiement" class="block text-sm font-medium text-gray-700 mb-1">Mode de paiement</label>
                                    <select id="mode_paiement" name="mode_paiement" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                                        <option value="espèces">Espèces</option>
                                        <option value="carte bancaire">Carte bancaire</option>
                                        <option value="mobile money">Mobile money</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                    <select id="type" name="type" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                                        <option value="emporte">Emporté</option>
                                        <option value="sur place">Sur place</option>
                                    </select>
                                </div>

                                <input type="hidden" name="statut" value="en attente">
                                <input type="hidden" name="date_commande" value="{{ now() }}">
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" id="btnSoumettreCommande" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm" disabled>
                            Créer la commande
                        </button>
                        <button type="button" id="btnFermerModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const btnNouvelleCommande = document.querySelector('button.bg-primary-600');
    const modalNouvelleCommande = document.getElementById('modalNouvelleCommande');
    const btnFermerModal = document.getElementById('btnFermerModal');
    const btnSoumettreCommande = document.getElementById('btnSoumettreCommande');
    const recapitulatifCommande = document.getElementById('recapitulatifCommande');
    const montantTotalElement = document.getElementById('montantTotal');
    const totalInput = document.getElementById('total');
    const rechercheBurgerInput = document.getElementById('rechercheBurger');
    const burgerItems = document.querySelectorAll('.burger-item');

    const searchInput = document.querySelector('input[placeholder="Rechercher par numéro, client ou adresse..."]');
    const filterDateSelect = document.querySelector('select.px-4.py-2.rounded-md');
    const statusTabs = document.querySelectorAll('.border-b nav a');
    

    function formatMonnaie(montant) {
        return montant  + ' FCFA';
    }
    
    function getQuantiteInputs() {
        return document.querySelectorAll('input[name^="burgers"][name$="[quantite]"]');
    }
    
    function calculerTotal() {
        let total = 0;
        let articleSelectionne = false;
        const quantiteInputs = getQuantiteInputs();
        
      
        recapitulatifCommande.innerHTML = '';
        
        quantiteInputs.forEach(input => {
            const burgerId = input.getAttribute('data-burger-id');
            const burgerPrix = parseInt(input.getAttribute('data-burger-prix'));
            const quantite = parseInt(input.value);
            
            if (quantite > 0) {
                articleSelectionne = true;
                

                const sousTotal = burgerPrix * quantite;
                total += sousTotal;
                
                
                const burgerNom = input.closest('.burger-item').querySelector('h4').textContent;
                
                const item = document.createElement('div');
                item.className = 'flex justify-between';
                item.innerHTML = `
                    <span>${quantite} x ${burgerNom}</span>
                    <span>${formatMonnaie(sousTotal)}</span>
                `;
                recapitulatifCommande.appendChild(item);
            }
        });
        
       
        montantTotalElement.textContent = formatMonnaie(total);
        totalInput.value = total;
        
        
        if (articleSelectionne) {
            btnSoumettreCommande.disabled = false;
        } else {
            btnSoumettreCommande.disabled = true;
            recapitulatifCommande.innerHTML = '<p class="text-gray-500 text-sm italic">Aucun article sélectionné</p>';
        }
        
        return total;
    }
    
    function filtrerBurgers(terme) {
        const termeRecherche = terme.toLowerCase().trim();
        
        burgerItems.forEach(item => {
            const nom = item.getAttribute('data-nom');
            if (termeRecherche === '' || nom.includes(termeRecherche)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    
    
    if (btnNouvelleCommande) {
        btnNouvelleCommande.addEventListener('click', function() {
            modalNouvelleCommande.classList.remove('hidden');
        });
    }
    
    if (btnFermerModal) {
        btnFermerModal.addEventListener('click', function() {
            modalNouvelleCommande.classList.add('hidden');
        });
    }
    
    if (rechercheBurgerInput) {
        rechercheBurgerInput.addEventListener('input', function() {
            filtrerBurgers(this.value);
        });
    }
    
    const quantiteInputs = getQuantiteInputs();
    quantiteInputs.forEach(input => {
        input.addEventListener('input', function() {
            const maxStock = parseInt(this.getAttribute('max'));
            let value = parseInt(this.value) || 0;
            
            if (value < 0) {
                value = 0;
            } else if (value > maxStock) {
                value = maxStock;
            }
            
            this.value = value;
            calculerTotal();
        });
    });
    
  
    calculerTotal();


    
    console.log('Nombre d\'inputs quantité initialisés:', quantiteInputs.length);
});
</script>
@endsection