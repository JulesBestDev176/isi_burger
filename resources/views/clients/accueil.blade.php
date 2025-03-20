@extends('layouts.app')

@section('title', 'Accueil - ' . $restaurant->nom)

@section('content')
<div class="bg-white">
  
    <div class="container mx-auto px-4 py-12">
        <div class="flex flex-col md:flex-row items-center gap-8">
           
            <div class="w-full md:w-1/2">
                <div class="relative rounded-xl overflow-hidden shadow-xl h-96">
                    @if($restaurant->logo)
                        <img src="{{ Storage::url($restaurant->logo) }}" alt="{{ $restaurant->nom }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-r from-primary-500 to-primary-700 flex items-center justify-center">
                            <i class="fas fa-utensils text-white text-6xl"></i>
                        </div>
                    @endif
                </div>
            </div>
            
           
            <div class="w-full md:w-1/2 mt-8 md:mt-0">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">{{ $restaurant->nom }}</h1>
                <div class="flex items-center mt-3">
                    <div class="flex text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="ml-2 text-gray-600">4.8/5 (157 avis)</span>
                </div>
                
                <p class="mt-4 text-gray-600 leading-relaxed">
                    {{ $restaurant->description }}
                </p>
                
                <div class="mt-6 space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-primary-600 w-6"></i>
                        <span class="text-gray-700">{{ $restaurant->adresse }}, {{ $restaurant->code_postal }} {{ $restaurant->ville }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-phone text-primary-600 w-6"></i>
                        <span class="text-gray-700">{{ $restaurant->tel }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope text-primary-600 w-6"></i>
                        <span class="text-gray-700">{{ $restaurant->email }}</span>
                    </div>
                </div>
                
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#menu" class="px-6 py-3 bg-primary-600 text-white font-medium rounded-lg shadow hover:bg-primary-700 transition flex items-center">
                        <i class="fas fa-hamburger mr-2"></i> Voir notre menu
                    </a>
                    <a href="" class="px-6 py-3 border border-primary-600 text-primary-600 font-medium rounded-lg hover:bg-primary-50 transition flex items-center">
                        <i class="fas fa-shopping-bag mr-2"></i> Commander maintenant
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="bg-gray-50 py-8" id="menu">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Notre Menu</h2>
                
                <div class="w-full md:w-auto flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    
                    <div class="relative flex-grow md:max-w-sm">
                        <input 
                            type="text" 
                            id="searchBurger"
                            placeholder="Rechercher un burger..." 
                            class="pl-10 pr-4 py-2 w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                    
                    
                    <select id="sortBurgers" class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="default">Trier par</option>
                        <option value="price-asc">Prix (croissant)</option>
                        <option value="price-desc">Prix (décroissant)</option>
                        <option value="name-asc">Nom (A-Z)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
   
    <div class="container mx-auto px-4 py-12">
        <div id="burgersList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($burgers as $burger)
                <div class="burger-item bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="relative">
                        <div class="h-56 bg-gray-200">
                            @if ($burger->image)
                                <img src="{{ Storage::url($burger->image) }}" alt="{{ $burger->nom }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                    <i class="fas fa-hamburger text-gray-400 text-4xl"></i>
                                </div>
                            @endif
                        </div>
                        
                        
                        <div class="absolute top-3 right-3">
                            @if($burger->quantite > 0)
                                <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    Disponible
                                </span>
                            @else
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    Épuisé
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">{{ $burger->nom }}</h3>
                                <p class="mt-2 text-gray-600 line-clamp-2">{{ $burger->description }}</p>
                            </div>
                            <div class="font-bold text-xl text-primary-600">{{ $burger->prix }} FCFA</div>
                        </div>
                        
                        <div class="mt-6">
                            @if($burger->quantite > 0)
                                <form action="{{route('panier.ajouter')}}" method="POST" class="flex items-center">
                                    @csrf
                                    <input type="hidden" name="burger_id" value="{{ $burger->id }}">
                                    
                                    <div class="flex-1 mr-3 flex border rounded-lg overflow-hidden">
                                        <button 
                                            type="button"
                                            class="decrement-quantity px-3 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200"
                                        >
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input 
                                            type="number"
                                            name="quantite"
                                            value="1"
                                            min="1"
                                            max="{{ $burger->quantite }}"
                                            class="quantity-input w-12 text-center border-0 focus:ring-0"
                                        >
                                        <button 
                                            type="button"
                                            class="increment-quantity px-3 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200"
                                        >
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    
                                    <button 
                                        type="submit"
                                        class="flex-1 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition flex items-center justify-center"
                                    >
                                        <i class="fas fa-cart-plus mr-2"></i> Ajouter
                                    </button>
                                </form>
                            @else
                                <button 
                                    disabled
                                    class="w-full px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed flex items-center justify-center"
                                >
                                    <i class="fas fa-times-circle mr-2"></i> Indisponible
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 text-primary-600 mb-4">
                        <i class="fas fa-utensils text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900">Aucun burger disponible</h3>
                    <p class="mt-2 text-gray-500">Revenez plus tard, notre chef est en train de préparer de délicieuses nouveautés.</p>
                </div>
            @endforelse
        </div>
        
        
        
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const incrementButtons = document.querySelectorAll('.increment-quantity');
    const decrementButtons = document.querySelectorAll('.decrement-quantity');
    
    incrementButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentNode.querySelector('.quantity-input');
            const maxValue = parseInt(input.getAttribute('max'));
            const currentValue = parseInt(input.value);
            
            if (currentValue < maxValue) {
                input.value = currentValue + 1;
            }
        });
    });
    
    decrementButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentNode.querySelector('.quantity-input');
            const currentValue = parseInt(input.value);
            
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        });
    });
    
    // Recherche de burgers
    const searchInput = document.getElementById('searchBurger');
    searchInput.addEventListener('input', filterBurgers);
    
    // Tri des burgers
    const sortSelect = document.getElementById('sortBurgers');
    sortSelect.addEventListener('change', sortBurgers);
    
    function filterBurgers() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const burgerItems = document.querySelectorAll('.burger-item');
        
        burgerItems.forEach(item => {
            const burgerName = item.querySelector('h3').textContent.toLowerCase();
            const burgerDescription = item.querySelector('p').textContent.toLowerCase();
            
            if (burgerName.includes(searchTerm) || burgerDescription.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
        
        checkNoResults();
    }
    
    function sortBurgers() {
        const burgersList = document.getElementById('burgersList');
        const burgerItems = Array.from(document.querySelectorAll('.burger-item'));
        const sortBy = sortSelect.value;
        
        burgerItems.sort((a, b) => {
            if (sortBy === 'price-asc') {
                return extractPrice(a) - extractPrice(b);
            } else if (sortBy === 'price-desc') {
                return extractPrice(b) - extractPrice(a);
            } else if (sortBy === 'name-asc') {
                return a.querySelector('h3').textContent.localeCompare(b.querySelector('h3').textContent);
            } else {
                return 0; 
            }
        });
        
        
        burgerItems.forEach(item => burgersList.appendChild(item));
    }
    
    function extractPrice(item) {
        const priceText = item.querySelector('.text-primary-600').textContent;
        return parseInt(priceText.replace(/[^\d]/g, ''));
    }
    
    function checkNoResults() {
        const burgersList = document.getElementById('burgersList');
        const visibleItems = document.querySelectorAll('.burger-item[style="display: block"]');
        
        
        const existingNoResults = document.getElementById('no-results-message');
        if (existingNoResults) {
            existingNoResults.remove();
        }
        
        
        if (visibleItems.length === 0) {
            const searchTerm = searchInput.value;
            const noResultsMessage = document.createElement('div');
            noResultsMessage.id = 'no-results-message';
            noResultsMessage.className = 'col-span-full py-12 text-center';
            noResultsMessage.innerHTML = `
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-500 mb-4">
                    <i class="fas fa-search text-3xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-900">Aucun résultat</h3>
                <p class="mt-2 text-gray-500">Aucun burger ne correspond à votre recherche "${searchTerm}"</p>
            `;
            
            burgersList.appendChild(noResultsMessage);
        }
    }
});
</script>
@endsection