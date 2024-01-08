<?php
// Connexion à la base de données
session_start();
require_once "config.php"; // Assurez-vous que le chemin est correct

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../index.php");
    exit;
}

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['film_title'];
    $synopsis = $_POST['film_synopsis'];
    $duree = $_POST['film_duree'];
    $tags = $_POST['film_tags'];

    $target_dir = "baldflix/video/film/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Nettoyer le titre du film pour le nom du dossier
    $safe_title = preg_replace("/[^A-Za-z0-9 ]/", '', $titre); // Supprime les caractères spéciaux
    $safe_title = str_replace(' ', '_', $safe_title); // Remplace les espaces par des underscores

    // Créer un dossier pour le film si nécessaire
    $film_dir = $target_dir . $safe_title . "/";
    if (!file_exists($film_dir)) {
        mkdir($film_dir, 0755, true);
    }
    // Traitement du fichier vidéo
    // Définir les chemins cibles dans le dossier du film
    $video_target_file = $film_dir . basename($_FILES["video"]["name"]);
    $image_target_file = $film_dir . basename($_FILES["image"]["name"]);

    // Déplacer les fichiers uploadés dans le dossier du film
    move_uploaded_file($_FILES["video"]["tmp_name"], $video_target_file);
    move_uploaded_file($_FILES["image"]["tmp_name"], $image_target_file);

    // Utiliser ffmpeg pour obtenir la durée totale de la vidéo
    $ffmpeg_cmd_duration = "ffmpeg -i $video_target_file 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//";
    $duree = exec($ffmpeg_cmd_duration);
    list($hours, $minutes, $seconds) = explode(":", $duree);
    $total_seconds = $hours * 3600 + $minutes * 60 + floatval($seconds);

    // Générer un moment aléatoire pour l'image
    $random_time = rand(1, $total_seconds);

    $image_file = $film_dir . 'miniature.jpg';  // Miniature directement dans le dossier du film
    $ffmpeg_cmd_extract = "ffmpeg -i $video_target_file -ss $random_time -frames:v 1 $image_file";
    exec($ffmpeg_cmd_extract);


    // Redirection ou affichage d'un message de succès
    $ajout = date('Y-m-d H:i:s');
    $sql = "INSERT INTO films (film_title, film_synopsis, film_duree, film_tags, film_date_ajout, film_path	, film_image_path) VALUES (?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssss", $param_titre, $param_synopsis, $param_duree, $param_tags, $param_ajout, $param_video, $param_image);

        // Assignation des paramètres
        $param_titre = $titre;
        $param_synopsis = $synopsis;
        $param_duree = $duree;
        $param_tags = $tags;
        $param_ajout = $ajout;
        $param_video = $video_target_file; // Chemin du fichier vidéo
        $param_image = $image_target_file; // Chemin de l'image

        // Exécution de la requête
        if (mysqli_stmt_execute($stmt)) {
            echo "Vidéo ajoutée avec succès!";
        } else {
            echo "Erreur lors de l'ajout de la vidéo.";
        }
    }

    // Fermeture de la déclaration
    mysqli_stmt_close($stmt);
}

?>