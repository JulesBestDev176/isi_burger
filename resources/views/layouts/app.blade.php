<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - ISI Burger</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        
        <nav class="bg-white shadow-sm sticky top-0 z-50">
            <div class="container mx-auto">
                <div class="flex justify-between items-center py-4 px-4 md:px-0">
                    
                    <a href="{{ route('restaurant') }}" class="flex items-center space-x-2">
                        <div class="p-2 bg-primary-600 rounded-full">
                            <i class="fas fa-hamburger text-white text-lg"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-800">ISI BURGER</span>
                    </a>
                    
                    
                    
                    
                    <div class="flex items-center space-x-4">
                        
                        <a href="{{route('panier.index')}}" class="relative p-2 text-gray-600 hover:text-primary-600 transition">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            @if(session()->has('panier') && count(session()->get('panier')) > 0)
                                <span class="absolute -top-1 -right-1 bg-primary-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                                    {{ count(session()->get('panier')) }}
                                </span>
                            @endif
                        </a>
                        
                       
                        @guest
                            <a href="{{ route('login') }}" class="hidden md:inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <i class="fas fa-sign-in-alt mr-2"></i> Connexion
                            </a>
                            <a href="{{ route('register') }}" class="hidden md:inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <i class="fas fa-user-plus mr-2"></i> Inscription
                            </a>
                        @else
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center">
                                        <span class="text-sm font-medium">
                                            {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}{{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}
                                        </span>
                                    </div>
                                    <span class="hidden md:block text-gray-700">{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                    <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user-circle mr-2"></i> Mon profil
                                    </a>
                                    <a href="{{route('commande_client.index')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-clipboard-list mr-2"></i> Mes commandes
                                    </a>
                                    <hr class="my-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endguest
                        
                        
                        <button id="mobile-menu-button" class="md:hidden text-gray-500 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            
            <div id="mobile-menu" class="hidden md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 border-t">
                    <a href="{{ route('restaurant') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Accueil</a>
                    <a href="" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Menu</a>
                    <a href="" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">À propos</a>
                    <a href="" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Contact</a>
                    
                    @guest
                        <div class="mt-4 pt-4 border-t flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="flex-1 flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-sign-in-alt mr-2"></i> Connexion
                            </a>
                            <a href="{{ route('register') }}" class="flex-1 flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700">
                                <i class="fas fa-user-plus mr-2"></i> Inscription
                            </a>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        
        <main>
            @yield('content')
        </main>
        
        
        <footer class="bg-gray-800 text-white pt-12 pb-8">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    
                    <div>
                        <h3 class="text-xl font-bold mb-4 flex items-center">
                            <div class="p-2 bg-primary-600 rounded-full mr-2">
                                <i class="fas fa-hamburger text-white"></i>
                            </div>
                            ISI BURGER
                        </h3>
                        <p class="text-gray-400 mb-4">
                            Savourez nos délicieux burgers préparés avec des ingrédients frais et locaux.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                    
                    
                    <div>
                        <!-- <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('restaurant') }}" class="text-gray-400 hover:text-white transition">Accueil</a></li>
                            <li><a href="" class="text-gray-400 hover:text-white transition">Menu</a></li>
                        </ul> -->
                    </div>
                    
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contactez-nous</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-map-marker-alt text-primary-500 mt-1 mr-3"></i>
                                <span class="text-gray-400">{{ $restaurant->adresse }}, {{ $restaurant->code_postal }} {{ $restaurant->ville }}</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-phone-alt text-primary-500 mr-3"></i>
                                <span class="text-gray-400">{{ $restaurant->tel }}</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-envelope text-primary-500 mr-3"></i>
                                <span class="text-gray-400">{{ $restaurant->email }}</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-clock text-primary-500 mr-3"></i>
                                <span class="text-gray-400">Ouvert 7j/7 de 11h à 23h</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-gray-700 mt-10 pt-6 text-center text-gray-500 text-sm">
                    <p>&copy; {{ date('Y') }} ISI BURGER. Tous droits réservés.</p>
                </div>
            </div>
        </footer>
    </div>
    
    
    @if (session('success') || session('error'))
    <div id="notification" class="fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg {{ session('success') ? 'bg-green-500' : 'bg-red-500' }} text-white flex items-center z-50">
        <i class="fas {{ session('success') ? 'fa-check-circle' : 'fa-exclamation-circle' }} mr-2"></i>
        <span>{{ session('success') ?? session('error') }}</span>
        <button class="ml-4 text-white focus:outline-none" onclick="document.getElementById('notification').style.display = 'none';">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif
    
    <!-- Scripts Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Scripts personnalisés -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
           
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
            
            
            const notification = document.getElementById('notification');
            if (notification) {
                setTimeout(function() {
                    notification.style.opacity = '0';
                    notification.style.transition = 'opacity 1s ease';
                    setTimeout(function() {
                        notification.style.display = 'none';
                    }, 1000);
                }, 5000);
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>