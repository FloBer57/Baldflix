<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="robots" content="noindex, nofollow, noimageindex">
  <link rel="shortcut icon" href="image/favicon/bald_favicon.ico" type="image/x-icon" />
  <title>BaldFlix Anime</title>
  <link href="../css/global.CSS" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Bungee+Inline&display=swap" rel="stylesheet">
</head>

<body>
  <?php

  require_once "../includes/header.php";

  ?>

  <section class="main-container">
    <div class="container" id="home">
      <h3 id="watched">Vue précédemment</h3>
      <div class="box box-watched">

        <?php

        $filmDirectory = '../video/film/';
        $files = scandir($filmDirectory);

        foreach ($files as $file) {
          if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'png'])) {
            echo '<div class="box-div"><a href=""><img src="' . htmlspecialchars($filmDirectory . '/' . $file) . '" alt="' . htmlspecialchars($file) . '"></div>';
          }
        }
        ?>

      </div>
    </div>

    <div class="container" id="anime__container">
      <h3 id="anime">Anime</h3>
      <div class="box box__anime">
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
        <a href=""><img src="https://picsum.photos/600/400?random=2" alt=""></a>
      </div>
    </div>
  </section>
  <!-- ##FOOTER## -->
  <?php

  require_once "../includes/footer.php";

  ?>
</body>

</html>