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

    $ffmpeg_cmd_duration = "ffmpeg -i $video_target_file 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//";
    $duree = exec($ffmpeg_cmd_duration);
    list($hours, $minutes, $seconds) = explode(":", $duree);
    $total_seconds = $hours * 3600 + $minutes * 60 + floatval($seconds);

    $random_time = rand(1, $total_seconds);

    $video_target_miniature = $film_dir . 'miniature.jpg';
    $ffmpeg_cmd_extract = "ffmpeg -i $video_target_file -ss $random_time -frames:v 1 $video_target_miniature";
    exec($ffmpeg_cmd_extract);
    $ajout = date('Y-m-d H:i:s');
    $sql = "INSERT INTO film (film_title, film_synopsis, film_duree, film_tags, film_date_ajout, film_path, film_image_path, film_miniature_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $film_id = mysqli_insert_id($link);
    $categories = $_POST['film_categories']; // Assure-toi de valider et nettoyer cette entrée
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssssss", $param_titre, $param_synopsis, $param_duree, $param_tags, $param_ajout, $param_video, $param_image, $param_miniature);

        $param_titre = $titre;
        $param_synopsis = $synopsis;
        $param_duree = (int) $total_seconds;
        $param_tags = $tags;
        $param_ajout = $ajout;
        $param_video = $video_target_file;
        $param_image = $image_target_file;
        $param_miniature = $video_target_miniature;

        if (mysqli_stmt_execute($stmt)) {
            $film_id = mysqli_insert_id($link); // Récupération de l'ID du film inséré

            mysqli_stmt_close($stmt);

            $sql = "SELECT categorie_id FROM categorie";
            $result = mysqli_query($link, $sql);
            $valid_categories = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $valid_categories[] = $row['categorie_id'];
            }
            if (isset($_POST['film_categories']) && is_array($_POST['film_categories'])) {
                foreach ($_POST['film_categories'] as $categorie_id) {
                    if (!in_array($categorie_id, $valid_categories)) {
                        // Si l'ID de la catégorie n'est pas valide, génère une erreur ou saute cette catégorie
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
            }

            // Renvoyer la réponse en format JSON
            $response = ["success" => true, "message" => "Vidéo ajoutée avec succès"];
            echo json_encode($response);
        } else {
            echo json_encode(["success" => false, "error" => "Erreur lors de l'ajout de la vidéo."]);
        }

        mysqli_stmt_close($stmt);
    }
}


