<?php
// ------------------------------------------------------------------
// NAME: register.php
// DESCRIPTION: Modal window used to register with Marbles.
// -------------------------------------------------------------------
  if (isset($_POST['submit'])){
    include "includes/library.php";
    $pdo = & dbconnect();

    $errors=array();

    $formuser = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    //check for existing email
    $sql="SELECT 1 FROM marbles_Users WHERE username = ?";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$formuser]);
    if($stmt->fetchColumn()){
      $errors[] = "<h2>An account with this username already exists</h2>";
    }

    $formpass = $_POST['password'];
    $formpassconfirm = $_POST['password-confirm'];
    if ($formpass != $formpassconfirm){ //Passwords must be identical
      $errors[]="<h2>Passwords do not match</h2>";
    }
    if(strlen($formpass) < 8){ //Password must be longer than 8 characters
      $errors[]="<h2>You must enter a password 8 or more characters long</h2>";
    }

    $formemail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);  //Sanitizes email
    if (!filter_var($formemail, FILTER_VALIDATE_EMAIL)){ //Validates email
      $errors[]="<h2>You must enter a valid email</h2>";
    } else {
      //check for existing email
      $sql="SELECT 1 FROM marbles_Users WHERE useremail = ?";
      $stmt=$pdo->prepare($sql);
      $stmt->execute([$formemail]);
      if($stmt->fetchColumn()){
        $errors[] = "<h2>An account with this email already exists</h2>";
      }
    }

    $formname = $_POST['name'];
    //call database connection function

    if(sizeof($errors)==0){
      $hashpass = password_hash($formpass, PASSWORD_DEFAULT);

      $sql="INSERT INTO marbles_Users (username, userpass, useremail, userfullname) VALUES (?,?,?,?)";
      $pdo->prepare($sql)->execute([$formuser, $hashpass, $formemail,$formname]);

      //redirect to main page
      $_SESSION['user'] = $formuser;
      header("Location:index.php");
      exit();
    }
  }

 ?>

<div id="container">
  <span id="closeBtn">&times;</span>
  <div class="form-window">
  <form id="form-register" name="form-register" action="register.php" method="post">
    <div>
      <label for="username"></label>
      <input type="text" name="username" id="username" placeholder="USERNAME"  required />
    </div>
    <div>
      <label for="name"></label>
      <input type="text" name="name" id="name" placeholder="NAME" pattern="[A-Za-z-0-9]+\s[A-Za-z-'0-9]+" required />
    </div>
    <div>
      <label for="email"></label>
      <input type="text" name="email" id="email" placeholder="EMAIL" required />
    </div>
    <div>
      <label for="password"></label>
      <input type="password" name="password" id="password" placeholder="PASSWORD" required />
    </div>
    <div>
      <label for="password-confirm"></label>
      <input type="password" name="password-confirm" id="password-confirm" placeholder="CONFIRM PASSWORD" required />
    </div>
    <div>
      <input type="submit" name="submit" value="REGISTER" />
    </div>
    <div id='errordiv'>
      <?php
      //Print out errors if encountered when registering
      if (isset($_POST['submit'])){
        if(sizeof($errors)!=0){
        foreach ($errors as $error): ?>
          <div class="error"><?php echo $error; ?></div>
        <?php endforeach;
        }
      }
      ?>
    </div>
  </form>
  </div>
</div>
