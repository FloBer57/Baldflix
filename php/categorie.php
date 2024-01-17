<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: php/baldflix_login.php");
  exit;
}

$categorie = mysqli_real_escape_string($link, $_GET['categorie'] ?? 'Anime');

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="robots" content="noindex, nofollow, noimageindex">
  <link rel="shortcut icon" href="image/favicon/bald_favicon.ico" type="image/x-icon" />
  <!-- noindex, nofollown, noimageindex servent à faire en sorte que rien de ma page HTML ne sois indexé par les navigateurs de recherche.-->
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

function getFilmsOrSeriesByCategory($link, $categorie) {
  $sql = "SELECT f.*, c.film_image_path AS image_path, 'film' AS type FROM film as f JOIN film_categorie fc ON f.film_ID = fc.filmXcategorie_film_ID JOIN categorie c ON fc.filmXcategorie_categorie_ID = c.categorie_id WHERE c.categorie_nom = '$categorie'
  UNION ALL
  SELECT s.*, c.serie_image_path AS image_path, 'serie' AS type FROM serie as s JOIN serie_categorie fc ON s.serie_ID = fc.serieXcategorie_serie_ID JOIN categorie c ON fc.serieXcategorie_categorie_ID = c.categorie_id WHERE c.categorie_nom = '$categorie'";

  $result = mysqli_query($link, $sql);

  $filmsOrSeries = array();

  if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $image_path = htmlspecialchars($row['image_path']);
      $type = $row['type'];

      $filmsOrSeries[] = array('image_path' => $image_path, 'type' => $type);
    }
  }

  return $filmsOrSeries;
}


    echo '<div class="container" id="categorie_container">';
    switch ($categorie) {
      case 'serie':
        echo '<h3 id="anime">Anime</h3>';
        echo '<div class="box box-anime">';

        $filmsOrSeries = getFilmsOrSeriesByCategory($link, $categorie);
        foreach ($filmsOrSeries as $item) {
          $image_path = $item['image_path'];
          $type = $item['type'];
          echo '<div class="box-div"><a href=""><img src="' . $image_path . '" alt="' . $image_path . '"></a></div>';
        }
        echo '</div>';
        echo '</div>';
        break;

      case 'Film':
        echo '<h3 id="film">Film</h3>';
        echo '<div class="box box-film">';
    
        $filmsOrSeries = getFilmsOrSeriesByCategory($link, $categorie);
        foreach ($filmsOrSeries as $item) {
          $image_path = $item['image_path'];
          $type = $item['type'];
          echo '<div class="box-div"><a href=""><img src="' . $image_path . '" alt="' . $image_path . '"></a></div>';
        }
        echo '</div>';
        echo '</div>';
        break;

      case 'Serie':
        echo '<h3 id="serie">Serie</h3>';
        echo '<div class="box box-serie">';
    
        $filmsOrSeries = getFilmsOrSeriesByCategory($link, $categorie);
        foreach ($filmsOrSeries as $item) {
          $image_path = $item['image_path'];
          $type = $item['type'];
          echo '<div class="box-div"><a href=""><img src="' . $image_path . '" alt="' . $image_path . '"></a></div>';
        }
        echo '</div>';
        echo '</div>';
        break;

      case 'Spectacle':
        echo '<h3 id="spectacle">Spectacle</h3>';
        echo '<div class="box box-spectacle">';

        $filmsOrSeries = getFilmsOrSeriesByCategory($link, $categorie);
        foreach ($filmsOrSeries as $item) {
          $image_path = $item['image_path'];
          $type = $item['type'];
          echo '<div class="box-div"><a href=""><img src="' . $image_path . '" alt="' . $image_path . '"></a></div>';
        }
        echo '</div>';
        echo '</div>';
        break;

      case 'Bald':
        echo '<h3 id="bald">Bald</h3>';
        echo '<div class="box box-bald">';
    
        $filmsOrSeries = getFilmsOrSeriesByCategory($link, $categorie);
        foreach ($filmsOrSeries as $item) {
          $image_path = $item['image_path'];
          $type = $item['type'];
          echo '<div class="box-div"><a href=""><img src="' . $image_path . '" alt="' . $image_path . '"></a></div>';
        }
        echo '</div>';
        echo '</div>';
        break;

      default:
        echo 'Il y a eu une erreur';
        break;
    }
    ?>

  </section>
  
  <!-- ##FOOTER## -->
  <?php

  require_once "../includes/footer.php";

  ?>
</body>

</html>