<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="robots" content="noindex, nofollow, noimageindex">
  <title>404 Error</title>
  <link href="css/global.CSS" rel="stylesheet" />
  <link rel="shortcut icon" href="image/favicon.ico" type="image/x-icon" />
</head>

<body class="error_page">
  <?php

  require_once "includes/header.php";

  ?>
  <section class="trailer">
    <div class="present_vid" id="video">
      <video class="preview" autoplay muted loop id="videoBackground">
        <source src="video/error/404 error même.mp4" type="video/mp4">
        Votre navigateur ne prend pas en charge la vidéo.
      </video>
      <h2 class="error text_video">Erreur 404</h3>
        <h2 class="error_acceuil text_video">Acceuil</h3>
    </div>
  </section>
  <?php

  require_once "includes/footer.php";

  ?>
</body>

</html>