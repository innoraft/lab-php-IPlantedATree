<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a href="#" class="navbar-brand">Treeplant</a>
      <button class="navbar-toggle" data-toggle="collapse" data-target=".myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <?php
        if(isset($_SESSION['role'])){
          if(($_SESSION['role'] == 0) || ($_SESSION['role'] == 1)){
            ?>
              <li><a href="adminHome.php">View Admin Dashboard</a></li>
            <?php
          }
        }
        ?>
        <li><a href="index.php">Home</a></li>
        <?php
          if(isset($_SESSION['facebook_access_token'])){
            echo '<li><a href="profile.php">Profile</a></li>';
            echo '<li><a href="post.php">Post</a></li>';
          }
        ?>
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="aboutus.php">About Us</a></li>
        <?php
          if(isset($_SESSION['facebook_access_token']))
            echo '<li><a href="logout.php">Logout</a></li>';
        ?>
      </ul>
    </div>
  </div>
</div>