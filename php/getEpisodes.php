<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: baldflix_login.php");
    exit;
}

if (isset($_GET['saisonNumber'], $_GET['serieId']) && ctype_digit($_GET['saisonNumber']) && ctype_digit($_GET['serieId'])) {
    $saisonNumber = (int)$_GET['saisonNumber'];
    $serieId = (int)$_GET['serieId'];

    $sql = "SELECT * FROM episode WHERE episode_saison_ID IN (SELECT saison_ID FROM saison WHERE saison_number = ? AND saison_serie_ID = ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $saisonNumber, $serieId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            echo '<select id="episodeSelect" onchange="updateEpisode(this.value)">';
            while ($episode = mysqli_fetch_assoc($result)) {
                $episodeParts = explode('_', $episode['episode_title']);
                $episodeNumber = end($episodeParts);
                echo '<option value="' . htmlspecialchars($episode['episode_path']) . '">Épisode ' . htmlspecialchars($episodeNumber) . '</option>';
            }
            echo '</select>';
        } else {
            echo "Aucun épisode trouvé.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur de préparation de la requête.";
    }
} else {
    echo "Paramètres manquants ou invalides.";
}
