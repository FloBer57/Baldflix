<?php
session_start();

require_once "config.php";

$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Rentrez un nom d'utilisateur";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Le nom d'utilisateur ne peux contenir que des lettres, chiffre et l'underscore.";
    } else {
        $sql = "SELECT user_ID FROM user WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "Le nom d'utilisateur est déjà pris.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Il y a eu un problème lors de la validation du nom d'utilisateur.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Rentrez un mot de passe.";
    } elseif (strlen(trim($_POST["password"])) < 10) {
        $password_err = "Le mot de passe doit être d'au moins 10 caractères.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Confirmez le mot de passe";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Les mots de passe ne sont pas identiques.";
        }
    }

    $email = "";
    $param_email = $email;
    if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Veuillez entrer une adresse email valide.";
    } else {
        $email = trim($_POST["email"]);
        $email = htmlspecialchars($email);
    }

    $DefaultRole = 3;

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($role_err)) {

        $sql = "INSERT INTO user (username, password, user_role_ID, email) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $param_role, $param_email);

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_role = $DefaultRole;
            $param_email = $email;

            if (mysqli_stmt_execute($stmt)) {
                header("location: baldflix_login.php");
                exit();
            } else {
                echo "Il y a eu un problème lors de l'inscription : " . mysqli_error($link);
            }
            mysqli_stmt_close($stmt);
        }
    }
}
