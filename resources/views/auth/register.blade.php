<x-guest-layout>
    <!-- Logo ISI Burger -->
    <div class="flex justify-center mb-6">
        <h1 class="text-4xl font-bold text-orange-600">ISI Burger</h1>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="p-6 bg-white rounded-lg shadow-md border-t-4 border-orange-500">
        <h2 class="text-2xl font-semibold text-orange-600 mb-6 text-center">Inscription</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="nom" :value="__('Nom')" class="text-orange-800" />
                <x-text-input id="nom" 
                    class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                    type="text" 
                    name="nom" 
                    :value="old('nom')" 
                    required 
                    autofocus 
                    autocomplete="nom" />
                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="prenom" :value="__('Prenom')" class="text-orange-800" />
                <x-text-input id="prenom" 
                    class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                    type="text" 
                    name="prenom" 
                    :value="old('prenom')" 
                    required 
                    autofocus 
                    autocomplete="prenom" />
                <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" class="text-orange-800" />
                <x-text-input id="email" 
                    class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Telephone -->
            <div class="mt-4">
                <x-input-label for="telephone" :value="__('Téléphone')" class="text-orange-800" />
                <x-text-input id="telephone" 
                    class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                    type="tel" 
                    name="telephone" 
                    :value="old('telephone')" 
                    required 
                    autocomplete="tel" />
                <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mot de passe')" class="text-orange-800" />

                <x-text-input id="password" 
                    class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    type="password"
                    name="password"
                    required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-orange-800" />

                <x-text-input id="password_confirmation" 
                    class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    type="password"
                    name="password_confirmation" 
                    required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <a class="text-sm text-orange-600 hover:text-orange-800 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500" 
                    href="{{ route('login') }}">
                    {{ __('Déjà inscrit?') }}
                </a>

                <button type="submit" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Inscription') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>