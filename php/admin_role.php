<?php
session_start();
require_once "config.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modify"])) {
    if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        die("Token CSRF invalide.");
    }
    $user_ID = $_POST["user_ID"];
    $new_role = $_POST["new_role"];

    if (!in_array($new_role, [1, 2])) {
        die("Choix de role invalide.");
    }

    $update_sql = "UPDATE user SET user_role_ID = ? WHERE user_ID = ?";
    $update_stmt = mysqli_prepare($link, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "si", $new_role, $user_ID);
    mysqli_stmt_execute($update_stmt);
    mysqli_stmt_close($update_stmt);
}
