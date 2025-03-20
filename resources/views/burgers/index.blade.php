@extends('dashboard')

@section('title', 'Burgers')
@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Gestion des Burgers</h1>
            <p class="mt-1 text-sm text-gray-500">Gérez votre menu de burgers, ajoutez de nouveaux produits ou modifiez les existants</p>
        </div>
        @auth
            @if(!Auth::user()->hasRole('admin'))
                <div class="mt-4 md:mt-0">
                    <button id="btnAjouterBurger" class="px-4 py-2 bg-primary-600 text-white rounded-lg shadow hover:bg-primary-700 transition-colors flex items-center">
                        <i class="fas fa-plus mr-2"></i> Ajouter un burger
                    </button>
                </div>
            @endif
        @endauth
    </div>

    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-4">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-search text-gray-400"></i>
                        </span>
                        <input type="text" class="pl-10 pr-4 py-2 w-full rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Rechercher un burger...">
                    </div>
                </div>
                <div class="flex flex-col md:flex-row gap-2">
                    <select class="px-4 py-2 rounded-md border border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                        <option>Trier par</option>
                        <option>Prix (croissant)</option>
                        <option>Prix (décroissant)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div id="grilleBurgers" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($burgers as $burger)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="relative">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        @if ($burger->image)
                            <img src="{{ Storage::url($burger->image) }}" alt="{{ $burger->nom }}" class="h-full w-full object-cover">
                        @else
                            <i class="fas fa-hamburger text-gray-400 text-4xl"></i>
                        @endif
                    </div>
                    <span class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">
                        {{ $burger->quantite > 0 ? 'Disponible' : 'Indisponible' }}
                    </span>
                </div>
                <div class="p-3">
                    <div class="flex justify-around items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $burger->nom }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $burger->description }}</p>
                            <span class="text-primary-600 font-bold">{{ number_format($burger->prix, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                    
                    <div class="flex space-x-2 mt-4">
                        @auth
                            @if(!Auth::user()->hasRole('admin'))
                            <button class="btnModifierBurger flex-1 px-3 py-2 bg-primary-600 text-white text-sm rounded hover:bg-primary-700 transition-colors"
                                    data-burger-id="{{ $burger->id }}"
                                    data-burger-nom="{{ $burger->nom }}"
                                    data-burger-prix="{{ $burger->prix }}"
                                    data-burger-quantite="{{ $burger->quantite }}"
                                    data-burger-description="{{ $burger->description }}"
                                    data-burger-image="{{ Storage::url($burger->image) }}">
                                <i class="fas fa-edit mr-1"></i> Modifier
                            </button> 
                            @endif
                        @endauth
                        @auth
                            @if(!Auth::user()->hasRole('admin'))
                            <form action="{{ route('burgers.destroy', $burger->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 border border-gray-300 text-gray-700 text-sm rounded hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 flex justify-center">
        {{ $burgers->links('pagination::tailwind') }}
    </div>

    <div id="modalBurger" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-2xl w-11/12 md:w-1/2 lg:w-1/3 max-h-[90vh] overflow-y-auto transform transition-all duration-300 ease-in-out">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 id="titreFenetre" class="text-2xl font-bold text-gray-800"></h2>
                    <button id="btnFermerModal" class="text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                
                <form method="POST" action="{{ route('burgers.store') }}" id="formulaireBurger" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    
                    <div id="champMethode"></div>
                    
                    <div class="flex justify-center mb-6">
                        <div class="relative">
                            <input type="file" id="image" name="image" accept="image/*" class="hidden">
                            <label for="image" class="cursor-pointer block">
                                <div id="apercuBurger" class="w-32 h-32 bg-orange-100 rounded-lg flex items-center justify-center border-2 border-orange-200 relative">
                                    <i id="iconeDefaut" class="fas fa-hamburger text-orange-500 text-4xl"></i>
                                    <img id="apercuImage" class="absolute inset-0 w-full h-full object-cover rounded-lg hidden" src="" alt="Aperçu du burger">
                                    <div class="absolute -bottom-3 -right-3 bg-white rounded-full p-2 shadow-md">
                                        <i class="fas fa-camera text-orange-500 text-lg"></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom du Burger</label>
                        <input type="text" id="nom" name="nom" required
                            class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                    </div>
                    <div>
                        <label for="prix" class="block text-sm font-medium text-gray-700 mb-1">Prix (FCFA)</label>
                        <input type="number" id="prix" name="prix" required
                            class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                    </div>
                    <div>
                        <label for="quantite" class="block text-sm font-medium text-gray-700 mb-1">Quantité</label>
                        <input type="number" id="quantite" name="quantite" required
                            class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="description" name="description" rows="3" required
                                class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"></textarea>
                    </div>
                    <div class="flex justify-end space-x-4 mt-8">
                        <button type="button" id="btnAnnuler"
                                class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            Annuler
                        </button>
                        <button type="submit" id="btnAction"
                                class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let estModification = false;
    const modal = document.getElementById('modalBurger');
    const btnAjouterBurger = document.getElementById('btnAjouterBurger');
    const btnsModifierBurger = document.querySelectorAll('.btnModifierBurger');
    const btnFermerModal = document.getElementById('btnFermerModal');
    const btnAnnuler = document.getElementById('btnAnnuler');
    const formulaireBurger = document.getElementById('formulaireBurger');
    const titreFenetre = document.getElementById('titreFenetre');
    const champImage = document.getElementById('image');
    const apercuImage = document.getElementById('apercuImage');
    const iconeDefaut = document.getElementById('iconeDefaut');
    const btnAction = document.getElementById('btnAction');
    const champRecherche = document.querySelector('input[placeholder="Rechercher un burger..."]');
    const grilleBurgers = document.getElementById('grilleBurgers');
    const cartesBurgers = document.querySelectorAll('#grilleBurgers > div');

    btnAjouterBurger.addEventListener('click', function() {
        estModification = false;
        titreFenetre.textContent = 'Ajouter un Burger';
        btnAction.textContent = 'Ajouter';
        reinitialiserFormulaire();
        const champMethode = formulaireBurger.querySelector('input[name="_method"]');
        if (champMethode) {
            champMethode.remove();
        }

        modal.classList.remove('hidden');
    });

    btnsModifierBurger.forEach(btn => {
        btn.addEventListener('click', function() {
            estModification = true;
            titreFenetre.textContent = 'Modifier un Burger';
            btnAction.textContent = 'Modifier';

            const burgerId = this.getAttribute('data-burger-id');
            const burgerNom = this.getAttribute('data-burger-nom');
            const burgerPrix = this.getAttribute('data-burger-prix');
            const burgerQuantite = this.getAttribute('data-burger-quantite');
            const burgerDescription = this.getAttribute('data-burger-description');
            const burgerImage = this.getAttribute('data-burger-image');

            document.getElementById('nom').value = burgerNom;
            document.getElementById('prix').value = burgerPrix;
            document.getElementById('quantite').value = burgerQuantite;
            document.getElementById('description').value = burgerDescription;

            if (burgerImage) {
                apercuImage.src = burgerImage;
                apercuImage.classList.remove('hidden');
                iconeDefaut.classList.add('hidden');
            } else {
                apercuImage.src = '';
                apercuImage.classList.add('hidden');
                iconeDefaut.classList.remove('hidden');
            }

            formulaireBurger.action = `/burgers/${burgerId}`;
            if (!formulaireBurger.querySelector('input[name="_method"]')) {
                const champMethode = document.createElement('input');
                champMethode.type = 'hidden';
                champMethode.name = '_method';
                champMethode.value = 'PUT';
                formulaireBurger.appendChild(champMethode);
            }

            modal.classList.remove('hidden');
        });
    });

    function fermerModal() {
        modal.classList.add('hidden');
    }

    btnFermerModal.addEventListener('click', fermerModal);
    btnAnnuler.addEventListener('click', fermerModal);

    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            fermerModal();
        }
    });

    function reinitialiserFormulaire() {
        formulaireBurger.reset();
        apercuImage.src = '';
        apercuImage.classList.add('hidden');
        iconeDefaut.classList.remove('hidden');
    }

    champImage.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const lecteur = new FileReader();
            
            lecteur.onload = function(e) {
                apercuImage.src = e.target.result;
                apercuImage.classList.remove('hidden');
                iconeDefaut.classList.add('hidden');
            };
            
            lecteur.readAsDataURL(this.files[0]);
        }
    });

    champRecherche.addEventListener('input', function() {
        const termeRecherche = this.value.toLowerCase().trim();
        
        if (termeRecherche === '') {
            cartesBurgers.forEach(carte => {
                carte.style.display = 'block';
            });
            return;
        }
        
        cartesBurgers.forEach(carte => {
            const nomBurger = carte.querySelector('h3').textContent.toLowerCase();
            const descBurger = carte.querySelector('p').textContent.toLowerCase();
            
            if (nomBurger.includes(termeRecherche) || descBurger.includes(termeRecherche)) {
                carte.style.display = 'block';
            } else {
                carte.style.display = 'none';
            }
        });
        
        const cartesVisibles = document.querySelectorAll('#grilleBurgers > div[style="display: block"]');
        if (cartesVisibles.length === 0) {
            if (!document.getElementById('aucunResultat')) {
                const aucunResultat = document.createElement('div');
                aucunResultat.id = 'aucunResultat';
                aucunResultat.className = 'col-span-full py-8 text-center';
                aucunResultat.innerHTML = `
                    <i class="fas fa-search text-gray-400 text-4xl mb-2"></i>
                    <p class="text-gray-500">Aucun burger ne correspond à votre recherche "${termeRecherche}"</p>
                `;
                grilleBurgers.appendChild(aucunResultat);
            } 
            else {
                const aucunResultat = document.getElementById('aucunResultat');
                aucunResultat.querySelector('p').textContent = `Aucun burger ne correspond à votre recherche "${termeRecherche}"`;
                aucunResultat.style.display = 'block';
            }
        } else {
            const aucunResultat = document.getElementById('aucunResultat');
            if (aucunResultat) {
                aucunResultat.style.display = 'none';
            }
        }
    });

    const selectTri = document.querySelector('select');
    selectTri.addEventListener('change', function() {
        const optionTri = this.value;
        const tableauCartesBurgers = Array.from(cartesBurgers);
        
        if (optionTri === 'Prix (croissant)') {
            trierBurgersParPrix(tableauCartesBurgers, 'asc');
        } else if (optionTri === 'Prix (décroissant)') {
            trierBurgersParPrix(tableauCartesBurgers, 'desc');
        }
    });
    
    function trierBurgersParPrix(cartesBurgers, ordre) {
        cartesBurgers.sort((a, b) => {
            const prixA = extrairePrix(a.querySelector('.text-primary-600').textContent);
            const prixB = extrairePrix(b.querySelector('.text-primary-600').textContent);
            
            return ordre === 'asc' ? prixA - prixB : prixB - prixA;
        });
        
        const grilleBurger = document.getElementById('grilleBurgers');
        cartesBurgers.forEach(carte => {
            grilleBurger.appendChild(carte);
        });
    }
    
    function extrairePrix(textePrix) {
        return parseInt(textePrix.replace(/[^\d]/g, ''));
    }
});
</script>
@endsection