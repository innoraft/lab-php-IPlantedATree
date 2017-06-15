<?php

// include("conn.php");
// $sql = "INSERT INTO userContent values";
// for($i=205;$i<1900;$i++){
// 	$time = 1494374400 + 1100*$i;
// 	$sql .= "($i,1234,'False values','False values',12312312323,$time),";
	
// }
// $sql = substr($sql,0,-1);
// $conn->query($sql);
// echo $conn->error;

// $sql = "DELETE FROM userContent where id>205";
// $conn->query($sql);
// echo $conn->error;

$date1 = new DateTime();
$date1->setTimestamp(1497517055);
echo $date1->format('d/m/y')."<br>";

$date2 = new DateTime();
$date2->setTimestamp(1497200000);
echo $date2->format('d/m/y')."<br>";

$diff = date_diff($date1,$date2,true);
$noOfDays = $diff->d + 2;
echo $noOfDays;
/*$noOfDays =  $diff->format("<br>%R%a");
// $noOfDays = intval($noOfDays);
echo "<br>".$noOfDays;
*/
?>