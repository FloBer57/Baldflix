<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: baldflix_login.php");
    exit;
}

if ($_SESSION["user_role_ID"] != 2) {
    header("location: profile.php");
    exit;
}

if (isset($_GET["action"], $_GET["user_ID"], $_GET["csrf_token"]) && $_GET["action"] == "delete") {
    if ($_GET["csrf_token"] !== $_SESSION["csrf_token"]) {
        die("Token CSRF invalide.");
    }

    $user_ID_to_delete = filter_var($_GET["user_ID"], FILTER_VALIDATE_INT);
    if ($user_ID_to_delete === false) {
        die("Identifiant utilisateur invalide.");
    }

    $delete_sql = "DELETE FROM user WHERE user_ID = ?";
    if ($delete_stmt = mysqli_prepare($link, $delete_sql)) {
        mysqli_stmt_bind_param($delete_stmt, "i", $user_ID_to_delete);
        if (mysqli_stmt_execute($delete_stmt)) {
            $_SESSION["delete_status"] = "Utilisateur supprimé avec succès.";
        } else {
            $_SESSION["delete_status"] = "Erreur lors de la suppression de l'utilisateur.";
        }
        mysqli_stmt_close($delete_stmt);
    } else {
        $_SESSION["delete_status"] = "Erreur de préparation de la requête.";
    }

    header("Location: admin_page.php");
    exit;
}
