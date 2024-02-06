<?php
session_start();
require_once "config.php";

// Vérification de la session et du rôle
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["user_role_ID"] != 2) {
  header("location: profile.php");
  exit;
}

if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
  die("Token CSRF invalide.");
}
function retrieveUserEmail($link, $user_ID)
{
  $email_query = "SELECT email FROM user WHERE user_ID = ?";
  if ($stmt = mysqli_prepare($link, $email_query)) {
    mysqli_stmt_bind_param($stmt, "i", $user_ID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_email);
    if (mysqli_stmt_fetch($stmt)) {
      mysqli_stmt_close($stmt);
      return $user_email;
    } else {
      mysqli_stmt_close($stmt);
      die("L'utilisateur n'a pas été trouvé.");
    }
  } else {
    die("Erreur lors de la préparation de la requête pour récupérer l'email.");
  }
}

function generateRandomPassword($length = 12)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_-=+;:,.?';
  $charactersLength = strlen($characters);
  $randomPassword = '';

  for ($i = 0; $i < $length; $i++) {
    $randomPassword .= $characters[rand(0, $charactersLength - 1)];
  }

  return $randomPassword;
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["csrf_token"])) {
  // Vérification du token CSRF
  if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    die("Erreur de validation CSRF.");
  }

  // Assainissement et validation de l'ID utilisateur
  $user_ID = filter_var($_POST["user_ID"], FILTER_SANITIZE_NUMBER_INT);

  if (false === filter_var($user_ID, FILTER_VALIDATE_INT)) {
    die("Erreur de validation de l'identifiant utilisateur.");
  }

  $new_password = generateRandomPassword();
  $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

  if ($reset_password_stmt = mysqli_prepare($link, "UPDATE user SET password = ? WHERE user_ID = ?")) {
    mysqli_stmt_bind_param($reset_password_stmt, "si", $hashed_password, $user_ID);
    mysqli_stmt_execute($reset_password_stmt);
    mysqli_stmt_close($reset_password_stmt);

    // Envoi de l'email avec PHPMailer
    try {
      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host = 'florentbernar.fr';
      $mail->SMTPAuth = true;
      $mail->Username = 'noreply@florentbernar.fr';
      $mail->Password = MAIL_PASSWORD;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;

      // Destinataires
      $userEmail = retrieveUserEmail($link, $user_ID);
      if (!$userEmail) {
        throw new Exception("Email de l'utilisateur non trouvé.");
      }
      $mail->setFrom('noreply@florentbernar.fr', 'Baldflix');
      $mail->addAddress($userEmail);

      $mail->isHTML(true);
      $mail->Subject = 'Réinitialisation de votre mot de passe';
      $mail->Body = "Bonjour,<br>Votre nouveau mot de passe est : <strong>{$new_password}</strong><br>Veuillez le changer dès votre prochaine connexion.";

      $mail->send();
      echo "Un email de réinitialisation a été envoyé.";
    } catch (Exception $e) {
      echo "Erreur lors de l'envoi de l'email. Mailer Error: " . $mail->ErrorInfo;
    }
    exit;
  }
}
