@extends('dashboard')

@section('title', 'Gestion des utilisateurs')
@section('content')
<div class="container mx-auto px-4 py-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Gestion des Utilisateurs</h1>
            <p class="mt-1 text-sm text-gray-500">Consultez, modifiez et gérez tous les utilisateurs de la plateforme</p>
        </div>
        <div class="mt-4 md:mt-0">
            <button id="boutonAjouterUtilisateur" class="px-4 py-2 bg-primary-600 text-white rounded-lg shadow hover:bg-primary-700 transition-colors flex items-center">
                <i class="fas fa-plus mr-2"></i> Nouvel utilisateur
            </button>
        </div>
    </div>

  
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="border-b">
            <nav class="flex -mb-px overflow-x-auto">
                <a href="#" class="border-primary-500 text-primary-600 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Tous ({{$gestionnaires->count()}})
                </a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Actifs ({{$actifs->count()}})
                </a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Inactifs ({{$inactifs->count()}})
                </a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">
                    Nouveaux ({{$nouveaux->count()}})
                </a>
            </nav>
        </div>

        
    </div>

    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table id="tableauUtilisateurs" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Utilisateur
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Téléphone
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rôle
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date d'inscription
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    
                    @foreach($gestionnaires as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-primary-600">#{{ $user->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-9 w-9 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->prenom }} {{ $user->nom }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->telephone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $user->getRoleNames()->first() }}  
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->created_at->format('d M, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $user->created_at->format('H:i') }}</div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $user->statut}}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button class="text-primary-600 hover:text-primary-900 boutonVoirUtilisateur" data-id="{{ $user->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    
    <div id="etatVide" class="hidden bg-white rounded-lg shadow p-8 text-center mt-6">
        <div class="mx-auto w-24 h-24 bg-primary-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-users text-4xl text-primary-600"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun utilisateur trouvé</h3>
        <p class="text-sm text-gray-500 mb-6">Aucun utilisateur ne correspond à vos critères de recherche actuels.</p>
        <button id="reinitialiserFiltres" class="px-4 py-2 bg-primary-600 text-white rounded-lg shadow hover:bg-primary-700 transition-colors">
            Réinitialiser les filtres
        </button>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    
    
    <div id="modalAjoutUtilisateur" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            
            
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-user-plus text-primary-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Ajouter un nouvel utilisateur</h3>
                            <div class="mt-4">
                            <form action="{{ route('utilisateurs.store') }}" method="POST" id="formAjoutUtilisateur">
                                @csrf
                                
                                <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-4">
                                    <div>
                                        <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                                        <input type="text" name="prenom" id="prenom" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                                        <input type="text" name="nom" id="nom" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                
                                
                                <div class="mt-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                                    <input type="email" name="email" id="email" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="nom@exemple.com">
                                </div>
                                
                                <div class="mt-4">
                                    <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                    <input type="text" name="telephone" id="telephone" class="mt-1 focus:ring-primary-500 focus:border-primary-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="nom@exemple.com">
                                </div>
                                
                                
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Ajouter l'utilisateur
                                    </button>
                                    <button type="button" class="fermerModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:w-auto sm:text-sm">
                                        Annuler
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
   
    <div id="modalDetailUtilisateur" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            
           
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-user text-primary-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Détails de l'utilisateur #<span id="detailUserId">1001</span></h3>
                            
                            <div class="mt-4">
                                
                                <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                    <div class="flex flex-col sm:flex-row">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-3">
                                                <div class="h-16 w-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                                                    <i class="fas fa-user text-2xl"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <h4 class="text-xl font-medium text-gray-900" id="detailUserName">Jean Dupont</h4>
                                                    <p class="text-sm text-gray-600" id="detailUserEmail">jean.dupont@example.com</p>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-2 grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">Rôle</p>
                                                    <p class="text-sm font-medium" id="detailUserRole">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            Administrateur
                                                        </span>
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Statut</p>
                                                    <p class="text-sm font-medium" id="detailUserStatus">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Actif
                                                        </span>
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Date d'inscription</p>
                                                    <p class="text-sm font-medium" id="detailUserCreated">15 Janv, 2025 - 09:30</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Dernière connexion</p>
                                                    <p class="text-sm font-medium" id="detailUserLastLogin">08 Mars, 2025 - 14:20</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                               
                                <div class="mb-4">
                                    <div class="border-b border-gray-200">
                                        <nav class="-mb-px flex space-x-6">
                                            <a href="#" class="tab-link border-primary-500 text-primary-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="activite">
                                                Activité récente
                                            </a>
                                            <a href="#" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="permissions">
                                                Permissions
                                            </a>
                                            <a href="#" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="securite">
                                                Sécurité
                                            </a>
                                        </nav>
                                    </div>
                                </div>
                                
                               
                                <div class="tab-content" id="tab-activite">
                                    <div class="space-y-3">
                                        <div class="border-l-2 border-primary-500 pl-3 py-1">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Connexion réussie</p>
                                                    <p class="text-xs text-gray-500">IP: 192.168.1.45</p>
                                                </div>
                                                <p class="text-xs text-gray-500">08 Mars, 2025 - 14:20</p>
                                            </div>
                                        </div>
                                        <div class="border-l-2 border-primary-500 pl-3 py-1">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Profil modifié</p>
                                                    <p class="text-xs text-gray-500">Modification du numéro de téléphone</p>
                                                </div>
                                                <p class="text-xs text-gray-500">05 Mars, 2025 - 10:45</p>
                                            </div>
                                        </div>
                                        <div class="border-l-2 border-primary-500 pl-3 py-1">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Connexion réussie</p>
                                                    <p class="text-xs text-gray-500">IP: 192.168.1.45</p>
                                                </div>
                                                <p class="text-xs text-gray-500">01 Mars, 2025 - 09:15</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="tab-content hidden" id="tab-permissions">
                                    <div class="space-y-4">
                                        <div class="bg-gray-50 p-3 rounded-md">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900">Administration</h4>
                                                    <p class="text-xs text-gray-500">Accès complet au tableau de bord</p>
                                                </div>
                                                <div class="flex h-5 items-center">
                                                    <input id="permissions-admin" name="permissions-admin" type="checkbox" checked class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-gray-50 p-3 rounded-md">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900">Gestion des utilisateurs</h4>
                                                    <p class="text-xs text-gray-500">Ajouter, modifier et supprimer des utilisateurs</p>
                                                </div>
                                                <div class="flex h-5 items-center">
                                                    <input id="permissions-users" name="permissions-users" type="checkbox" checked class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-gray-50 p-3 rounded-md">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900">Rapports et analyses</h4>
                                                    <p class="text-xs text-gray-500">Accès aux statistiques et rapports</p>
                                                </div>
                                                <div class="flex h-5 items-center">
                                                    <input id="permissions-reports" name="permissions-reports" type="checkbox" checked class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content hidden" id="tab-securite">
                                    <div class="space-y-4">
                                        <div class="bg-gray-50 p-3 rounded-md">
                                            <h4 class="text-sm font-medium text-gray-900 mb-2">Réinitialiser le mot de passe</h4>
                                            <p class="text-xs text-gray-500 mb-3">Envoyer un lien de réinitialisation du mot de passe à l'utilisateur</p>
                                            <button type="button" class="px-3 py-1.5 bg-primary-600 text-white rounded-md text-sm hover:bg-primary-700 transition-colors">
                                                Envoyer un lien de réinitialisation
                                            </button>
                                        </div>
                                        
                                        <div class="bg-gray-50 p-3 rounded-md">
                                            <h4 class="text-sm font-medium text-gray-900 mb-2">Double authentification</h4>
                                            <div class="flex items-center justify-between mb-3">
                                                <p class="text-xs text-gray-500">Statut actuel</p>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Non activé
                                                </span>
                                            </div>
                                            <button type="button" class="px-3 py-1.5 bg-primary-600 text-white rounded-md text-sm hover:bg-primary-700 transition-colors">
                                                Activer la double authentification
                                            </button>
                                        </div>
                                        
                                        <div class="bg-gray-50 p-3 rounded-md">
                                            <h4 class="text-sm font-medium text-gray-900 mb-2">Sessions actives</h4>
                                            <div class="space-y-2 mb-3">
                                                <div class="flex justify-between text-xs">
                                                    <span class="text-gray-500">Chrome sur Windows 11</span>
                                                    <span class="text-green-600 font-medium">Actuellement actif</span>
                                                </div>
                                                <div class="flex justify-between text-xs">
                                                    <span class="text-gray-500">Safari sur iPhone</span>
                                                    <span class="text-gray-500">Il y a 2 jours</span>
                                                </div>
                                            </div>
                                            <button type="button" class="px-3 py-1.5 bg-red-600 text-white rounded-md text-sm hover:bg-red-700 transition-colors">
                                                Déconnecter toutes les sessions
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Modifier
                    </button>
                    <button type="button" class="fermerModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Fermer
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-red-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-red-700 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:w-auto sm:text-sm">
                        <i class="fas fa-ban mr-2"></i> Bloquer l'utilisateur
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const boutonAjouterUtilisateur = document.getElementById('boutonAjouterUtilisateur');
        const modalAjoutUtilisateur = document.getElementById('modalAjoutUtilisateur');
        const modalDetailUtilisateur = document.getElementById('modalDetailUtilisateur');
        const boutonsVoirUtilisateur = document.querySelectorAll('.boutonVoirUtilisateur');
        const boutonsfermerModal = document.querySelectorAll('.fermerModal');
        const selecteurPeriode = document.querySelector('select[name="periode"]');
        const periodePersonnalisee = document.getElementById('periodePersonnalisee');
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const tabLinks = document.querySelectorAll('.tab-link');
        
        
        boutonAjouterUtilisateur.addEventListener('click', function() {
            modalAjoutUtilisateur.classList.remove('hidden');
        });
        
        
        boutonsVoirUtilisateur.forEach(function(bouton) {
            bouton.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                
                
                document.getElementById('detailUserId').textContent = userId;
                
                
                modalDetailUtilisateur.classList.remove('hidden');
            });
        });
        
        
        boutonsfermerModal.forEach(function(bouton) {
            bouton.addEventListener('click', function() {
                modalAjoutUtilisateur.classList.add('hidden');
                modalDetailUtilisateur.classList.add('hidden');
            });
        });
        
        
        window.addEventListener('click', function(event) {
            if (event.target === modalAjoutUtilisateur || event.target === modalDetailUtilisateur) {
                modalAjoutUtilisateur.classList.add('hidden');
                modalDetailUtilisateur.classList.add('hidden');
            }
        });
        
        
        if (selecteurPeriode) {
            selecteurPeriode.addEventListener('change', function() {
                if (this.value === 'personnalise') {
                    periodePersonnalisee.classList.remove('hidden');
                } else {
                    periodePersonnalisee.classList.add('hidden');
                }
            });
        }
        
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }
        
        
        tabLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                
                tabLinks.forEach(function(tab) {
                    tab.classList.remove('border-primary-500', 'text-primary-600');
                    tab.classList.add('border-transparent', 'text-gray-500');
                });
                
                
                this.classList.remove('border-transparent', 'text-gray-500');
                this.classList.add('border-primary-500', 'text-primary-600');
                
                
                const tabContents = document.querySelectorAll('.tab-content');
                tabContents.forEach(function(content) {
                    content.classList.add('hidden');
                });
                
                
                const tabId = this.getAttribute('data-tab');
                document.getElementById('tab-' + tabId).classList.remove('hidden');
            });
        });
        
        
        
    });
</script>
@endsection