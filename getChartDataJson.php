
<?php
//  Gets the data for the chart based on the date values selected by the user
// $startDate = $_POST['startDate'];
// $endDate = $_POST['endDate'];
// die();['DAY', 'Posts', { role: 'style' } ],
//echo '["12/Jun/17",10,"color:grey"]';

$startDate = intval($_POST['startDate']);
$endDate = intval($_POST['endDate']);
$noOfDays = intval($_POST['noOfDays']);
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
	$postCount[$j] = array("day"=>$firstTimestamp,"posts"=>$count);
	$firstTimestamp = $secondTimestamp;
	$secondTimestamp = $secondTimestamp + 86400;
		
}
// echo "Printing postcount";
// var_dump($postCount);
// print_r($postCount);die();
//echo "\n".$noOfDays;
// for($i=$noOfDays ; $i>=0 ; $i--){
// 	$date->setTimestamp($postCount[$i]['day']);
// 	array_push($returnArray, [$date->format('d/M/y'),$postCount[$i]['posts'],"color:#aaa;opacity:0.7;stroke-color:#aaa;stroke-width:4"]);
// 	// echo "['".$date->format('d/M/y')."',".$postCount[$i]['posts'].",'color:#d".$i*$i."e'],";
// }
// $returnArray = json_encode($returnArray);
// print_r($returnArray);
$returnArray = array();
$returnArray['cols'] = array(
					array('id'=>'DAY' , 'label'=>'DAY' , 'type'=>'string'),
					array('id'=>'Posts', 'label'=>'Posts' , 'type'=>'number')
						);
$returnArray['rows'] = array();

// print_r($returnArray['rows']);
for($i=0 ; $i<=$noOfDays-1 ; $i++){
	$date->setTimestamp($postCount[$i]['day']);
	$returnArray['rows'][$i] = array(
									"c"=>array(
										array("v"=>$date->format('d/M/y'),"f"=>$date->format('d/M/y')),
										array("v"=>$postCount[$i]['posts'],"f"=>$postCount[$i]['posts'])
									)
								);
}
// $temp = array();
// $returnArray["p"] = array("style"=>"color:#000;stroke-width:2px;");
$returnArray = json_encode($returnArray);
print_r($returnArray);
?>