<?php 

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: baldflix_login.php");
    exit;
  }
require_once "config.php";

// Initialisation des variables avec des chaines vides
$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";

// Traitement des données du formulaire lorsqu'il est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validation du nom d'utilisateur
    if (empty(trim($_POST["username"]))) {
        $username_err = "Veuillez entrer un nom d'utilisateur.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Le nom d'utilisateur ne peut contenir que des lettres, des chiffres et des underscores.";
    } else {
        // Préparation d'une déclaration SELECT pour vérifier si le nom d'utilisateur existe déjà
        $sql = "SELECT user_ID FROM user WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "Ce nom d'utilisateur est déjà pris.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Quelque chose s'est mal passé. Veuillez réessayer plus tard.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Validation du mot de passe
    if (empty(trim($_POST["password"]))) {
        $password_err = "Veuillez entrer un mot de passe.";
    } elseif (strlen(trim($_POST["password"])) < 10) {
        $password_err = "Le mot de passe doit contenir au moins 10 caractères.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validation de la confirmation du mot de passe
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Veuillez confirmer le mot de passe.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Les mots de passe ne correspondent pas.";
        }
    }

    // Validation de l'email (facultatif)
    if (!empty(trim($_POST["email"])) && !filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Veuillez entrer une adresse email valide.";
    } else {
        $email = htmlspecialchars(trim($_POST["email"]));
    }

    // Vérification des erreurs avant l'insertion dans la base de données
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {

        // Préparation d'une déclaration INSERT
        $sql = "INSERT INTO user (username, password, user_role_ID, email) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssis", $param_username, $param_password, $param_role, $param_email);

            // Paramètres
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Création d'un hash pour le mot de passe
            $param_role = 3; // Rôle par défaut ( démo )
            $param_email = $email;

            // Exécution de la déclaration préparée
            if (mysqli_stmt_execute($stmt)) {
                // Redirection vers la page de login
                header("location: baldflix_login.php");
            } else {
                echo "Quelque chose s'est mal passé. Veuillez réessayer plus tard.";
            }

            // Fermeture de la déclaration
            mysqli_stmt_close($stmt);
        }
    }

    // Fermeture de la connexion
    mysqli_close($link);
}