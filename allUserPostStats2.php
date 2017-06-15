
<?php

$date = new DateTime();
$currTime = $date->getTimestamp();
$currHours =  $date->format('H');
$currMins = $date->format('i');
$currSeconds = $date->format('s');
$prevWeekTimestamp = $currTime - ($currHours*60*60 + $currMins*60 + $currSeconds + 518400); //518400=no of seconds in 6 days
//$prevWeekTimestamp gets timestamp one week ago from 00:00 hours.
$date->setTimestamp($prevWeekTimestamp);


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
var data;
var options;
var chart;


 function drawChart() {
      data = google.visualization.arrayToDataTable([
      	['DAY', 'Posts'],
      	[0,0]
   //    	<?php
			// for($i=$noOfDays ; $i>=0 ; $i--){
			// 	$date->setTimestamp($postCount[$i]['day']);
			// 	echo "['".$date->format('d/M/y')."',".$postCount[$i]['posts'].",'color:#0".$i."f'],";
			// }
   //    	?>
        
      ]);
// ['Week', 'Posts', { role: 'style' } ],
//         ['2010', 10, 'color: gray'],
        // ['2020', 14, 'color: #76A7FA'],
        // ['2030', 16, 'opacity: 0.2'],
        // ['2040', 22, 'stroke-color: #703593; stroke-width: 4; fill-color: #C5A5CF'],
        // ['2050', 28, 'stroke-color: #871B47; stroke-opacity: 0.6; stroke-width: 8; fill-color: #BC5679; fill-opacity: 0.2']
 options = {
        title: 'ALL USERS POSTS STATS',
        annotations: {
          alwaysOutside: true,
          textStyle: {
            fontSize: 14,
            color: '#eee',
            auraColor: 'none',
          },
        },
        hAxis: {
          title: 'DAY OF WEEK'
        },
        vAxis: {
          title: 'NUMBER OF POSTS'
        },
         animation : {
         		startup : true,
            	duration:1000,
            	easing:'linear'
            }
      };
      
      // Instantiate and draw the chart.
      chart = new google.visualization.ColumnChart(document.getElementById('myChart'));
      chart.draw(data, options);
}

$(window).resize(function(){
	chart.draw(data,options);
});
</script>
</head>
<body>
<form method="get" action="adminHome.php">
	<label>Start Date</label><input type="date" id="startDate" name="startDate" size="20" /><br>
	<label>End Date</label><input type="date" id="endDate" name="endDate" size="20" /><br>
	<input type="submit" value="Submit" name="submit"></p>
</form>
<div id="myChart" style="height: 500px;margin: 0 auto;"></div>

<script type="text/javascript">

$("input[type='submit']").on("click", function(event){
        event.preventDefault();
        changeDateValues();
    });

</script>
<script type="text/javascript">
function changeDateValues(){
		var startDate = document.getElementById("startDate").value;
		var endDate = document.getElementById("endDate").value;
		var noOfDays = 0;// = endDate.getDate() - startDate.getDate();

		var dateComponentArray =  startDate.split("-");
		noOfDays -= parseInt(dateComponentArray[2]);
		startDate = dateComponentArray[1] + "-" + dateComponentArray[2] + "-" + dateComponentArray[0];
		startDate = new Date(startDate).getTime()/1000;
		startDate += 5*60*60 + 30*60;
		
		dateComponentArray = endDate.split("-");
		noOfDays += parseInt(dateComponentArray[2]) + 1; // since noOfDays = -startDay
		console.log(noOfDays);

		endDate = dateComponentArray[1] + "-" + dateComponentArray[2] + "-" + dateComponentArray[0];
		endDate = new Date(endDate).getTime()/1000;
		endDate += 5*60*60 + 30*60 + 86399; //86399 because posts till midnight of endDate are considered
		console.log(endDate);
		
        var request = $.ajax({
          url: "getChartDataJson2.php",
          method: "POST",
          data : {'startDate' : startDate , 'endDate' : endDate , 'noOfDays' : noOfDays}
        });

        request.done(function(response){
        	console.log(response);
        	data = new google.visualization.DataTable(response);
        	console.log(data);
        	chart.draw(data, options);
        });
         
        request.fail(function( jqXHR, textStatus ) {
          console.log("Could not successfully complete AJAX request!");
        });
};	
</script>
</body>
</html>