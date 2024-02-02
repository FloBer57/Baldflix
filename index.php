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
      <h2 class="text_video">Bienvenue sur BaldFlix</h2>
    </div>
  </section>

  <section class="main_container main_watched">
    <?php
    
  require_once "php/getFilmOrSerie.php"

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