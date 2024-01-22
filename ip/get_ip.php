<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Baldflix - Récupération d'IP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        #consentement {
            margin: 20px;
        }
    </style>
</head>
<body>
    <h1>Bienvenue sur Baldflix</h1>
    <p>Pour des raisons de sécurité, nous collectons les adresses IP de nos visiteurs.</p>

    <div id="consentement">
        <p>En continuant à utiliser ce site, vous acceptez que votre adresse IP soit enregistrée. <a href="politique_de_confidentialite.html">En savoir plus</a>.</p>
        <button onclick="accepterConsentement()">Accepter</button>
        <button onclick="refuserConsentement()">Refuser</button>
    </div>

    <script>
        function accepterConsentement() {
            // Logique pour accepter le consentement
            document.cookie = "consentement_ip=accepte; path=/";
            window.location.reload(); // Recharger la page pour activer le script PHP
        }

        function refuserConsentement() {
            // Logique pour refuser le consentement
            document.cookie = "consentement_ip=refuse; path=/";
            alert("Vous avez refusé la collecte de votre adresse IP.");
        }
    </script>

    <?php
    if (isset($_COOKIE['consentement_ip']) && $_COOKIE['consentement_ip'] == 'accepte') {
        // Récupérer l'adresse IP du visiteur
        $adresse_ip = $_SERVER['REMOTE_ADDR'];

        // Écrire l'adresse IP dans un fichier texte
        file_put_contents('adresses_ip.txt', $adresse_ip . PHP_EOL, FILE_APPEND);

        echo "<p>Votre adresse IP a été enregistrée : " . htmlspecialchars($adresse_ip) . "</p>";
    }
    ?>
</body>
</html>
