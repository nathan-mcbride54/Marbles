<?php
// ------------------------------------------------------------------
// NAME: editaccount.php
// DESCRIPTION: Used to display account details and update accordingly.
// -------------------------------------------------------------------
  session_start();
  include 'includes/checklogin.php';

  include "includes/library.php";
  $pdo = & dbconnect();

  $sql = "SELECT username, useremail, userfullname, userpass FROM marbles_Users WHERE userid = ?";
  $stmt=$pdo->prepare($sql);
  $stmt->execute([$_SESSION['userid']]);
  $row = $stmt->fetch();

  $formuser = $row['username'];
  $formemail = $row['useremail'];
  $formname = $row['userfullname'];

  if (isset($_POST['submit'])){
    $formoldpass = $_POST['oldpassword'];
    $formpass = $_POST['password'];
    $formpassconfirm = $_POST['password-confirm'];
    $formemail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $formname = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $error = false;
    //check for existing email
    $sql="SELECT 1 FROM marbles_Users WHERE userid = ?";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$_SESSION['userid']]);

    if (password_verify($formoldpass, $row['userpass'])){
      if ($formpass==""){
        //build query
        $query="UPDATE marbles_Users SET useremail=?, userfullname=? WHERE userid = ?";
        //prepare & execute query
        $stmt=$pdo->prepare($query)->execute([$formemail,$formname,$formuser]);
      }else{
        if ($formpass == $formpassconfirm){
          //build query
          $query="UPDATE marbles_Users SET userpass=?, useremail=?, userfullname=? WHERE userid = ?";
          //prepare & execute query
          $hashpass = password_hash($formpass, PASSWORD_DEFAULT);
          $stmt=$pdo->prepare($query)->execute([$hashpass, $formemail,$formname,$_SESSION['userid']]);
        }
        else{
          echo "passwords don't match";
          $error = true;
        }
      }

      if (!$error){
        //redirect to main page
        $_SESSION['user'] = $formuser;
        header("Location:index.php");
        exit();
      }
    }
  }
  if (isset($_POST['delete'])){
    $formoldpass = $_POST['oldpassword'];
    if (password_verify($formoldpass, $row['userpass'])){

      $sql="DELETE FROM marbles_Movies WHERE owner = ?";
      $stmt=$pdo->prepare($sql);
      $stmt->execute([$_SESSION['userid']]);

      $sql="DELETE FROM marbles_Users WHERE userid = ?";
      $stmt=$pdo->prepare($sql);
      $stmt->execute([$_SESSION['userid']]);

      session_destroy();
      header("Location:splashscreen.php");
      exit();
    }
  }
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
    $PAGE_TITLE = "EDIT PROFILE";
    include 'includes/head_includes.php';?>
</head>

<body class="form-body">
  <main>
    <div id="container">
      <div class="form-window">
        <form id="form-register" name="form-register" action=<?php echo $_SERVER['PHP_SELF'] ?> method="post">
          <div>
            <label for="username"></label>
            <input type="text" name="username" id="username" placeholder="USERNAME" value="<?php echo $formuser ?>" required />
          </div>
          <div>
            <label for="name"></label>
            <input type="text" name="name" id="name" placeholder="NAME" pattern="[A-Za-z-0-9]+\s[A-Za-z-'0-9]+" value="<?php echo $formname ?>" required />
          </div>
          <div>
            <label for="email"></label>
            <input type="text" name="email" id="email" placeholder="EMAIL" value="<?php echo $formemail ?>" required />
          </div>
          <div>
            <label for="oldpassword"></label>
            <input type="password" name="oldpassword" id="oldpassword" placeholder="OLD PASSWORD" required />
          </div>
          <div>
            <label for="password"></label>
            <input type="password" name="password" id="password" placeholder="NEW PASSWORD" />
          </div>
          <div>
            <label for="password-confirm"></label>
            <input type="password" name="password-confirm" id="password-confirm" placeholder="CONFIRM NEW PASSWORD" />
          </div>
          <div>
            <input type="submit" name="submit" value="UPDATE" />
          </div>
          <div>
            <input type="submit" name="delete" value="DELETE ACCOUNT" />
          </div>
        </form>
      </div>
    </div>
  </main>
  <footer>

  </footer>
</body>


</html>
