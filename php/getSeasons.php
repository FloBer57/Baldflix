<?php
session_start();
require_once "config.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: baldflix_login.php");
    exit;
}

if (isset($_GET['serieId']) && ctype_digit($_GET['serieId'])) {
    $serieId = (int)$_GET['serieId'];

    $sql = "SELECT saison_number FROM saison WHERE saison_serie_ID = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $serieId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            while ($saison = mysqli_fetch_assoc($result)) {
                echo '<option value="' . htmlspecialchars($saison['saison_number']) . '">Saison ' . htmlspecialchars($saison['saison_number']) . '</option>';
            }
        } else {
            echo "Aucune saison trouvée pour cette série.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur de préparation de la requête.";
    }
} else {
    echo "Identifiant de série invalide ou non fourni.";
}
