<?php
session_start();
if(!array_key_exists('facebook_access_token', $_SESSION))
  header('location: index.php');
?>
<?php
include('conn.php');
require_once __DIR__ . '/vendor/autoload.php';
include('assets/config/fbCredentials.php');
$accessToken =  $_SESSION["facebook_access_token"];

if(isset($_SESSION['saveContentID'])){
  $_SESSION['saveContentID'] = NULL;
  unset($_SESSION['saveContentID']);
}

// try {
//   $response = $fb->get('/me?fields=name,id,first_name,last_name,email',$accessToken);
//   // $requestPicture = $fb->get('me/picture?redirect=false&height=300&width=300',$accessToken);
//   // $picture = $requestPicture->getGraphUser();
//   $userNode = $response->getGraphUser();

// } catch(Facebook\Exceptions\FacebookResponseException $e) {
//   // When Graph returns an error
//   echo 'Graph returned an error: ' . $e->getMessage();
//   exit;
// } catch(Facebook\Exceptions\FacebookSDKException $e) {
//   // When validation fails or other local issues
//   echo 'Facebook SDK returned an error: ' . $e->getMessage();
//   exit;
// }
// $_SESSION['id'] = $userNode->getId();
// $logoutUrl = 'https://www.facebook.com/logout.php?next=treeplant123.com&access_token='.$accessToken;
// $name = $userNode->getName();
// $userId = $userNode->getId();
// // $sql = "INSERT INTO user IF NOT EXISTS values('$name','$userId','')";
// // if($conn->query($sql))
//   // echo "Updated";
// // else
//   // die($conn->error);

$sql = "SELECT * from userContent where fb_id=".$_SESSION['id']." ORDER BY timestamp DESC";
$rs = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
  <title>TreePlant123</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/w3.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/js/homepage.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Alegreya:400,400i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rancho" rel="stylesheet">
    <script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>
    <script type="text/javascript">
      var tagged_friends = '';
    </script>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script type="text/javascript" src="scripts/js/profile.js"></script>
 <style type="text/css">
section {
  padding: 100px 0;
}

html, body {
  overflow-x: hidden;
}

body {
  font-family: 'Roboto';
  font-size: 17px;
  font-weight: 400;
background-color: #0cc437;
background-image: url("https://www.transparenttextures.com/patterns/tree-bark.png");
/* This is mostly intended for prototyping; please download the pattern and re-host for production environments. Thank you! */
}

h1.gallery-h1 {
  font-size: 300%;
  text-transform: uppercase;
  letter-spacing: 3px;
  font-weight: 400;
}

header.gallery-header {
  background: #00ff11;
  color: #FFFFFF;
  padding: 50px 0;
  text-align: center;
}
header.gallery-header p {
  font-family: 'Allura';
  color: rgba(255, 255, 255, 0.8);
  margin-bottom: 0;
  font-size: 60px;
  margin-top: -30px;
}

.timeline {
  position: relative;
}
.timeline::before {
  content: '';
  margin-top: -26px;
  background: #C5CAE9;
  width: 5px;
  height: 95%;
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
}

.timeline-item {
  width: 100%;
  margin-bottom: -70px;
}
.timeline-item:nth-child(even) .timeline-content {
  float: right;
  padding: 40px 30px 10px 30px;
}
.timeline-item:nth-child(even) .timeline-content .date {
  right: auto;
  left: 0;
}
.timeline-item:nth-child(even) .timeline-content::after {
    content: '';
    position: absolute;
    border-style: solid;
    width: 0;
    height: 0;
    top: 0px;
    left: -15px;
    border-width: 22px 15px 22px 0;
    border-color: transparent #f5f5f5 transparent transparent;
}
.timeline-item::after {
  content: '';
  display: block;
  clear: both;
}

.timeline-content {
  position: relative;
  width: 45%;
  padding: 10px 30px;
  border-radius: 4px;
  background: #f5f5f5;
  /*box-shadow: 0 20px 25px -15px rgba(0, 0, 0, 0.3);*/
  -webkit-box-shadow: 7px 9px 29px 0px rgba(0,0,0,0.75);
-moz-box-shadow: 7px 9px 29px 0px rgba(0,0,0,0.75);
box-shadow: 7px 9px 29px 0px rgba(0,0,0,0.75);
}
.timeline-content::after {
    content: '';
    position: absolute;
    border-style: solid;
    width: 0;
    height: 0;
    /* background: #FF4081; */
    top: 0;
    right: -15px;
    border-width: 22px 0 22px 15px;
    border-color: transparent transparent transparent #f5f5f5;
}

.timeline-img {
    width: 30px;
    height: 30px;
    background: #3F51B5;
    border-radius: 50%;
    position: absolute;
    left: 50%;
    margin-top: 9px;
    margin-left: -15px;
}

a.gallery-a {
  background: #3F51B5;
  color: #FFFFFF;
  padding: 8px 20px;
  text-transform: uppercase;
  font-size: 14px;
  margin: 10px 5px 10px;
  /*margin: 0px 5px;*/
  display: inline-block;
  border-radius: 2px;
  box-shadow: 0 1px 3px -1px rgba(0, 0, 0, 0.6);
}
.next{ margin-left: 10px; }
.prev{  }

a.gallery-a:hover, a.gallery-a:active, a.gallery-a:focus {
  background: #32408f;
  color: #FFFFFF;
  text-decoration: none;
}

.gallery-h2-name{
  text-shadow: 2px 2px 2px #000;
}

.timeline-card {
  padding: 0 !important;
}
.timeline-card p {
  padding: 0 20px;
}
.timeline-card a {
  margin-left: 20px;
}

.timeline-item .timeline-img-header {
  background: linear-gradient(transparent, rgba(0, 0, 0, 0.4)), url("") center center no-repeat;
  background-size: cover;
}

.timeline-img-header {
  height: 200px;
  position: relative;
  margin-bottom: 20px;
}
.timeline-img-header h2 {
  color: #FFFFFF;
  position: absolute;
  bottom: 5px;
  left: 20px;
}

blockquote {
  margin-top: 30px;
  color: #757575;
  border-left-color: #3F51B5;
  padding: 0 20px;
}

.date {
  background: #FF4081;
  display: inline-block;
  color: #FFFFFF;
  padding: 10px;
  position: absolute;
  top: 0;
  right: 0;
}

@media screen and (max-width: 768px) {
  .timeline::before {
    left: 50px;
  }
  .timeline .timeline-img {
    left: 50px;
  }
  .timeline .timeline-content {
    max-width: 100%;
    width: auto;
    margin-left: 70px;
  }
  .timeline .timeline-item:nth-child(even) .timeline-content {
    float: none;
  }
  .timeline .timeline-item:nth-child(odd) .timeline-content::after {
    content: '';
    position: absolute;
    border-style: solid;
    width: 0;
    height: 0;
    top: 0px;
    left: -15px;
    border-width: 22px 15px 22px 0px;
    border-color: transparent #f5f5f5 transparent transparent;
  }
.timeline-item{
  margin-bottom: 20px;
}
}
    
  </style>
</head>
<body>

<?php include('navbar.php'); ?>

<div>
  <h1 style="text-align:center;margin-top : 60px;">My Posts</h1>
</div>

<section class="timeline">
  <div class="container">

<?php
  $i = 0;
  while($row = $rs->fetch_assoc()){
    $i++;
    $sql = "SELECT fb_name from user where fb_id=".$row['fb_id'];
    $rs2 = $conn->query($sql);
    $name = $rs2->fetch_assoc();
?>
    <div class="timeline-item">
      <div class="timeline-img"></div>
      <div class="timeline-content timeline-card js--<?php if($i%2!=0) 
                                                              echo 'fadeInLeft';
                                                            else  
                                                               echo 'fadeInRight'?>">
        <div class="timeline-img-header" style="background-image: url('<?php echo $row["picture_url"];?>');">
          <h2 class="gallery-h2-name"><?php echo $name['fb_name']?></h2>
        </div>
        <div class="date"><?php $date = new DateTime();$date->setTimestamp($row['timestamp']);echo $date->format('d-m-Y H:i')?></div>
        <p><?php echo $row['description'];?></p>
        <a class="gallery-a bnt-more" href="content.php?contentId=<?php echo $row['id'];?>">More</a>
      </div>
    </div>   

<?php

}
?>

  </div>
</section>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(function(){

  window.sr = ScrollReveal();

  if ($(window).width() < 768) {

    if ($('.timeline-content').hasClass('js--fadeInLeft')) {
      $('.timeline-content').removeClass('js--fadeInLeft').addClass('js--fadeInRight');
    }

    sr.reveal('.js--fadeInRight', {
      origin: 'right',
      distance: '300px',
      easing: 'ease-in-out',
      duration: 800,
    });

  } else {
    
    sr.reveal('.js--fadeInLeft', {
      origin: 'left',
      distance: '300px',
      easing: 'ease-in-out',
      duration: 800,
    });

    sr.reveal('.js--fadeInRight', {
      origin: 'right',
      distance: '300px',
      easing: 'ease-in-out',
      duration: 800,
    });

  }
  
  sr.reveal('.js--fadeInLeft', {
      origin: 'left',
      distance: '300px',
      easing: 'ease-in-out',
      duration: 800,
    });

    sr.reveal('.js--fadeInRight', {
      origin: 'right',
      distance: '300px',
      easing: 'ease-in-out',
      duration: 800,
    });


});

</script>
</body>
</html>

