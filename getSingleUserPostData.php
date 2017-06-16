
<?php
//  Gets the data for the chart based on the date values selected by the user
// $startDate = $_POST['startDate'];
// $endDate = $_POST['endDate'];
// die();['DAY', 'Posts', { role: 'style' } ],
//echo '["12/Jun/17",10,"color:grey"]';
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
// echo "<br>".$date->format('d/m/y h:i:s');
$date->setTimestamp($date->getTimestamp()-$monthDiff);
$startDate = $date->getTimestamp();

$noOfDays = 30;
// echo "<br>Number of days <br>".$noOfDays;
$returnArray = array();


include('conn.php');
$sql = "SELECT timestamp from userContent WHERE timestamp >= $startDate AND timestamp <= $endDate AND fb_id=".$fbId."
 ORDER BY timestamp ASC";
$rs = $conn->query($sql);
$day = 2;
$firstTimestamp = $startDate;
$secondTimestamp = $firstTimestamp + 86400;
$count=0;
// $noOfDays = 6;
$timeStampArray = array();
// if(mysqli_num_rows($rs) = 0)

while($row = mysqli_fetch_array($rs)){
	array_push($timeStampArray,$row['timestamp']);
}
// print_r($timeStampArray);
$arrayPos = 0;
$posted = false;
$postCount = array();

for($j=$noOfDays-1; $j>=0; $j--){
	$count = 0;
	while(($arrayPos<count($timeStampArray)) && ($timeStampArray[$arrayPos]>=$firstTimestamp) && ($timeStampArray[$arrayPos]<$secondTimestamp)){
		$posted = true;
		$count++;
		$arrayPos++;
	}
	$postCount[$noOfDays-$j-1] = array("day"=>$firstTimestamp,"posts"=>$count);
	$firstTimestamp = $secondTimestamp;
	$secondTimestamp = $secondTimestamp + 86400;
		
}
// var_dump($postCount);


$returnArray = array();
$returnArray['cols'] = array(
					array('id'=>'DAY' , 'label'=>'DAY' , 'type'=>'date'),
					array('id'=>'Posts', 'label'=>'Posts' , 'type'=>'number'),
					// array('type'=>'string','role'=>'style'),
					array('type'=>'string','role'=>'tooltip')
						);
$returnArray['rows'] = array();

// print_r($returnArray['rows']);
for($i=0 ; $i<=$noOfDays-1 ; $i++){
	$date->setTimestamp($postCount[$i]['day']);
	$phpDate = getdate($postCount[$i]['day']);
	$year = $phpDate['year'];
	$day = $phpDate['mday'];
	$month = $phpDate['mon']-1;
	$returnArray['rows'][$i] = array(
									"c"=>array(
										array("v"=>"Date($year, $month, $day)","f"=>"Date($year, $month, $day)"),
										array("v"=>$postCount[$i]['posts'],"f"=>$postCount[$i]['posts']),
										// array("v"=>"color:#$i$i$i;"),
										array("v"=>"Date : ".$date->format('d/M/y')."\nPosts : ".$postCount[$i]['posts'])
									)
								);
}
// $temp = array();
// $returnArray["p"] = array("style"=>"color:#000;stroke-width:2px;");
$returnArray = json_encode($returnArray);
print_r($returnArray);
?>