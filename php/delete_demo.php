<?php
if (php_sapi_name() !== 'cli') {
    echo "Ce script ne peut être exécuté que depuis la ligne de commande (CLI).";
    exit;
}

if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1') {
    echo "L'accès à ce script n'est autorisé que depuis l'adresse IP locale.";
    exit;
}

require_once 'config.php';

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
