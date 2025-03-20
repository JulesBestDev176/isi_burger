@extends('dashboard')

@section('title', 'Dashboard - ISI Burger')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Tableau de bord</h1>
            
            
            <div class="flex items-center mt-4 md:mt-0 space-x-4">
                <div class="relative">
                    <input 
                        type="date" 
                        id="date-filter"
                        class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        value="{{ date('Y-m-d') }}"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar text-gray-400"></i>
                    </div>
                </div>
                <button id="refresh-data" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition flex items-center">
                    <i class="fas fa-sync-alt mr-2"></i> Actualiser
                </button>
            </div>
        </div>
        
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Commandes en cours</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ $enCours }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('commandes.index', ['statut' => 'en cours']) }}" class="text-sm text-primary-600 hover:text-primary-800 flex items-center">
                        Voir détails <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
           
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Commandes validées</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ $validees }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('commandes.index', ['statut' => 'payée']) }}" class="text-sm text-primary-600 hover:text-primary-800 flex items-center">
                        Voir détails <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-primary-100 text-primary-600">
                        <i class="fas fa-money-bill-wave text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Recette journalière</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ number_format($recette, 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm {{ $evolution > 0 ? 'text-green-600' : 'text-red-600' }} flex items-center">
                        <i class="fas fa-{{ $evolution > 0 ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                        {{ abs($evolution) }}% par rapport à hier
                    </span>
                </div>
            </div>
            
           
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-hamburger text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Burgers vendus</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ $burgersVendus }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm {{ $evolutionBurgers > 0 ? 'text-green-600' : 'text-red-600' }} flex items-center">
                        <i class="fas fa-{{ $evolutionBurgers > 0 ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                        {{ abs($evolutionBurgers) }}% par rapport à hier
                    </span>
                </div>
            </div>
        </div>
        
       
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Évolution des commandes</h3>
                <div class="h-80">
                    <canvas id="commandesChart"></canvas>
                </div>
            </div>
            
           
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Burgers par catégorie</h3>
                <div class="h-80">
                    <canvas id="categorieChart"></canvas>
                </div>
            </div>
        </div>
        
        
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Commandes récentes</h3>
                <a href="{{ route('commandes.index') }}" class="text-sm text-primary-600 hover:text-primary-800 flex items-center">
                    Voir toutes <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($commandes as $commande)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">#{{ $commande->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $commande->user_name }}</div>
                                <div class="text-sm text-gray-500">{{ $commande->user_email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $commande->statut == 'payée' ? 'bg-green-100 text-green-800' : 
                                       ($commande->statut == 'en préparation' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($commande->statut == 'prête' ? 'bg-blue-100 text-blue-800' : 
                                       ($commande->statut == 'annulé' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))) }}">
                                    {{ ucfirst($commande->statut) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $commande->type == 'sur place' ? 'bg-indigo-100 text-indigo-800' : 
                                       ($commande->type == 'emporte' ? 'bg-purple-100 text-purple-800' : 'bg-pink-100 text-pink-800') }}">
                                    {{ ucfirst($commande->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                Aucune commande récente
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
       
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Burgers les plus populaires</h3>
                <a href="{{ route('burgers.index') }}" class="text-sm text-primary-600 hover:text-primary-800 flex items-center">
                    Voir tous <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($burgersPopulaires as $burger)
                <div class="bg-gray-50 rounded-lg p-4 flex items-center">
                    <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden">
                        @if($burger->image)
                            <img src="{{ Storage::url($burger->image) }}" alt="{{ $burger->nom }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-300">
                                <i class="fas fa-hamburger text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    <div class="ml-4">
                        <h4 class="text-gray-800 font-medium">{{ $burger->nom }}</h4>
                        <p class="text-sm text-gray-600">{{ $burger->vendu }} vendus</p>
                        <p class="text-sm font-medium text-primary-600">{{ number_format($burger->prix, 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const commandesCtx = document.getElementById('commandesChart').getContext('2d');
    const commandesChart = new Chart(commandesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($commandesMois->pluck('mois')) !!},
            datasets: [{
                label: 'Nombre de commandes',
                data: {!! json_encode($commandesMois->pluck('total')) !!},
                backgroundColor: 'rgba(249, 115, 22, 0.2)',
                borderColor: 'rgba(249, 115, 22, 1)',
                borderWidth: 2,
                tension: 0.4,
                pointBackgroundColor: 'rgba(249, 115, 22, 1)',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                }
            }
        }
    });
    
    const categorieCtx = document.getElementById('categorieChart').getContext('2d');
    const categorieChart = new Chart(categorieCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($burgerCategories->pluck('categorie')) !!},
            datasets: [{
                label: 'Nombre de burgers vendus',
                data: {!! json_encode($burgerCategories->pluck('total')) !!},
                backgroundColor: [
                    'rgba(249, 115, 22, 0.7)',
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(16, 185, 129, 0.7)',
                    'rgba(245, 158, 11, 0.7)',
                    'rgba(139, 92, 246, 0.7)'
                ],
                borderColor: [
                    'rgba(249, 115, 22, 1)',
                    'rgba(59, 130, 246, 1)',
                    'rgba(16, 185, 129, 1)',
                    'rgba(245, 158, 11, 1)',
                    'rgba(139, 92, 246, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    
    const dateFilter = document.getElementById('date-filter');
    const refreshButton = document.getElementById('refresh-data');
    
    refreshButton.addEventListener('click', function() {
        const selectedDate = dateFilter.value;
        window.location.href = `{{ route('dashboard') }}?date=${selectedDate}`;
    });
});
</script>
@endsection
