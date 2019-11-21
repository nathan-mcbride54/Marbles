<?php
// ------------------------------------------------------------------
// NAME: header.php
// DESCRIPTION: Header containing nav, shown on all pages.
// -------------------------------------------------------------------
  $login = false;
  if (isset($_SESSION['user'])){
    $login = true;
  }
 ?>
<header>
  <div>
    <h1 class="logo">M</h1>
  </div>
  <div>
    <h1 class="logo"><?php echo ucwords(strtolower($PAGE_TITLE)) ?></h1>
  </div>
  <nav>
    <div id="mySidenav" class="sidenav">
      <div>
        <h1 class="logo">M</h1>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      </div>
      <div>
        <?php
          if (!$login):?>
            <a class="navlink" id='navLogin'>
              <div><i class="fas fa-sign-in-alt fa-2x"></i></div><div>Login</div>
            </a>
            <a class="navlink" id='navRegister'>
              <div><i class="fas fa-user-plus fa-2x"></i></div><div>Register</div>
            </a>
        <?php else:?>
          <a href="logout.php" class="navlink">
            <div><i class="fas fa-sign-out-alt fa-2x"></i></div><div>Logout</div>
          </a>
        <?php endif;?>
          <a href="index.php" class="navlink">
            <div><i class="fas fa-home fa-2x"></i></div><div>Home</div>
          </a>
          <a href="search.php" class="navlink">
            <div><i class="fas fa-search fa-2x"></i></div><div>Search</div>
          </a>
          <a href="addvid.php" class="navlink">
            <div><i class="far fa-play-circle fa-2x"></i></i></div><div>Add Video</div>
          </a>
          <a href="editaccount.php" class="navlink">
            <div><i class="fas fa-cog fa-2x"></i></div><div>Account</div>
          </a>
      </div>
    </div>

    <!-- Use any element to open the sidenav -->
    <span onclick="openNav()"><i class="fas fa-bars fa-2x"></i></span>
  </nav>
  <div id="loginModal">
    <div class="modal-content">
       <?php include 'login.php'; ?>
     </div>
  </div>

  <div id="registerModal">
    <div class="modal-content">
       <?php include 'register.php'; ?>
     </div>
  </div>
</header>
