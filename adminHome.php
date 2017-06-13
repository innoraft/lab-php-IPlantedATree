
<?php

$date = new DateTime();
$currTime = $date->getTimestamp();
$currHours =  $date->format('H');
$currMins = $date->format('i');
$currSeconds = $date->format('s');
$prevWeekTimestamp = $currTime - ($currHours*60*60 + $currMins*60 + $currSeconds + 518400); //518400=no of seconds in 6 days
//$prevWeekTimestamp gets timestamp one week ago from 00:00 hours.
$date->setTimestamp($prevWeekTimestamp);
// $timeStampArray = array("7" => $prevWeekTimestamp + 0 * 86400,"6" => $prevWeekTimestamp + 1 * 86400,"5" => $prevWeekTimestamp + 2 * 86400,"4" => $prevWeekTimestamp + 3 * 86400, "3" => $prevWeekTimestamp + 4 * 86400, "2" => $prevWeekTimestamp +  5 * 86400, "1" => $prevWeekTimestamp + 6 * 86400);
// $i = 1;

?>
<?php
include('conn.php');
$sql = "SELECT timestamp from userContent WHERE timestamp >= $prevWeekTimestamp
 ORDER BY timestamp ASC";
$rs = $conn->query($sql);
$day = 2;
$firstTimestamp = $prevWeekTimestamp;
$secondTimestamp = $firstTimestamp + 86400;
$count=0;
$noOfDays = 6;
$timeStampArray = array();

// if(mysqli_num_rows($rs) = 0)

while($row = mysqli_fetch_array($rs)){
	array_push($timeStampArray,$row['timestamp']);
}

$arrayPos = 0;
$posted = false;
$postCount = array();
for($j=$noOfDays; $j>=0; $j--){
	$count = 0;
	while(($timeStampArray[$arrayPos]>=$firstTimestamp) && ($timeStampArray[$arrayPos]<$secondTimestamp) && ($arrayPos<sizeof($timeStampArray)-1)){
		$posted = true;
		$count++;
		$arrayPos++;
	}
	$postCount[$j] = array("day"=>$firstTimestamp,"posts"=>$count);
	$firstTimestamp = $secondTimestamp;
	$secondTimestamp = $secondTimestamp + 86400;
}
// $row = mysqli_fetch_array($rs);
// echo ($row['timestamp']);
// var_dump($timeStampArray);
/*
2nd attempt
for($i=7; $i>=1; $i--){
	echo "First = ".$firstTimestamp."  Second = ".$secondTimestamp."<br>";
	$flagChanged = 0;
	while($row = mysqli_fetch_array($rs)){
		$flagChanged = 1;
		if(($row['timestamp'] >= $firstTimestamp) && ($row['timestamp'] < $secondTimestamp)){
			$count++;
		}
		else{
			$timeStampArray[$i] = array("day"=>$firstTimestamp,"posts"=>$count);
			break;
		}
	}

	if($flagChanged == 0){
		$timeStampArray[$i] = array("day"=>$firstTimestamp,"posts"=>0);
	}
	$firstTimestamp = $secondTimestamp;
	$secondTimestamp = $firstTimestamp + 86400;
	mysqli_data_seek($rs,0);
	$count = 0;		
}
*/

/* main code
while($row = mysqli_fetch_array($rs)){
	// $x = $date->setTimestamp($firstTimestamp);
	// echo $x->format("d/M/y")."<br>";
	if(($row['timestamp'] >= $firstTimestamp) && ($row['timestamp'] <= $secondTimestamp)){
		$count++;
	}
	else{
		$days = $date->setTimestamp($firstTimestamp);
		$timeStampArray[$i] = array("day"=>$days->getTimestamp(),"posts"=>$count);
		var_dump($timeStampArray[$i]);
		$count = 1; //since $row['timestamp'] is already equal to the next value
		$day++;
		$firstTimestamp = $secondTimestamp;
		$secondTimestamp = $prevWeekTimestamp + ($day) * 86400;
		$i--;
	}
}

if($i > 1){
	while($i >= 1){
		$days = $date->setTimestamp($firstTimestamp);
		$days->format('d/M/y');
		$timeStampArray[$i] = array("day"=>$days->format('d/m/y'),"posts"=>0);
		// echo $i." = ".$timeStampArray[$i]["day"]."<br>";
		// $timeStampArray[$i] = array("day"=>$firstTimestamp,"posts"=>0);
		$day++;
		$firstTimestamp = $secondTimestamp;
		$secondTimestamp = $prevWeekTimestamp + ($day) * 86400;
		$i--;
	}
}
var_dump($timeStampArray);
*/
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Home</title>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Date Picker Scripts -->
<script type="text/javascript">
    var datefield=document.createElement("input");
    datefield.setAttribute("type", "date");
    if (datefield.type!="date"){ //if browser doesn't support input type="date", load files for jQuery UI Date Picker
        document.write('<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />\n');
        document.write('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"><\/script>\n');
        document.write('<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"><\/script>\n');
    }
</script>
 
<script>
if (datefield.type!="date"){ //if browser doesn't support input type="date", initialize date picker widget:
    jQuery(function($){ //on document.ready
        $('#startDate').datepicker();
    })
}
</script>
<!-- Date Picker Script -->

<script type="text/javascript">
  google.charts.load('current', {packages: ['corechart']});
  google.charts.setOnLoadCallback(drawChart);

 function drawChart() {
      var data = google.visualization.arrayToDataTable([
      	['Week', 'Posts', { role: 'style' } ],
      	<?php
			for($i=$noOfDays ; $i>=0 ; $i--){
				$date->setTimestamp($postCount[$i]['day']);
				echo "['".$date->format('d/M/y')."',".$postCount[$i]['posts'].",'color:#d".$i*$i."e'],";
			}
      	?>
        // ['Week', 'Posts', { role: 'style' } ],
        // ['2010', 10, 'color: gray'],
        // ['2020', 14, 'color: #76A7FA'],
        // ['2030', 16, 'opacity: 0.2'],
        // ['2040', 22, 'stroke-color: #703593; stroke-width: 4; fill-color: #C5A5CF'],
        // ['2050', 28, 'stroke-color: #871B47; stroke-opacity: 0.6; stroke-width: 8; fill-color: #BC5679; fill-opacity: 0.2']
      ]);
 var options = {
        title: 'ALL USERS POSTS STATS',
        annotations: {
          alwaysOutside: true,
          textStyle: {
            fontSize: 14,
            color: '#000',
            auraColor: 'none'
          }
        },
        hAxis: {
          title: 'DAY OF WEEK',
          format: 'h:mm a',
          viewWindow: {
            min: [7, 30, 0],
            max: [17, 30, 0]
          }
        },
        vAxis: {
          title: 'NUMBER OF POSTS'
        }
      };

      // Instantiate and draw the chart.
      var chart = new google.visualization.ColumnChart(document.getElementById('myPieChart'));
      chart.draw(data, options);
}

$(window).resize(function(){
	drawChart();
});
</script>
</head>
<body>

<div id="myPieChart" style="height: 500px;margin: 0 auto;"></div>
<form method="get" action="adminHome.php">
	<label>Start Date</label><input type="date" id="startDate" name="startDate" size="20" /><br>
	<label>End Date</label><input type="date" id="endDate" name="endDate" size="20" /><br>
	<input type="submit" value="Submit" name="submit"></p>
</form>
<script type="text/javascript">

</script>
</body>
</html>