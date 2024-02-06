<?php
session_start();
require_once "php/config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: php/baldflix_login.php");
  exit;
}

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

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
    echo "    <div id=\"welcomePopup\" class=\"welcome_popup\">
    <div class=\"welcome_popup_content\">
      <span class=\"welcome_close\">&times;</span>
      <h2>Bienvenue sur BaldFlix !</h2>
      <p>Découvrez mon petit projet perso d'étudiant !</p>
        <p>Actuellement stagiaire en tant que Concepteur Développeur d'application à Metz Numeric School, j'ai créé le site BaldFlix dans le cadre de ma formation. Ce projet est pour moi une excellente occasion de mettre en pratique et d'approfondir mes connaissances en PHP, JavaScript, HTML, CSS, et Ajax. À travers le développement de ce site, je cherche à appliquer concrètement les notions apprises en cours et à améliorer mes compétences en développement web, tout en proposant une plateforme divertissante. Ceci est la V.1 de mon site, je met mon projet en pause pour me consacrer pleinement à mon apprentissage du C#.</p>
        <p>Le compte que vous avez crée précedemment est un compte démo. Le serveur étant hébergé sur mon Raspberry Pi, les comptes seront supprimés à minuit. Si vous souhaitez avoir un compte permenant, envoyez moi un mail à contact@florentbernar.fr ou directement dans la section suggestion du site dans profile :) </p>
    </div>
  </div>";

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
    require_once "php/getFilmOrSerieIndex.php";
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
  <script src="../js/popup.js"></script>
</body>

</html>