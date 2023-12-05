<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: baldflix_login.php");
  exit;
}

echo "Statut actuel : " . $_SESSION["statut"];

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted


// Validate new password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_password"])) {
  if (empty(trim($_POST["new_password"]))) {
    $new_password_err = "Please enter the new password.";
  } elseif (strlen(trim($_POST["new_password"])) < 6) {
    $new_password_err = "Password must have at least 6 characters.";
  } else {
    $new_password = trim($_POST["new_password"]);
  }

  // Validate confirm password
  if (isset($_POST["confirm_password"])) {
    if (empty(trim($_POST["confirm_password"]))) {
      $confirm_password_err = "Please confirm the password.";
    } else {
      $confirm_password = htmlspecialchars(trim($_POST["confirm_password"]));
      if (empty($new_password_err) && ($new_password != $confirm_password)) {
        $confirm_password_err = "Password did not match.";
      }
    }
  }

  // Check input errors before updating the database
  if (empty($new_password_err) && empty($confirm_password_err)) {
    // Prepare an update statement
    $sql = "UPDATE users SET password = ? WHERE id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

      // Set parameters
      $param_password = password_hash($new_password, PASSWORD_DEFAULT);
      $param_id = $_SESSION["id"];

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Password updated successfully. Destroy the session, and redirect to login page
        session_destroy();
        session_regenerate_id();
        header("location: baldflix_login.php");
        exit();
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }
  } else {
    echo "Erreur de validation du mot de passe : " . $new_password_err . " " . $confirm_password_err;
  }
}

// Separate block for account deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_account"])) {
  // Validate password for account deletion
  $password = trim($_POST["password_delete"]); // Assuming you define $password somewhere

  // Prepare a select statement to verify the password
  $sql_verify = "SELECT id, username, password FROM users WHERE id = ?";

  if ($stmt_verify = mysqli_prepare($link, $sql_verify)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt_verify, "i", $param_id_verify);

    // Set parameters
    $param_id_verify = $_SESSION["id"];

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt_verify)) {
      // Store result
      mysqli_stmt_store_result($stmt_verify);

      // Check if the username exists and verify the password
      if (mysqli_stmt_num_rows($stmt_verify) == 1) {
        // Bind result variables
        mysqli_stmt_bind_result($stmt_verify, $id_verify, $username_verify, $hashed_password_verify);
        if (mysqli_stmt_fetch($stmt_verify)) {
          if (password_verify($password, $hashed_password_verify)) {
            // Password is correct, delete the account
            $delete_sql = "DELETE FROM users WHERE id = ?";
            if ($delete_stmt = mysqli_prepare($link, $delete_sql)) {
              // Bind variable to the prepared statement as a parameter
              mysqli_stmt_bind_param($delete_stmt, "i", $id_delete);

              // Set parameters
              $id_delete = $_SESSION["id"];

              // Attempt to execute the prepared statement
              if (mysqli_stmt_execute($delete_stmt)) {
                // Redirect to the login page or home page after successful deletion
                session_destroy();
                session_regenerate_id();
                header("location: baldflix_login.php");
                exit();
              } else {
                echo "Erreur MySQL lors de la suppression du compte : " . mysqli_error($link);
              }

              // Close statement
              mysqli_stmt_close($delete_stmt);
            }
          } else {
            // Display an error message if the password is not valid
            $password_err = "The password you entered was not valid.";
          }
        }
      } else {
        // Display an error message if the username doesn't exist
        $username_err = "No account found with that username.";
      }
    } else {
      echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt_verify);
  }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_suggestion"])) {
  $suggestion_firstname = htmlspecialchars(trim($_POST["suggestion_firstname"]));
  $suggestion_lastname = htmlspecialchars(trim($_POST["suggestion_lastname"]));
  $suggestion_message = htmlspecialchars(trim($_POST["suggestion_message"]));

  // Construisez le corps de l'email
  $email_body = "Nom: $suggestion_lastname\n";
  $email_body .= "Prenom: $suggestion_firstname\n";
  $email_body .= "Message:\n$suggestion_message";

  // Envoie de l'email
  $to = "contact@florentbernar.fr";
  $subject = "Nouvelle suggestion de $suggestion_firstname $suggestion_lastname";
  $headers = "From: $suggestion_firstname $suggestion_lastname <noreply@baldflix.florentbernar.fr>";

  // Utilisez la fonction mail() pour envoyer l'email
  if (mail($to, $subject, $email_body, $headers)) {
    echo "Votre suggestion a été envoyée avec succès!";
  } else {
    echo "Erreur lors de l'envoi de la suggestion. Veuillez réessayer plus tard.";
  }
}

// Close connection
mysqli_close($link);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mon compte</title>
  <link href="css/global.CSS" rel="stylesheet" />
</head>

</html>

<body class="background">

  <?php

  require_once "includes/header.php";

  ?>

  <main>
    <div class="account__container">
      <div class="sub__container">
        <nav class="account__nav">
          <ul>
            <li class="test" data-tab="profile-tab-content" onclick="showTab('profile-tab-content')">Mon profil</li>
            <li class="test" data-tab="password-tab-content" onclick="showTab('password-tab-content')">Mot de passe et
              Sécurité</li>
            <li class="test" data-tab="delete-tab-content" onclick="showTab('delete-tab-content')">Supprimer le compte
            </li>
            <li class="test" data-tab="suggest-tab-content" onclick="showTab('suggest-tab-content')">Une suggestion?
            </li>
          </ul>
        </nav>

        <div id="profile-tab-content" class="tab__content">
          <h2>Modifier la photo de profil</h2>
          <form action="users_image.php" method="post">
            <label for="profilImage">Choisir une photo de profil :</label>
            <select name="profilImage" id="profilImage">
              <?php
              $imagesDirectory = 'profil_images/';
              $images = glob($imagesDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

              foreach ($images as $image) {
                $imageName = basename($image);
                echo "<option value=\"$imageName\">$imageName</option>";
              }
              ?>
            </select>
            <br>
            <input type="submit" value="Modifier ma photo de profil">
          </form>
          <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST") {

          }
          ?>
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
              <br><br>
            </div>
            <div class="form-group">
              <label for="confirm_new_password">Confirmer le nouveau mot de passe :</label>
              <input type="password" placeholder="Confirmez le mot de passe" name="confirm_password"
                id="confirm_new_password" required
                class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $confirm_password; ?>">
              <span class="invalid-feedback">
                <?php echo $confirm_password_err; ?>
                <br><br>
              </span>
            </div>
            <div class="form-group">
              <input type="submit" value="Modifier le mot de passe">
            </div>
          </form>
          <!-- You can include additional HTML content if needed -->
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
              <br><br>
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
              <br><br>
            </div>
            <div class="form-group">
              <label for="suggestion_lastname">Nom :</label>
              <input type="text" placeholder="Nom" name="suggestion_lastname" id="suggestion_lastname" required
                class="form-control">
              <br><br>
            </div>
            <div class="form-group">
              <label for="suggestion_message">Message :</label>
              <textarea placeholder="Votre suggestion" name="suggestion_message" id="suggestion_message" required
                class="form-control"></textarea>
              <br><br>
            </div>
            <div class="form-group">
              <input type="submit" name="submit_suggestion" value="Envoyer la suggestion">
            </div>
          </form>
        </div>
      </div>
      <script src="js/account.js"></script>
    </div>
    </div>
  </main>
</body>