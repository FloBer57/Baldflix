<?php
// Initialize the session
session_start();
require_once "config.php";

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
  <div class="main__container">
    <div class="container">
      <div class="container__form">
        <?php
        if (!empty($login_err)) {
          echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["login.php"]); ?>" method="post">
          <label for="username" class="username">Nom d'utilisateur*</label>
          <input type="text" placeholder="Nom d'utilisateur" id="username" name="username" required
            class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
            value="<?php echo $username; ?>">
          <span class="invalid-feedback">
            <?php echo $username_err; ?>
          </span>
          <br><br>

          <label for="password">Mot de passe* :</label>
          <input type="password" placeholder="Mot de passe" id="password" name="password" required
            class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
          <span class="invalid-feedback">
            <?php echo $password_err; ?>
          </span>
          <br><br>

          <input class="input" id="inepute" type="submit" value="Connexion">
          <p>Vous n'avez pas de compte? Cheh</p>
        </form>
      </div>

      <div class="container__title">
        <div class="title">
          <h1>Baldflix</h1>
        </div>
        <p class="wai">Bienvenue sur Baldflix! Identifie toi pour accéder à de superbes contenus !</p>

      </div>
    </div>
  </div>
</body>

</html>