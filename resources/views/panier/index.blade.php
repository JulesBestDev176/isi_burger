@extends('layouts.app')

@section('title', 'Votre panier - ' . $restaurant->nom)

@section('content')
<div class="bg-white">
    <div class="container mx-auto px-4 py-12">
        <div class="flex flex-col md:flex-row items-start justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Votre panier</h1>
                <p class="mt-1 text-gray-600">Vérifiez vos articles avant de passer commande</p>
            </div>
            
            @if(count($burgers) > 0)
            <a href="{{ route('restaurant') }}" class="mt-4 md:mt-0 text-primary-600 hover:text-primary-700 flex items-center">
                <i class="fas fa-long-arrow-alt-left mr-2"></i> Continuer mes achats
            </a>
            @endif
        </div>
        
        @if(count($burgers) > 0)
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="w-full lg:w-2/3">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4 border-b">
                        <h2 class="font-semibold text-lg text-gray-800">Articles ({{ count($burgers) }})</h2>
                    </div>
                    
                    <ul class="divide-y divide-gray-200">
                        @foreach($burgers as $item)
                            <li class="flex flex-col sm:flex-row py-4 px-4">
                                <div class="flex-shrink-0 w-24 h-24 bg-gray-100 rounded-md overflow-hidden">
                                    @if($item['burger']->image)
                                        <img src="{{ Storage::url($item['burger']->image) }}" alt="{{ $item['burger']->nom }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-hamburger text-gray-400 text-2xl"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="sm:ml-6 mt-4 sm:mt-0 flex-1">
                                    <div class="flex justify-between">
                                        <h3 class="text-base font-medium text-gray-800">{{ $item['burger']->nom }}</h3>
                                        <p class="text-base font-medium text-primary-600">{{ number_format($item['burger']->prix, 0, ',', ' ') }} FCFA</p>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ $item['burger']->description }}</p>
                                    
                                    <div class="flex justify-between items-center mt-4">
                                        <form action="{{ route('panier.modifier') }}" method="POST" class="flex items-center">
                                            @csrf
                                            <input type="hidden" name="burger_id" value="{{ $item['burger']->id }}">
                                            <label for="quantite-{{ $item['burger']->id }}" class="sr-only">Quantité</label>
                                            <div class="flex border rounded overflow-hidden">
                                                <button 
                                                    type="button"
                                                    class="decrement-quantity px-3 py-1 bg-gray-100 text-gray-600 hover:bg-gray-200 focus:outline-none"
                                                >
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input 
                                                    type="number"
                                                    id="quantite-{{ $item['burger']->id }}"
                                                    name="quantite"
                                                    value="{{ $item['quantite'] }}"
                                                    min="1"
                                                    max="{{ $item['burger']->stock }}"
                                                    class="quantity-input w-12 text-center border-0 focus:ring-0"
                                                >
                                                <button 
                                                    type="button"
                                                    class="increment-quantity px-3 py-1 bg-gray-100 text-gray-600 hover:bg-gray-200 focus:outline-none"
                                                >
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <button 
                                                type="submit"
                                                class="ml-2 text-sm text-gray-500 hover:text-primary-600 focus:outline-none"
                                            >
                                                Mettre à jour
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('panier.supprimer', $item['burger']->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit"
                                                class="text-sm text-red-500 hover:text-red-700 focus:outline-none"
                                            >
                                                <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    
                    <div class="p-4 border-t flex justify-between items-center">
                        <form action="{{ route('panier.vider') }}" method="POST">
                            @csrf
                            <button 
                                type="submit"
                                class="text-sm text-gray-500 hover:text-gray-700 focus:outline-none flex items-center"
                            >
                                <i class="fas fa-trash mr-2"></i> Vider le panier
                            </button>
                        </form>
                        
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="text-xl font-bold text-primary-600">{{ number_format($total, 0, ',', ' ') }} FCFA</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="w-full lg:w-1/3 mt-8 lg:mt-0">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4 border-b">
                        <h2 class="font-semibold text-lg text-gray-800">Récapitulatif de la commande</h2>
                    </div>
                    
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sous-total</span>
                            <span class="font-medium">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>
                        
                        
                        <hr>
                        
                        <div class="flex justify-between font-bold">
                            <span>Total</span>
                            <span class="text-primary-600">{{ $total }} FCFA</span>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{route('commande_client.create')}}" class="block w-full py-3 px-4 bg-primary-600 text-white text-center font-medium rounded-lg hover:bg-primary-700 transition">
                                Passer la commande
                            </a>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <p class="text-xs text-gray-500">
                                En passant commande, vous acceptez nos conditions générales de vente.
                            </p>
                        </div>
                    </div>
                </div>
                
                
                <div class="mt-4 bg-white rounded-lg shadow-md p-4">
                    <h3 class="font-medium text-gray-800 mb-2">Modes de paiement acceptés</h3>
                    <div class="flex space-x-3">
                        <div class="p-2 bg-gray-100 rounded">
                            <i class="fas fa-money-bill-wave text-gray-600"></i>
                        </div>
                        <div class="p-2 bg-gray-100 rounded">
                            <i class="fas fa-credit-card text-gray-600"></i>
                        </div>
                        <div class="p-2 bg-gray-100 rounded">
                            <i class="fab fa-cc-visa text-gray-600"></i>
                        </div>
                        <div class="p-2 bg-gray-100 rounded">
                            <i class="fab fa-cc-mastercard text-gray-600"></i>
                        </div>
                        <div class="p-2 bg-gray-100 rounded">
                            <i class="fab fa-cc-paypal text-gray-600"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 text-gray-400 mb-4">
                <i class="fas fa-shopping-cart text-3xl"></i>
            </div>
            <h2 class="text-xl font-medium text-gray-800 mb-2">Votre panier est vide</h2>
            <p class="text-gray-600 mb-6">Ajoutez des burgers à votre panier pour commencer votre commande</p>
            <a href="{{ route('restaurant') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition">
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
   
    const incrementButtons = document.querySelectorAll('.increment-quantity');
    const decrementButtons = document.querySelectorAll('.decrement-quantity');
    
    incrementButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentNode.querySelector('input');
            const maxValue = parseInt(input.getAttribute('max'));
            const currentValue = parseInt(input.value);
            
            if (currentValue < maxValue) {
                input.value = currentValue + 1;
            }
        });
    });
    
    decrementButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentNode.querySelector('input');
            const currentValue = parseInt(input.value);
            
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        });
    });
});
</script>
@endsection