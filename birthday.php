<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez la nouvelle date de naissance depuis le formulaire
    $nouvelleDateNaissance = $_POST["nouvelleDateNaissance"];

    // Enregistrez la nouvelle date de naissance dans votre base de données
    // ou utilisez-la comme nécessaire (par exemple, mise à jour du profil utilisateur).

    // Redirigez l'utilisateur vers une page de profil ou une autre destination.
    header("Location: account_page.php");
    exit();
}
?>