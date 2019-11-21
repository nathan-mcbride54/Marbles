<?php
// ------------------------------------------------------------------
// NAME: logout.php
// DESCRIPTION: Logs user out.
// -------------------------------------------------------------------
session_start();
$_SESSION = array();
session_destroy();
setcookie("rememberme","",1);
header("Location:splashscreen.php");
?>
