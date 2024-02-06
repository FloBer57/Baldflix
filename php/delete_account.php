<?php
session_start();
require_once "config.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: baldflix_login.php");
    exit;
}
if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    die("Token CSRF invalide");
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_account"])) {

    $password_err = "";
    $password = trim($_POST["password_delete"]);

    if (empty($password)) {
        $password_err = "Veuillez entrer votre mot de passe.";
    }

    if (empty($password_err)) {
        $sql_verify = "SELECT password FROM user WHERE user_ID = ?";

        if ($stmt_verify = mysqli_prepare($link, $sql_verify)) {
            mysqli_stmt_bind_param($stmt_verify, "i", $param_id_verify);
            $param_id_verify = $_SESSION["user_ID"];
            if (mysqli_stmt_execute($stmt_verify)) {
                mysqli_stmt_store_result($stmt_verify);
                if (mysqli_stmt_num_rows($stmt_verify) == 1) {
                    mysqli_stmt_bind_result($stmt_verify, $hashed_password_verify);
                    if (mysqli_stmt_fetch($stmt_verify)) {
                        if (password_verify($password, $hashed_password_verify)) {
                            $delete_sql = "DELETE FROM user WHERE user_ID = ?";
                            if ($delete_stmt = mysqli_prepare($link, $delete_sql)) {
                                mysqli_stmt_bind_param($delete_stmt, "i", $param_id_delete);
                                $param_id_delete = $_SESSION["user_ID"];
                                if (mysqli_stmt_execute($delete_stmt)) {
                                    session_destroy();
                                    header("location: baldflix_login.php");
                                    exit();
                                } else {
                                    echo "Erreur lors de la suppression du compte.";
                                }
                                mysqli_stmt_close($delete_stmt);
                            }
                        } else {
                            $password_err = "Le mot de passe que vous avez entré n'est pas valide.";
                        }
                    }
                } else {
                    echo "Aucun compte trouvé.";
                }
            } else {
                echo "Une erreur s'est produite. Veuillez réessayer plus tard.";
            }
            mysqli_stmt_close($stmt_verify);
        }
    }
    if (!empty($password_err)) {
        echo "Erreur : " . $password_err;
    }
}
