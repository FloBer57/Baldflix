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

$_SESSION["csrf_token"] = bin2hex(random_bytes(32));

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
    <div class="account_container">
      <div class="sub_container">
        <nav class="account_nav">
          <ul>
            <li data-tab="profileTabContent" class="menu_dropdown" onclick="showTab('profileTabContent')">Mon profil</li>
            <li data-tab="passwordTabContent" class="menu_dropdown" onclick="showTab('passwordTabContent')">Mot de passe et
              Sécurité</li>
            <li data-tab="deleteTabContent" class="menu_dropdown" onclick="showTab('deleteTabContent')">Supprimer le compte
            </li>
            <li data-tab="suggestTabContent" class="menu_dropdown" onclick="showTab('suggestTabContent')">Une suggestion?
            </li>
          </ul>
        </nav>

        <div id="profileTabContent" class="tab_content">
          <h2>Modifier la photo de profil</h2>
          <?php if (isset($_SESSION["profile_picture"])) : ?>
            <p class="text_modify">Actuellement : </p>
            <img class="choose_picture" src="<?php echo $_SESSION["profile_picture"]; ?>" alt="Photo actuelle">
          <?php endif; ?>
          <button class="btn_open_icon_modal" id="openIconModal">Choisir une icône</button>
        </div>

        <div id="iconModal" class="modal" style="display:none">
          <div class="modal_content">
            <span class="close"><img id="closeModal" src="../image/icon/close.svg" alt="Close"></span>
            <h2>Choisir une icône</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div class="icon_container" id="iconContainer">
                <?php
                $imagesDirectory = '../image/users_icon/';
                $images = glob($imagesDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                foreach ($images as $image) {
                  $imageName = basename($image);
                  echo "
                        <label class=\"icon_label\">
                            <input type=\"radio\" class=\"modal_radio\" name=\"selectedIcon\" value=\"$imageName\">
                            <img class=\"icon_preview\" src=\"$image\" data-icon=\"$imageName\">
                        </label>
                    ";
                }
                ?>
              </div>
              <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
              <button class="button_modal" type="submit" name="submitImage">Confirmer la sélection</button>
            </form>
          </div>
        </div>

        <div id="passwordTabContent" class="tab_content active_tab">
          <h2>Modifier le mot de passe</h2>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form_group">
              <label for="new_password" class="new_password">Nouveau mot de passe*</label>
              <input type="password" placeholder="Nouveau mot de passe" name="new_password" id="newPassword" required class="form_control <?php echo (!empty($new_password_err)) ? 'is_invalid' : ''; ?>" value="<?php echo $new_password; ?>">
              <span class="invalid_feedback">
                <?php echo $new_password_err; ?>
              </span>
              <br>
            </div>
            <div class="form_group">
              <label for="confirm_new_password">Confirmer le nouveau mot de passe :</label>
              <input type="password" placeholder="Confirmez le mot de passe" name="confirm_password" id="confirmNewPassword" required class="form_control <?php echo (!empty($confirm_password_err)) ? 'is_invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
              <span class="invalid_feedback">
                <?php echo $confirm_password_err; ?>
                <br>
              </span>
            </div>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="form_group">
              <input type="submit" value="Modifier le mot de passe">
            </div>
          </form>
        </div>
        <div id="deleteTabContent" class="tab_content active_tab">
          <h2>Supprimer le compte</h2>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form_group">
              <label for="password_delete">Entrez votre mot de passe pour confirmer :</label>
              <input type="password" placeholder="Mot de passe" name="password_delete" id="password_delete" required class="form_control <?php echo (!empty($password_err)) ? 'is_invalid' : ''; ?>">
              <span class="invalid_feedback">
                <?php echo $password_err; ?>
              </span>
              <br>
            </div>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="form_group">
              <input type="submit" name="delete_account" value="Supprimer le compte">
            </div>
          </form>
        </div>
        <div id="suggestTabContent" class="tab_content active_tab">
          <h2>Une suggestion?</h2>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form_group">
              <label for="suggestion_firstname">Prénom :</label>
              <input type="text" placeholder="Prénom" name="suggestion_firstname" id="suggestionFirstname" required class="form_control">
              <br>
            </div>
            <div class="form_group">
              <label for="suggestion_lastname">Nom :</label>
              <input type="text" placeholder="Nom" name="suggestion_lastname" id="suggestionLastname" required class="form_control">
              <br>
            </div>
            <div class="form_group">
              <label for="suggestion_email">Mail :</label>
              <input placeholder="Votre email" class="suggestion_mail" name="suggestion_mail" id="suggestionMail" required class="form_control"></input>
              <br>
            </div>
            <div class="form_group">
              <label for="suggestion_message">Message :</label>
              <textarea placeholder="Votre suggestion" class="suggestion_message" name="suggestion_message" id="suggestionMessage" required class="form_control"></textarea>
              <br>
            </div>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="form_group">
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