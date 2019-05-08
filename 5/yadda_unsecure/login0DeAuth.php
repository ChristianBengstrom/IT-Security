<?php
session_start();
// Unset all session values / a bit much in an unnamed session
$_SESSION = array();
// Destroy session cookie on server
session_destroy();
header('Location: ./login0.php');
