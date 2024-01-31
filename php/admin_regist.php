<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: baldflix_login.php");
    exit;
}

require_once "config.php";

if ($_SESSION["user_role_ID"] != 2) {
    header("location: profile.php");
    exit;
}

$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Rentrez un nom d'utilisateur";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Le nom d'utilisateur ne peux contenir que des lettres, chiffre et l'underscore.";
    } else {
        $sql = "SELECT user_ID FROM user WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "Le nom d'utilisateur est déjà pris.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Il y a eu un problème lors de la validation du nom d'utilisateur.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Rentrez un mot de passe.";
    } elseif (strlen(trim($_POST["password"])) < 10) {
        $password_err = "Le mot de passe doit être d'au moins 10 caractères.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Confirmez le mot de passe";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Les mots de passe ne sont pas identiques.";
        }
    }

    $role = "";
    $role_err = "";

    if (empty(trim($_POST["user_role_ID"]))) {
        $role_err = "Veuillez choisir un role.";
    } else {
        $role = trim($_POST["user_role_ID"]);
    }

    $email = "";
    $param_email = $email;
    if (empty(trim($_POST["email"]))) {
        $email_err = "Veuillez entrer votre adresse email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Veuillez entrer une adresse email valide.";
    } else {
        $email = trim($_POST["email"]);
        $email = htmlspecialchars($email);
    }

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($role_err)) {

        $sql = "INSERT INTO user (username, password, user_role_ID, email) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $param_role, $param_email);

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_role = $role;
            $param_email = $email; 

            if (mysqli_stmt_execute($stmt)) {
                header("location: baldflix_login.php");
                exit(); 
            } else {
                echo "Il y a eu un problème lors de l'inscription : " . mysqli_error($link);
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="robots" content="noindex, nofollow, noimageindex">
    <title>Baldflix_register</title>
    <link href="/css/login.CSS" rel="stylesheet" />
    <link rel="shortcut icon" href="../image/favicon/bald_favicon.ico" type="image/x-icon" />
</head>

<body class="background bodyburger">
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
                    <input type="text" placeholder="Nom d'utilisateur" id="username" name="username" required class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback">
                        <?php echo $username_err; ?>
                    </span>
                    <br><br>

                    <label for="password">Mot de passe* :</label>
                    <input type="password" placeholder="Mot de passe" id="password" name="password" required class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                    <span class="invalid-feedback">
                        <?php echo $password_err; ?>
                    </span>
                    <br><br>
                    <label for="confirm_password">Confirmez le mot de passe* :</label>
                    <input type="password" placeholder="Confirmez le mot de passe" id="confirm_password" name="confirm_password" required class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                    <span class="invalid-feedback">
                        <?php echo $confirm_password_err; ?>
                    </span>
                    <br><br>
                    <label for="email">Email* :</label>
                    <input type="email" placeholder="Votre adresse email" id="email" name="email" required class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                    <span class="invalid-feedback">
                        <?php echo $email_err; ?>
                    </span>
                    <br><br>
                    <label for="user_role_ID">Role :</label>
                    <select name="user_role_ID" required class="form-control">
                        <option value="1">Utilisateur</option>
                        <option value="2">Administrateur</option>
                    </select>

                    <input class="input" type="submit" value="Connexion">
                </form>
            </div>

            <div class="container__title">
                <div class="title">
                    <h1>Baldflix</h1>
                </div>
                <p class="wai">Création de compte par BERNAR FLORENT</p>

            </div>
        </div>
    </div>
    <script src="../js/burger.js"></script>
</body>

</html>