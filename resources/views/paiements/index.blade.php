@extends('dashboard')

@section('title', 'Gestion des paiements')
@section('content')
<div class="container mx-auto px-4 py-6">
   
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Gestion des Paiements</h1>
            <p class="mt-1 text-sm text-gray-500">Consultez et gérez tous les paiements reçus et en attente</p>
        </div>
        
    </div>

    
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="border-b">
            <nav class="flex -mb-px overflow-x-auto">
                <a href="#" class="border-primary-500 text-primary-600 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Tous ({{$commandes->count()}})
                </a>
            </nav>
        </div>

        
        <div class="p-4">
            <form action="" method="GET">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-search text-gray-400"></i>
                            </span>
                            <input type="text" name="search" class="pl-10 pr-4 py-2 w-full rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Rechercher par transaction, client ou méthode...">
                        </div>
                    </div>
                    <!-- <div class="flex flex-col md:flex-row gap-2">
                        <select name="payment_method" class="px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Toutes les méthodes</option>
                            <option value="card">Carte bancaire</option>
                            <option value="cash">Espèces</option>
                            <option value="mobile">Paiement mobile</option>
                        </select>
                        <select name="amount_range" class="px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Tous les montants</option>
                            <option value="0-20">0 - 20 €</option>
                            <option value="20-50">20 - 50 €</option>
                            <option value="50-100">50 - 100 €</option>
                            <option value="100+">Plus de 100 €</option>
                        </select>
                        <select name="date_range" class="px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                            <option value="7">7 derniers jours</option>
                            <option value="today">Aujourd'hui</option>
                            <option value="yesterday">Hier</option>
                            <option value="30">30 derniers jours</option>
                            <option value="this_month">Ce mois-ci</option>
                            <option value="last_month">Mois dernier</option>
                            <option value="custom">Personnalisé</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md">
                            <i class="fas fa-filter mr-1"></i> Filtrer
                        </button>
                    </div> -->
                </div>
                
                
                <div id="customDateRange" class="hidden mt-3 flex flex-col sm:flex-row gap-2">
                    <div class="flex items-center">
                        <label class="mr-2 text-sm text-gray-600">Du:</label>
                        <input type="date" name="date_from" class="px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div class="flex items-center">
                        <label class="mr-2 text-sm text-gray-600">Au:</label>
                        <input type="date" name="date_to" class="px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg shadow hover:bg-primary-700 transition-colors">
                        Appliquer
                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Transaction #
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Commande
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Client
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Montant
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Méthode
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
                                <div class="text-sm font-medium text-primary-600">{{ $commande->numero_paiement }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium">#ORD-{{ $commande->id }}</div>
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
                                <div class="text-sm text-gray-900">
                                @switch($commande->mode_paiement)
                                    @case('espèces')
                                        <i class="fas fa-money-bill-wave text-gray-500 mr-2"></i>
                                        @break
                                    @case('carte bancaire')
                                        <i class="fas fa-credit-card text-gray-500 mr-2"></i>
                                        @break

                                    @case('mobile money')
                                        <i class="fas fa-mobile-alt text-gray-500 mr-2"></i>
                                        @break
                                @endswitch
                                {{ $commande->mode_paiement }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ ucfirst($commande->statut) }}
                                </span>
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
    
    
    <div class="hidden bg-white rounded-lg shadow p-8 text-center mt-6">
        <div class="mx-auto w-24 h-24 bg-primary-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-money-bill-wave text-4xl text-primary-600"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun paiement trouvé</h3>
        <p class="text-sm text-gray-500 mb-6">Aucun paiement ne correspond à vos critères de recherche actuels.</p>
        <button class="px-4 py-2 bg-primary-600 text-white rounded-lg shadow hover:bg-primary-700 transition-colors">
            Réinitialiser les filtres
        </button>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateRangeSelect = document.querySelector('select[name="date_range"]');
        const customDateRange = document.getElementById('customDateRange');
        
        dateRangeSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customDateRange.classList.remove('hidden');
            } else {
                customDateRange.classList.add('hidden');
            }
        });
    });
</script>
@endsection