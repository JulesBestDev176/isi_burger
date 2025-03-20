
<div class="hidden md:flex flex-col w-64 bg-white shadow-lg">

    <div class="flex items-center justify-center h-16 border-b">
        <h1 class="text-2xl font-bold text-primary-600">ISI Burger</h1>
    </div>
    
 
    <div class="flex flex-col flex-grow p-4 overflow-y-auto">
        <nav class="flex-1 space-y-2">

            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg transition-colors duration-200 {{ Route::is('dashboard') ? 'bg-primary-50' : 'hover:bg-primary-50 hover:text-gray-700' }}">
                <i class="fas fa-home mr-3 {{ Route::is('dashboard') ? 'text-primary-600' : 'text-gray-400' }}"></i>
                <span class="font-medium">Accueil</span>
            </a>
            

            <a href="{{ route('burgers.index') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-lg transition-colors duration-200 {{ Route::is('burgers.*') ? 'bg-primary-50' : 'hover:bg-primary-50 hover:text-gray-700' }}">
                <i class="fas fa-hamburger mr-3 {{ Route::is('burgers.*') ? 'text-primary-600' : 'text-gray-400' }}"></i>
                <span>Burgers</span>
            </a>

            
            <a href="{{ route('commandes.index') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-lg transition-colors duration-200 {{ Route::is('commandes.*') ? 'bg-primary-50' : 'hover:bg-primary-50 hover:text-gray-700' }}">
                <i class="fas fa-cash-register mr-3 {{ Route::is('commandes.*') ? 'text-primary-600' : 'text-gray-400' }}"></i>
                <span>Commandes</span>
            </a>

            
            <a href="{{ route('paiements.index') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-lg transition-colors duration-200 {{ Route::is('paiements.*') ? 'bg-primary-50' : 'hover:bg-primary-50 hover:text-gray-700' }}">
                <i class="fas fa-credit-card mr-3 {{ Route::is('paiements.*') ? 'text-primary-600' : 'text-gray-400' }}"></i>
                <span>Paiements</span>
            </a>

            
            @auth
                @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('utilisateurs.index') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-lg transition-colors duration-200 {{ Route::is('utilisateurs.*') ? 'bg-primary-50' : 'hover:bg-primary-50 hover:text-gray-700' }}">
                    <i class="fas fa-users-cog mr-3 {{ Route::is('utilisateurs.*') ? 'text-primary-600' : 'text-gray-400' }}"></i>
                    <span>Gestionnaires</span>
                </a>
                @endif
            @endauth

            
            @auth
                @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('restaurant.edit') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-lg transition-colors duration-200 {{ Route::is('restaurant.*') ? 'bg-primary-50' : 'hover:bg-primary-50 hover:text-gray-700' }}">
                    <i class="fas fa-cog mr-3 {{ Route::is('restaurant.*') ? 'text-primary-600' : 'text-gray-400' }}"></i>
                    <span>Mon restaurant</span>
                </a>
                @endif
            @endauth
        </nav>
    </div>

 
    <div class="p-4 border-t">
        <a href="{{ route('profile.index') }}" class="flex items-center justify-center px-4 py-3 text-gray-600 rounded-lg transition-colors duration-200 {{ Route::is('profile.*') ? 'bg-primary-50' : 'hover:bg-primary-50 hover:text-gray-700' }}">
            <i class="fas fa-user-circle mr-3 {{ Route::is('profile.*') ? 'text-primary-600' : 'text-gray-400' }}"></i>
            <span>Profil</span>
        </a>
    </div>
</div>