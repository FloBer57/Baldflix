<?php
session_start();

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
    require_once "includes/netflix_intro.php";

    $_SESSION['animation_vue'] = true;
  }
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
        <div class="box-div div1"><a href=""><img src="https://picsum.photos/240/320?random=2" alt=""></a></div>
        <div class="box-div div2"><a href=""><img src="https://picsum.photos/240/320?random=3" alt=""></a></div>
        <div class="box-div div3"><a href=""><img src="https://picsum.photos/240/320?random=4" alt=""></a></div>
        <div class="box-div div4"><a href=""><img src="https://picsum.photos/240/320?random=5" alt=""></a></div>
        <div class="box-div div5"><a href=""><img src="https://picsum.photos/240/320?random=6" alt=""></a></div>
        <div class="box-div div6"><a href=""><img src="https://picsum.photos/240/320?random=7" alt=""></a></div>
        <div class="box-div div7"><a href=""><img src="https://picsum.photos/240/320?random=8" alt=""></a></div>
        <div class="box-div div8"><a href=""><img src="https://picsum.photos/240/320?random=9" alt=""></a></div>
        <div class="box-div div9"><a href=""><img src="https://picsum.photos/240/320?random=10" alt=""></a></div>
        <div class="box-div div10"><a href=""><img src="https://picsum.photos/240/320?random=11" alt=""></a></div>
        <div class="box-div div11"><a href=""><img src="https://picsum.photos/240/320?random=12" alt=""></a></div>
        <div class="box-div div12"><a href=""><img src="https://picsum.photos/240/320?random=13" alt=""></a></div>
        <div class="box-div div13"><a href=""><img src="https://picsum.photos/240/320?random=14" alt=""></a></div>
        <div class="box-div div14"><a href=""><img src="https://picsum.photos/240/320?random=15" alt=""></a></div>
        <div class="box-div div15"><a href=""><img src="https://picsum.photos/240/320?random=16" alt=""></a></div>
        <div class="box-div div16"><a href=""><img src="https://picsum.photos/240/320?random=17" alt=""></a></div>
        <div class="box-div div17"><a href=""><img src="https://picsum.photos/240/320?random=18" alt=""></a></div>
        <div class="box-div div18"><a href=""><img src="https://picsum.photos/240/320?random=19" alt=""></a></div>
      </div>
    </div>

    <div class="container" id="home__series">
      <h3 id="serie">A Découvrir</h3>
      <div class="box box-serie">
        <div class="box-div div19"><a href=""><img src="https://picsum.photos/240/320?random=20" alt=""></a></div>
        <div class="box-div div20"><a href=""><img src="https://picsum.photos/240/320?random=21" alt=""></a></div>
        <div class="box-div div21"><a href=""><img src="https://picsum.photos/240/320?random=22" alt=""></a></div>
        <div class="box-div div22"><a href=""><img src="https://picsum.photos/240/320?random=23" alt=""></a></div>
        <div class="box-div div23"><a href=""><img src="https://picsum.photos/240/320?random=24" alt=""></a></div>
        <div class="box-div div24"><a href=""><img src="https://picsum.photos/240/320?random=25" alt=""></a></div>
        <div class="box-div div25"><a href=""><img src="https://picsum.photos/240/320?random=26" alt=""></a></div>
        <div class="box-div div26"><a href=""><img src="https://picsum.photos/240/320?random=27" alt=""></a></div>
        <div class="box-div div27"><a href=""><img src="https://picsum.photos/240/320?random=28" alt=""></a></div>
        <div class="box-div div28"><a href=""><img src="https://picsum.photos/240/320?random=29" alt=""></a></div>
        <div class="box-div div29"><a href=""><img src="https://picsum.photos/240/320?random=40" alt=""></a></div>
        <div class="box-div div30"><a href=""><img src="https://picsum.photos/240/320?random=41" alt=""></a></div>
        <div class="box-div div31"><a href=""><img src="https://picsum.photos/240/320?random=42" alt=""></a></div>
        <div class="box-div div32"><a href=""><img src="https://picsum.photos/240/320?random=43" alt=""></a></div>
        <div class="box-div div33"><a href=""><img src="https://picsum.photos/240/320?random=44" alt=""></a></div>
        <div class="box-div div34"><a href=""><img src="https://picsum.photos/240/320?random=45" alt=""></a></div>
        <div class="box-div div35"><a href=""><img src="https://picsum.photos/240/320?random=46" alt=""></a></div>
        <div class="box-div div36"><a href=""><img src="https://picsum.photos/240/320?random=47" alt=""></a></div>
      </div>
    </div>

  </section>

  <?php

  require_once "includes/footer.php";

  ?>
  <script src="js/burger.js"></script>
</body>



</html>