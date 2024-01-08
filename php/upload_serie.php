<?php
// ... [Connexion à la base de données et vérifications initiales]

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serie_id = $_POST['serie_id']; // ID de la série
    $saison_id = $_POST['saison_id']; // ID de la saison

    // Chemins des dossiers
    $serie_dir = "baldflix/video/serie/" . $serie_id . "/";
    $saison_dir = $serie_dir . "saison_" . str_pad($saison_id, 2, '0', STR_PAD_LEFT) . "/";

    // Création des dossiers si nécessaire
    if (!file_exists($saison_dir)) {
        mkdir($saison_dir, 0755, true); // Modification des permissions pour des raisons de sécurité
    }

    // Traitement de chaque épisode uploadé
    foreach ($_FILES['episodes']['name'] as $index => $name) {
        $episode_file = $saison_dir . "serie_ep_" . basename($name);
        $image_file = $saison_dir . "image_serie_ep_" . basename($name, ".mp4") . '.jpg';

        move_uploaded_file($_FILES['episodes']['tmp_name'][$index], $episode_file);

        // Utiliser ffmpeg pour générer une image aléatoire
        $ffmpeg_cmd_extract = "ffmpeg -i $episode_file -ss 00:00:10 -frames:v 1 $image_file";
        exec($ffmpeg_cmd_extract);

    }

}
?>
