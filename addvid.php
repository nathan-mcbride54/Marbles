<?php
// ------------------------------------------------------------------
// NAME: addvid.php
// DESCRIPTION: Form used to add a new video.
// -------------------------------------------------------------------
session_start();
include 'includes/checklogin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
    $PAGE_TITLE = "ADD VIDEO";
    include 'includes/head_includes.php';?>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>

<body class="form-body">
  <main>
    <div id="container">
      <div class="form-window">
        <form id="addvid" name="addvid" action="processaddvid.php" method="post" enctype="multipart/form-data">
          <div>
            <label for="Title"></label>
            <input type="text" name="title" id="title" placeholder="TITLE" required />
          </div>
          <div>
            <input type="button" id='search' value="LOOKUP"/>
          </div>
          <div>
            <label for="Year"></label>
            <input type="text" name="year" id="year" placeholder="YEAR" pattern="^\d{4}$" />
          </div>
          <div>
            <label for="Actors"></label>
            <input type="text" name="actors" id="actors" placeholder="ACTORS" />
          </div>
          <div>
            <label for="Studio"></label>
            <input type="text" name="studio" id="studio" placeholder="STUDIO" />
          </div>
          <div>
            <label for="Runtime"></label>
            <input type="text" name="runtime" id="runtime" placeholder="RUNTIME (MINUTES)" />
          </div>
          <div>
            <label for="Theatre Release"></label>
            <input type="text" name="theatre-release" class="datepicker" placeholder="THEATRE RELEASE" pattern="^[1-2]\d\d\d-[0,1]\d-[0-3]\d$"/>
          </div>
          <div>
            <label for="Dvd Release"></label>
            <input type="text" name="dvd-release" class="datepicker" placeholder="DVD RELEASE" pattern="^[1-2]\d\d\d-[0,1]\d-[0-3]\d$"/>
          </div>
          <div>
            <label for="Plot"></label>
            <input type="text" name="plot" id="plot" placeholder="PLOT SUMMARY" maxlength="2500"/>
          </div>
          <span id="charCount"></span>
<!-- pattern="^[0,1]\d\/[0-3]\d\/[1-2]\d\d\d$"  -->
          <div>
            <label for="Genre"></label>
            <select name="genre" id="genre">
                <option value="0">SELECT GENRE</option>
                <option value="action">Action</option>
                <option value="adventure">Adventure</option>
                <option value="animation">Animation</option>
                <option value="comedy">Comedy</option>
                <option value="crime">Crime</option>
                <option value="documentary">Documentary</option>
                <option value="drama">Drama</option>
                <option value="family">Family</option>
                <option value="fantasy">Fantasy</option>
                <option value="history">History</option>
                <option value="horror">Horror</option>
                <option value="music">Music</option>
                <option value="mystery">Mystery</option>
                <option value="romance">Romance</option>
                <option value="science-fiction">Science Fiction</option>
                <option value="tv-movie">TV Movie</option>
                <option value="thriller">Thriller</option>
                <option value="war">War</option>
                <option value="western">Western</option>
            </select>
          </div>

          <div class="mpaa-rating">
            <fieldset>
              <input type="radio" name="mpaa-rating" id="g" value="5" />
              <label for="g">G</label>
              <input type="radio" name="mpaa-rating" id="pg" value="4" />
              <label for="pg">PG</label>
              <input type="radio" name="mpaa-rating" id="pg13" value="3" />
              <label for="pg13">PG-13</label>
              <input type="radio" name="mpaa-rating" id="r" value="2" />
              <label for="r">R</label>
              <input type="radio" name="mpaa-rating" id="nc17" value="1" />
              <label for="nc17">NC-17</label>
          </fieldset>
          </div>

          <div class="video">
            <fieldset>
              <input type="checkbox" name="video-type[]" id="dvd" /><label for="dvd">DVD</label>
              <input type="checkbox" name="video-type[]" id="bluray" /><label for="bluray">Bluray</label>
              <input type="checkbox" name="video-type[]" id="digitalsd" /><label for="digitalsd">Digital SD</label>
              <input type="checkbox" name="video-type[]" id="digitalhd" /><label for="digitalhd">Digital HD</label>
            </fieldset>
          </div>

          <div id="rateYo"></div>

          <div class="upload-btn-wrapper">
            <button class="button">UPLOAD COVER</button>
            <input type="file" name="fileToUpload" id="fileToUpload">
          </div>
          <div class='imageLink'>
            <input type="text" name="externalCover" id="externalCover">
          </div>

          <input type="submit" name="submit" value="ADD MOVIE" />
          <div id="errordiv"></div>
        </form>
      </div>
    </div>
  </main>

</body>

</html>
