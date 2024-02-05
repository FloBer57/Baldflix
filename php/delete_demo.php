<?php
include 'config.php';

try {
    $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME;
    $dbh = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
    $sql = "DELETE FROM user WHERE user_role_ID = 3";
    $dbh->exec($sql);
    echo "Les utilisateurs ont été supprimés avec succès.";
} catch (PDOException $e) {
    echo "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
?>