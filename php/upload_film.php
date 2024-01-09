<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['film_title'];
    $synopsis = $_POST['film_synopsis'];
    $tags = $_POST['film_tags'];

    $target_dir = "../video/film/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $safe_title = preg_replace("/[^A-Za-z0-9 ]/", '', $titre);
    $safe_title = str_replace(' ', '_', $safe_title);

    $film_dir = $target_dir . $safe_title . "/";
    if (!file_exists($film_dir)) {
        mkdir($film_dir, 0755, true);
    }

    $video_target_file = $film_dir . basename($_FILES["video"]["name"]);
    $image_target_file = $film_dir . basename($_FILES["image"]["name"]);

    if (!move_uploaded_file($_FILES["video"]["tmp_name"], $video_target_file) || !move_uploaded_file($_FILES["image"]["tmp_name"], $image_target_file)) {
        exit("Erreur lors du téléchargement des fichiers.");
    }

    echo "aled";
    $ffmpeg_cmd_duration = "ffmpeg -i $video_target_file 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//";
    $duree = exec($ffmpeg_cmd_duration);
    list($hours, $minutes, $seconds) = explode(":", $duree);
    $total_seconds = $hours * 3600 + $minutes * 60 + floatval($seconds);

    $random_time = rand(1, $total_seconds);

    $video_target_miniature = $film_dir . 'miniature.jpg';
    $ffmpeg_cmd_extract = "ffmpeg -i $video_target_file -ss $random_time -frames:v 1 $video_target_miniature";
    exec($ffmpeg_cmd_extract);
    echo "aled siouplait";
    $ajout = date('Y-m-d H:i:s');
    $sql = "INSERT INTO film (film_title, film_synopsis, film_duree, film_tags, film_date_ajout, film_path, film_image_path, film_miniature_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssssss", $param_titre, $param_synopsis, $param_duree, $param_tags, $param_ajout, $param_video, $param_image, $param_miniature);

        $param_titre = $titre;
        $param_synopsis = $synopsis;
        $param_duree = (string)$total_seconds; // Converti en chaîne pour correspondre au type attendu par la requête
        $param_tags = $tags;
        $param_ajout = $ajout;
        $param_video = $video_target_file;
        $param_image = $image_target_file;
        $param_miniature = $video_target_miniature;

        if (mysqli_stmt_execute($stmt)) {
            echo "Vidéo ajoutée avec succès!";
        } else {
            echo "Erreur lors de l'ajout de la vidéo.";
        }

        mysqli_stmt_close($stmt);
    }
    echo "aled siouplait WOUHOU";
}

