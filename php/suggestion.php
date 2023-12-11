<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: baldflix_login.php");
  exit;
}

require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_suggestion"])) {
    $suggestion_firstname = htmlspecialchars(trim($_POST["suggestion_firstname"]));
    $suggestion_lastname = htmlspecialchars(trim($_POST["suggestion_lastname"]));
    $suggestion_message = htmlspecialchars(trim($_POST["suggestion_message"]));
  
    // Construisez le corps de l'email
    $email_body = "Nom: $suggestion_lastname\n";
    $email_body .= "Prenom: $suggestion_firstname\n";
    $email_body .= "Message:\n$suggestion_message";
  
    // Envoie de l'email
    $to = "contact@florentbernar.fr";
    $subject = "Nouvelle suggestion de $suggestion_firstname $suggestion_lastname";
    $headers = "From: $suggestion_firstname $suggestion_lastname <noreply@baldflix.florentbernar.fr>";
  
    // Utilisez la fonction mail() pour envoyer l'email
    if (mail($to, $subject, $email_body, $headers)) {
      echo "Votre suggestion a été envoyée avec succès!";
    } else {
      echo "Erreur lors de l'envoi de la suggestion. Veuillez réessayer plus tard.";
    }
  }

?>