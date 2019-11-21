<?php
// ------------------------------------------------------------------
// NAME: index.php
// DESCRIPTION: Used to check the username being entered with the database when registering
// -------------------------------------------------------------------

  include 'includes/library.php';
  $pdo =  & dbconnect();

  $username = $_GET['username'];

  $sql= "select 1 from marbles_Users where username = ?";
  $stmt=$pdo->prepare($sql);
  $stmt->execute([$username]);
  if($stmt->fetchColumn()){
    echo true;
  } else {
    echo false;
  }

?>
