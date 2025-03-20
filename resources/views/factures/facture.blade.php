<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture à Imprimer</title>
    
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9fafb;
            color: #374151;
        }

        .facture-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        .bg-white {
            background-color: #ffffff;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .shadow-lg {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .p-8 {
            padding: 2rem;
        }

        .max-w-2xl {
            max-width: 42rem;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .text-center {
            text-align: center;
        }

        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-gray-800 {
            color: #1f2937;
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .text-gray-500 {
            color: #6b7280;
        }

        .mb-8 {
            margin-bottom: 2rem;
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
        }

        .font-semibold {
            font-weight: 600;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .space-y-2 > * + * {
            margin-top: 0.5rem;
        }

        .text-gray-700 {
            color: #374151;
        }

        .font-medium {
            font-weight: 500;
        }

        .flex {
            display: flex;
        }

        .justify-between {
            justify-content: space-between;
        }

        .items-center {
            align-items: center;
        }

        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }

        .border-t {
            border-top-width: 1px;
        }

        .pt-4 {
            padding-top: 1rem;
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }

        .mt-8 {
            margin-top: 2rem;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .bg-primary-600 {
            background-color: #2563eb;
        }

        .text-white {
            color: #ffffff;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .hover\:bg-primary-700:hover {
            background-color: #1d4ed8;
        }

        .transition-colors {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>
</head>
<body>
    <div class="facture-container">
        
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl mx-auto">
            
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Facture</h1>
                <p class="text-sm text-gray-500">Date: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
            </div>

            
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Informations du Client</h2>
                <div class="space-y-2">
                    <p class="text-sm text-gray-700"><span class="font-medium">Nom: </span> {{$user->prenom}} {{$user->nom}} </p>
                    <p class="text-sm text-gray-700"><span class="font-medium">Email: </span>{{$user->email}} </p>
                    <p class="text-sm text-gray-700"><span class="font-medium">Téléphone: </span>{{$user->telephone}} </p>
                </div>
            </div>

            
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Détails de la Commande</h2>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <p class="text-sm text-gray-700">Commande #</p>
                        <p class="text-sm text-gray-700">{{ $commande->numero_paiement }}</p>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-sm text-gray-700">Date de la Commande</p>
                        <p class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-sm text-gray-700">Statut</p>
                        <p class="text-sm text-gray-700">{{ ucfirst($commande->statut) }}</p>
                    </div>
                </div>
            </div>

            
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Articles Commandés</h2>
                <div class="space-y-4">
                    @foreach ($commande->burgers as $burger)
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $burger->nom }}</p>
                                <p class="text-xs text-gray-500">{{ $burger->pivot->quantite }} x {{ $burger->prix }} FCFA</p>
                            </div>
                            <p class="text-sm text-gray-700">{{ $burger->pivot->quantite * $burger->prix }} FCFA</p>
                        </div>
                    @endforeach
                </div>
            </div>

            
            <div class="border-t pt-4">
                <div class="flex justify-between">
                    <p class="text-lg font-semibold text-gray-800">Total</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $commande->total }} FCFA</p>
                </div>
            </div>

            
            <div class="mt-8 text-center">
                <button onclick="window.print()" class="px-4 py-2 bg-primary-600 text-white rounded-lg shadow hover:bg-primary-700 transition-colors">
                    Imprimer la Facture
                </button>
            </div>
        </div>
    </div>
</body>
</html>