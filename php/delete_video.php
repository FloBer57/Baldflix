<?php 

require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: baldflix_login.php");
  exit;
}

if ($_SESSION["user_role_ID"] != 2) {
  header("location: profile.php");
  exit;
}

function deleteFiles($path) {
  if (is_file($path)) {
      unlink($path); 
  } elseif (is_dir($path)) {
      $files = array_diff(scandir($path), ['.', '..']);
      foreach ($files as $file) {
          deleteFiles($path . '/' . $file);
      }
      rmdir($path); 
  }
}

$film_dir = "../video/film/";
$serie_dir = "../video/serie/";


if (isset($_GET["action"]) && $_GET["action"] == "deleteVideo" && isset($_GET["ID"]) && isset($_GET["type"]) && isset($_GET["title"]) && isset($_GET["csrf_token"])) {
  if ($_GET["csrf_token"] === $_SESSION["csrf_token"]) {
    $idToDelete = $_GET["ID"];
    $typeToDelete = $_GET["type"];
    $titleToDelete = $_GET["title"];

    mysqli_begin_transaction($link);

    try {
      if ($typeToDelete === 'film') {
        $path = $film_dir . $titleToDelete;
        deleteFiles($path);
        $sql = "DELETE FROM film_categorie WHERE filmXcategorie_film_ID = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idToDelete);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Supprimer le film
        $sql = "DELETE FROM film WHERE film_ID = ?";
      } elseif ($typeToDelete === 'serie') {
        $path = $serie_dir . $titleToDelete;
        deleteFiles($path);
    
        // Supprimer les entrées dans serieXcategorie
        $sql = "DELETE FROM serie_categorie WHERE serieXcategorie_serie_ID = ?";
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
        $sql = "DELETE FROM serie WHERE serie_ID = ?";
      } else {
        throw new Exception("Type inconnu pour la suppression.");
      }

      // Exécuter la suppression finale
      $stmt = mysqli_prepare($link, $sql);
      mysqli_stmt_bind_param($stmt, "i", $idToDelete);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);

      mysqli_commit($link);
    } catch (Exception $e) {
      mysqli_rollback($link);
      echo "<p>Erreur lors de la suppression : " . $e->getMessage() . "</p>";
    }
  } else {
    echo "<p>Erreur de vérification CSRF.</p>";
  }
}