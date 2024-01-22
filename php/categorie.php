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
      film.film_title,
      film.film_tags,
      film.film_synopsis,
      film.film_image_path,
      film.film_duree,
      film.film_path,
      film.film_miniature_path,
      film.film_date_ajout,
      NULL AS serie_ID,
      NULL AS serie_image_path,
      NULL AS serie_type,
      NULL AS serie_synopsis,
      NULL AS serie_image_path,
      NULL AS saison_ID,
      NULL AS saison_number,
      NULL AS saison_serie_ID,
      NULL AS episode_ID,
      NULL AS episode_title,
      NULL AS episode_duree,
      NULL AS episode_saison_ID,
      NULL AS episode_path,
      NULL AS episode_miniature_path,
      NULL AS episode_date_ajout,
      "film" AS type
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
      NULL AS film_synopsis,
      NULL AS film_duree,
      NULL AS film_tags,
      NULL AS film_path,
      NULL AS film_miniature_path,
      NULL AS film_date_ajout,
      NULL AS film_image_path,
      serie.serie_ID,
      serie.serie_title,
      serie.serie_tags,
      serie.serie_synopsis,
      serie.serie_image_path,
      saison.saison_ID,
      saison.saison_number,
      saison.saison_serie_ID,
      episode.episode_ID,
      episode.episode_title,
      episode.episode_duree,
      episode.episode_saison_ID,
      episode.episode_path,
      episode.episode_miniature_path,
      episode.episode_date_ajout,
      "serie" AS serie_type
  FROM
      serie
  INNER JOIN
      serie_categorie ON serie.serie_ID = serie_categorie.serieXcategorie_serie_ID
  INNER JOIN
      categorie ON serie_categorie.serieXcategorie_categorie_ID = categorie.categorie_id
  INNER JOIN
      saison ON saison.saison_serie_ID = serie.serie_ID
  INNER JOIN 
      episode ON episode.episode_saison_ID = saison.saison_ID
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

    echo '<div class="container container_cat" id="' . $lower_categorie . '_container">';
    echo '<h3 id="' . $lower_categorie . '">' . htmlspecialchars($categorie) . '</h3>';
    echo '<div class="box box-' . $lower_categorie . '">';

    foreach ($filmsOrSeries as $item) {
      $id = htmlspecialchars($item['type'] === 'film' ? $item['film_ID'] : $item['serie_ID']);
      $title = htmlspecialchars($item['type'] === 'film' ? $item['film_title'] : $item['serie_title']);
      $image_path = htmlspecialchars($item['type'] === 'film' ? $item['film_image_path'] : $item['serie_image_path']);
      $synopsis = htmlspecialchars($item['type'] === 'film' ? $item['film_synopsis'] : $item['serie_synopsis']);
      $duree = htmlspecialchars($item['type'] === 'film' ? $item['film_duree'] : (isset($item['episode_duree']) ? $item['episode_duree'] : ''));
      $tags = htmlspecialchars($item['type'] === 'film' ? $item['film_tags'] : (isset($item['serie_tags']) ? $item['serie_tags'] : ''));
      $video_path = htmlspecialchars($item['type'] === 'film' ? $item['film_path'] : (isset($item['episode_path']) ? $item['episode_path'] : ''));
      $date_ajout = htmlspecialchars($item['type'] === 'film' ? $item['film_date_ajout'] : (isset($item['episode_date_ajout']) ? $item['episode_date_ajout'] : ''));

      echo '<div class="box-div">
      <a href="javascript:void(0);" onclick="openModal(this)"
         data-id="' . $id . '"
         data-image="' . $image_path . '"
         data-title="' . $title . '"
         data-synopsis="' . $synopsis . '"
         data-tags="' . $tags . '"
         data-duration="' . $duree . '"
         data-video="' . $video_path . '"
         data-date-ajout="' . $date_ajout . '">
          <img src="' . $image_path . '" alt="' . $title . '">
      </a>
  </div>';
    }
    ?>

    <div id="container_modale_video" class="container_modale_video" style="display:none">
      <div class="modale_video">
        <span class="close_video" onclick="closeModal()">&times;</span>
        <div class="title_video">
          <h2></h2>
        </div>
        <div class="container_duree_affiche">
          <div class="affiche_modale">
            <img src="" alt="">
          </div>
          <div class="tags_duree_modale">
          </div>
        </div>
        <div class="title_synopsis_modale">
          <div class="player_modale">
            <video src=""></video>
            <p></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
  require_once "../includes/footer.php";
  ?>
  <script src="../js/burger.js"></script>
  <script src="../js/modaleVideo.js"></script>
</body>

</html>