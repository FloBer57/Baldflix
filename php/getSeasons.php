<?php
// getSeasons.php

// Assurez-vous que vous avez une connexion à la base de données
require_once "config.php"; // Ajustez le chemin selon votre configuration

if (isset($_GET['serieId'])) {
    $serieId = $_GET['serieId'];

    // Préparation de la requête SQL pour obtenir les saisons de la série
    $sql = "SELECT saison_number FROM saison WHERE saison_serie_ID = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        // Lie l'ID de la série comme paramètre
        mysqli_stmt_bind_param($stmt, "i", $serieId);

        // Exécution de la requête
        mysqli_stmt_execute($stmt);

        // Récupération des résultats
        $result = mysqli_stmt_get_result($stmt);

        // Construction des options pour le sélecteur
        while ($saison = mysqli_fetch_assoc($result)) {
            echo '<option value="' . htmlspecialchars($saison['saison_number']) . '">Saison ' . htmlspecialchars($saison['saison_number']) . '</option>';
        }

        // Fermeture du statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur de préparation de la requête.";
    }
} else {
    echo "Aucun identifiant de série fourni.";
}

