
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
<!-- Bootstrap scripts -->
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <!-- Bootstrap scripts end -->
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
       ]);


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
      // chart = new google.visualization.ColumnChart(document.getElementById('allUsersPostsChart'));
      // chart.draw(data, options);
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
	<input id="dateSubmit" type="Submit" value="Submit" name="dateSubmit"></p>
</form>
<div>
	<div id="allUsersPostsChart" style="height: 500px;margin: 0 auto;"></div>
</div>
<div style="margin-top: 100px;border-top: 1px solid #000;">
	<form id="topUsers">
		<input id="topPostsNumber" type="number" name="topPostsNumber" >
		<input id="submitTopPosts" type="submit" name="submitTopPosts">
	</form>	
	<div id="topUsersTableDiv" class="container"></div>
</div>




<script type="text/javascript">
$("#submitTopPosts").on("click",function(event){
	event.preventDefault();
	getNewTopStats();
});
</script>

<script type="text/javascript">

function createTable(tableData){
	var isExistsTable = document.getElementById("topUsersTable");
	if(isExistsTable)
		isExistsTable.parentNode.removeChild(isExistsTable);

	var topUsersTableDiv = document.getElementById("topUsersTableDiv");
	var topUsersTable = document.createElement('TABLE');
	topUsersTable.setAttribute("id","topUsersTable");
	topUsersTable.setAttribute("class","table table-bordered table-striped table-hover table-responsive");
	topUsersTable.border = 1;

	var topUsersTableHead = document.createElement("THEAD");
	topUsersTable.appendChild(topUsersTableHead);
	var tr = document.createElement("TR");
	topUsersTableHead.appendChild(tr);
	
	var th = document.createElement("TH");
	tr.appendChild(th);
	th.appendChild(document.createTextNode("Name"));
	
	th = document.createElement("TH");
	tr.appendChild(th);
	th.appendChild(document.createTextNode("Posts"));
	
	th = document.createElement("TH");
	tr.appendChild(th);
	th.appendChild(document.createTextNode("Graph"));

	var topUsersTableBody = document.createElement("TBODY");
	topUsersTable.appendChild(topUsersTableBody);

	for(var i=0;i<tableData.length;i++){
		var tr = document.createElement("TR");
		topUsersTableBody.appendChild(tr);

		for(var j=0;j<3;j++){
			var td = document.createElement("TD");
			tr.appendChild(td);
			if(j == 0)
				td.appendChild(document.createTextNode(tableData[i]['name']));
			else if(j == 1)
				td.appendChild(document.createTextNode(tableData[i]['posts']));
			else if(j == 2){
				td.height = "80px";
				var userGraphDiv = document.createElement("div");
				userGraphDiv.setAttribute("id" , tableData[i]['id']);
				getSingleUserPostData(tableData[i]['id']);
				td.appendChild(userGraphDiv);
				// td.appendChild(document.createTextNode(tableData[i]['id']));
			}
		}	
	}	
	topUsersTableDiv.appendChild(topUsersTable);
}

function getSingleUserPostData(id){
	console.log(id);
	var request = $.ajax({
						url : 'getSingleUserPostData.php?fb_id='+id,
						method : 'POST',
						data : {'id' : id}
					});

	request.done(function(response){
		// response = JSON.parse(response);
		data = new google.visualization.DataTable(response);
      	var chart = new google.visualization.BarChart(document.getElementById(id));
      	chart.draw(data, options);		
	});

    request.fail(function( jqXHR, textStatus ) {
        console.log("Could not successfully complete AJAX request!");
    });	
}

function getNewTopStats(){
	var topPostsNumber = document.getElementById("topPostsNumber").value;
	var request = $.ajax({
					url : 'getTopUsersData.php',
					method : 'POST',
					data : {'topPostsNumber': topPostsNumber}
				});

	
	request.done(function(response){
		console.log(response);
		response = JSON.parse(response);
		// console.log(response);
		createTable(response);
	});
    
    request.fail(function( jqXHR, textStatus ) {
        console.log("Could not successfully complete AJAX request!");
    });

}
</script>










<script type="text/javascript">

$("#dateSubmit").on("click", function(event){
        event.preventDefault();
        changeDateValues();
    });

</script>
<script type="text/javascript">
function changeDateValues(){
		var startDate = document.getElementById("startDate").value;
		var endDate = document.getElementById("endDate").value;

		var dateComponentArray =  startDate.split("-");
		startDate = dateComponentArray[1] + "-" + dateComponentArray[2] + "-" + dateComponentArray[0];
		startDate = new Date(startDate).getTime()/1000;
		startDate += 5*60*60 + 30*60;
		
		dateComponentArray = endDate.split("-");

		endDate = dateComponentArray[1] + "-" + dateComponentArray[2] + "-" + dateComponentArray[0];
		endDate = new Date(endDate).getTime()/1000;
		endDate += 5*60*60 + 30*60 + 86399; //86399 because posts till midnight of endDate are considered
		console.log(endDate);
		
        var request = $.ajax({
          url: "getChartDataJson3.php",
          method: "POST",
          data : {'startDate' : startDate , 'endDate' : endDate}
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