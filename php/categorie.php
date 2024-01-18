<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: php/baldflix_login.php");
  exit;
}

$categorie = mysqli_real_escape_string($link, $_GET['categorie'] ?? 'Anime');
$lower_categorie = strtolower($categorie);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="robots" content="noindex, nofollow, noimageindex">
  <link rel="shortcut icon" href="image/favicon/bald_favicon.ico" type="image/x-icon" />
  <title>
    <?php echo ucfirst($categorie); ?>
  </title>
  <link href="../css/global.CSS" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Bungee+Inline&display=swap" rel="stylesheet">
</head>

<body class="back bodyburger">
  <?php

  require_once "../includes/header.php";

  ?>
  <section class="main-container">
    <?php

    function getFilmsOrSeriesByCategory($link, $categorie)
    {
      $sql = "SELECT f.*, c.film_image_path AS image_path, 'film' AS type, film_ID 
          FROM film as f 
          JOIN film_categorie fc ON f.film_ID = fc.filmXcategorie_film_ID 
          JOIN categorie c ON fc.filmXcategorie_categorie_ID = c.categorie_id 
          WHERE c.categorie_nom = ?
          UNION ALL
          SELECT s.*, c.serie_image_path AS image_path, 'serie' AS type, serie_ID 
          FROM serie as s 
          JOIN serie_categorie fc ON s.serie_ID = fc.serieXcategorie_serie_ID 
          JOIN categorie c ON fc.serieXcategorie_categorie_ID = c.categorie_id 
          WHERE c.categorie_nom = ?";

      if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $categorie, $categorie);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $filmsOrSeries = array();
        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            array_push($filmsOrSeries, $row);
          }
        }
        mysqli_stmt_close($stmt);
        return $filmsOrSeries;
      } else {
        echo "Erreur de préparation de la requête.";
        return array();
      }
    }

    $filmsOrSeries = getFilmsOrSeriesByCategory($link, $categorie);

    echo '<div class="container" id="' . $lower_categorie . '_container">';
    echo '<h3 id="' . $lower_categorie . '">' . htmlspecialchars($categorie) . '</h3>';
    echo '<div class="box box-' . $lower_categorie . '">';

    foreach ($filmsOrSeries as $item) {
      $image_path = htmlspecialchars($item['image_path']);
      $id = htmlspecialchars($item['type'] === 'film' ? $item['film_ID'] : $item['serie_ID']);
      echo '<div class="box-div"><a href=""><img src="' . $image_path . '" alt="' . $image_path . '" data-id="' . $id . '"></a></div>';
    }

    echo '</div>';
    echo '</div>';
    ?>
  </section>

  <?php 
  require_once "../includes/footer.php"; 
  ?>
  <script src="../js/burger.js"></script>
</body>

</html>