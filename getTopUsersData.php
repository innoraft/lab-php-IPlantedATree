<?php

include("conn.php");
date_default_timezone_set("Asia/Kolkata");
$date  = new DateTime();
$monthDiff = 2592000; //number of seconds in one month
$hours = $date->format('h');
$minutes = $date->format('i');
$seconds = $date->format('s');
$subVal = $hours*60*60 + $minutes*60 + $seconds-1;
$date->setTimestamp($date->getTimestamp()-$monthDiff-$subVal);
$startDate = $date->getTimestamp();
$number = 1000;
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$number = $_POST['topPostsNumber'];

if($number <= 0)
	$number = 1;

if(!$number)
	$number = 1;

$sql = "SELECT user.fb_id, user.fb_name,count(id)
		FROM userContent,user
		WHERE user.fb_id=userContent.fb_id AND timestamp >= $startDate AND timestamp <= $endDate 
		GROUP BY fb_id
		ORDER BY count(id) DESC
";

if($number > 0)
	$sql .= " LIMIT ".$number;

$rs = $conn->query($sql);

$i = 0;
$fbId = array();

while($row = mysqli_fetch_assoc($rs)){
	$fbId[$i]['name'] = $row['fb_name'];
	$fbId[$i]['id'] = $row['fb_id'];
	$fbId[$i]['posts'] = $row['count(id)'];
	$i++;
}

 echo json_encode($fbId);

?>
