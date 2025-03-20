<x-guest-layout>
    <!-- Logo ISI Burger -->
    <div class="flex justify-center mb-6">
        <h1 class="text-4xl font-bold text-orange-600">ISI Burger</h1>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md border-t-4 border-orange-500">
        <h2 class="text-2xl font-semibold text-orange-600 mb-6 text-center">Définir un nouveau mot de passe</h2>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-orange-800" />
                <x-text-input id="email" 
                    class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                    type="email" 
                    name="email" 
                    :value="old('email', $request->email)" 
                    required 
                    autofocus 
                    autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Nouveau mot de passe')" class="text-orange-800" />
                <x-text-input id="password" 
                    class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    type="password"
                    name="password"
                    required 
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-orange-800" />

                <x-text-input id="password_confirmation" 
                    class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    type="password"
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Réinitialiser le mot de passe') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>