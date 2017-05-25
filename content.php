<?php
session_start();
?>
<?php

include('conn.php');
$contentId = $_GET['contentId'];
$sql = "SELECT * FROM `userContent` WHERE id='".$contentId."'";
$rs = $conn->query($sql);
$row = mysqli_fetch_array($rs);
$fb_id = $row['fb_id'];
$description = $row['description'];
$target_file = $row['picture_url'];

if(isset($_SESSION['facebook_access_token'])){
  require_once __DIR__ . '/vendor/autoload.php';
  include('assets/config/fbCredentials.php');
  $accessToken =  $_SESSION["facebook_access_token"];
  try {
    $friends = $fb->get('/me/taggable_friends?fields=name,id,picture.width(50)',$accessToken); 
    $friends = $friends->getGraphEdge()->asArray();  
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }
  $_SESSION['friends'] = $friends;
  $totalFriends = count($friends);
  $count = 0;
  $friendIDs = '';
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>TreePlant123</title>
  <meta charset="utf-8">
  <meta property="og:url"                content="http://<?php echo $_SERVER['SERVER_NAME']?>/content.php?contentId=<?php echo $contentId?>" />
  <meta property="og:title"              content="I Planted A Tree" />
  <meta property="og:type"   content="website" /> 
  <meta property="og:description"        content="<?php echo $description;?>" />
  <meta property="og:image"              content="<?php echo 'http://'.$_SERVER['SERVER_NAME'].'/'.$target_file;?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/w3.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="scripts/js/homepage.js"></script> -->
    <link href="https://fonts.googleapis.com/css?family=Alegreya:400,400i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rancho" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script type="text/javascript" src="scripts/js/homepage.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
$('#tagged_friends').val('');
var tagged_friends = '';
    $(document).keypress(function(e) {
        if(e.which == 13) {
            e.preventDefault();
        }
    });

  $('#friends').on('input', function() {
      var userText = $(this).val();
      $("#taggable_friends").find("option").each(function() {
          if ($(this).val() == userText) {
            var description = $('#description').html();
            var thisVal = $(this).val();
            description += " @"+thisVal;
            $('#description').html(description);
            $('#friends').val('');
            tagged_friends  += ',' + ($(this).attr('id'));
            this.remove();
            console.log(tagged_friends);
            $('#tagged_friends').val(tagged_friends);
          }
      })
    });
});
    </script>
    <style>
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 40vh; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 30%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}

/* The Close Button */
.close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}

.modal-body {
  padding: 10px 16px;
  font-size: 20px;
}

.modal-footer {
    padding: 10px 16px;
    background-color: #5cb85c;
}
#friends{
  display: none;
}
#showPreview-submit{
  display: none;
}
.btn-custom{
      margin-top: 20px;
      border-radius: 0px;
    }
#lbl_tag_friends{
  display: none;
}
#taggable_friends{
  display: none;
}
.description1{
  height: auto;
  width:600px;
  margin:10px auto;
  padding: 10px;
  resize: none;
  color:#000;
  background-color: #fff;
  text-align: left;
}
.description2{
  height: auto;
  width:50vw;
  margin:10px auto;
  padding: 10px;
  resize: none;
  color:#000;
  background-color: #fff;
  text-align: center;
}
.fa-lg{
  margin-right: 20px;
}
.share-button{
  height:100%;
  display: inline;
  border-right:1px solid #000;
  margin-right: 10px;
}
#myBtn{
  margin-bottom:20px;
}
.modal-content{
  text-align: center;
}
.modal-footer{
  text-align: center;
}
</style>
<script type="text/javascript">
  function formSubmit(){
    document.uploadForm.submit();
  }
</script>
</head>
<body>
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
        <li><a href="index.php">Home</a></li>
        <?php if(isset($_SESSION['facebook_access_token'])) 
          echo '<li><a href="profile.php">Profile</a></li>';
          echo '<li><a href="post.php">Post</a></li>';
        ?>
        <li><a href="gallery.php">Gallery</a></li>
        <li><a href="aboutus.php">About Us</a></li>
        <?php if(isset($_SESSION['facebook_access_token'])) 
          echo '<li><a href="logout.php">Logout</a></li>';
        ?>
      </ul>
    </div>
  </div>
</div>

<div  class="row" id="profile_row">
  <div class="col-md-12 border-negative profile-col-2 rem-padding-right">
    <div id="main-container" class="expandUp">
      <span>I Planted A Tree</span><br>
      <span>@<?php 
      include('conn.php');
      $sql = "SELECT fb_name from user where fb_id=$fb_id";
      $rs = $conn->query($sql);
      $row = $rs->fetch_assoc();
      echo $row['fb_name'];
      ?></span>
    <form id="uploadForm" name="uploadForm" action="upload.php" method="POST"> <!-- Upload form begins-->
      <div id="imageContainer">
        <img id="imagePreview" name="imagePreview" src="<?php echo $target_file; ?>" alt="your image" width="400" height="300" />
      </div>
      <div id="profile_fileUploadButtons">
        <?php if(!empty($description)){ ?>
          <div class="description1" id="description" name="description"><?php echo $description; ?></div><br>
          <?php 
              }
          else{ ?> 
            <div class="description2" id="description" name="description">No description given!</div><br>
          <?php
              }
           ?>
        <label id="lbl_tag_friends">Tag friends</label>
<?php
if(isset($_SESSION['facebook_access_token'])){
  echo ' <input type="text" id="friends" list="taggable_friends">';
  echo '<datalist id="taggable_friends">';
  echo ' <!--[if lte IE 9]><select data-datalist="taggable_friends"><![endif]-->';
  while($count < $totalFriends){
    if($count == 0)
        $friendIDs =  $friends[$count]['id'].',';
    else if($count == $totalFriends-1)
        $friendIDs =  $friendIDs.$friends[$count]['id'];
    else
        $friendIDs =  $friendIDs.$friends[$count]['id'].',';

    echo '<option id="'.$count.'" value="'.$friends[$count]['name'].'">'.$friends[$count]['name']."</option>";   
      
    $count++;
  }
  echo ' <!--[if lte IE 9]></select><![endif]-->';
  echo '</datalist>';
  echo '      <br>
<input type="hidden" id="tagged_friends"  name="tagged_friends" value="A">
      <button id="showPreview-submit" type="button"  class="btn btn-primary btn-lg btn-custom" onclick="formSubmit()">
<i class="fa fa-facebook fa-lg" aria-hidden="true"></i><div class="share-button"></div>Share</button>
      
    </form>
    </div>
    <button id="myBtn" type="button" class="btn btn-primary btn-lg btn-custom">
<i class="fa fa-facebook fa-lg" aria-hidden="true"></i><div class="share-button"></div>Share</button>';
}                                                                 
?>

  </div>
</div>

<!-- Trigger/Open The Modal -->

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Tag friends</h2>
    </div>
    <div class="modal-body">
      <p>Do you want to tag your friends?</p>
    </div>
    <div class="modal-footer">
      <button id="yes">Yes</button>
      <button id="no">No</button>
    </div>
  </div>

</div>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
document.getElementById('yes').onclick = function(){
  modal.style.display = "none";
    document.getElementById('myBtn').style.display = "none";
    document.getElementById('friends').style.display = "inline-block";
    document.getElementById('tagged_friends').style.display = 'inline-block';
    document.getElementById('lbl_tag_friends').style.display = "inline-block";
    document.getElementById('showPreview-submit').style.display = "inline-block";
};
document.getElementById('no').onclick = function(){
  document.getElementById('uploadForm').submit();
};
$(document).ready(function(){
    document.getElementById('friends').style.display = "none";
    document.getElementById('tagged_friends').style.display = "none";
    document.getElementById('lbl_tag_friends').style.display = "none";
    document.getElementById('showPreview-submit').style.display = "none";
});
</script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>

