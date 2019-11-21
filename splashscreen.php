
<!-- NAME: splashscreen.php -->
<!-- DESCRIPTION: Main page for non logged in users. -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
      $PAGE_TITLE = "Marbles";
      include 'includes/head_includes.php';
    ?>
  </head>
  <body>
    <div id="container">
      <?php include 'includes/header.php';?>
      <main>
        <div>
          <h2 class="gradient">Welcome To Marbles</h2>
        </div>
        <div>
          <h3>The internets greatest movie management system</h3>
        </div>

        <div id="splash-buttons">
          <input type='button' id="loginBtn" value="Login"></input>
          <input type='button' id="registerBtn" value="Register"></input>
        </div>

      </main>
    </div>
  </body>
</html>
