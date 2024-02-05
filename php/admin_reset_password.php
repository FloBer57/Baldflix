<?php
session_start();

require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_ID = $_POST["user_ID"];
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

    $reset_password_sql = "UPDATE user SET password = ? WHERE user_ID = ?";
    $reset_password_stmt = mysqli_prepare($link, $reset_password_sql);
    mysqli_stmt_bind_param($reset_password_stmt, "ss", $hashed_password, $user_ID);
    mysqli_stmt_execute($reset_password_stmt);
    mysqli_stmt_close($reset_password_stmt);

    $user_email_query = "SELECT email FROM user WHERE user_ID = ?";
    $user_email_stmt = mysqli_prepare($link, $user_email_query);
    mysqli_stmt_bind_param($user_email_stmt, "i", $user_ID);
    mysqli_stmt_execute($user_email_stmt);
    mysqli_stmt_bind_result($user_email_stmt, $user_email);

    if (mysqli_stmt_fetch($user_email_stmt)) {

        $to = $user_email;
        $subject = 'Reinitialisation du mot de passe';
        $message = 'Bonjour! Votre nouveau mot de passe est : ' . $new_password;
        $headers = 'From: baldflix.florentbernar@noreply.fr' . "\r\n" .
            'Reply-To: baldflix.florentbernar@noreply.fr' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        mysqli_stmt_close($user_email_stmt);
    } else {
        echo "Erreur: Adresse e-mail non trouvée pour l'utilisateur.";
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
