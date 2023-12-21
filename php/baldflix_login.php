<?php
// Initialize the session
session_start([
    'cookie_lifetime' => 86400, // Durée de vie du cookie en secondes (par exemple, 1 jour)
    'cookie_secure' => true,    // Transférer le cookie uniquement via HTTPS
    'cookie_httponly' => true,  // Empêcher l'accès au cookie via JavaScript
    'use_strict_mode' => true,  // Renforcer les contraintes de sécurité
]);

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: ../index.php");
  exit;
}


// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

function getProfileData($userId)
{
  global $link;

  $sql = "SELECT user_role_id, profile_picture FROM user WHERE user_id = ?";
  $stmt = mysqli_prepare($link, $sql);
  mysqli_stmt_bind_param($stmt, "i", $userId);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $user_role, $profile_picture);
  mysqli_stmt_fetch($stmt);

  return ['user_role_id' => $user_role, 'profile_picture' => $profile_picture];
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Check if username is empty
  if (empty(trim($_POST["username"]))) {
    $username_err = "Veuillez rentrer votre nom d'utilisateur";
  } else {
    $username = trim($_POST["username"]);
  }

  // Check if password is empty
  if (empty(trim($_POST["password"]))) {
    $password_err = "Veuillez rentrer votre mot de passe";
  } else {
    $password = trim($_POST["password"]);
  }

  // Validate credentials
  if (empty($username_err) && empty($password_err)) {
    // Prepare a select statement
    $sql = "SELECT user_id, username, password FROM user WHERE username = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_username);

      // Set parameters
      $param_username = $username;

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);

        // Check if username exists, if yes then verify password
        if (mysqli_stmt_num_rows($stmt) == 1) {
          // Bind result variables
          mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
          if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($password, $hashed_password)) {
              // Password is correct, so start a new session
              session_start();

              // Store data in session variables
              $_SESSION["loggedin"] = true;
              $_SESSION["user_id"] = $id;
              $_SESSION["username"] = $username;

              // Fetch and store the user's status and profile picture
              $profileData = getProfileData($id);
              $_SESSION["user_role_id"] = $profileData['user_role_id'];
              $_SESSION["profile_picture"] = $profileData['profile_picture'];

              // Redirect user to welcome page
              header("location: ../index.php");
            } else {
              // Password is not valid, display a generic error message
              $login_err = "Nom d'utilisateur ou mot de passe invalide.";
            }
          }
        } else {
          // Username doesn't exist, display a generic error message
          $login_err = "Nom d'utilisateur ou mot de passe invalide.";
        }
      } else {
        echo "Jeannne! Oh secour! Il y a eu un problème.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }
  }

  // Close connection
  mysqli_close($link);
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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