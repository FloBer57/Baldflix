<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: baldflix_login.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="robots" content="noindex, nofollow, noimageindex">
  <!-- noindex, nofollown, noimageindex servent à faire en sorte que rien de ma page HTML ne sois indexé par les navigateurs de recherche.-->
  <title>BaldFlix</title>
  <link href="css/global.CSS" rel="stylesheet" />
  <link rel="shortcut icon" href="image/favicon.ico" type="image/x-icon" />
  <!-- Add the slick-theme.css if you want default styling -->
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <!-- Add the slick-theme.css if you want default styling -->
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

</head>

<body class="back">

  <?php

  require_once "includes/header.php";

  ?>

  <section class="trailer">
    <div class="present-vid" id="video">
      <video class="preview" autoplay muted loop id="video-background">
        <source src="trailer.mp4" type="video/mp4">
        Votre navigateur ne prend pas en charge la vidéo.
      </video>
      <h2 class="text-video">Nouveau sur BaldFlix</h2>
    </div>
  </section>

  <section class="main-container">
    <div class="container" id="home__watched">
      <h3 id="watched">Vue précédemment</h3>
      <div class="box box-watched">
        <div class="box-div div1"><a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a></div>
        <div class="box-div div2"><a href=""><img src="https://picsum.photos/600/400?random=3" alt=""></a></div>
        <div class="box-div div3"><a href=""><img src="https://picsum.photos/600/400?random=4" alt=""></a></div>
        <div class="box-div div4"><a href=""><img src="https://picsum.photos/600/400?random=5" alt=""></a></div>
        <div class="box-div div5"><a href=""><img src="https://picsum.photos/600/400?random=6" alt=""></a></div>
        <div class="box-div div6"><a href=""><img src="https://picsum.photos/600/400?random=7" alt=""></a></div>
        <div class="box-div div7"><a href=""><img src="https://picsum.photos/600/400?random=8" alt=""></a></div>
        <div class="box-div div8"><a href=""><img src="https://picsum.photos/600/400?random=9" alt=""></a></div>
        <div class="box-div div9"><a href=""><img src="https://picsum.photos/600/400?random=10" alt=""></a></div>
        <div class="box-div div10"><a href=""><img src="https://picsum.photos/600/400?random=11" alt=""></a></div>
        <div class="box-div div11"><a href=""><img src="https://picsum.photos/600/400?random=12" alt=""></a></div>
        <div class="box-div div12"><a href=""><img src="https://picsum.photos/600/400?random=13" alt=""></a></div>
        <div class="box-div div13"><a href=""><img src="https://picsum.photos/600/400?random=14" alt=""></a></div>
        <div class="box-div div14"><a href=""><img src="https://picsum.photos/600/400?random=15" alt=""></a></div>
        <div class="box-div div15"><a href=""><img src="https://picsum.photos/600/400?random=16" alt=""></a></div>
        <div class="box-div div16"><a href=""><img src="https://picsum.photos/600/400?random=17" alt=""></a></div>
        <div class="box-div div17"><a href=""><img src="https://picsum.photos/600/400?random=18" alt=""></a></div>
        <div class="box-div div18"><a href=""><img src="https://picsum.photos/600/400?random=19" alt=""></a></div>
      </div>
    </div>

    <div class="container" id="home__series">
      <h3 id="serie">Séries</h3>
      <div class="box box-serie">
        <div class="box-div div19"><a href=""><img src="https://picsum.photos/600/400?random=20" alt=""></a></div>
        <div class="box-div div20"><a href=""><img src="https://picsum.photos/600/400?random=21" alt=""></a></div>
        <div class="box-div div21"><a href=""><img src="https://picsum.photos/600/400?random=22" alt=""></a></div>
        <div class="box-div div22"><a href=""><img src="https://picsum.photos/600/400?random=23" alt=""></a></div>
        <div class="box-div div23"><a href=""><img src="https://picsum.photos/600/400?random=24" alt=""></a></div>
        <div class="box-div div24"><a href=""><img src="https://picsum.photos/600/400?random=25" alt=""></a></div>
        <div class="box-div div25"><a href=""><img src="https://picsum.photos/600/400?random=26" alt=""></a></div>
        <div class="box-div div26"><a href=""><img src="https://picsum.photos/600/400?random=27" alt=""></a></div>
        <div class="box-div div27"><a href=""><img src="https://picsum.photos/600/400?random=28" alt=""></a></div>
        <div class="box-div div28"><a href=""><img src="https://picsum.photos/600/400?random=29" alt=""></a></div>
        <div class="box-div div29"><a href=""><img src="https://picsum.photos/600/400?random=40" alt=""></a></div>
        <div class="box-div div30"><a href=""><img src="https://picsum.photos/600/400?random=41" alt=""></a></div>
        <div class="box-div div31"><a href=""><img src="https://picsum.photos/600/400?random=42" alt=""></a></div>
        <div class="box-div div32"><a href=""><img src="https://picsum.photos/600/400?random=43" alt=""></a></div>
        <div class="box-div div33"><a href=""><img src="https://picsum.photos/600/400?random=44" alt=""></a></div>
        <div class="box-div div34"><a href=""><img src="https://picsum.photos/600/400?random=45" alt=""></a></div>
        <div class="box-div div35"><a href=""><img src="https://picsum.photos/600/400?random=46" alt=""></a></div>
        <div class="box-div div36"><a href=""><img src="https://picsum.photos/600/400?random=47" alt=""></a></div>
      </div>
    </div>

    <div class="container" id="home__films">
      <h3 id="films">Films</h3>
      <div class="box box-films">
        <div class="box-div div37"><a href=""><img src="https://picsum.photos/600/400?random=48" alt=""></a></div>
        <div class="box-div div38"><a href=""><img src="https://picsum.photos/600/400?random=49" alt=""></a></div>
        <div class="box-div div39"><a href=""><img src="https://picsum.photos/600/400?random=50" alt=""></a></div>
        <div class="box-div div40"><a href=""><img src="https://picsum.photos/600/400?random=51" alt=""></a></div>
        <div class="box-div div41"><a href=""><img src="https://picsum.photos/600/400?random=52" alt=""></a></div>
        <div class="box-div div42"><a href=""><img src="https://picsum.photos/600/400?random=53" alt=""></a></div>
        <div class="box-div div43"><a href=""><img src="https://picsum.photos/600/400?random=54" alt=""></a></div>
        <div class="box-div div44"><a href=""><img src="https://picsum.photos/600/400?random=55" alt=""></a></div>
        <div class="box-div div45"><a href=""><img src="https://picsum.photos/600/400?random=56" alt=""></a></div>
        <div class="box-div div46"><a href=""><img src="https://picsum.photos/600/400?random=57" alt=""></a></div>
        <div class="box-div div47"><a href=""><img src="https://picsum.photos/600/400?random=58" alt=""></a></div>
        <div class="box-div div48"><a href=""><img src="https://picsum.photos/600/400?random=59" alt=""></a></div>
        <div class="box-div div49"><a href=""><img src="https://picsum.photos/600/400?random=60" alt=""></a></div>
        <div class="box-div div50"><a href=""><img src="https://picsum.photos/600/400?random=61" alt=""></a></div>
        <div class="box-div div51"><a href=""><img src="https://picsum.photos/600/400?random=62" alt=""></a></div>
        <div class="box-div div52"><a href=""><img src="https://picsum.photos/600/400?random=63" alt=""></a></div>
        <div class="box-div div53"><a href=""><img src="https://picsum.photos/600/400?random=64" alt=""></a></div>
        <div class="box-div div54"><a href=""><img src="https://picsum.photos/600/400?random=65" alt=""></a></div>
      </div>
    </div>

    <div class="container" id="home__animes">
      <h3 id="anime">Animes</h3>
      <div class="box box-anime">
        <div class="box-div di55"><a href=""><img src="https://picsum.photos/600/400?random=30" alt=""></a></div>
        <div class="box-div di56"><a href=""><img src="https://picsum.photos/600/400?random=31" alt=""></a></div>
        <div class="box-div div57"><a href=""><img src="https://picsum.photos/600/400?random=32" alt=""></a></div>
        <div class="box-div div58"><a href=""><img src="https://picsum.photos/600/400?random=33" alt=""></a></div>
        <div class="box-div div59"><a href=""><img src="https://picsum.photos/600/400?random=34" alt=""></a></div>
        <div class="box-div div60"><a href=""><img src="https://picsum.photos/600/400?random=35" alt=""></a></div>
        <div class="box-div div61"><a href=""><img src="https://picsum.photos/600/400?random=36" alt=""></a></div>
        <div class="box-div div62"><a href=""><img src="https://picsum.photos/600/400?random=37" alt=""></a></div>
        <div class="box-div div63"><a href=""><img src="https://picsum.photos/600/400?random=38" alt=""></a></div>
        <div class="box-div div64"><a href=""><img src="https://picsum.photos/600/400?random=39" alt=""></a></div>
        <div class="box-div div65"><a href=""><img src="https://picsum.photos/600/400?random=66" alt=""></a></div>
        <div class="box-div div66"><a href=""><img src="https://picsum.photos/600/400?random=67" alt=""></a></div>
        <div class="box-div div67"><a href=""><img src="https://picsum.photos/600/400?random=68" alt=""></a></div>
        <div class="box-div div68"><a href=""><img src="https://picsum.photos/600/400?random=69" alt=""></a></div>
        <div class="box-div div69"><a href=""><img src="https://picsum.photos/600/400?random=70" alt=""></a></div>
        <div class="box-div div70"><a href=""><img src="https://picsum.photos/600/400?random=71" alt=""></a></div>
        <div class="box-div div71"><a href=""><img src="https://picsum.photos/600/400?random=72" alt=""></a></div>
        <div class="box-div div72"><a href=""><img src="https://picsum.photos/600/400?random=73" alt=""></a></div>
      </div>
    </div>

    <div class="container" id="home__spectacles">
      <h3 id="spectacles">Spectacles</h3>
      <div class="box box-spectacles">
        <div class="box-div div73"><a href=""><img src="https://picsum.photos/600/400?random=74" alt=""></a></div>
        <div class="box-div div74"><a href=""><img src="https://picsum.photos/600/400?random=75" alt=""></a></div>
        <div class="box-div div75"><a href=""><img src="https://picsum.photos/600/400?random=76" alt=""></a></div>
        <div class="box-div div76"><a href=""><img src="https://picsum.photos/600/400?random=77" alt=""></a></div>
        <div class="box-div div77"><a href=""><img src="https://picsum.photos/600/400?random=78" alt=""></a></div>
        <div class="box-div div78"><a href=""><img src="https://picsum.photos/600/400?random=79" alt=""></a></div>
        <div class="box-div div79"><a href=""><img src="https://picsum.photos/600/400?random=80" alt=""></a></div>
        <div class="box-div div80"><a href=""><img src="https://picsum.photos/600/400?random=81" alt=""></a></div>
        <div class="box-div div81"><a href=""><img src="https://picsum.photos/600/400?random=82" alt=""></a></div>
        <div class="box-div div82"><a href=""><img src="https://picsum.photos/600/400?random=83" alt=""></a></div>
        <div class="box-div div83"><a href=""><img src="https://picsum.photos/600/400?random=84" alt=""></a></div>
        <div class="box-div div84"><a href=""><img src="https://picsum.photos/600/400?random=85" alt=""></a></div>
        <div class="box-div div85"><a href=""><img src="https://picsum.photos/600/400?random=86" alt=""></a></div>
        <div class="box-div div86"><a href=""><img src="https://picsum.photos/600/400?random=87" alt=""></a></div>
        <div class="box-div div87"><a href=""><img src="https://picsum.photos/600/400?random=88" alt=""></a></div>
        <div class="box-div div88"><a href=""><img src="https://picsum.photos/600/400?random=89" alt=""></a></div>
        <div class="box-div div89"><a href=""><img src="https://picsum.photos/600/400?random=90" alt=""></a></div>
        <div class="box-div div90"><a href=""><img src="https://picsum.photos/600/400?random=91" alt=""></a></div>
      </div>
    </div>

  </section>
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://code.jquery.com/jquery-migrate-3.4.1.js"></script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <script src="js/carrousel.js"></script>
  <script src="js/carrousel_2.js"></script>
  <script src="js/carrousel_3.js"></script>
  <script src="js/carrousel_4.js"></script>
  <script src="js/carrousel_5.js"></script>
  <!-- ##FOOTER## -->
  <?php

  require_once "includes/footer.php";

  ?>
</body>



</html>