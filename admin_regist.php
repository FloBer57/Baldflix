<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Rentrez un nom d'utilisateur";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Le nom d'utilisateur ne peux contenir que des lettres, chiffre et l'underscore.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "Le nom d'utilisateur est déjà pris.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "JEAAAANNEE, AU SECOURS!! Il y à eu un problème!";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Rentrez un mot de passe.";
    } elseif (strlen(trim($_POST["password"])) < 10) {
        $password_err = "Le mot de passe doit être de minimum 10 caractères.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Confirmez le mot de passe";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Les mots de passe ne sont pas identiques.";
        }
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: baldflix_login.php");
            } else {
                echo "JEAAAANNEE, AU SECOURS!! Il y à eu un problème!";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robot" content="noindex">
    <meta name="robot" content="nofollow">
    <meta name="robot" content="noimageindex">
    <title>Baldflix_register</title>
    <link href="/css/login.CSS" rel="stylesheet" />
    <link rel="shortcut icon" href="/baldflix/image/5151698.ico" type="image/x-icon" />
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
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
                        class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $password; ?>">
                    <span class="invalid-feedback">
                        <?php echo $password_err; ?>
                    </span>
                    <br><br>
                    <label for="password">Mot de passe* :</label>
                    <input type="password" placeholder="Mot de passe" id="password" name="confirm_password" required
                        class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $confirm_password; ?>">
                    <span class="invalid-feedback">
                        <?php echo $confirm_password_err; ?>
                    </span>
                    <br><br>
                    <input class="input" type="submit" value="Connexion">
                </form>
            </div>

            <div class="container_title">
                <div class="title">
                    <h1>Baldflix</h1>
                </div>
                <p class="wai">Création de compte par BERNAR FLORENT</p>

            </div>
        </div>
    </div>
</body>

</html>