
<?php

$fbId = $_GET['fb_id'];
date_default_timezone_set("Asia/Kolkata");
$date  = new DateTime();
$monthDiff = 2592000; //number of seconds in one month
$hours = $date->format('h');
$minutes = $date->format('i');
$seconds = $date->format('s');
$subVal = $hours*60*60 + $minutes*60 + $seconds-1;
$date->setTimestamp($date->getTimestamp() - $subVal);
$endDate = $date->getTimestamp();
$date->setTimestamp($date->getTimestamp()-$monthDiff);
$startDate = $date->getTimestamp();

$noOfDays = 30;

$returnArray = array();


include('conn.php');

$sql = "SELECT userContent.timestamp,user.fb_name 
		FROM userContent,user 
		WHERE userContent.timestamp >= $startDate AND userContent.fb_id=$fbId AND user.fb_id=userContent.fb_id 
		";
$rs = $conn->query($sql);
$numRows = mysqli_num_rows($rs);
// echo "Number of rows is ".$numRows;
$row = mysqli_fetch_array($rs);
$name = $row['fb_name'];
$returnArray = array();
$date->setTimestamp($startDate);
$returnArray['cols'] = array(
							array('id'=>'User', 'label'=>'User','type'=>'string'),
							array('id'=>'Posts','label'=>'Number of Posts','type'=>'number'),
							array('type'=>'string','role'=>'tooltip')
						);
$returnArray['rows'] = array();
$returnArray['rows'][0] = array(
					"c"=>array(
						array("v"=>"$name","f"=>"$name"),
						array("v"=>"$numRows","f"=>"$numRows"),
						array("v"=>"$numRows posts since ".$date->format('d/M/y'))
					)
				);
$returnArray = json_encode($returnArray);
 echo $returnArray;

?>