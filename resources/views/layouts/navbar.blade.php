
<header class="flex items-center justify-between p-4 bg-white shadow-sm">
    <button class="md:hidden text-gray-500 focus:outline-none">
        <i class="fas fa-bars"></i>
    </button>
                
    
    <h2 class="text-xl font-semibold text-gray-800">Tableau de bord</h2>
                
    <div class="flex items-center space-x-4">
        <button class="text-gray-500 hover:text-primary-600 focus:outline-none">
            <i class="fas fa-bell"></i>
        </button>
                    
        <div class="relative">
            <div class="flex items-center space-x-3 cursor-pointer">
                <div class="flex flex-col items-end">
                    <span class="text-sm font-medium text-gray-700">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                    <span class="text-xs text-gray-500">{{ Auth::user()->getRoleNames()->isNotEmpty() ? Auth::user()->getRoleNames()->first() : 'Aucun rôle' }}</span>
                            </div>
                            <div class="h-10 w-10 rounded-full bg-primary-500 flex items-center justify-center text-white shadow-md">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        
                        
                        <div class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                            <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50">Profile</a>
                            <div class="border-t border-gray-100"></div>
                            <form action="{{route('logout')}}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Déconnexion</button>
                            </form>   
                            
                        </div>
                    </div>
                </div>
            </header>
