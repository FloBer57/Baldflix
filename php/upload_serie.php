<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_serie = filter_input(INPUT_POST, 'nom_serie', FILTER_SANITIZE_STRING);
    $numero_saison = filter_input(INPUT_POST, 'numero_saison', FILTER_SANITIZE_NUMBER_INT);
    $tags = filter_input(INPUT_POST, 'serie_tags', FILTER_SANITIZE_STRING);
    $categories = array_map('intval', $_POST['serie_categories']);

    $safe_nom_serie = preg_replace("/[^A-Za-z0-9 ]/", '', $nom_serie);
    $safe_nom_serie = str_replace(' ', '_', $safe_nom_serie);

    $serie_dir = "../video/series/" . $safe_nom_serie . "/saison_" . $numero_saison . "/";
    if (!file_exists($serie_dir)) {
        mkdir($serie_dir, 0755, true);
    }

    mysqli_begin_transaction($link);

    $image_target_file = $serie_dir . basename($_FILES["image"]["name"]);
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image_target_file)) {
        echo "Erreur lors du téléchargement de l'image.";
        mysqli_rollback($link);
        exit;
    }

    $sql_serie = "INSERT INTO serie (serie_title, serie_tags, serie_image_path) VALUES (?, ?, ?)";
    if ($stmt_serie = mysqli_prepare($link, $sql_serie)) {
        mysqli_stmt_bind_param($stmt_serie, "sss", $nom_serie, $tags, $image_target_file);
        if (mysqli_stmt_execute($stmt_serie)) {
            $serie_id = mysqli_insert_id($link);
        } else {
            echo "Erreur lors de l'insertion de la série.";
            mysqli_rollback($link);
            exit;
        }
        mysqli_stmt_close($stmt_serie);
    } else {
        echo "Erreur de préparation de la requête.";
        mysqli_rollback($link);
        exit;
    }

    foreach ($_FILES["video"]["name"] as $index => $fileName) {
        $video_target_file = $serie_dir . basename($fileName);
        if (!move_uploaded_file($_FILES["video"]["tmp_name"], $video_target_file)) {
            exit("Erreur lors du téléchargement de la vidéo.");
        }
        
        $ffmpeg_cmd_duration = escapeshellcmd("ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 " . escapeshellarg($video_target_file));
        $duree = shell_exec($ffmpeg_cmd_duration);
        $total_seconds = round(floatval($duree));
    
        $duration_formatted = gmdate("H:i:s", $total_seconds);
    
        $random_time = rand(1, $total_seconds);
        $video_target_miniature = $film_dir . 'miniature.jpg';
        $ffmpeg_cmd_extract = "ffmpeg -i " . escapeshellarg($video_target_file) . " -ss $random_time -frames:v 1 " . escapeshellarg($video_target_miniature);
        exec($ffmpeg_cmd_extract);
    
        if (file_exists($video_target_miniature)) {
            $miniature_success = true;
        } else {
            $miniature_success = false;
        }

        // Code pour la durée et la miniature ici ...

        $nom_fichier = $safe_nom_serie . "_S" . str_pad($numero_saison, 2, "0", STR_PAD_LEFT) . "_EP" . str_pad($index + 1, 2, "0", STR_PAD_LEFT);
        $new_video_path = $serie_dir . $nom_fichier . "." . pathinfo($video_target_file, PATHINFO_EXTENSION);
        rename($video_target_file, $new_video_path);

        $ajout = date('Y-m-d H:i:s');

        $sql_episode = "INSERT INTO episodes (episode_title,episode_synopsis,episode_duree,episode_saison_ID,episode_path,episode_image_Path,episode_date_ajout) VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($stmt_episode = mysqli_prepare($link, $sql_episode)) {
            mysqli_stmt_bind_param($stmt_episode, "iiis", $serie_id, $numero_saison, $new_video_path);
            if (!mysqli_stmt_execute($stmt_episode)) {
                echo "Erreur lors de l'insertion de l'épisode.";
            }
            mysqli_stmt_close($stmt_episode);
        }
    }
    // Traitement des catégories

    $sql = "SELECT categorie_id FROM categorie";
    $result = mysqli_query($link, $sql);
    $valid_categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $valid_categories[] = $row['categorie_id'];
    }
    $categories = $_POST['film_categories'] ?? [];
    foreach ($categories as $categorie_id) {
        if (!in_array($categorie_id, $valid_categories)) {
            continue;
        }


        // Insertion de la catégorie, si elle est valide
        $sql_cat = "INSERT INTO film_categorie (filmXcategorie_film_ID, filmXcategorie_categorie_ID) VALUES (?, ?)";
        if ($stmt_cat = mysqli_prepare($link, $sql_cat)) {
            mysqli_stmt_bind_param($stmt_cat, "ii", $film_id, $categorie_id);
            mysqli_stmt_execute($stmt_cat);
            mysqli_stmt_close($stmt_cat);
        }
    }
    mysqli_commit($link);
}