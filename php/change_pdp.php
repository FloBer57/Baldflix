<?php
session_start();

// Vérifier si l'utilisateur est connecté, sinon le rediriger vers la page de connexion
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: baldflix_login.php");
  exit;
}

// Inclure le fichier de configuration
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitImage"])) {
  // Récupérer la valeur sélectionnée dans le menu déroulant
  $selectedImage = $_POST["selectedIcon"];

  // Chemin par défaut de l'image si aucun choix n'est fait
  $defaultImagePath = '../image/users_icon/default.png'; // Assurez-vous que ce chemin est correct

  // Construire le chemin complet vers l'image
  $imageDirectory = '../image/users_icon/';
  $selectedImagePath = $imageDirectory . $selectedImage;

  // Si aucune image n'est sélectionnée, utilisez l'image par défaut
  $fullImagePath = !empty($selectedImage) ? $selectedImagePath : $defaultImagePath;

  // Mettre à jour la session avec le nouveau chemin de l'image
  $_SESSION["profile_picture"] = $fullImagePath;

  // Mettre à jour la base de données avec le nouveau chemin d'image
  $updateSql = "UPDATE user SET profile_picture = ? WHERE id = ?";
  $updateStmt = mysqli_prepare($link, $updateSql);

  if ($updateStmt) {
    // Binder les variables à la déclaration préparée en tant que paramètres
    mysqli_stmt_bind_param($updateStmt, "si", $fullImagePath, $_SESSION["id"]);

    if (mysqli_stmt_execute($updateStmt)) {
      // Mise à jour réussie, vous pouvez ajouter un message de succès ici si nécessaire
    } else {
      echo "Oops! Quelque chose s'est mal passé. Veuillez réessayer plus tard.";
    }

    // Fermer la déclaration
    mysqli_stmt_close($updateStmt);
  }
}

?>