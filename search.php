<?php
// ------------------------------------------------------------------
// NAME: search.php
// DESCRIPTION: Returns four videos from database based on users search criteria.
// -------------------------------------------------------------------
session_start();
include 'includes/checklogin.php';
include 'includes/library.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
    $PAGE_TITLE = "SEARCH";
    include 'includes/head_includes.php';?>
</head>

<body>
  <div id="container">
    <?php include 'includes/header.php';?>
    <main>
      <div>
        <h2 class="gradient">RESULTS</h2>
      </div>
      <div>
        <h3>We found these movies</h3>
      </div>
      <div class="outer">
        <form id="searchform" name="searchform" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
          <span>
            <select name="filter" id="filter">
                <option value="title">TITLE</option>
                <option value="genre">GENRE</option>
                <option value="actors">ACTOR</option>
                <option value="studio">STUDIO</option>
                <option value="year">YEAR</option>
            </select>
            <label for="search"></label>
            <input type="text" name="search" id="search" placeholder="SEARCH" />
            <button type="submit"><i class="fa fa-search"></i></button>
            <label for="filter"></label>
          </span>
        </form>
      </div>
      <div class="genre">
        <div class="movierow">
          <?php
          if(isset($_GET['filter']) && isset($_GET['search'])):
            $filterArray = array('title', 'genre', 'actors', 'studio', 'year');
            foreach($filterArray as $filter){
              if($_GET['filter'] == $filter){
                $searchfilter = $filter;
              }
            }
            $search = "%".$_GET['search']."%";
            $userid = $_SESSION['userid'];
            $pdo = & dbconnect();
            //Query the db for 4 movies, and grab their title, id, and filetarget

            $sql = "SELECT title, movieid, filetarget FROM marbles_Movies WHERE owner = ? AND " . $searchfilter . " LIKE ? LIMIT 4";
            $stmt = $pdo->prepare($sql);

            $stmt->execute([$_SESSION['userid'], $search]);

            $movielist = $stmt->fetchAll();
            //For each movie, populate the movie's information into a movie div.
            foreach($movielist as $movie): ?>
          <div class="movie">
            <div class="cover">
              <?php //if no cover has been uploaded, use the default.
                if (isset($movie['filetarget']) && $movie['filetarget'] != ""){
                  if(substr($movie['filetarget'], 0, 4) == 'http') {
                    echo "<img src=\"" . $movie['filetarget'] . "\" width='100%'/>";
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
                <div>
                  <a href="./deletevid.php?movieid=<?php echo $movie['movieid'] ?>">
                    <i class="fas fa-trash-alt"></i>
                  </a>
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
        <?php endforeach;
        endif;
//var_dump($_GET);
//echo($_GET['filter']);

        ?>
        </div>
      </div>
    </main>
    <?php include 'includes/footer.php';?>
  </div>
</body>


</html>
