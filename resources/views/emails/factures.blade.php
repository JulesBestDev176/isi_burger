<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture de la commande - ISI BURGER</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #ff6f00; /* Couleur orange */
            padding: 20px;
            text-align: center;
        }
        .header img {
            max-width: 150px;
            height: auto;
        }
        .content {
            padding: 20px;
        }
        h1 {
            color: #ff6f00; /* Couleur orange */
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            background-color: #fff3e0; /* Fond orange clair */
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 4px;
            font-size: 14px;
        }
        ul li strong {
            color: #ff6f00; /* Couleur orange */
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #ff6f00; /* Couleur orange */
            color: white;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f9f9f9;
            font-size: 12px;
            color: #777;
        }
        .footer a {
            color: #ff6f00; /* Couleur orange */
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- En-tête -->
        <div class="header">
            <h1>ISI BURGER</h1>
            <h1>Facture de la commande</h1>
        </div>

        <!-- Contenu -->
        <div class="content">
            <p>Bonjour,</p>
            <p>Merci pour votre commande chez ISI BURGER. Voici les détails de votre facture :</p>

            <!-- Détails de la commande -->
            <ul>
                <li><strong>Numéro de commande :</strong> {{ $commande->id }}</li>
                <li><strong>Date de la commande :</strong> {{ $commande->date_commande->format('d/m/Y H:i') }}</li>
                <li><strong>Statut :</strong> {{ $commande->statut }}</li>
                <li><strong>Mode de paiement :</strong> {{ $commande->mode_paiement }}</li>
                <li><strong>Total :</strong> {{ $commande->paiement_montant }} FCFA</li>
            </ul>

            <!-- Liste des burgers commandés -->
            <h2>Burgers commandés</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($commande->burgers as $burger)
                        <tr>
                            <td>{{ $burger->nom }}</td>
                            <td>{{ $burger->pivot->quantite }}</td>
                            <td>{{ $burger->prix }} FCFA</td>
                            <td>{{ $burger->pivot->quantite * $burger->prix }} FCFA</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Total de la commande -->
            <p><strong>Total de la commande :</strong> {{ $commande->paiement_montant }} FCFA</p>

            <!-- Message de remerciement -->
            <p>Merci de faire confiance à ISI BURGER !</p>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <p>Si vous avez des questions, contactez-nous à <a href="mailto:isiburger@isiburger.com">isiburger@isiburger.com</a>.</p>
            <p>&copy; {{ date('Y') }} ISI BURGER. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>