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
    $titre = $_POST['titre'];
    $synopsis = $_POST['synopsis'];
    $duree = $_POST['duree'];
    $tags = $_POST['tags'];

    // Traitement du fichier vidéo
    $videoPath = 'chemin/vers/les/videos/' . $_FILES['video']['name'];
    move_uploaded_file($_FILES['video']['tmp_name'], $videoPath);
    
    $cmd = "ffmpeg -i " . escapeshellarg($videoPath) . " 2>&1";
    $output = shell_exec($cmd);
    preg_match('/Duration: ([0-9:.]+)/', $output, $matches);
    $duree = $matches[1]; // Durée au format HH:MM:SS

    // Traitement de l'image de couverture
    $imagePath = 'chemin/vers/les/images/couverture.jpg';
    $cmd = "ffmpeg -i " . escapeshellarg($videoPath) . " -ss 00:00:10 -vframes 1 " . escapeshellarg($imagePath) . " 2>&1";
    shell_exec($cmd);

    // Insertion dans la base de données
    $query = $pdo->prepare("INSERT INTO video (video_titre, video_synopsis, video_duree, video_tags, video_path, video_image_path) VALUES (?, ?, ?, ?, ?, ?)");
    $query->execute([$titre, $synopsis, $duree, $tags, $videoPath, $imagePath]);

    // Redirection ou affichage d'un message de succès
    echo "Vidéo ajoutée avec succès!";
}
?>