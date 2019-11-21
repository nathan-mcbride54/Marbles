<?php
// ------------------------------------------------------------------
// NAME: login.php
// DESCRIPTION: Modal login window.
// -------------------------------------------------------------------
  session_start();
  $formuser="";

  if (isset($_COOKIE['remember-me'])){
    $formuser = $_COOKIE['remember-me'];
  }

  if(isset($_POST['submit'])){
    $formuser = $_POST['username'];
    $formpass = $_POST['password'];

    if (isset($_POST['remember-me'])){
      setcookie('remember-me', $formuser, time()+60+60+24+30);
    } else {
      // if the user does not want username to be remembered, unset cookie.
        unset($_COOKIE['remember-me']);
    }

    include 'includes/library.php';
    $pdo = & dbconnect();
    $stmt = $pdo->prepare("select userpass, userid from marbles_Users where username=?");
    $stmt -> execute([$formuser]);
    $row = $stmt -> fetch();

    if (password_verify($formpass, $row['userpass'])) {
      if (password_needs_rehash($row['userpass'], PASSWORD_DEFAULT, $options)) {
        $newHash = password_hash($formpass, PASSWORD_DEFAULT, $options);
        //update database with new hash


      }

      //redirect to main page
      $_SESSION['user']=$formuser;
      $_SESSION['userid']=$row['userid'];
      header("Location:index.php");
    }
    else {
    $error=true;

    header("Location:splashscreen.php");
    }
  }
?>

<div id="container">
  <span id="closeBtn">&times;</span>
  <div class="form-window">
  <form id="form-login" name="form-login" action="login.php" method="post">
    <div>
      <label for="username"></label>
      <input type="text" name="username" id="username" placeholder="USERNAME" value="<?php echo $formuser ?>" required />
    </div>
    <div>
      <label for="password"></label>
      <input type="password" name="password" id="password" placeholder="PASSWORD" required />
    </div>
    <div>
      <label for="remember-me"> Remember Me </label>
      <input type="checkbox" name="remember-me" id="remember-me" checked="checked" value="Y" />
    </div>
    <div>
      <input type="submit" name="submit" value="LOGIN" />
    </div>
    <div>
      <a href="passwordReset.html"> Forgot your password? </a>

    </div>
  </form>
  </div>
</div>
