<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: baldflix_login.php");
  exit;
}

require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["submitImage"])) {
    include_once "change_pdp.php";
  } elseif (isset($_POST["new_password"])) {
    include_once "change_password.php";
  } elseif (isset($_POST["delete_account"])) {
    include_once "delete_account.php";
  } elseif (isset($_POST["submit_suggestion"])) {
    include_once "suggestion.php";
  }
}

mysqli_close($link);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="robots" content="noindex, nofollow, noimageindex">
  <link rel="shortcut icon" href="../image/favicon/bald_favicon.ico" type="image/x-icon" />
  <title>Profil</title>
  <link href="../css/global.CSS" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Bungee+Inline&display=swap" rel="stylesheet">
</head>

</html>

<body class="background bodyburger">

  <?php

  require_once "../includes/header.php";

  ?>

  <main>
    <div class="account__container">
      <div class="sub__container">
        <nav class="account__nav">
          <ul>
            <li data-tab="profile-tab-content" onclick="showTab('profile-tab-content')">Mon profil</li>
            <li data-tab="password-tab-content" onclick="showTab('password-tab-content')">Mot de passe et
              Sécurité</li>
            <li data-tab="delete-tab-content" onclick="showTab('delete-tab-content')">Supprimer le compte
            </li>
            <li data-tab="suggest-tab-content" onclick="showTab('suggest-tab-content')">Une suggestion?
            </li>
          </ul>
        </nav>

        <div id="profile-tab-content" class="tab__content">
          <h2>Modifier la photo de profil</h2>
          <?php if (isset($_SESSION["profile_picture"])): ?>
            <p class="text_modify">Actuellement : </p>
            <img class="choose_picture" src="<?php echo $_SESSION["profile_picture"]; ?>" alt="Photo actuelle">
          <?php endif; ?>
          <button id="openIconModal">Choisir une icône</button>
        </div>

        <div id="iconModal" class="modal">
          <div class="modal-content">
            <span class="close"><img id="closeModal" src="../image/icon/close.svg" alt="Close"></span>
            <h2>Choisir une icône</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div id="iconContainer">
                <?php
                $imagesDirectory = '../image/users_icon/';
                $images = glob($imagesDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                foreach ($images as $image) {
                  $imageName = basename($image);
                  echo "
                        <label class=\"icon-label\">
                            <input type=\"radio\" class=\"modal_radio\" name=\"selectedIcon\" value=\"$imageName\">
                            <img class=\"icon-preview\" src=\"$image\" data-icon=\"$imageName\">
                        </label>
                    ";
                }
                ?>
              </div>
              <button class="button_modal" type="submit" name="submitImage">Confirmer la sélection</button>
            </form>
          </div>
        </div>

        <div id="password-tab-content" class="tab__content active-tab">
          <h2>Modifier le mot de passe</h2>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
              <label for="new_password" class="new_password">Nouveau mot de passe*</label>
              <input type="password" placeholder="Nouveau mot de passe" name="new_password" id="new_password" required
                class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $new_password; ?>">
              <span class="invalid-feedback">
                <?php echo $new_password_err; ?>
              </span>
              <br>
            </div>
            <div class="form-group">
              <label for="confirm_new_password">Confirmer le nouveau mot de passe :</label>
              <input type="password" placeholder="Confirmez le mot de passe" name="confirm_password"
                id="confirm_new_password" required
                class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $confirm_password; ?>">
              <span class="invalid-feedback">
                <?php echo $confirm_password_err; ?>
                <br>
              </span>
            </div>
            <div class="form-group">
              <input type="submit" value="Modifier le mot de passe">
            </div>
          </form>
        </div>
        <div id="delete-tab-content" class="tab__content active-tab">
          <h2>Supprimer le compte</h2>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
              <label for="password_delete">Entrez votre mot de passe pour confirmer :</label>
              <input type="password" placeholder="Mot de passe" name="password_delete" id="password_delete" required
                class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
              <span class="invalid-feedback">
                <?php echo $password_err; ?>
              </span>
              <br>
            </div>
            <div class="form-group">
              <input type="submit" name="delete_account" value="Supprimer le compte">
            </div>
          </form>
        </div>
        <div id="suggest-tab-content" class="tab__content active-tab">
          <h2>Une suggestion?</h2>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
              <label for="suggestion_firstname">Prénom :</label>
              <input type="text" placeholder="Prénom" name="suggestion_firstname" id="suggestion_firstname" required
                class="form-control">
              <br>
            </div>
            <div class="form-group">
              <label for="suggestion_lastname">Nom :</label>
              <input type="text" placeholder="Nom" name="suggestion_lastname" id="suggestion_lastname" required
                class="form-control">
              <br>
            </div>
            <div class="form-group">
              <label for="suggestion_message">Message :</label>
              <textarea placeholder="Votre suggestion" name="suggestion_message" id="suggestion_message" required
                class="form-control"></textarea>
              <br>
            </div>
            <div class="form-group">
              <input type="submit" name="submit_suggestion" value="Envoyer la suggestion">
            </div>
          </form>
        </div>
      </div>
      <script src="../js/burger.js"></script>
      <script src="../js/onglet.js"></script>
      <script src="../js/confirmDelete.js"></script>
      <script src="../js/modaleIcon.js"></script>
    </div>
  </main>
</body>