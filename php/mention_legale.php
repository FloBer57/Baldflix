<?php
session_start();
require_once "config.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: baldflix_login.php");
    exit;
}

$_SESSION["csrf_token"] = bin2hex(random_bytes(32));


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="robots" content="noindex, nofollow, noimageindex">
    <link rel="shortcut icon" href="../image/favicon/bald_favicon.ico" type="image/x-icon" />
    <title>BaldFlix</title>
    <link href="../css/global.CSS" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Bungee+Inline&display=swap" rel="stylesheet">
</head>

<body class="back_mention">
    <?php
    include "../includes/header.php";
    ?>
    <section class="section_mention">
        <h1>Mention Légale</h1>
        <div class="legal">
            <h2>Editeur du site :</h2>
            <p>Baldflix estune plateforme de diffusion de films libres de droit, est éditée par Bernar Florent.</p>
        </div>
        <div class="legal">
            <h2>Hébergement du site :</h2>
            <p>Le site Baldflix est hébergé par sur les services d'OVH.</p>
        </div>
        <div class="legal">
            <h2>Protection et traitement des données personnelles :</h2>
            <p>La confidentialité et la protection des données des utilisateurs de Baldflix sont de la plus haute importance. Les informations personnelles recueillies (nom, adresse e-mail, etc.) le sont pour le bon fonctionnement du service et ne sont en aucun cas cédées ou vendues à des tiers. Les utilisateurs disposent d'un droit d'accès, de modification, et de suppression de leurs données personnelles, qu'ils peuvent exercer à tout moment en contactant l'adresse e-mail contact.florentbernar.fr. De plus, le compte utilisé pour cette "démo" sont stocké temporairement, et à votre déconnexion, est détruit.</p>
        </div>
        <div class="legal">
            <h2>Conditions Générales d'Utilisation (CGU) :</h2>
            <p>L'accès et l'utilisation de Baldflix sont soumis aux présentes CGU. En naviguant sur Baldflix, l'utilisateur accepte sans réserve les CGU en vigueur. Les contenus disponibles sur Baldflix, y compris les films, sont soumis aux licences spécifiques sous lesquelles ils sont publiés, permettant leur diffusion libre et gratuite. L'utilisation commerciale non autorisée de ces contenus est strictement interdite.
                La source de tout contenu disponible sur baldflix vient de archive.org et leurs copyright à été vérifié avant d'être publiées.
            </p>
        </div>
        <div class="legal">
            <h2>Droits d'auteur et contenus libres de droit :</h2>
            <p>Les films et contenus vidéo diffusés sur Baldflix sont sélectionnés pour leur statut de libre droit ou parce qu'ils sont publiés sous des licences permettant leur redistribution, telle que la licence Creative Commons. Les conditions spécifiques de chaque œuvre, y compris les autorisations de reproduction, de distribution, et d'usage, sont clairement indiquées sur les pages de présentation des contenus.</p>
        </div>
        <div class="legal">
            <h2>Responsabilité :</h2>
            <p>Baldflix s'efforce d'assurer l'exactitude et la mise à jour des informations diffusées. Toutefois, Baldflix ne peut garantir l'exactitude, la précision ou l'exhaustivité des données disponibles sur le site. Baldflix décline toute responsabilité pour toute interruption du site, problèmes techniques, inexactitude ou omission sur les données disponibles, ou pour tout dommage résultant d'une intrusion frauduleuse d'un tiers.</p>
        </div>
        <div class="legal">
            <h2>Responsabilité :</h2>
            <p>Pour toute question ou demande d'information concernant le site, ou pour exercer vos droits sur vos données personnelles, vous pouvez me contacter à l'adresse e-mail [Adresse e-mail].</p>
        </div>
    </section>
    <?php
    include "../includes/footer.php";
    ?>
    <script src="../js/burger.js"></script>
</body>