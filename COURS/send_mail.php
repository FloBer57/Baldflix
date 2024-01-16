<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "il manque les données";
    die;
}

// Manque le sujet?

// Manque l'email??

$error = false;
$errorMessages = [];


if(isset($_POST['subject']) && !empty($_POST['subject'])) {

$error = true;    
}else{
    $subject = htmlentities($_POST['subject']);
}

if(isset($_POST['message']) && !empty($_POST['message'])) {

}else {
    $message = $_POST['$message'];
}