<?php
// ------------------------------------------------------------------
// NAME: deleteconfirmation.php
// DESCRIPTION: Modal dialog to confirm deleting a movie.
// -------------------------------------------------------------------
//Get movieid from GET array
$movieid = $_COOKIE['movieId']; //GET STATMENT HERE
$userid = $_SESSION['userid']; //GET STATMENT HERE

$sql="SELECT title FROM marbles_Movies WHERE movieid=? AND owner=?";
$stmt=$pdo->prepare($sql);
$stmt->execute([$movieid, $userid]);
$result = $stmt->fetch();
$title = $result['title'];
?>

<div id="container">
  <span id="closeBtn">&times;</span>
  <div class="form-window">
  <form class="form-login" name="form-login" action="deletevid.php" method="post">
    <div class="warning">
      <input type="text" name="movieid" id="movieidInput" hidden />
      Are you sure you want to delete this movie?
    </div>
    <div>
      <input type="submit" name="submit" value="Delete" />
    </div>
    <div>
      <input type="button" name="cancel" value="Cancel" class="closeBtn"/>
    </div>
  </form>
  </div>
</div>
