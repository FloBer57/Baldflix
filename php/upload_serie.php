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
    $nom_serie = htmlspecialchars($_POST["serie_title"]);
    $numero_saison = intval($_POST["numero_saison"]);
    $tags = htmlspecialchars($_POST["serie_tags"]);
    $synopsis = htmlspecialchars($_POST["serie_synopsis"]);
    $categories = array_map('intval', $_POST['serie_categories']);


    $allFilesAreValid = true; 

    foreach ($_FILES["video"]["tmp_name"] as $index => $tmpName) {
        $videoFileType = mime_content_type($tmpName);
        $allowedVideoTypes = ['video/mp4', 'video/avi', 'video/mpeg', 'video/mkv'];
        
        if (!in_array($videoFileType, $allowedVideoTypes)) {
            $allFilesAreValid = false; 
            break; 
        }
    }

    $imageFileType = mime_content_type($_FILES["image"]["tmp_name"]);
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($imageFileType, $allowedImageTypes)) {
        $allFilesAreValid = false; 
    }
    
    if (!$allFilesAreValid) {
        $_SESSION['error_message_serie'] = 'Format invalide.';
        exit();
    }
    
    
    if ($numero_saison == 1) {
        $safe_nom_serie = str_replace(' ', '_', $nom_serie);
        $serie_dir = "../video/series/" . $safe_nom_serie . "/saison_" . $numero_saison . "/";
        if (!file_exists($serie_dir)) {
            mkdir($serie_dir, 0755, true);
        }

        if (!in_array($imageFileType, $allowedImageTypes)) {
            die("Le fichier image n'est pas dans un format autorisé.");
        }

        $image_new_name = $serie_dir . $safe_nom_serie .  '_Affiche.' . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $image_target_file = $image_new_name;
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image_target_file)) {
            exit("Erreur lors du téléchargement de l'image.");
        }

        if (strtolower(pathinfo($image_target_file, PATHINFO_EXTENSION)) != 'jpg') {
            $converted_image_file = $serie_dir . $safe_nom_serie . '_Affiche.jpg';

            $ffmpeg_cmd_convert_image = "ffmpeg -i " . escapeshellarg($image_target_file) . " " . escapeshellarg($converted_image_file);

            $ffmpeg_cmd_convert_image .= " 2>&1";
            exec($ffmpeg_cmd_convert_image, $output_image, $return_var_image);
            if ($return_var_image !== 0) {
                error_log("Échec de la conversion de l'image avec ffmpeg. Sortie: " . implode("\n", $output_image));
                exit("Erreur lors de la conversion de l'image.");
            } else {
                if (file_exists($image_target_file)) {
                    unlink($image_target_file);
                }
                $image_target_file = $converted_image_file;
            }
        }


        mysqli_begin_transaction($link);
        $sql_serie = "INSERT INTO serie (serie_title, serie_tags, serie_image_path, serie_synopsis) VALUES (?, ?, ?, ?)";
        if ($stmt_serie = mysqli_prepare($link, $sql_serie)) {
            $param_nom_serie = $safe_nom_serie;
            $param_tags = $tags;
            $param_image_path = $image_target_file;
            $param_synopsis = $synopsis;
            mysqli_stmt_bind_param($stmt_serie, "ssss", $param_nom_serie, $param_tags, $param_image_path, $param_synopsis);
            if (mysqli_stmt_execute($stmt_serie)) {
                $serie_id = mysqli_insert_id($link);
                foreach ($categories as $categorie_ID) {
                    $sql_categorie = "INSERT INTO serie_categorie (serieXcategorie_categorie_ID, serieXcategorie_serie_ID) VALUES (?, ?)";
                    if ($stmt_categorie = mysqli_prepare($link, $sql_categorie)) {
                        mysqli_stmt_bind_param($stmt_categorie, "ii", $categorie_ID, $serie_id);
                        mysqli_stmt_execute($stmt_categorie);
                        mysqli_stmt_close($stmt_categorie);
                    }
                }
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
        $sql_saison = "INSERT INTO saison (saison_number, saison_serie_ID) VALUES (?, ?)";
        if ($stmt_saison = mysqli_prepare($link, $sql_saison)) {
            $param_numero_saison = $numero_saison;
            $param_serie_id = $serie_id;
            mysqli_stmt_bind_param($stmt_saison, "ii", $param_numero_saison, $param_serie_id);
            if (!mysqli_stmt_execute($stmt_saison)) {
                echo "Erreur lors de l'insertion de la saison.";
                mysqli_rollback($link);
                exit;
            }
            $saison_id = mysqli_insert_id($link);
            mysqli_stmt_close($stmt_saison);
        } else {
            echo "Erreur de préparation de la requête pour la saison.";
            mysqli_rollback($link);
            exit;
        }
        foreach ($_FILES["video"]["name"] as $index => $fileName) {

            $safe_episode_title = $safe_nom_serie . "_S" . str_pad($numero_saison, 2, "0", STR_PAD_LEFT) . "_EP" . str_pad($index + 1, 2, "0", STR_PAD_LEFT);
            $video_extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $video_target_file = $serie_dir . $safe_episode_title . "." . $video_extension;

            $tmp_name = $_FILES["video"]["tmp_name"][$index];
            if (!move_uploaded_file($tmp_name, $video_target_file)) {
                echo "Erreur lors du téléchargement de la vidéo.";
                mysqli_rollback($link);
                exit;
            }
            if (strtolower(pathinfo($video_target_file, PATHINFO_EXTENSION)) != 'mp4') {
                $converted_video_file = $video_target_file . ".mp4";

                $ffmpeg_cmd_convert = "ffmpeg -i " . escapeshellarg($video_target_file) . " -c:v libx264 -preset slow -crf 22 -c:a aac " . escapeshellarg($converted_video_file);
                exec($ffmpeg_cmd_convert, $output, $return_var);

                if ($return_var === 0 && file_exists($converted_video_file)) {
                    if (file_exists($video_target_file)) {
                        unlink($video_target_file);
                    }
                    $video_target_file = $converted_video_file;
                } else {
                    exit("Erreur lors de la conversion de la vidéo.");
                }
            }

            $ffmpeg_cmd_duration = escapeshellcmd("ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 " . escapeshellarg($video_target_file));
            $duree = shell_exec($ffmpeg_cmd_duration);
            $total_seconds = round(floatval($duree));
            $duration_formatted = gmdate("H:i:s", $total_seconds);

            $random_time = rand(1, $total_seconds);
            $video_target_miniature = $serie_dir . 'miniature_' . 'EP_0' . ($index + 1) . '.jpg';
            $ffmpeg_cmd_extract = "ffmpeg -i " . escapeshellarg($video_target_file) . " -ss $random_time -frames:v 1 " . escapeshellarg($video_target_miniature);
            exec($ffmpeg_cmd_extract);

            if (file_exists($video_target_miniature)) {
                $miniature_success = true;
            } else {
                $miniature_success = false;
            }
            $nom_fichier = $safe_nom_serie . "_S" . str_pad($numero_saison, 2, "0", STR_PAD_LEFT) . "_EP" . str_pad($index + 1, 2, "0", STR_PAD_LEFT);
            $new_video_path = $serie_dir . $nom_fichier . "." . pathinfo($video_target_file, PATHINFO_EXTENSION);

            rename($video_target_file, $new_video_path);
            $episode_title = $safe_nom_serie . "_S0" . $numero_saison . "_" . "Épisode_0" . ($index + 1);

            $date = date('Y-m-d H:i:s');

            $sql_episode = "INSERT INTO episode (episode_title, episode_duree, episode_saison_ID, episode_path, episode_miniature_path, episode_date_ajout) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt_episode = mysqli_prepare($link, $sql_episode)) {
                $param_episode_title = $episode_title;
                $param_duree = $duration_formatted;
                $param_saison_id = $saison_id;
                $param_video_path = $new_video_path;
                $param_image_path = $video_target_miniature;
                $param_date_ajout = $date;
                mysqli_stmt_bind_param($stmt_episode, "ssisss", $param_episode_title, $param_duree, $param_saison_id, $param_video_path, $param_image_path, $param_date_ajout);
                if (!mysqli_stmt_execute($stmt_episode)) {
                    echo "Erreur lors de l'insertion de l'épisode.";
                    mysqli_rollback($link);
                    exit;
                }
                mysqli_stmt_close($stmt_episode);
            } else {
                echo "Erreur de préparation de la requête pour l'épisode.";
                mysqli_rollback($link);
                exit;
            }
        }
    } else {


        $serie_id = htmlspecialchars($_POST["serie_ID"]);
        $safe_nom_serie = str_replace(' ', '_', $nom_serie);
        $serie_dir = "../video/series/" . $safe_nom_serie . "/saison_" . $numero_saison . "/";
        if (!file_exists($serie_dir)) {
            mkdir($serie_dir, 0755, true);
        }

        $sql_saison = "INSERT INTO saison (saison_number, saison_serie_ID) VALUES (?, ?)";
        if ($stmt_saison = mysqli_prepare($link, $sql_saison)) {
            $param_numero_saison = $numero_saison;
            $param_serie_id = $serie_id;
            mysqli_stmt_bind_param($stmt_saison, "ii", $param_numero_saison, $param_serie_id);
            if (!mysqli_stmt_execute($stmt_saison)) {
                echo "Erreur lors de l'insertion de la saison.";
                mysqli_rollback($link);
                exit;
            }
            $saison_id = mysqli_insert_id($link);
            mysqli_stmt_close($stmt_saison);
        } else {
            echo "Erreur de préparation de la requête pour la saison.";
            mysqli_rollback($link);
            exit;
        }
        foreach ($_FILES["video"]["name"] as $index => $fileName) {

            $safe_episode_title = $safe_nom_serie . "_S" . str_pad($numero_saison, 2, "0", STR_PAD_LEFT) . "_EP" . str_pad($index + 1, 2, "0", STR_PAD_LEFT);
            $video_extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $video_target_file = $serie_dir . $safe_episode_title . "." . $video_extension;

            $tmp_name = $_FILES["video"]["tmp_name"][$index];
            if (!move_uploaded_file($tmp_name, $video_target_file)) {
                echo "Erreur lors du téléchargement de la vidéo.";
                mysqli_rollback($link);
                exit;
            }
            if (strtolower(pathinfo($video_target_file, PATHINFO_EXTENSION)) != 'mp4') {
                $converted_video_file = $video_target_file . ".mp4";

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

            $ffmpeg_cmd_duration = escapeshellcmd("ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 " . escapeshellarg($video_target_file));
            $duree = shell_exec($ffmpeg_cmd_duration);
            $total_seconds = round(floatval($duree));
            $duration_formatted = gmdate("H:i:s", $total_seconds);

            $random_time = rand(1, $total_seconds);
            $video_target_miniature = $serie_dir . 'miniature_' . 'EP_0' . ($index + 1) . '.jpg';
            $ffmpeg_cmd_extract = "ffmpeg -i " . escapeshellarg($video_target_file) . " -ss $random_time -frames:v 1 " . escapeshellarg($video_target_miniature);
            exec($ffmpeg_cmd_extract);

            if (file_exists($video_target_miniature)) {
                $miniature_success = true;
            } else {
                $miniature_success = false;
            }
            $nom_fichier = $safe_nom_serie . "_S" . str_pad($numero_saison, 2, "0", STR_PAD_LEFT) . "_EP" . str_pad($index + 1, 2, "0", STR_PAD_LEFT);
            $new_video_path = $serie_dir . $nom_fichier . "." . pathinfo($video_target_file, PATHINFO_EXTENSION);

            rename($video_target_file, $new_video_path);
            $episode_title = $safe_nom_serie . "_S0" . $numero_saison . "_" . "Épisode_0" . ($index + 1);

            $date = date('Y-m-d H:i:s');

            $sql_episode = "INSERT INTO episode (episode_title, episode_duree, episode_saison_ID, episode_path, episode_miniature_path, episode_date_ajout) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt_episode = mysqli_prepare($link, $sql_episode)) {
                $param_episode_title = $episode_title;
                $param_duree = $duration_formatted;
                $param_saison_id = $saison_id;
                $param_video_path = $new_video_path;
                $param_image_path = $video_target_miniature;
                $param_date_ajout = $date;
                mysqli_stmt_bind_param($stmt_episode, "ssisss", $param_episode_title, $param_duree, $param_saison_id, $param_video_path, $param_image_path, $param_date_ajout);
                if (!mysqli_stmt_execute($stmt_episode)) {
                    echo "Erreur lors de l'insertion de l'épisode.";
                    mysqli_rollback($link);
                    exit;
                }
                mysqli_stmt_close($stmt_episode);
            } else {
                echo "Erreur de préparation de la requête pour l'épisode.";
                mysqli_rollback($link);
                exit;
            }
        }
    }
    mysqli_commit($link);
}
