<?php
session_start();
 
if ($_SESSION["user_role_ID"] == 3) {
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
  }

$_SESSION = array();
session_destroy();
 
header("location: baldflix_login.php");
exit;
