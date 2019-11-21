<?php
// ------------------------------------------------------------------
// NAME: movierownext.php
// DESCRIPTION: Returns next four movies from the database.
// -------------------------------------------------------------------
session_start();
include 'includes/library.php';
$pdo = & dbconnect();

$genre = $_GET['genre'];
$pageNum = ($_GET['pageNum'] ?? 0) * 4;
$userid = $_SESSION['userid'];
?>
  <?php
  //Query the db for 4 movies, and grab their title, id, and filetarget
  $sql = "SELECT title, movieid, filetarget FROM marbles_Movies WHERE genre = ? AND owner = ? LIMIT ?, 4";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$genre, $userid, $pageNum]);
  $movielist = $stmt->fetchAll();
  //For each movie, populate the movie's information into a movie div.
  foreach($movielist as $movie): ?>
  <div class="movie">
    <div class="cover">
      <?php //if no cover has been uploaded, use the default.
          if (isset($movie['filetarget']) && $movie['filetarget'] != ""){
          if(substr($movie['filetarget'], 0, 4) == 'http') {
            echo "<img src=\"" . $movie['filetarget'] . "\" width='100%'  />";
          }
          else {
            echo "<img src=\"/~nathanmcbride/" . $movie['filetarget'] . "\" width='100%'  />";
          }
        } else {
          echo "<img src = \"img/nick_1.png\" width='100%'  />";
        }?>
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
