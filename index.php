<?php
session_start();
require_once "php/config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: php/baldflix_login.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="robots" content="noindex, nofollow, noimageindex">
  <link rel="shortcut icon" href="../image/favicon/bald_favicon.ico" type="image/x-icon" />
  <title>BaldFlix</title>
  <link href="css/global.CSS" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Bungee+Inline&display=swap" rel="stylesheet">
</head>

<body class="back bodyburger">

  <?php
  require_once "includes/header.php";

  if (!isset($_SESSION['animation_vue'])) {
    echo '<script>
          document.body.classList.add("no_scroll");
          setTimeout(function() {
              document.body.classList.remove("no_scroll");
          }, 3500);
        </script>';
    require_once "includes/netflix_intro.php";

    $_SESSION['animation_vue'] = true;
  }
  ?>

  <section class="trailer">
    <div class="present_vid" id="video">
      <video class="preview" autoplay muted loop id="videoBackground">
        <source src="../video/trailer/trailer.mp4" type="video/mp4">
        Votre navigateur ne prend pas en charge la vidéo.
      </video>
      <h2 class="text_video">Bienvenue <?php echo $_SESSION["username"] ?></h2>
    </div>
  </section>

  <section class="main_container main_watched">


    <?php
    function getFilmsOrSeries($link)
    {
      $orderBy = "title ASC";
      if (isset($_GET['tri'])) {
        switch ($_GET['tri']) {
          case 'title_asc':
            $orderBy = "title ASC";
            break;
          case 'title_desc':
            $orderBy = "title DESC";
            break;
        }
      }
      $sql = 'SELECT
  film.film_ID,
  film.film_image_path,
  film.film_synopsis,
  film.film_duree,
  film.film_tags,
  film.film_path,
  film.film_miniature_path,
  film.film_image_path,
  film.film_title AS title,
  NULL AS serie_ID,
  NULL AS serie_title,
  NULL AS serie_tags,
  NULL AS serie_synopsis,
  NULL AS serie_image_path,
  "film" AS type
FROM
  film
GROUP BY
  film.film_ID
UNION ALL
SELECT
  NULL AS film_ID,
  NULL AS film_image_path,
  NULL AS film_synopsis,
  NULL AS film_duree,
  NULL AS film_tags,
  NULL AS film_path,
  NULL AS film_miniature_path,
  NULL AS film_image_path,
  NULL AS film_title,
  serie.serie_ID, 
  serie.serie_title AS title,
  serie.serie_tags,
  serie.serie_synopsis,
  serie.serie_image_path,
  "serie" AS serie_type
FROM
  serie
GROUP BY
  serie.serie_ID
  ORDER BY ' . $orderBy;

      if ($stmt = mysqli_prepare($link, $sql)) {
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



    $filmsOrSeries = getFilmsOrSeries($link);

    echo '<div class="container container_cat" id="' . "index" . 'Container">';
    echo '<div class="cat_select">';
    echo '<h3 id="' . "index" . '">' . "Film & Serie" . '</h3>';
    echo '<form id="triForm" method="get">';
    echo '<input type="radio" id="title_asc" name="tri" value="title_asc" onchange="submitForm()" ' . (isset($_GET['tri']) && $_GET['tri'] == 'title_asc' ? 'checked' : '') . '>';
    echo '<label for="title_asc">Titre (A-Z)</label>';
    echo '<input type="radio" id="title_desc" name="tri" value="title_desc" onchange="submitForm()" ' . (isset($_GET['tri']) && $_GET['tri'] == 'title_desc' ? 'checked' : '') . '>';
    echo '<label for="title_desc">Titre (Z-A)</label>';
    echo '</form>';
    echo '</div>';
    echo '<script>
function submitForm() {
  document.getElementById("triForm").submit();
}
</script>';
    echo '<div class="box box_cat box_' . "index" . '">';

    foreach ($filmsOrSeries as $item) {
      $id = htmlspecialchars($item['type'] === 'film' ? $item['film_ID'] : $item['serie_ID']);
      $type = htmlspecialchars($item['type']); // Ajout du type (film ou serie)
      $title = htmlspecialchars_decode($item['type'] === 'film' ? $item['title'] : $item['serie_title']);
      $title = str_replace("_", " ", $title);
      $image_path = htmlspecialchars($item['type'] === 'film' ? $item['film_image_path'] : $item['serie_image_path']);
      $synopsis = htmlspecialchars_decode($item['type'] === 'film' ? $item['film_synopsis'] : $item['serie_synopsis']);
      $duree = htmlspecialchars($item['type'] === 'film' ? $item['film_duree'] : ''); // Durée pour les séries non disponible ici
      $video_path = htmlspecialchars($item['type'] === 'film' ? $item['film_path'] : ''); // Chemin vidéo pour les séries non disponible ici
      $miniature = htmlspecialchars($item['type'] === 'film' ? $item['film_miniature_path'] : ''); // Miniature pour les séries non disponible ici

      echo '<div class="box_div">
          <a href="javascript:void(0);" onclick="openModal(this)"
             data-id="' . $id . '"
             data-type="' . $type . '"
             data-image="' . $image_path . '"
             data-title="' . $title . '"
             data-synopsis="' . $synopsis . '"
             data-duration="' . $duree . '"
             data-video="' . $video_path . '"
             data-miniature="' . $miniature . '">
              <img src="' . $image_path . '" alt="' . $title . '">
          </a>
      </div>';
    }


    ?>
    </div>
    </div>
    <div id="containerModaleVideo" class="container_modale_video" style="display:none">
      <div class="modale_video">
        <span class="close_video" onclick="closeModal()">&times;</span>
        <div class="title_video">
          <h2></h2>
        </div>
        <div class="sub_container_modale_video">
          <div class="container_duree_affiche">
            <div class="affiche_modale">
              <img src="" alt="">
            </div>
            <div class="tags_duree_modale">
            </div>
          </div>
          <div class="title_synopsis_modale">
            <div class="player_modale">
              <video class="my_video" id="myVideo" controls>
                <source src="" type="video/mp4">
                Votre navigateur ne supporte pas la balise vidéo.
              </video>
              <div class="select_saison_episode">
                <div id="saisonSelectContainer" class="saison_select_container"></div>
                <div id="episodesSelectContainer" class="episodes_select_container"></div>
              </div>
              <p class="synopsis"></p>
            </div>
          </div>
        </div>
      </div>
    </div>



  </section>

  <?php

  require_once "includes/footer.php";

  ?>
  <script src="../js/burger.js"></script>
  <script src="../js/loadSeasons.js"></script>
  <script src="../js/loadEpisodes.js"></script>
  <script src="../js/modaleVideo.js"></script>
</body>

</html>