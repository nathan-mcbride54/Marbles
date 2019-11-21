<?php
// ------------------------------------------------------------------
// NAME: processaddvid.php
// DESCRIPTION: Processing page used for adding a video to the users library.
// -------------------------------------------------------------------
session_start();
include 'includes/library.php';

if (isset($_POST['submit'])){
  $formtitle = $_POST['title'] == "" ? null : filter_var($_POST['title'], FILTER_SANITIZE_STRING);
  $formyear = $_POST['year'] == "" ? 1 : filter_var($_POST['year'], FILTER_SANITIZE_NUMBER_INT);
  $formactors = $_POST['actors'] == "" ? null : filter_var($_POST['actors'], FILTER_SANITIZE_STRING);
  $formstudio = $_POST['studio'] == "" ? null : filter_var($_POST['studio'], FILTER_SANITIZE_STRING);
  $formplot = $_POST['plot'] == "" ? null : filter_var($_POST['plot'], FILTER_SANITIZE_STRING);
  $formgenre = filter_var($_POST['genre'], FILTER_SANITIZE_STRING);
  $formstarrating = $_COOKIE['userRating'] ?? 0;
  $formmpaarating = $_POST['mpaa-rating'] ?? null;
  $formruntime = $_POST['runtime'] == "" ? null : filter_var($_POST['runtime'], FILTER_SANITIZE_NUMBER_INT);
  $formtheatrerelease = $_POST['theatre-release'] == "" ? null : filter_var($_POST['theatre-release'], FILTER_SANITIZE_STRING);
  $formdvdrelease = $_POST['dvd-release'] == "" ? null : filter_var($_POST['dvd-release'], FILTER_SANITIZE_STRING);
  $formvideotype = ($_POST['video-type[]']) ?? null;
  $formcoverlink = $_POST['externalCover'];

  $pdo = & dbconnect();
  $sql= "insert into marbles_Movies (title, year, actors, studio, plotsummary, genre, starrating, mpaarating, runtime, theatrerelease, dvdrelease, videotype, owner) values (?,?,?,?,?,?,?,?,?,?,?,?,?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$formtitle,$formyear,$formactors,$formstudio,$formplot,$formgenre,$formstarrating,$formmpaarating,$formruntime,$formtheatrerelease,$formdvdrelease,$formvideotype, $_SESSION['userid']]);
  $movieid = $pdo->lastInsertId();

  $target_dir = "www_data/uploads/";

  if($formcoverlink == null) {
    // library.php - function createFilename($file, $path, $prefix,$uniqueID)
    $newname = createFilename("fileToUpload", $target_dir, "cover-", $movieid);
    // library.php - checkAndMoveFile($file, $limit, $newname)
    // pass file, the file size limit, and new file name
    checkAndMoveFile("fileToUpload", 1500000, WEBROOT.$newname);
  }
  else {
    $newname = $formcoverlink;
  }
  $sql= "UPDATE marbles_Movies SET filetarget = ? WHERE movieid = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$newname, $movieid]);

  header("Location:displaydetails.php?movieid=".$movieid);
  exit();
}
?>
