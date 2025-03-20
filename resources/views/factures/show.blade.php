<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture #{{ $commande->id }} - {{ $restaurant->nom }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                font-size: 12pt;
                line-height: 1.5;
                color: #000;
                background-color: #fff;
            }
            .border, .border-t, .border-b, .border-l, .border-r {
                border-color: #000 !important;
                border-width: 1px !important;
            }
            .page-break {
                page-break-after: always;
            }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="max-w-3xl mx-auto my-10 bg-white p-8 rounded-lg shadow-md print:shadow-none">
        
        <div class="no-print flex justify-between mb-8">
            <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
            <button onclick="window.print()" class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">
                <i class="fas fa-print mr-2"></i> Imprimer
            </button>
        </div>
        
        
        <div class="flex justify-between items-start mb-10">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $restaurant->nom }}</h1>
                <p class="text-gray-600">{{ $restaurant->adresse }}</p>
                <p class="text-gray-600">{{ $restaurant->code_postal }} {{ $restaurant->ville }}</p>
                <p class="text-gray-600">Tél: {{ $restaurant->tel }}</p>
                <p class="text-gray-600">Email: {{ $restaurant->email }}</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold text-gray-800">FACTURE</h2>
                <p class="text-gray-600"># {{ $commande->id }}</p>
                <p class="text-gray-600">Date: {{ \Carbon\Carbon::parse($commande->date_paiement)->format('d/m/Y') }}</p>
                <p class="text-gray-600">Heure: {{ \Carbon\Carbon::parse($commande->date_paiement)->format('H:i') }}</p>
            </div>
        </div>
        
        
        <div class="border border-gray-200 rounded-lg p-4 mb-6">
            <h3 class="font-bold text-gray-800 mb-2">Informations client</h3>
            <p class="text-gray-700"><span class="font-medium">Nom:</span> {{ $client->prenom }} {{ $client->nom }}</p>
            <p class="text-gray-700"><span class="font-medium">Email:</span> {{ $client->email }}</p>
            <p class="text-gray-700"><span class="font-medium">Téléphone:</span> {{ $client->telephone }}</p>
        </div>
        
        
        <div class="mb-6">
            <h3 class="font-bold text-gray-800 mb-4">Détails de la commande</h3>
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-2 font-medium text-gray-600">Article</th>
                        <th class="text-right py-2 font-medium text-gray-600">Prix unitaire</th>
                        <th class="text-right py-2 font-medium text-gray-600">Quantité</th>
                        <th class="text-right py-2 font-medium text-gray-600">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commande->burgers as $burger)
                    <tr class="border-b border-gray-200">
                        <td class="py-3 text-gray-700">{{ $burger->nom }}</td>
                        <td class="py-3 text-right text-gray-700">{{ number_format($burger->prix, 0, ',', ' ') }} FCFA</td>
                        <td class="py-3 text-right text-gray-700">{{ $burger->pivot->quantite }}</td>
                        <td class="py-3 text-right text-gray-700">{{ number_format($burger->prix * $burger->pivot->quantite, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="py-3 text-right font-medium text-gray-700">Sous-total</td>
                        <td class="py-3 text-right font-medium text-gray-700">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="py-3 text-right font-medium text-gray-700">Frais de service</td>
                        <td class="py-3 text-right font-medium text-gray-700">1 000 FCFA</td>
                    </tr>
                    <tr class="border-t-2 border-gray-300">
                        <td colspan="3" class="py-3 text-right font-bold text-gray-800">TOTAL</td>
                        <td class="py-3 text-right font-bold text-gray-800">{{ number_format($commande->total + 1000, 0, ',', ' ') }} FCFA</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        
        <div class="mb-6">
            <h3 class="font-bold text-gray-800 mb-2">Informations supplémentaires</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-700"><span class="font-medium">Numéro de commande:</span> #{{ $commande->id }}</p>
                    <p class="text-gray-700"><span class="font-medium">Date de commande:</span> {{ \Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y H:i') }}</p>
                    <p class="text-gray-700"><span class="font-medium">Type:</span> 
                        {{ $commande->type == 'emporte' ? 'À emporter' : ($commande->type == 'livraison' ? 'Livraison' : 'Sur place') }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-700"><span class="font-medium">Numéro paiement:</span> #{{ $commande->numero_paiement }}</p>
                    <p class="text-gray-700"><span class="font-medium">Statut:</span> Payée</p>
                    <p class="text-gray-700"><span class="font-medium">Mode de paiement:</span> {{ ucfirst($commande->mode_paiement) }}</p>
                    <p class="text-gray-700"><span class="font-medium">Date de paiement:</span> {{ \Carbon\Carbon::parse($commande->date_paiement)->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
        
        
        <div class="border-t border-gray-200 pt-6 mt-10 text-center">
            <p class="text-gray-600 mb-2">Merci pour votre confiance !</p>
            <p class="text-sm text-gray-500">Cette facture a été générée automatiquement et ne nécessite pas de signature.</p>
            
            
            <div class="mt-6">
                <div class="flex justify-center items-center mb-4">
                    <div class="p-2 bg-primary-600 rounded-full mr-2">
                        <i class="fas fa-hamburger text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-800">{{ $restaurant->nom }}</span>
                </div>
                <p class="text-xs text-gray-500">
                    {{ $restaurant->nom }} - {{ $restaurant->adresse }}, {{ $restaurant->code_postal }} {{ $restaurant->ville }}<br>
                    Tél: {{ $restaurant->tel }} - Email: {{ $restaurant->email }}
                </p>
            </div>
        </div>
    </div>
</body>
</html>