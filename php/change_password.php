<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: baldflix_login.php");
  exit;
}

if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
  die("Token CSRF invalide");
}
require_once "config.php";

$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
$password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_password"])) {
  if (empty(trim($_POST["new_password"]))) {
    $new_password_err = "Please enter the new password.";
  } elseif (strlen(trim($_POST["new_password"])) < 6) {
    $new_password_err = "Password must have at least 6 characters.";
  } else {
    $new_password = trim($_POST["new_password"]);
  }

  if (isset($_POST["confirm_password"])) {
    if (empty(trim($_POST["confirm_password"]))) {
      $confirm_password_err = "Please confirm the password.";
    } else {
      $confirm_password = htmlspecialchars(trim($_POST["confirm_password"]));
      if (empty($new_password_err) && ($new_password != $confirm_password)) {
        $confirm_password_err = "Password did not match.";
      }
    }
  }

  if (empty($new_password_err) && empty($confirm_password_err)) {
    $sql = "UPDATE user SET password = ? WHERE user_ID = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

      $param_password = password_hash($new_password, PASSWORD_DEFAULT);
      $param_id = $_SESSION["user_ID"];

      if (mysqli_stmt_execute($stmt)) {
        session_destroy();
        session_regenerate_id();
        header("location: baldflix_login.php");
        exit();
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
      mysqli_stmt_close($stmt);
    }
  } else {
    echo "Erreur de validation du mot de passe : " . $new_password_err . " " . $confirm_password_err;
  }
}
