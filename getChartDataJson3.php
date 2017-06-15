
<?php
//  Gets the data for the chart based on the date values selected by the user
// $startDate = $_POST['startDate'];
// $endDate = $_POST['endDate'];
// die();['DAY', 'Posts', { role: 'style' } ],
//echo '["12/Jun/17",10,"color:grey"]';

$startDate = intval($_POST['startDate']);
$endDate = intval($_POST['endDate']);
$date1 = new DateTime();
$date2 = new DateTime();
$date1->setTimestamp($startDate);
$date2->setTimestamp($endDate);
$diff = date_diff($date2,$date1,true);
$dayDiff = $diff->d + 1;
$monthDiff = $diff->m;
$yearDiff = $diff->y;
$noOfDays = $yearDiff*365 + $monthDiff*30 + $diff->d + 1;
// echo "<br>Number of days <br>".$noOfDays;
$returnArray = array();
$date = new DateTime();

include('conn.php');
$sql = "SELECT timestamp from userContent WHERE timestamp >= $startDate AND timestamp <= $endDate
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