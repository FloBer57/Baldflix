<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: baldflix_login.php");
    exit;
  }
  
if ($_SESSION["user_role_ID"] != 2) {
    header("location: profile.php");
    exit;
  }
require_once "config.php"; 

if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["user_ID"])) {
    if (!isset($_GET["csrf_token"]) || $_GET["csrf_token"] !== $_SESSION["csrf_token"]) {
        die("Token CSRF invalide.");
    }

    $user_ID_to_delete = $_GET["user_ID"];
    $delete_sql = "DELETE FROM user WHERE user_ID = ?";
    $delete_stmt = mysqli_prepare($link, $delete_sql);
    mysqli_stmt_bind_param($delete_stmt, "i", $user_ID_to_delete);
    mysqli_stmt_execute($delete_stmt);
    mysqli_stmt_close($delete_stmt);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
