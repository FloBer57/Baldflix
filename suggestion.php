<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Initialize variables
$message_sent = false;
$error_message = "";

// Configuration du serveur SMTP
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.exemple.com'; // Replace with OVH's SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'votre_adresse_email@exemple.com'; // Replace with your OVH email address
    $mail->Password   = 'votre_mot_de_passe';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // or 'ssl' if necessary
    $mail->Port       = 587; // OVH's SMTP port

    // Other configurations...
} catch (Exception $e) {
    // Log the error or handle it as needed
    $error_message = "Error configuring SMTP: {$e->getMessage()}";
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $destinataire = "retarded_iceman@outlook.fr";
    $sujet = "Nouvelle suggestion";

    // Récupérer les données du formulaire
    $prenom = trim(htmlspecialchars($_POST["prenom"]));
    $nom = trim(htmlspecialchars($_POST["nom"]));
    $message = trim(htmlspecialchars($_POST["message"]));

    // Validation des champs
    if (empty($prenom) || empty($nom) || empty($message)) {
        $error_message = "Veuillez remplir tous les champs du formulaire.";
    } else {
        // Créer le corps du message
        $corps_message = "Nouvelle suggestion reçue :\n\n";
        $corps_message .= "Prénom : $prenom\n";
        $corps_message .= "Nom : $nom\n";
        $corps_message .= "Message :\n$message";

        // En-têtes du message
        $headers = "From: $prenom $nom <$destinataire>" . "\r\n";
        $headers .= "Reply-To: $prenom $nom <$destinataire>" . "\r\n";

        try {
            // Envoyer l'e-mail
            $mail->setFrom("$prenom $nom", $destinataire);
            $mail->addAddress($destinataire);
            $mail->Subject = $sujet;
            $mail->Body    = $corps_message;

            // Envoyer le message
            $message_sent = $mail->send();
        } catch (Exception $e) {
            $error_message = "Oops! Quelque chose s'est mal passé. Veuillez réessayer plus tard.";
        }
    }
}
?>


<div id="mail-tab-content" class="tab__content active-tab">
    <h2>Formulaire de Contact</h2>
    <?php if ($message_sent): ?>
        <p>Votre suggestion a été envoyée avec succès !</p>
    <?php else: ?>
        <?php if (!empty($error_message)): ?>
            <p style="color: red;">
                <?php echo $error_message; ?>
            </p>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" name="prenom" value="<?php echo $prenom; ?>" required>
            </div>

            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" name="nom" value="<?php echo $nom; ?>" required>
            </div>

            <div class="form-group">
                <label for="message">Message :</label>
                <textarea name="message" rows="4" required><?php echo $message; ?></textarea>
            </div>

            <div class="form-group">
                <input type="submit" value="Envoyer">
            </div>
        </form>
    </div>
<?php endif; ?>