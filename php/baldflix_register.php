<?php
session_start();
require_once "config.php";
require_once "register.php";
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
    <title>Baldflix - Création de compte</title>
    <link href="/css/login.CSS" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Bungee+Inline&display=swap" rel="stylesheet">
</head>

<body class="background bodyburger">
    <div class="main_container">
        <div class="container">
            <div class="container_form">
                <?php
                if (!empty($login_err)) {
                    echo '<div class="alert alert_danger">' . $login_err . '</div>';
                }
                ?>
                <form action="#" method="post">
                    <label for="username" class="username">Nom d'utilisateur*</label>
                    <input type="text" placeholder="Nom d'utilisateur" id="username" name="username" required class="form_control <?php echo (!empty($username_err)) ? 'is_invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid_feedback">
                        <?php echo $username_err; ?>
                    </span>

                    <label for="password">Mot de passe* :</label>
                    <input type="password" placeholder="Mot de passe" id="password" name="password" required class="form_control <?php echo (!empty($password_err)) ? 'is_invalid' : ''; ?>" value="<?php echo $password; ?>">
                    <span class="invalid_feedback">
                        <?php echo $password_err; ?>
                    </span>
                    <label for="confirm_password">Confirmez le mot de passe* :</label>
                    <input type="password" placeholder="Confirmez le mot de passe" id="confirmPassword" name="confirm_password" required class="form_control <?php echo (!empty($confirm_password_err)) ? 'is_invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                    <span class="invalid_feedback">
                        <?php echo $confirm_password_err; ?>
                    </span>
                    <label for="email">Email :</label>
                    <input type="email" placeholder="Vous n'êtes pas obligé." id="email" name="email" class="form_control" value="<?php echo $email; ?>">
                    <span class="invalid_feedback">
                    </span>
                    <input class="input" type="submit" value="Inscription">

                </form>
            </div>

            <div class="container_title">
                <div class="title">
                    <h1>Baldflix</h1>
                </div>
                <p class="message_demo">Bienvenue! Vous pouvez créer un compte de démo ICI !</p>

            </div>
        </div>
    </div>
    <script src="../js/burger.js"></script>
</body>

</html>