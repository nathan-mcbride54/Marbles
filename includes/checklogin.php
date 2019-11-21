<?php
// ------------------------------------------------------------------
// NAME: checklogin.php
// DESCRIPTION: Included to check if user is logged in on a page.
// -------------------------------------------------------------------
if(!isset($_SESSION['user'])){
  header("Location:splashscreen.php");
  exit();
}
?>
