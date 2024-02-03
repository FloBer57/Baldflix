<?php
session_start();
 
$_SESSION = array();
session_destroy();
 
header("location: baldflix_login.php");
exit;
