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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_suggestion"])) {
    if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        die("Token CSRF invalide");
    }

    $suggestion_firstname = htmlspecialchars(trim($_POST["suggestion_firstname"]));
    $suggestion_lastname = htmlspecialchars(trim($_POST["suggestion_lastname"]));
    $suggestion_message = htmlspecialchars(trim($_POST["suggestion_message"]));
    $suggestion_email = htmlspecialchars(trim($_POST["suggestion_email"]));

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'florentbernar.fr';
        $mail->SMTPAuth = true;
        $mail->Username = 'contact@florentbernar.fr';
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('noreply@florentbernar.fr');
        $mail->addAddress('contact@florentbernar.fr', 'Florent BERNAR');

        $mail->addReplyTo('contact@florentbernar.fr', 'Florent BERNAR');

        $mail->isHTML(true);
        $mail->Subject = "Nouvelle suggestion de $suggestion_firstname  $suggestion_lastname" . " Email : " . $suggestion_email;
        $mail->Body    = nl2br($suggestion_message);

        $mail->send();
        echo "Votre suggestion a été envoyée avec succès!";
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de la suggestion. Mailer Error: {$mail->ErrorInfo}";
    }
}
