<?php
session_start();
require_once "config.php"; // Remplacez par le chemin correct vers votre script de configuration

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_account"])) {
    // Initialisation des variables
    $password_err = "";

    // Récupérer et valider le mot de passe saisi
    $password = trim($_POST["password_delete"]);
    if (empty($password)) {
        $password_err = "Veuillez entrer votre mot de passe.";
    }

    // Continuer seulement s'il n'y a pas d'erreur
    if (empty($password_err)) {
        // Préparer une requête pour vérifier le mot de passe de l'utilisateur
        $sql_verify = "SELECT password FROM user WHERE user_id = ?";

        if ($stmt_verify = mysqli_prepare($link, $sql_verify)) {
            mysqli_stmt_bind_param($stmt_verify, "i", $param_id_verify);

            // Définir le paramètre
            $param_id_verify = $_SESSION["user_id"];

            // Exécuter la requête
            if (mysqli_stmt_execute($stmt_verify)) {
                mysqli_stmt_store_result($stmt_verify);

                // Vérifier si l'utilisateur existe
                if (mysqli_stmt_num_rows($stmt_verify) == 1) {
                    mysqli_stmt_bind_result($stmt_verify, $hashed_password_verify);
                    if (mysqli_stmt_fetch($stmt_verify)) {
                        if (password_verify($password, $hashed_password_verify)) {
                            // Le mot de passe est correct, supprimer le compte
                            $delete_sql = "DELETE FROM user WHERE user_id = ?";

                            if ($delete_stmt = mysqli_prepare($link, $delete_sql)) {
                                mysqli_stmt_bind_param($delete_stmt, "i", $param_id_delete);

                                // Définir le paramètre
                                $param_id_delete = $_SESSION["user_id"];

                                // Exécuter la requête
                                if (mysqli_stmt_execute($delete_stmt)) {
                                    // Compte supprimé avec succès
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

    // Gérer les erreurs
    if (!empty($password_err)) {
        echo "Erreur : " . $password_err;
    }
}
?>
