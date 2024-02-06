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

$imageDirectory = '../image/users_icon/';


$filesInDirectory = scandir($imageDirectory);


$allowedImages = array_filter($filesInDirectory, function ($file) use ($imageDirectory) {
  return is_file($imageDirectory . $file) && in_array(pathinfo($file, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg']);
});


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitImage"])) {
  $selectedImage = $_POST["selectedIcon"];

  if (in_array($selectedImage, $allowedImages)) {
    $fullImagePath = $imageDirectory . $selectedImage;
  } else {
    $fullImagePath = '../image/users_icon/default.png';
  }

  $_SESSION["profile_picture"] = $fullImagePath;
  $updateSql = "UPDATE user SET profile_picture = ? WHERE user_ID = ?";
  $updateStmt = mysqli_prepare($link, $updateSql);

  if ($updateStmt) {
    mysqli_stmt_bind_param($updateStmt, "si", $fullImagePath, $_SESSION["user_ID"]); // Stockez seulement le nom du fichier
    if (mysqli_stmt_execute($updateStmt)) {
    } else {
      echo "Oops! Quelque chose s'est mal passé. Veuillez réessayer plus tard.";
    }
    mysqli_stmt_close($updateStmt);
  }
}
