<x-guest-layout>
    <!-- Logo ISI Burger -->
    <div class="flex justify-center mb-6">
        <h1 class="text-4xl font-bold text-orange-600">ISI Burger</h1>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md border-t-4 border-orange-500">
        <h2 class="text-2xl font-semibold text-orange-600 mb-4 text-center">Réinitialisation du mot de passe</h2>

        <div class="mb-4 text-sm text-gray-700">
            {{ __('Mot de passe oublié ? Pas de problème. Indiquez-nous simplement votre adresse e-mail et nous vous enverrons un lien de réinitialisation qui vous permettra d\'en choisir un nouveau.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-orange-800" />
                <x-text-input id="email" 
                    class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('login') }}" class="text-sm text-orange-600 hover:text-orange-800 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    {{ __('Retour à la connexion') }}
                </a>

                <button type="submit" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Envoyer le lien') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>