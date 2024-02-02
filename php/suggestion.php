<?php

require_once "config.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: baldflix_login.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_suggestion"])) {
    $suggestion_firstname = htmlspecialchars(trim($_POST["suggestion_firstname"]));
    $suggestion_lastname = htmlspecialchars(trim($_POST["suggestion_lastname"]));
    $suggestion_message = htmlspecialchars(trim($_POST["suggestion_message"]));

    // Création d'une instance de PHPMailer
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP(); // Utiliser SMTP
        $mail->Host = 'ssl0.ovh.net'; // Serveur SMTP
        $mail->SMTPAuth = true; // Activer l'authentification SMTP
        $mail->Username = 'florent.bernar@outlook.fr'; // SMTP username
        $mail->Password = MAIL_PASSWORD; // SMTP password
        $mail->SMTPSecure = 'ssl'; // Activer TLS (ou 'ssl')
        $mail->Port = 587; // Port TCP pour se connecter

        // Destinataires
        $mail->setFrom('noreply@baldflix.florentbernar.fr', $suggestion_firstname . ' ' . $suggestion_lastname);
        $mail->addAddress('contact@baldflix.florentbernar.fr'); // Ajouter un destinataire

        // Contenu
        $mail->isHTML(true); // Définir le format de l'email en HTML
        $mail->Subject = "Nouvelle suggestion de $suggestion_firstname $suggestion_lastname";
        $mail->Body    = nl2br($email_body); // Convertir les sauts de ligne en balises <br>

        $mail->send();
        echo "Votre suggestion a été envoyée avec succès!";
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de la suggestion. Mailer Error: {$mail->ErrorInfo}";
    }
}
