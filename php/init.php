<?php
session_start();
require_once "config.php";

// Redirection si non connecté
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../php/baldflix_login.php");
    exit;
}

// Gestion de l'expiration de la session pour les utilisateurs avec user_role_ID == 3
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["user_role_ID"] == 3) {
    $expireAfter = 30; // Durée d'expiration en minutes

    if (isset($_SESSION['last_action'])) {
        $secondsInactive = time() - $_SESSION['last_action'];
        $expireAfterSeconds = $expireAfter * 60;

        if ($secondsInactive >= $expireAfterSeconds) {
            // Suppression du compte utilisateur
            $delete_sql = "DELETE FROM user WHERE user_ID = ?";
            if ($delete_stmt = mysqli_prepare($link, $delete_sql)) {
                mysqli_stmt_bind_param($delete_stmt, "i", $_SESSION["user_ID"]);
                if (mysqli_stmt_execute($delete_stmt)) {
                    // Si la suppression est réussie, détruire la session et rediriger
                    session_destroy();
                    header("location: baldflix_login.php");
                    exit;
                } else {
                    // Gérer l'erreur de suppression
                    echo "Erreur lors de la suppression du compte.";
                }
                mysqli_stmt_close($delete_stmt);
            }
            session_unset();
            session_destroy();
            header("Location: baldflix_login.php");
            exit;
        }
    }
    $_SESSION['last_action'] = time();
}