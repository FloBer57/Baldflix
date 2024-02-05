<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: baldflix_login.php");
    exit;
}

require_once "config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

// Assurez-vous que MAIL_PASSWORD est bien défini dans "config.php"
// define('MAIL_PASSWORD', 'votre_mot_de_passe_ici');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_suggestion"])) {
    $suggestion_firstname = htmlspecialchars(trim($_POST["suggestion_firstname"]));
    $suggestion_lastname = htmlspecialchars(trim($_POST["suggestion_lastname"]));
    $suggestion_message = htmlspecialchars(trim($_POST["suggestion_message"]));

    // Création d'une instance de PHPMailer
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP(); // Utiliser SMTP
        $mail->Host = 'florentbernar.fr';
        $mail->SMTPAuth = true; // Activer l'authentification SMTP
        $mail->Username = 'contact@florentbernar.fr'; 
        $mail->Password = MAIL_PASSWORD; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587; 

        // Destinataires
        $mail->setFrom('contact@florentbernar.fr', $suggestion_firstname . '  ' . $suggestion_lastname);
        $mail->addAddress('contact@florentbernar.fr'); 

        // Contenu
        $mail->isHTML(true); // Définir le format de l'email en HTML
        $mail->Subject = "Nouvelle suggestion de $suggestion_firstname $suggestion_lastname";
        $mail->Body    = nl2br($suggestion_message); // Utiliser $suggestion_message pour le corps du mail

        $mail->send();
        echo "Votre suggestion a été envoyée avec succès!";
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de la suggestion. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
