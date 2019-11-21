<?php
// ------------------------------------------------------------------
// NAME: index.php
// DESCRIPTION: Used to display the users content library.
// -------------------------------------------------------------------
session_start();
include 'includes/checklogin.php';
include 'includes/library.php';
$pdo = & dbconnect();
$genre = "fantasy";

$userid = $_SESSION['userid'];

$sql = "SELECT DISTINCT genre FROM marbles_Movies WHERE owner = ? LIMIT 5";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userid]);
$results = $stmt->fetchAll();

$counter =+ 5;

$sql = "SELECT genre, COUNT(*) AS movieCount FROM marbles_Movies WHERE owner = ? GROUP BY genre";
$stmt = $pdo->prepare($sql);
$stmt->execute([$userid]);
$results2 = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

?>
<!DOCTYPE html>
<html lang="en">

<script>
// Create a cookie that passes movieId from Index.php to deleteconfirmation.php who can then send to deletevid.php
function createMovieIdCookie(movieId){
    document.cookie = "movieId=" + movieId;
}

</script>

<head>
  <?php
    $PAGE_TITLE = "HOME";
    include 'includes/head_includes.php';?>
<style>

.holder{
  display:flex;
  flex-direction: row;
  justify-content: space-around;
}

.prevBtn, .nextBtn {
  align-self: center;
}
</style>
</head>

<body>
  <div id="container-index">
    <?php include 'includes/header.php';?>
    <main>
      <div>
        <h2 class="gradient">MOVIES</h2>
      </div>
      <div>
        <h3>Currently available movies</h3>
      </div>
      <?php //For each genre in the list of genres, create a movie row and do...
        foreach($results as $genretype):
      ?>
      <div class="genre">
        <h3>
          <?php //echo the title of the genre
            echo strtoupper($genretype['genre']);
          ?>
        </h3>
        <span class='genreCount' style="display:none"><?php echo $results2[$genretype['genre']]; ?></span>
        <div class="holder">

        <a class='prevBtn' href="movierownext.php?genre=<?php echo $genretype['genre'] ?>">PREV</a>
        <!-- <a class='prevBtn linkhide' href="movierownext.php?genre=<?php echo $genretype['genre'] ?>">PREV</a> -->

        <div class="movierow">
          <?php
          //Query the db for 4 movies, and grab their title, id, and filetarget
          $genre = $genretype['genre'];
          $sql = "SELECT title, movieid, filetarget FROM marbles_Movies WHERE genre = ? AND owner = ? LIMIT 4";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([$genre, $userid]);
          $movielist = $stmt->fetchAll();
          //For each movie, populate the movie's information into a movie div.
          foreach($movielist as $movie): ?>
          <div class="movie">
            <div class="cover">
              <?php //if no cover has been uploaded, use the default.
                if (isset($movie['filetarget']) && $movie['filetarget'] != ""){
                  if(substr($movie['filetarget'], 0, 4) == 'http') {
                    echo "<img src=\"" . $movie['filetarget'] . "\" width='100%' />";
                  }
                  else {
                    echo "<img src=\"/~nathanmcbride/" . $movie['filetarget'] . "\" width='100%' />";
                  }
                } else {
                  echo "<img src = \"img/nick_1.png\" width='100%' />";
                } ?>
            </div>
            <div class="title">
              <?php
              // if the movie does not have a title, set it as unknown.
                echo (isset($movie['title']) ? $movie['title'] : "unknown");
              ?>
            </div>
            <div class="options">
              <div>
                <div class="deleteBtn" onClick="createMovieIdCookie(<?php echo $movie['movieid']?>);">
                  <!-- <a href=""> -->
                    <i class="fas fa-trash-alt"></i>
                  <!-- </a> -->
                 </div>
                 <div>
                   <a href="./displaydetails.php?movieid=<?php echo $movie['movieid'] ?>">
                     <i class="fas fa-info"></i>
                   </a>
                  </div>
                  <div>
                     <a href="./editvid.php?movieid=<?php echo $movie['movieid'] ?>"> <!-- This puts the movieid in the URl as a param, we can pass this to edit movies etc. Not sure if this is what jamie wants though.-->
                       <i class="fas fa-edit"></i>
                     </a>
                  </div>
                  </div>
                </div>
          </div>
        <?php endforeach; ?>
        </div>
        <a class='nextBtn' href="movierownext.php?genre=<?php echo $genretype['genre'] ?>">NEXT</a>
      </div>
      </div>
    <?php endforeach; ?>

      <div> <h3> Don't lose your marbles! <br /> Organize your movies smarter </h3> </div>
    </main>
    <?php include 'includes/footer.php';?>
  </div>
  <div id="deleteModal">
    <div class="modal-content">
       <?php include 'includes/deleteconfirmation.php'; ?>
     </div>
  </div>
</body>


</html>
