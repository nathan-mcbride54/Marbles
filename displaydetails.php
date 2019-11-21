<?php
// ------------------------------------------------------------------
// NAME: displaydetails.php
// DESCRIPTION: Used to display the details of a movie given a movie ID
// -------------------------------------------------------------------
session_start();
include 'includes/checklogin.php';


include "includes/library.php";
$pdo = & dbconnect();

$movieid = $_GET['movieid']; //GET STATMENT HERE

$sql="SELECT title, year, actors, studio, plotsummary, genre, starrating, mpaarating, runtime, theatrerelease, dvdrelease, videotype, filetarget FROM marbles_Movies WHERE movieid=? AND owner=?";
$stmt=$pdo->prepare($sql);
$stmt->execute([$movieid, $_SESSION['userid']]);
$row = $stmt->fetch();

if(!$row){
  exit("Unable to display movie");
}
$title = $row['title'];
$year = $row['year'];
$actors = $row['actors'];
$studio = $row['studio'];
$plotsummary = $row['plotsummary'];
$genre = $row['genre'];
$starrating = $row['starrating'];
$mpaarating = $row['mpaarating'];
$runtime = $row['runtime'];
$theatrerelease = $row['theatrerelease'];
$dvdrelease = $row['dvdrelease'];
$videotype = $row['videotype'];
$filetarget = $row['filetarget'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
    $PAGE_TITLE = "MOVIE DETAILS";
    include 'includes/head_includes.php';?>
</head>

<body>
  <div id="container">
    <?php include 'includes/header.php';?>
  <main>
      <div id="details">
        <div id="information">
          <div class="title"> <?php echo $title ?> </div>
          <ul>
            <li><span class="info">Year:</span><span> <?php echo $year ?> </span></li>
            <li><span class="info">Actors:</span><span> <?php echo $actors ?> </span></li>
            <li><span class="info">Studio:</span><span> <?php echo $studio ?> </span></li>
            <li><span class="info">Runtime:</span><span> <?php echo $runtime ?> </span></li>
            <li><span class="info">Theatre Release:</span><span> <?php echo $theatrerelease ?> </span></li>
            <li><span class="info">DVD Release:</span><span> <?php echo $dvdrelease ?> </span></li>
            <li><span class="info">MPAA Rating:</span><span> <?php echo $mpaarating ?> </span></li>
            <li><span class="info">Your Rating:</span><span> <?php echo $starrating ?> </span></li>
            <li><span class="info">Plot:</span></li>
            <span> <?php echo $plotsummary ?> </span>
          </ul>
        </div>
        <div>
          <div class="cover">
            <?php //if no cover has been uploaded, use the default.
              $sql = "SELECT filetarget FROM marbles_Movies WHERE movieid = ?";
              $stmt = $pdo->prepare($sql);
              $stmt->execute([$movieid]);
              $movie = $stmt->fetch();

              if (isset($movie['filetarget']) && $movie['filetarget'] != ""){
                if(substr($movie['filetarget'], 0, 4) == 'http') {
                  echo "<img src=\"" . $movie['filetarget'] . "\" />";
                }
                else {
                  echo "<img src=\"/~nathanmcbride/" . $movie['filetarget'] . "\" />";
                }
              } else {
                echo "<img src = \"img/nick_1.png\" />";
              } ?>
          </div>
        </div>
      </div>
  </main>
  <footer>
    <?php include 'includes/footer.php' ?>
  </footer>
</body>

</html>
