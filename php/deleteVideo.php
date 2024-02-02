<?php 
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["ID"]) && isset($_GET["type"]) && isset($_GET["csrf_token"])) {
  if ($_GET["csrf_token"] === $_SESSION["csrf_token"]) {
    $idToDelete = $_GET["ID"];
    $typeToDelete = $_GET["type"];

    // Débuter une transaction
    mysqli_begin_transaction($link);

    try {
      if ($typeToDelete === 'film') {
        // Supprimer les entrées dans filmXcategorie
        $sql = "DELETE FROM filmXcategorie WHERE filmXcategorie_film_ID = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idToDelete);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Supprimer le film
        $sql = "DELETE FROM film WHERE film_ID = ?";
      } elseif ($typeToDelete === 'serie') {
        // Supprimer les entrées dans serieXcategorie
        $sql = "DELETE FROM serieXcategorie WHERE serieXcategorie_serie_ID = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idToDelete);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Supprimer les épisodes via les saisons
        $sql = "DELETE episode FROM episode INNER JOIN saison ON episode.episode_saison_ID = saison.saison_ID WHERE saison.saison_serie_ID = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idToDelete);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Supprimer les saisons
        $sql = "DELETE FROM saison WHERE saison_serie_ID = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idToDelete);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Préparer à supprimer la série
        $sql = "DELETE FROM serie WHERE serie_ID = ?";
      } else {
        throw new Exception("Type inconnu pour la suppression.");
      }

      // Exécuter la suppression finale
      $stmt = mysqli_prepare($link, $sql);
      mysqli_stmt_bind_param($stmt, "i", $idToDelete);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);

      // Valider la transaction
      mysqli_commit($link);
      echo "<p>La vidéo a été supprimée avec succès.</p>";
    } catch (Exception $e) {
      // Annuler la transaction en cas d'erreur
      mysqli_rollback($link);
      echo "<p>Erreur lors de la suppression : " . $e->getMessage() . "</p>";
    }
  } else {
    echo "<p>Erreur de vérification CSRF.</p>";
  }
}