<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations de connexion - ISI BURGER</title>
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
        <div class="header">
            <img src="https://example.com/path/to/isi-burger-logo.png" alt="ISI BURGER Logo">
        </div>

        
        <div class="content">
            <h1>Bonjour,</h1>
            <p>Voici vos informations de connexion pour accéder à votre compte ISI BURGER :</p>
            <ul>
                <li><strong>E-mail :</strong> {{ $email }}</li>
                <li><strong>Mot de passe :</strong> {{ $password }}</li>
            </ul>
            <p>Pour des raisons de sécurité, nous vous recommandons de changer votre mot de passe après votre première connexion.</p>
            <p>Merci de faire confiance à ISI BURGER !</p>
        </div>

        
        <div class="footer">
            <p>Si vous n'avez pas créé ce compte, veuillez nous contacter immédiatement à <a href="mailto:support@isiburger.com">support@isiburger.com</a>.</p>
            <p>&copy; {{ date('Y') }} ISI BURGER. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>