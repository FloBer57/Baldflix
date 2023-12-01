<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedImage = $_POST["profilImage"];

    // Enregistrez la sélection dans votre base de données ou utilisez-la comme nécessaire
    // par exemple, enregistrez le nom du fichier dans la base de données utilisateur.

    // Redirigez l'utilisateur vers une page de profil ou une autre destination.
    header("Location: account_page.php");
    exit();
}
?>