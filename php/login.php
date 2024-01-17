<?php


session_start([
    'cookie_lifetime' => 86400,
    'cookie_secure' => true, 
    'cookie_httponly' => true, 
    'use_strict_mode' => true, 
]);

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: ../index.php");
  exit;
}

require_once "config.php";

function getProfileData($userId)
{
  global $link;

  $sql = "SELECT user_role_id, profile_picture FROM user WHERE user_id = ?";
  $stmt = mysqli_prepare($link, $sql);
  mysqli_stmt_bind_param($stmt, "i", $userId);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $user_role, $profile_picture);
  mysqli_stmt_fetch($stmt);

  return ['user_role_id' => $user_role, 'profile_picture' => $profile_picture];
}

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty(trim($_POST["username"]))) {
    $username_err = "Veuillez rentrer votre nom d'utilisateur";
} elseif(strlen(trim($_POST["username"])) < 3){
  $username_err = "Votre nom d'utilisateur doit être de plus de trois caractères";
} elseif(strlen(trim($_POST["username"])) > 30){
  $username_err = "Votre nom d'utilisateur ne peux contenir plus de 30 caractères";
}
else {
    $username = trim($_POST["username"]);
    $username = htmlspecialchars($username);
  }

  if (empty(trim($_POST["password"]))) {
    $password_err = "Veuillez rentrer votre mot de passe";
  } else {
    $password = trim($_POST["password"]);
    $password = htmlspecialchars($password);
  }

  if (empty($username_err) && empty($password_err)) {
    $sql = "SELECT user_id, username, password FROM user WHERE username = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $param_username);
      $param_username = $username;

      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
          mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

          if (mysqli_stmt_fetch($stmt)) {

            if (password_verify($password, $hashed_password)) {
              $_SESSION["loggedin"] = true;
              $_SESSION["user_id"] = $id;
              $_SESSION["username"] = $username;
              $_SESSION["intro"] = true;
              $profileData = getProfileData($id);
              $_SESSION["user_role_id"] = $profileData['user_role_id'];
              $_SESSION["profile_picture"] = $profileData['profile_picture'];
              header("location: ../index.php");
            } else {
              $login_err = "Nom d'utilisateur ou mot de passe invalide.";
            }
          }
        } else {
          $login_err = "Nom d'utilisateur ou mot de passe invalide.";
        }
      } else {
        echo "Il y a eu un problème.";
      }
      mysqli_stmt_close($stmt);
    }
  }
  mysqli_close($link);
}
