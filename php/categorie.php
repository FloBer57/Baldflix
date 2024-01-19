<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: ../php/baldflix_login.php");
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
      $sql = 'SELECT
      film.film_ID,
      film.film_image_path,
      "film" AS type,
      NULL AS serie_ID,
      NULL AS serie_image_path,
      NULL AS serie_type
  FROM
      film
  INNER JOIN
      film_categorie ON film.film_ID = film_categorie.filmXcategorie_film_ID
  INNER JOIN
      categorie ON film_categorie.filmXcategorie_categorie_ID = categorie.categorie_id
  WHERE
      categorie.categorie_nom = ?
  UNION ALL
  SELECT
      NULL AS film_ID,
      NULL AS film_image_path,
      NULL AS type,
      serie.serie_ID,
      serie.serie_image_path,
      "serie" AS serie_type
  FROM
      serie
  INNER JOIN
      serie_categorie ON serie.serie_ID = serie_categorie.serieXcategorie_serie_ID
  INNER JOIN
      categorie ON serie_categorie.serieXcategorie_categorie_ID = categorie.categorie_id
  WHERE
      categorie.categorie_nom = ?';

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
      $image_path = htmlspecialchars($item['film_ID'] ? $item['film_image_path'] : $item['serie_image_path']);
      $id = htmlspecialchars($item['type'] === 'film' ? $item['film_ID'] : '');

      // Vérifiez si la clé "serie_ID" existe pour les enregistrements de type "serie"
      if ($item['serie_type'] === 'serie' && isset($item['serie_ID'])) {
        $serieID = htmlspecialchars($item['serie_ID']);
      } else {
        $serieID = '';
      }

      echo '<div class="box-div"><a href=""><img src="' . $image_path . '" alt="' . $image_path . '" data-id="' . $id . '"></a></div>';
    }
    ?>
  </section>

  <?php
  require_once "../includes/footer.php";
  ?>
  <script src="../js/burger.js"></script>
</body>

</html>