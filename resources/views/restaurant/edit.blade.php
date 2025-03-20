@extends('dashboard')

@section('title', 'Informations du restaurant')
@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-8 border-b border-gray-200 pb-5">
        <h1 class="text-3xl font-bold text-gray-800">Informations du restaurant</h1>
        <p class="mt-2 text-gray-600">Personnalisez les informations et l'identité de votre restaurant</p>
    </div>

    @if (session('status'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle mt-1"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm">{{ session('status') }}</p>
                </div>
            </div>
        </div>
    @endif

    
    <form action="{{ route('restaurant.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Identité visuelle</h2>
        
        <div class="flex flex-col md:flex-row items-center md:items-start">
            <div class="mb-6 md:mb-0 md:mr-8">
            <div class="relative group">
                <div class="h-40 w-40 rounded-xl bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center text-primary-600 overflow-hidden shadow-sm border border-gray-200">
                    <!-- @if($restaurant->logo)
                        <img src="{{ Storage::url($restaurant->logo) }}" alt="Logo du restaurant" class="h-full w-full object-cover" id="logo-preview">
                    @else -->
                        <i class="fas fa-utensils text-6xl opacity-70" id="default-icon"></i>
                    <!-- @endif -->
                </div>
                <!-- <label for="logo" class="absolute bottom-2 right-2 bg-white rounded-full p-3 shadow cursor-pointer hover:bg-gray-50 transition-colors border border-gray-200">
                    <i class="fas fa-camera text-primary-600"></i>
                    <input type="file" name="logo" id="logo" class="hidden">
                </label> -->
            </div>
                <!-- <p class="text-sm text-gray-500 mt-3 text-center">Format JPG ou PNG (max 2MB)</p> -->
            </div>
            
            <div class="flex-1 w-full">
                <div class="mb-5">
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom du restaurant</label>
                    <input type="text" name="nom" id="nom" value="{{ $restaurant->nom }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-shadow">
                    @error('nom')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-shadow resize-none" placeholder="Décrivez votre restaurant en quelques mots...">{{ $restaurant->description }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Coordonnées</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="tel" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-phone text-gray-400"></i>
                    </div>
                    <input type="tel" name="tel" id="tel" value="{{ $restaurant->tel }}" class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-shadow">
                </div>
                @error('tel')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" name="email" id="email" value="{{ $restaurant->email }}" class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-shadow">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

   
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Localisation</h2>
        
        <div class="space-y-5">
            <div>
                <label for="adresse" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                    </div>
                    <input type="text" name="adresse" id="adresse" value="{{ $restaurant->adresse }}" class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-shadow">
                </div>
                @error('adresse')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="ville" class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                    <input type="text" name="ville" id="ville" value="{{ $restaurant->ville }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-shadow">
                    @error('ville')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="code_postal" class="block text-sm font-medium text-gray-700 mb-1">Code postal</label>
                    <input type="text" name="code_postal" id="code_postal" value="{{ $restaurant->code_postal }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-shadow">
                    @error('code_postal')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    
    <div class="flex justify-end space-x-4">
        <button type="button" onclick="window.history.back()" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg shadow-sm hover:bg-gray-50 transition-colors">
            Annuler
        </button>
        <button type="submit" class="px-6 py-3 bg-primary-600 text-white rounded-lg shadow-md hover:bg-primary-700 transition-colors flex items-center">
            <i class="fas fa-save mr-2"></i> Sauvegarder les modifications
        </button>
    </div>
</form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const logoInput = document.getElementById('logo');
        const logoPreview = document.getElementById('logo-preview');
        const defaultIcon = document.getElementById('default-icon');

        logoInput.addEventListener('change', function (event) {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    
                    if (logoPreview) {
                        logoPreview.src = e.target.result;
                        logoPreview.classList.remove('hidden');
                    } else {
                       
                        const newLogoPreview = document.createElement('img');
                        newLogoPreview.id = 'logo-preview';
                        newLogoPreview.src = e.target.result;
                        newLogoPreview.classList.add('h-full', 'w-full', 'object-cover');
                        document.querySelector('.relative.group div').prepend(newLogoPreview);
                    }

                    if (defaultIcon) {
                        defaultIcon.classList.add('hidden');
                    }
                };

                reader.readAsDataURL(file);
            }
        });
    });
    
</script>
@endsection