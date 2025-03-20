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
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        
        @include('layouts.sidebar')
        
       
        <div class="flex-1 flex flex-col overflow-hidden">
            
            @include('layouts.navbar')
            
            
            <main class="flex-1 overflow-y-auto p-4 bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            const userDropdown = document.querySelector('.relative');
            const dropdownMenu = userDropdown.querySelector('.absolute');
            
            userDropdown.addEventListener('click', function() {
                dropdownMenu.classList.toggle('hidden');
            });
            
            
            document.addEventListener('click', function(event) {
                if (!userDropdown.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
            
            
            const mobileMenuBtn = document.querySelector('.md\\:hidden');
            const sidebar = document.querySelector('.hidden.md\\:flex');
            
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('absolute');
                sidebar.classList.toggle('z-10');
                sidebar.classList.toggle('h-screen');
            });
        });
    </script>
    
    
    @yield('scripts')
</body>
</html>