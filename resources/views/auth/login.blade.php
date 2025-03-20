<x-guest-layout>
    <!-- Logo ISI Burger -->
    <div class="flex justify-center mb-6">
        <h1 class="text-4xl font-bold text-orange-600">ISI Burger</h1>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="p-6 bg-white rounded-lg shadow-md border-t-4 border-orange-500">
        <h2 class="text-2xl font-semibold text-orange-600 mb-6 text-center">Connexion</h2>

        <form method="POST" action="{{ route('login') }}">
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
                    autofocus 
                    autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mot de passe')" class="text-orange-800" />

                <x-text-input id="password" 
                    class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" 
                        class="rounded border-orange-300 text-orange-600 shadow-sm focus:ring-orange-500" 
                        name="remember">
                    <span class="ms-2 text-sm text-black-600">{{ __('Se souvenir de moi') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="text-sm text-orange-600 hover:text-orange-800 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500" 
                        href="{{ route('password.request') }}">
                        {{ __('Mot de passe oublié?') }}
                    </a>
                @endif

                <button type="submit" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Connexion') }}
                </button>
            </div>
        </form>

        <!-- Lien d'inscription -->
        <div class="text-center mt-4">
            <a class="text-sm text-orange-600 hover:text-orange-800 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500" 
                href="{{ route('register') }}">
                {{ __('Pas encore de compte? Inscrivez-vous') }}
            </a>
        </div>
    </div>
</x-guest-layout>