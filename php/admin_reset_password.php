<?php
session_start();
require_once "config.php"; // Assurez-vous que le chemin est correct

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reset_password"])) {
    // Récupérer les données du formulaire
    $user_id = $_POST["user_id"];

    function generateRandomPassword($length = 12)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        $charactersLength = strlen($characters);

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, $charactersLength - 1)];
        }

        return $password;
    }

    $new_password = generateRandomPassword();
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Ajoutez une déclaration préparée pour la réinitialisation du mot de passe
    $reset_password_sql = "UPDATE user SET password = ? WHERE id = ?";
    $reset_password_stmt = mysqli_prepare($link, $reset_password_sql);
    mysqli_stmt_bind_param($reset_password_stmt, "ss", $hashed_password, $user_id);
    mysqli_stmt_execute($reset_password_stmt);
    mysqli_stmt_close($reset_password_stmt);

    // Récupérer l'adresse e-mail de l'utilisateur depuis la base de données
    $user_email_query = "SELECT email FROM user WHERE id = ?";
    $user_email_stmt = mysqli_prepare($link, $user_email_query);
    mysqli_stmt_bind_param($user_email_stmt, "i", $user_id);
    mysqli_stmt_execute($user_email_stmt);
    mysqli_stmt_bind_result($user_email_stmt, $user_email);

    // Vérifier s'il y a une ligne de résultat
    if (mysqli_stmt_fetch($user_email_stmt)) {
        // Utiliser l'adresse e-mail récupérée pour envoyer l'e-mail
        $to = $user_email;
        $subject = 'Reinitialisation du mot de passe';
        $message = 'Bonjour! Votre nouveau mot de passe est : ' . $new_password;
        $headers = 'From: baldflix.florentbernar@noreply.fr' . "\r\n" .
            'Reply-To: baldflix.florentbernar@noreply.fr' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        // Utilisation de la fonction mail() pour envoyer l'e-mail
        mail($to, $subject, $message, $headers);

        // Fermer la déclaration préparée
        mysqli_stmt_close($user_email_stmt);
    } else {
        // Gérer le cas où l'adresse e-mail n'est pas trouvée
        echo "Erreur: Adresse e-mail non trouvée pour l'utilisateur.";
    }

    // Rediriger vers la même page après la réinitialisation
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>