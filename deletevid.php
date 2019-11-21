<?php
// ------------------------------------------------------------------
// NAME: deletevid.php
// DESCRIPTION: Used to delete a video from the users library
// -------------------------------------------------------------------
session_start();

include "includes/library.php";
$pdo = & dbconnect();

//Get movieid from GET array
$movieid = $_POST['movieid']; //GET STATMENT HERE
//Get owner of movie to be deleted
$sql="SELECT owner FROM marbles_Movies WHERE movieid=?";
$stmt=$pdo->prepare($sql);
$stmt->execute([$movieid]);
$result = $stmt->fetch();

//Check that user owns the movie to be deleted
if ($result['owner'] != $_SESSION['userid']){
  header("Location:index.php");
  exit();
} else {
  //Delete movie from db and refresh page
    $sql="DELETE FROM marbles_Movies WHERE movieid=? AND owner=?";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$movieid, $_SESSION['userid']]);
    header("Location:index.php");
    exit();
  }
?>
