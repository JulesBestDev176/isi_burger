@extends('dashboard')

@section('title', 'Paramètres du compte')
@section('content')
<div class="container mx-auto px-4 py-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Paramètres du compte</h1>
            <p class="mt-1 text-sm text-gray-500">Modifiez vos informations personnelles et sécurisez votre compte</p>
        </div>
    </div>

    @if (session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('status') }}
        </div>
    @endif

    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="border-b">
            <nav class="flex -mb-px">
                <button id="tab-profile" onclick="switchTab('profile')" class="border-primary-500 text-primary-600 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Profil
                </button>
                <button id="tab-password" onclick="switchTab('password')" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Mot de passe
                </button>
            </nav>
        </div>

        
        <div id="content-profile" class="p-6">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 mb-6 md:mb-0">
                        <div class="flex flex-col items-center">
                            <div class="mb-4 relative">
                                <div class="h-32 w-32 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 overflow-hidden">
                                    @if(Auth::user()->profile_photo_path)
                                        <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
                                    @else
                                        <i class="fas fa-user text-5xl"></i>
                                    @endif
                                </div>
                                <label for="photo" class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-md cursor-pointer">
                                    <i class="fas fa-camera text-primary-600"></i>
                                    <!-- <input type="file" name="photo" id="photo" class="hidden"> -->
                                </label>
                            </div>
                            <p class="text-sm text-gray-500">JPG ou PNG. Max 2MB.</p>
                        </div>
                    </div>
                    
                    <div class="md:w-2/3 md:pl-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                                <input type="tel" name="prenom" id="prenom" value="{{ Auth::user()->prenom ?? '' }}" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                                @error('prenom')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                <input type="text" name="nom" id="nom" value="{{ Auth::user()->nom }}" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                                @error('nom')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

    
                            
                            <div >
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse e-mail</label>
                                <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div >
                                <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                <input type="text" name="telephone" id="telephone" value="{{ Auth::user()->telephone }}" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                                @error('telephone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            
                    
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg shadow hover:bg-primary-700 transition-colors">
                                Sauvegarder les modifications
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        
        <div id="content-password" class="p-6 hidden">
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-xl">
                    <div class="md:col-span-2">
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel</label>
                        <input type="password" name="current_password" id="current_password" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                        <input type="password" name="password" id="password" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le nouveau mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    
                    <div class="md:col-span-2">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Assurez-vous d'utiliser un mot de passe sécurisé avec au moins 8 caractères, des lettres majuscules, minuscules, des chiffres et des symboles.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg shadow hover:bg-primary-700 transition-colors">
                            Mettre à jour le mot de passe
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
</div>

<script>
    function switchTab(tab) {
        document.querySelectorAll('[id^="content-"]').forEach(section => {
            section.classList.add('hidden');
        });

        document.getElementById(`content-${tab}`).classList.remove('hidden');

        document.querySelectorAll('[id^="tab-"]').forEach(button => {
            button.classList.remove('border-primary-500', 'text-primary-600');
            button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        });

        document.getElementById(`tab-${tab}`).classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        document.getElementById(`tab-${tab}`).classList.add('border-primary-500', 'text-primary-600');
    }

 
    document.addEventListener('DOMContentLoaded', function() {
        switchTab('profile');
    });
</script>
@endsection