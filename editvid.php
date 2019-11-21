<!-- NAME: editvid.php -->
<!-- DESCRIPTION: -->
<?php
session_start();
include 'includes/checklogin.php';


include "includes/library.php";
$pdo = & dbconnect();

$movieid = $_GET['movieid']; //GET STATMENT HERE

$sql="SELECT title, year, actors, studio, plotsummary, genre, starrating, mpaarating, runtime, theatrerelease, dvdrelease, videotype, filetarget, owner FROM marbles_Movies WHERE movieid=?";
$stmt=$pdo->prepare($sql);
$stmt->execute([$movieid]);
$row = $stmt->fetch();

if($row['owner'] != $_SESSION['userid']){
  header("Location:index.php");
  exit();
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
    $PAGE_TITLE = "EDIT VIDEO";
    include 'includes/head_includes.php';?>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>

<body class="form-body">
  <main>
    <div id="container">
      <div class="form-window">
        <form id="addvid" name="addvid" action="processeditvid.php?movieid=<?php echo $movieid ?>" method="post" enctype="multipart/form-data">
          <div>
            <label for="Title"></label>
            <input type="text" name="title" id="title" placeholder="TITLE" value="<?php echo $title ?>" required />
          </div>
          <div>
            <label for="Year"></label>
            <input type="text" name="year" id="year" placeholder="YEAR" pattern="^\d{4}$" value="<?php echo $year ?>"/>
          </div>
          <div>
            <label for="Actors"></label>
            <input type="text" name="actors" id="actors" placeholder="ACTORS"  value="<?php echo $actors ?>" />
          </div>
          <div>
            <label for="Studio"></label>
            <input type="text" name="studio" id="studio" placeholder="STUDIO" value="<?php echo $studio ?>" />
          </div>
          <div>
            <label for="Runtime"></label>
            <input type="text" name="runtime" id="runtime" placeholder="RUNTIME (MINUTES)" value="<?php echo $runtime ?>" />
          </div>
          <div>
            <label for="Theatre Release"></label>
            <input type="text" name="theatre-release" class="datepicker"  placeholder="THEATRE RELEASE" value="<?php echo $theatrerelease ?>"  pattern="^[1-2]\d\d\d-[0,1]\d-[0-3]\d$"/>
          </div>
          <div>
            <label for="Dvd Release"></label>
            <input type="text" name="dvd-release" class="datepicker"  placeholder="DVD RELEASE" value="<?php echo $dvdrelease ?>" pattern="^[1-2]\d\d\d-[0,1]\d-[0-3]\d$"/>
          </div>
          <div>
            <label for="Plot"></label>
            <input type="text" name="plot" id="plot" placeholder="PLOT SUMMARY" maxlength="2500" value="<?php echo $plotsummary ?>"/>
          </div>
          <span id="charCount"></span>
          <div>
            <label for="Genre"></label>
            <select name="genre" id="genre">
                <option value="0" <?php if($genre = "0"){echo "selected";}?> >SELECT GENRE</option>
                <option value="action" <?php if($genre = "action"){echo "selected";}?> >Action</option>
                <option value="adventure" <?php if($genre = "adventure"){echo "selected";}?> >Adventure</option>
                <option value="animation" <?php if($genre = "animation"){echo "selected";}?> >Animation</option>
                <option value="comedy" <?php if($genre = "comedy"){echo "selected";}?> >Comedy</option>
                <option value="crime" <?php if($genre = "crime"){echo "selected";}?> >Crime</option>
                <option value="documentary" <?php if($genre = "documentary"){echo "selected";}?> >Documentary</option>
                <option value="drama" <?php if($genre = "drama"){echo "selected";}?> >Drama</option>
                <option value="family" <?php if($genre = "family"){echo "selected";}?> >Family</option>
                <option value="fantasy" <?php if($genre = "fantasy"){echo "selected";}?> >Fantasy</option>
                <option value="history" <?php if($genre = "history"){echo "selected";}?> >History</option>
                <option value="horror" <?php if($genre = "horror"){echo "selected";}?> >Horror</option>
                <option value="music" <?php if($genre = "music"){echo "selected";}?> >Music</option>
                <option value="mystery" <?php if($genre = "mystery"){echo "selected";}?> >Mystery</option>
                <option value="romance" <?php if($genre = "romance"){echo "selected";}?> >Romance</option>
                <option value="science-fiction" <?php if($genre = "science-fiction"){echo "selected";}?> >Science Fiction</option>
                <option value="tv-movie" <?php if($genre = "tv-movie"){echo "selected";}?> >TV Movie</option>
                <option value="thriller" <?php if($genre = "thriller"){echo "selected";}?> >Thriller</option>
                <option value="war" <?php if($genre = "war"){echo "selected";}?> >War</option>
                <option value="western" <?php if($genre = "western"){echo "selected";}?> >Western</option>
            </select>
          </div>

          <div class="mpaa-rating">
            <fieldset>
              <input type="radio" name="mpaa-rating" id="g" value="5"  <?php if($mpaarating = 5){echo "selected";}?> />
              <label for="g">G</label>
              <input type="radio" name="mpaa-rating" id="pg" value="4" <?php if($mpaarating = 4){echo "selected";}?> />
              <label for="pg">PG</label>
              <input type="radio" name="mpaa-rating" id="pg13" value="3" <?php if($mpaarating = 3){echo "selected";}?> />
              <label for="pg13">PG-13</label>
              <input type="radio" name="mpaa-rating" id="r" value="2" <?php if($mpaarating = 2){echo "selected";}?> />
              <label for="r">R</label>
              <input type="radio" name="mpaa-rating" id="nc17" value="1" <?php if($mpaarating = 1){echo "selected";}?> />
              <label for="nc17">NC-17</label>
          </fieldset>
          </div>

          <div class="video">
            <fieldset>
              <input type="checkbox" name="video-type[]" id="dvd" <?php if($videotype = 0){echo "selected";}?> /><label for="dvd">DVD</label>
              <input type="checkbox" name="video-type[]" id="bluray" <?php if($mpaarating = 0){echo "selected";}?> /><label for="bluray">Bluray</label>
              <input type="checkbox" name="video-type[]" id="digitalsd" <?php if($mpaarating = 0){echo "selected";}?> /><label for="digitalsd">Digital SD</label>
              <input type="checkbox" name="video-type[]" id="digitalhd" <?php if($mpaarating = 0){echo "selected";}?> /><label for="digitalhd">Digital HD</label>
            </fieldset>
          </div>

          <div id="rateYo"></div>

          <div class="upload-btn-wrapper">
            <button class="button">UPLOAD COVER</button>
            <input type="file" name="fileToUpload" id="fileToUpload" />
          </div>

          <input type="submit" name="submit" value="UPDATE MOVIE" />
        </form>
      </div>
    </div>
  </main>
</body>

</html>
