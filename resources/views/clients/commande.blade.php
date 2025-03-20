@extends('layouts.app')

@section('title', 'Mes commandes-', $restaurant->nom)

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Mes commandes</h1>
                <p class="mt-1 text-gray-600">Historique et suivi de toutes vos commandes</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{route('restaurant')}}" class="text-primary-600 hover:text-primary-700 flex items-center">
                    <i class="fas fa-long-arrow-alt-left mr-2"></i> Retour à l'accueil
                </a>
            </div>
        </div>

        
        <div class="bg-white rounded-lg shadow-md mb-6">
            <div class="p-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-search text-gray-400"></i>
                            </span>
                            <input type="text" id="search-commandes" class="pl-10 pr-4 py-2 w-full rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Rechercher une commande...">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-2">
                        <select id="filter-status" class="px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                            <option value="all">Tous les statuts</option>
                            <option value="en attente">En attente</option>
                            <option value="en préparation">En préparation</option>
                            <option value="prête">Prête</option>
                            <option value="payée">Payée</option>
                        </select>
                        
                    </div>
                </div>
            </div>
        </div>

        @if(count($commandes) > 0)
            
            <div class="space-y-6 mb-8">
                @foreach($commandes as $commande)
                    <div class="commande-item bg-white rounded-lg shadow-md overflow-hidden" 
                         data-commande-id="{{ $commande->id }}"
                         data-commande-date="{{ \Carbon\Carbon::parse($commande->date_commande)->format('Y-m-d') }}"
                         data-commande-status="{{ $commande->statut }}">
                        
                        <div class="border-b border-gray-200">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-center p-4">
                                <div class="flex flex-col md:flex-row md:items-center mb-3 md:mb-0">
                                    <div class="font-medium text-gray-900 mb-1 md:mb-0 md:mr-4">
                                        Commande #{{ $commande->id }}
                                    </div>
                                    
                                    @php
                                        $statusClasses = [
                                            'en attente' => 'bg-yellow-100 text-yellow-800',
                                            'en préparation' => 'bg-blue-100 text-blue-800',
                                            'prête' => 'bg-green-100 text-green-800',
                                            'payée' => 'bg-gray-100 text-gray-800',
                                        ];
                                        $statusClass = $statusClasses[$commande->statut] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    
                                    <span class="px-2 py-1 text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ ucfirst($commande->statut) }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center space-x-4">
                                    <div class="text-sm text-gray-500">
                                        <i class="far fa-calendar-alt mr-1"></i> 
                                        {{ \Carbon\Carbon::parse($commande->date_commande)->format('d M Y, H:i') }}
                                    </div>
                                    
                                    @if($commande->statut == 'payée')
                                        <a href="{{ route('factures.show', $commande->id) }}" target="_blank" class="text-primary-600 hover:text-primary-800 flex items-center">
                                            <i class="fas fa-print mr-1"></i> 
                                            <span class="hidden sm:inline">Facture</span>
                                        </a>
                                    @endif
                                    
                                    <button class="toggle-details text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                       
                        <div class="details-panel hidden p-4">
                            <div class="flex flex-col md:flex-row border-b border-gray-200 pb-4 mb-4">
                                <div class="w-full md:w-1/4 mb-4 md:mb-0">
                                    <h4 class="font-medium text-gray-900 mb-2">Informations</h4>
                                    <ul class="text-sm text-gray-600 space-y-1">
                                        <li>
                                            <span class="font-medium">Type:</span> 
                                            {{ $commande->type == 'emporte' ? 'À emporter' : 'Sur place' }}
                                        </li>
                                        <li>
                                            <span class="font-medium">Mode de paiement:</span> 
                                            {{ ucfirst($commande->mode_paiement) }}
                                        </li>
                                        @if($commande->date_paiement)
                                        <li>
                                            <span class="font-medium">Date de paiement:</span>
                                            {{ \Carbon\Carbon::parse($commande->date_paiement)->format('d/m/Y H:i') }}
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                                
                                <div class="w-full md:w-3/4">
                                    <h4 class="font-medium text-gray-900 mb-2">Articles commandés</h4>
                                    
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full">
                                            <thead>
                                                <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    <th class="pb-2">Article</th>
                                                    <th class="pb-2">Prix unitaire</th>
                                                    <th class="pb-2">Quantité</th>
                                                    <th class="pb-2">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-sm divide-y divide-gray-200">
                                                @foreach($commande->burgers as $burger)
                                                    <tr>
                                                        <td class="py-2 pr-2">
                                                            <div class="flex items-center">
                                                                <div class="h-10 w-10 flex-shrink-0 mr-3">
                                                                    @if($burger->image)
                                                                        <img class="h-10 w-10 rounded-md object-cover" 
                                                                             src="{{ Storage::url($burger->image) }}" 
                                                                             alt="{{ $burger->nom }}">
                                                                    @else
                                                                        <div class="h-10 w-10 rounded-md bg-gray-200 flex items-center justify-center">
                                                                            <i class="fas fa-hamburger text-gray-400"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="font-medium text-gray-900">
                                                                    {{ $burger->nom }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="py-2 pr-2">{{ number_format($burger->prix, 0, ',', ' ') }} FCFA</td>
                                                        <td class="py-2 pr-2">{{ $burger->pivot->quantite }}</td>
                                                        <td class="py-2 pr-2">{{ number_format($burger->prix * $burger->pivot->quantite, 0, ',', ' ') }} FCFA</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr class="border-t border-gray-200">
                                                    <td colspan="3" class="py-3 text-right font-medium">Total</td>
                                                    <td class="py-3 font-bold text-primary-600">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div>
                                <h4 class="font-medium text-gray-900 mb-3">Suivi de commande</h4>
                                
                                <div class="flex justify-between items-center">
                                    @php
                                        $statusSteps = ['en attente', 'en préparation', 'prête', 'payée'];
                                        $currentStatusIndex = array_search($commande->statut, $statusSteps);
                                    @endphp
                                    
                                    @foreach($statusSteps as $index => $status)
                                        <div class="flex flex-col items-center">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $index <= $currentStatusIndex ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                                                @if($status == 'en attente')
                                                    <i class="fas fa-clock"></i>
                                                @elseif($status == 'en préparation')
                                                    <i class="fas fa-utensils"></i>
                                                @elseif($status == 'prête')
                                                    <i class="fas fa-check"></i>
                                                @elseif($status == 'payée')
                                                    <i class="fas fa-money-bill-wave"></i>
                                                @endif
                                            </div>
                                            <div class="text-xs font-medium text-gray-700 mt-1">
                                                {{ ucfirst($status) }}
                                            </div>
                                        </div>
                                        
                                        @if($index < count($statusSteps) - 1)
                                            <div class="flex-1 h-1 {{ $index < $currentStatusIndex ? 'bg-primary-600' : 'bg-gray-200' }}"></div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
           
            <div class="mt-6">
                <!-- {{ $commandes->links('pagination::tailwind') }} -->
            </div>
        @else
            
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 text-gray-400 mb-4">
                    <i class="fas fa-receipt text-3xl"></i>
                </div>
                <h2 class="text-xl font-medium text-gray-800 mb-2">Vous n'avez pas encore de commande</h2>
                <p class="text-gray-600 mb-6">Commandez vos burgers préférés pour voir votre historique ici</p>
                <a href="{{ route('restaurant') }}#menu" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition">
                    <i class="fas fa-utensils mr-2"></i> Voir le menu
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.toggle-details');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const detailsPanel = this.closest('.commande-item').querySelector('.details-panel');
            detailsPanel.classList.toggle('hidden');
            
           
            const icon = this.querySelector('i');
            if (detailsPanel.classList.contains('hidden')) {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            } else {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        });
    });
    
   
    const searchInput = document.getElementById('search-commandes');
    const statusFilter = document.getElementById('filter-status');
    const dateFilter = document.getElementById('filter-date');
    const commandeItems = document.querySelectorAll('.commande-item');
    
    function filterCommandes() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const dateValue = dateFilter.value;
        
        commandeItems.forEach(item => {
            const commandeId = item.getAttribute('data-commande-id');
            const commandeStatus = item.getAttribute('data-commande-status');
            const commandeDate = new Date(item.getAttribute('data-commande-date'));
            
            let matchSearch = commandeId.includes(searchTerm);
            let matchStatus = statusValue === 'all' || commandeStatus === statusValue;
            let matchDate = true;
            
           
            if (dateValue !== 'all') {
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                const todayYear = today.getFullYear();
                const todayMonth = today.getMonth();
                const todayDate = today.getDate();
                const todayDay = today.getDay() || 7; 
                
                if (dateValue === 'today') {
                    matchDate = commandeDate.setHours(0, 0, 0, 0) === today.getTime();
                } else if (dateValue === 'week') {
                    
                    const firstDayOfWeek = new Date(today);
                    firstDayOfWeek.setDate(todayDate - (todayDay - 1));
                    
                    matchDate = commandeDate >= firstDayOfWeek;
                } else if (dateValue === 'month') {
                    matchDate = commandeDate.getFullYear() === todayYear && 
                               commandeDate.getMonth() === todayMonth;
                } else if (dateValue === 'year') {
                    matchDate = commandeDate.getFullYear() === todayYear;
                }
            }
            
            if (matchSearch && matchStatus && matchDate) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
        
        
        checkNoResults();
    }
    
    function checkNoResults() {
        const visibleItems = document.querySelectorAll('.commande-item[style="display: block"]');
        const noResultsMessage = document.getElementById('no-results-message');
        
        if (visibleItems.length === 0 && commandeItems.length > 0) {
            if (!noResultsMessage) {
                const message = document.createElement('div');
                message.id = 'no-results-message';
                message.className = 'bg-white rounded-lg shadow-md p-6 text-center mt-6';
                message.innerHTML = `
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-400 mb-4">
                        <i class="fas fa-search text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Aucune commande trouvée</h3>
                    <p class="text-gray-600">Aucune commande ne correspond à vos critères de recherche.</p>
                    <button id="reset-filters" class="mt-4 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                        Réinitialiser les filtres
                    </button>
                `;
                
                document.querySelector('.space-y-6').after(message);
                
                
                document.getElementById('reset-filters').addEventListener('click', resetFilters);
            }
        } else if (noResultsMessage) {
            noResultsMessage.remove();
        }
    }
    
    function resetFilters() {
        searchInput.value = '';
        statusFilter.value = 'all';
        dateFilter.value = 'all';
        filterCommandes();
    }
    
    
    searchInput.addEventListener('input', filterCommandes);
    statusFilter.addEventListener('change', filterCommandes);
    dateFilter.addEventListener('change', filterCommandes);
});
</script>
@endsection