<?php
session_start();

require "config.php";

$_SESSION = array();
session_destroy();

header("location: baldflix_login.php");
exit;
