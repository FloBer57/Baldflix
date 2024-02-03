<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: baldflix_login.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitImage"])) {

  $selectedImage = $_POST["selectedIcon"];
  $defaultImagePath = '../image/users_icon/default.png';
  $imageDirectory = '../image/users_icon/';
  $selectedImagePath = $imageDirectory . $selectedImage;
  $fullImagePath = !empty($selectedImage) ? $selectedImagePath : $defaultImagePath;
  $_SESSION["profile_picture"] = $fullImagePath;
  $updateSql = "UPDATE user SET profile_picture = ? WHERE user_ID = ?";
  $updateStmt = mysqli_prepare($link, $updateSql);
  if ($updateStmt) {
    mysqli_stmt_bind_param($updateStmt, "si", $fullImagePath, $_SESSION["user_ID"]);
    if (mysqli_stmt_execute($updateStmt)) {
    } else {
      echo "Oops! Quelque chose s'est mal passé. Veuillez réessayer plus tard.";
    }
    mysqli_stmt_close($updateStmt);
  }
}