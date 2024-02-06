<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: baldflix_login.php");
    exit;
}

if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    die("Token CSRF invalide");
}

if ($_SESSION["user_role_ID"] != 2) {
    header("location: profile.php");
    exit;
  }


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = htmlspecialchars($_POST["film_title"]);
    $synopsis = htmlspecialchars($_POST["film_synopsis"]);
    $tags = htmlspecialchars($_POST["film_tags"]);
    $safe_title = str_replace(' ', '_', $titre);

    
    $allFilesAreValid = true;

    $videoFileType = mime_content_type($_FILES["video"]["tmp_name"]);
    $allowedVideoTypes = ['video/mp4', 'video/avi', 'video/mpeg', 'video/quicktime', 'video/mkv'];
    if (!in_array($videoFileType, $allowedVideoTypes)) {
        $allFilesAreValid = false;
    }

    $imageFileType = mime_content_type($_FILES["image"]["tmp_name"]);
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg']; 

    if (!in_array($imageFileType, $allowedImageTypes)) {
        $allFilesAreValid = false;
    }

    if (!$allFilesAreValid) {
        $_SESSION['error_message'] = 'Format invalide.';
        exit();
    }

    $target_dir = "../video/film/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }


    $film_dir = $target_dir . $safe_title . "/";
    if (!file_exists($film_dir)) {
        mkdir($film_dir, 0755, true);
    }

    $video_target_file = $film_dir . $safe_title . "." . pathinfo($_FILES["video"]["name"], PATHINFO_EXTENSION);
    $image_target_file = $film_dir . $safe_title . '_Affiche.' . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

    if (!move_uploaded_file($_FILES["video"]["tmp_name"], $video_target_file)) {
        exit("Erreur lors du téléchargement de la vidéo.");
    }
    if (strtolower(pathinfo($video_target_file, PATHINFO_EXTENSION)) != 'mp4') {
        $converted_video_file = $film_dir . $safe_title . ".mp4";

        $ffmpeg_cmd_convert = "ffmpeg -i " . escapeshellarg($video_target_file) . " -c:v libx264 -preset slow -crf 22 -c:a aac " . escapeshellarg($converted_video_file);
        exec($ffmpeg_cmd_convert, $output, $return_var);

        if ($return_var === 0 && file_exists($converted_video_file)) {
            if (file_exists($video_target_file)) {
                unlink($video_target_file);
            }
            $video_target_file = $converted_video_file; // Utilisez le fichier converti pour la suite
        } else {
            exit("Erreur lors de la conversion de la vidéo.");
        }
    }

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image_target_file)) {
        exit("Erreur lors du téléchargement de l'image.");
    }

    if (strtolower(pathinfo($image_target_file, PATHINFO_EXTENSION)) != 'jpg') {
        $converted_image_file = $film_dir . $safe_title . '_Affiche.jpg';

        // Définir la commande ffmpeg pour la conversion d'image
        $ffmpeg_cmd_convert_image = "ffmpeg -i " . escapeshellarg($image_target_file) . " " . escapeshellarg($converted_image_file);

        // Rediriger la sortie d'erreur vers la sortie standard
        $ffmpeg_cmd_convert_image .= " 2>&1";
        exec($ffmpeg_cmd_convert_image, $output_image, $return_var_image);
        if ($return_var_image !== 0) {
            error_log("Échec de la conversion de l'image avec ffmpeg. Sortie: " . implode("\n", $output_image));
            exit("Erreur lors de la conversion de l'image.");
        } else {
            // La conversion a réussi, supprimer l'ancien fichier si différent du nouveau
            if (file_exists($image_target_file)) {
                unlink($image_target_file);
            }
            // Mise à jour du chemin de l'image pour utiliser l'image convertie
            $image_target_file = $converted_image_file;
        }
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

    mysqli_begin_transaction($link);
    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO film (film_title, film_synopsis, film_duree, film_tags, film_date_ajout, film_path, film_image_path, film_miniature_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $film_id = mysqli_insert_id($link);
    $categories = $_POST['film_categories'];
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssssss", $param_titre, $param_synopsis, $param_duree, $param_tags, $param_ajout, $param_video, $param_image, $param_miniature);

        $param_titre = $safe_title;
        $param_synopsis = $synopsis;
        $param_duree = $duration_formatted;
        $param_tags = $tags;
        $param_ajout = $date;
        $param_video = $video_target_file;
        $param_image = $image_target_file;
        $param_miniature = $video_target_miniature;

        if (mysqli_stmt_execute($stmt)) {
            $film_id = mysqli_insert_id($link);

            $sql = "SELECT categorie_ID FROM categorie";
            $result = mysqli_query($link, $sql);
            $valid_categories = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $valid_categories[] = $row['categorie_ID'];
            }
            $categories = $_POST['film_categories'] ?? [];
            foreach ($categories as $categorie_ID) {
                if (!in_array($categorie_ID, $valid_categories)) {
                    continue;
                }

                $sql_cat = "INSERT INTO film_categorie (filmXcategorie_film_ID, filmXcategorie_categorie_ID) VALUES (?, ?)";
                if ($stmt_cat = mysqli_prepare($link, $sql_cat)) {
                    $param_film_id = $film_id;
                    $param_categorie_ID = $categorie_ID;

                    mysqli_stmt_bind_param($stmt_cat, "ii", $param_film_id, $param_categorie_ID);
                    mysqli_stmt_execute($stmt_cat);
                    mysqli_stmt_close($stmt_cat);
                }
            }
        } else {
            mysqli_rollback($link);
        }

        mysqli_commit($link);
        mysqli_stmt_close($stmt);
    }
}
