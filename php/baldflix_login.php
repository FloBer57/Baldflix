<?php
session_start();
require_once "config.php";
require_once "login.php";
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: ../index.php");
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
  <title>Baldflix_login</title>
  <link href="../css/login.CSS" rel="stylesheet" />

</head>

<body class="background">
  <div class="main_container">
    <div class="container">
      <div class="container_form">
        <?php
        if (isset($_SESSION["login_err"])) {
          echo '<div class="alert alert_danger">' . $_SESSION["login_err"] . '</div>';
          unset($_SESSION["login_err"]);
        }
        ?>
        <form action="#" method="post">
          <label for="username" class="username">Nom d'utilisateur*</label>
          <input type="text" placeholder="Nom d'utilisateur" id="username" name="username" required class="form_control <?php echo (!empty($username_err)) ? 'is_invalid' : ''; ?>" value="<?php echo $username; ?>">
          <span class="invalid_feedback">
            <?php echo $username_err; ?>
          </span>

          <label for="password">Mot de passe* :</label>
          <input type="password" placeholder="Mot de passe" id="password" name="password" required class="form_control <?php echo (!empty($password_err)) ? 'is_invalid' : ''; ?>">
          <span class="invalid_feedback">
            <?php echo $password_err; ?>
          </span>

          <input class="input" id="inepute" type="submit" value="Connexion">
          <p>Vous n'avez pas de compte?</p>
          <a href="baldflix_register.php">Créer un compte</a>
        </form>
      </div>

      <div class="container_title">
        <div class="title">
          <h1>Baldflix</h1>
        </div>
        <p class="message_demo">Bienvenue sur Baldflix! Identifie toi pour accéder à de superbes contenus !</p>

      </div>
    </div>
  </div>
</body>

</html>