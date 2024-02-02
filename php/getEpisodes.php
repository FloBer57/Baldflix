<?php
// getEpisodes.php

require_once "config.php"; 

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: baldflix_login.php");
    exit;
}

if (isset($_GET['saisonNumber']) && isset($_GET['serieId'])) {
    $saisonNumber = $_GET['saisonNumber'];
    $serieId = $_GET['serieId'];

    // Requête SQL pour récupérer les épisodes de la saison spécifiée pour la série donnée
    $sql = "SELECT * FROM episode WHERE episode_saison_ID IN (SELECT saison_ID FROM saison WHERE saison_number = ? AND saison_serie_ID = ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $saisonNumber, $serieId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Construisez le HTML pour les options d'épisode
        echo '<select id="episodeSelect" onchange="updateEpisode(this.value)">';
        while ($episode = mysqli_fetch_assoc($result)) {
            $episodeParts = explode('_', $episode['episode_title']);
            $episodeNumber = end($episodeParts); // Prend le dernier élément, qui devrait être le numéro de l'épisode
            echo '<option value="' . htmlspecialchars($episode['episode_path']) . '">Épisode ' . htmlspecialchars($episodeNumber) . '</option>';
        }
        echo '</select>';

        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur de préparation de la requête.";
    }
} else {
    echo "Paramètres manquants.";
}
