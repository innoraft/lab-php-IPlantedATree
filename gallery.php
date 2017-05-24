<?php
$_PHP_SELF = $_SERVER['PHP_SELF'];
include('conn.php');
//get total number of records
$sql = "SELECT count(id) from userContent";
$retval = $conn->query($sql);
$row = $retval->fetch_assoc();
$rec_count = $row['count(id)'];
$rec_limit = 5;

if(isset($_GET['page'])){
  $page = $_GET['page'] + 1;
  $offset = $rec_limit * $page;
}
else{
  $page = 0;
  $offset = 0;
}

$left_rec = $rec_count - ($page * $rec_limit);

$sql = "SELECT * FROM userContent LIMIT $offset,$rec_limit";
$rs = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
      <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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

h1 {
  font-size: 300%;
  text-transform: uppercase;
  letter-spacing: 3px;
  font-weight: 400;
}

header {
  background: #00ff11;
  color: #FFFFFF;
  padding: 50px 0;
  text-align: center;
}
header p {
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
  background: #C5CAE9;
  width: 5px;
  height: 95%;
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
}

.timeline-item {
  width: 100%;
  margin-bottom: 70px;
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
  top: 30px;
  left: -15px;
  border-width: 10px 15px 10px 0;
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
  box-shadow: 0 20px 25px -15px rgba(0, 0, 0, 0.3);
}
.timeline-content::after {
  content: '';
  position: absolute;
  border-style: solid;
  width: 0;
  height: 0;
  top: 30px;
  right: -15px;
  border-width: 10px 0 10px 15px;
  border-color: transparent transparent transparent #f5f5f5;
}

.timeline-img {
  width: 30px;
  height: 30px;
  background: #3F51B5;
  border-radius: 50%;
  position: absolute;
  left: 50%;
  margin-top: 25px;
  margin-left: -15px;
}

a {
  background: #3F51B5;
  color: #FFFFFF;
  padding: 8px 20px;
  text-transform: uppercase;
  font-size: 14px;
  margin-bottom: 20px;
  margin-top: 10px;
  display: inline-block;
  border-radius: 2px;
  box-shadow: 0 1px 3px -1px rgba(0, 0, 0, 0.6);
}
a:hover, a:active, a:focus {
  background: #32408f;
  color: #FFFFFF;
  text-decoration: none;
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
    top: 30px;
    left: -15px;
    border-width: 10px 15px 10px 0;
    border-color: transparent #f5f5f5 transparent transparent;
  }
}
    
  </style>
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
<script type="text/javascript">
function getPostTime(unix_timestamp){
  // Create a new JavaScript Date object based on the timestamp
  // multiplied by 1000 so that the argument is in milliseconds, not seconds.
  var date = new Date(unix_timestamp*1000);
  // Hours part from the timestamp
  var hours = date.getHours();
  // Minutes part from the timestamp
  var minutes = "0" + date.getMinutes();
  // Seconds part from the timestamp
  var seconds = "0" + date.getSeconds();

  // Will display time in 10:30:23 format
  var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
  this.innerHTML = formattedTime;
}  
</script>
</head>
<body>
<header>
  <div class="container text-center">
    <h1>Welcome to Gallery</h1>
    <p>See the greenery spread!</p>
  </div>
</header>

<section class="timeline">
  <div class="container">

<?php
  $i = 0;
  while($row = $rs->fetch_assoc()){
    $i++;
    if($i%6 == 0)
      break;
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
          <h2><?php echo $name['fb_name']?></h2>
        </div>
        <div class="date"><?php $date = new DateTime();$date->setTimestamp($row['timestamp']);echo $date->format('H:i Y-m-d')?></div>
        <p><?php echo $row['description'];?></p>
        <a class="bnt-more" href="content.php?contentId=<?php echo $row['id'];?>">More</a>
      </div>
    </div>   

<?php

}
?>

  </div>
</section>
<div style="height: auto;margin:0px 0;width: 100%;text-align: center;">
<?php
 if( $page > 0 ) {
            $last = $page - 2;
            echo "<a href = \"$_PHP_SELF?page=$last\">Last 5 Posts</a> |";
            echo "<a href = \"$_PHP_SELF?page=$page\">Next 5 Posts</a>";
         }else if( $page == 0 ) {
            echo "<a href = \"$_PHP_SELF?page=$page\">Next 5 Posts</a>";
         }else if( $left_rec < $rec_limit ) {
            $last = $page - 2;
            echo "<a href = \"$_PHP_SELF?page=$last\">Last 5 Posts</a>";
         }
         
         mysqli_close($conn);
?>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>