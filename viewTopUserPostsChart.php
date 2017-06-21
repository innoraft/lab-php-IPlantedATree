<?php
include('conn.php');

date_default_timezone_set("Asia/Kolkata");
$date  = new DateTime();
$monthDiff = 2592000; //number of seconds in one month
$hours = $date->format('h');
$minutes = $date->format('i');
$seconds = $date->format('s');
$subVal = $hours*60*60 + $minutes*60 + $seconds-1;
$date->setTimestamp($date->getTimestamp()-$monthDiff-$subVal);
$startDate = $date->getTimestamp();

$sql = "SELECT fb_id,count(timestamp) AS no_of_posts from userContent WHERE timestamp >= $startDate Group By fb_id Order by count(timestamp) DESC";
$rs = $conn->query($sql);
$row = mysqli_fetch_assoc($rs);
$maxPosts = $row['no_of_posts'];
?>
<?php
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

$sql = "SELECT user.fb_id, user.fb_name,count(id)
		FROM userContent,user
		WHERE user.fb_id=userContent.fb_id AND timestamp >= $startDate
		GROUP BY fb_id
		ORDER BY count(id) DESC
";

if($number > 0)
	$sql .= " LIMIT ".$number;

$rs = $conn->query($sql);

$fieldArray = array();
$i = 0;
while ($i < mysqli_num_fields($rs)){
   $field = mysqli_fetch_field_direct($rs, $i);
   array_push($fieldArray,$field->name);
   $i++;
}
$i = 0;
$dataArray = array();
while($row = mysqli_fetch_assoc($rs)){
	array_push($dataArray, $row);
	$i++;
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
  	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <!-- Bootstrap scripts end -->
<script type="text/javascript">
function getSingleUserPostData(id){
	// console.log(id);
	var request = $.ajax({
						url : 'getSingleUserPostData.php?fb_id='+id,
						method : 'POST',
						data : {'id' : id}
					});

	request.done(function(response){
		// response = JSON.parse(response);
		// console.log(response);
		individualUsersChartData[individualUsersChartCount] = new google.visualization.DataTable(response);
		// console.log(data);
      	individualUsersChart[individualUsersChartCount] = new google.visualization.BarChart(document.getElementById(id));
      	individualUsersChart[individualUsersChartCount].draw(individualUsersChartData[individualUsersChartCount], options2);	
      	individualUsersChartCount++;
	});

    request.fail(function( jqXHR, textStatus ) {
        console.log("Could not successfully complete AJAX request!");
    });	
}
</script>

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
        $('#endDate').datepicker();
    })
}
</script>
<!-- Date Picker Script -->
<style type="text/css">
	.center{
		text-align: center;
	}
	.date-container{
		margin-top: 20px;
	}
	.jumbo-mod{
		background-color: orange;
	}	
	.jumbo-mod h1{
		text-align: center;
	}
	.col-mod{
		margin-bottom: 10px;
	}
	#singleUserPostStats{
		/*display: none;*/
	}
	#allUsersPostsStats{
		
	}
	.graph-cell{
		width:800px;
		height:300px;
		border:1px solid #000;
	}
	@media only screen and (max-width:992px){
		.graph-cell{
			width: 600px;
		}
	}
	@media only screen and (max-width:768px){
		.graph-cell{
			width: 400px;
		}
	}
	@media only screen and (max-width:640px){
		.graph-cell{
			width: 350px;
		}
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("#dateSubmit").on("click", function(event){
	        event.preventDefault();
	        changeDateValues();
	});	
});

</script>
<script type="text/javascript">
 google.charts.load('current', {packages: ['corechart']});
var data;
var options;
var allUsersPostsChart;
var individualUsersChart = new Array();
var individualUsersChartCount = 0;
var individualUsersChartData = new Array();
var options2 = {
        title: 'User Posts v/s Time',
        annotations: {
          alwaysOutside: true,
          textStyle: {
            fontSize: 14,
            color: '#eee',
            auraColor: 'none',
          },
        },
        hAxis : {
		    viewWindow: {
		        min: 0,
		        max: <?php echo $maxPosts;?>
		    }
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
</script>
<script type="text/javascript">
function getMaxPosts(){
	var request = $.ajax({
						url : 'getMaxPosts.php',
						method : 'POST',
						data : {'startDate':startDate , 'endDate' : endDate}
					});

	request.done(function(response){
		options2.hAxis.viewWindow.max = parseInt(response);
	});

    request.fail(function( jqXHR, textStatus ) {
        console.log("Could not successfully complete AJAX request!");
    });	
}

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
	th.appendChild(document.createTextNode("Graph for past one month"));

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
				var userGraphDiv = document.createElement("div");
				userGraphDiv.setAttribute("id" , tableData[i]['id']);
				userGraphDiv.setAttribute("class" , "graph-cell");
				getSingleUserPostData(tableData[i]['id']);
				td.appendChild(userGraphDiv);
			}
		}	
	}	
	topUsersTableDiv.appendChild(topUsersTable);
}

function getNewTopStats(){
	var request = $.ajax({
					url : 'getTopUsersData.php',
					method : 'POST',
					data : {'topPostsNumber': topPostsNumber , 'startDate':startDate,'endDate' : endDate}
				});

	
	request.done(function(response){
		response = JSON.parse(response);
		getMaxPosts();
		createTable(response);
	});
    
    request.fail(function( jqXHR, textStatus ) {
        console.log("Could not successfully complete AJAX request!");
    });

}

function getSingleUserPostData(id){
	var request = $.ajax({
						url : 'getSingleUserPostData.php?fb_id='+id,
						method : 'POST',
						data : {'id' : id, 'startDate':startDate,'endDate':endDate}
					});

	request.done(function(response){
		// console.log(response);
		individualUsersChartData[individualUsersChartCount] = new google.visualization.DataTable(response);
      	individualUsersChart[individualUsersChartCount] = new google.visualization.BarChart(document.getElementById(id));
      	individualUsersChart[individualUsersChartCount].draw(individualUsersChartData[individualUsersChartCount], options2);	
      	individualUsersChartCount++;
	});

    request.fail(function( jqXHR, textStatus ) {
        console.log("Could not successfully complete AJAX request!");
    });	
}



var startDate;
var endDate;
var topPostsNumber;
function changeDateValues(){
		startDate = document.getElementById("startDate").value;
		endDate = document.getElementById("endDate").value;
		topPostsNumber = document.getElementById("topPostsNumber").value;

		var dateComponentArray =  startDate.split("-");
		startDate = dateComponentArray[1] + "-" + dateComponentArray[2] + "-" + dateComponentArray[0];
		startDate = new Date(startDate).getTime()/1000;
		startDate += 5*60*60 + 30*60;
		
		dateComponentArray = endDate.split("-");

		endDate = dateComponentArray[1] + "-" + dateComponentArray[2] + "-" + dateComponentArray[0];
		endDate = new Date(endDate).getTime()/1000;
		endDate += 5*60*60 + 30*60 + 86399; //86399 because posts till midnight of endDate are considered
		getNewTopStats();
};	


</script>
</head>
<body>
	<div class="container date-container">
		<form id="topUsers">
			<div class="col-md-12 center col-mod">
				<label>Start Date</label><input type="date" id="startDate" name="startDate" size="20" /><br>
			</div>
			<div class="col-md-12 center col-mod">
				<label>End Date</label><input type="date" id="endDate" name="endDate" size="20" /><br>
			</div>
			<div class="col-md-12 center col-mod">
				<label>Enter number of users : </label><input id="topPostsNumber" type="number" name="topPostsNumber" >
			</div>
			<div class="col-md-12 center col-mod">
				<input id="dateSubmit" type="Submit" value="Submit" name="dateSubmit"></p>
			</div>
		</form>
	</div>
	<div id="topUsersTableDiv"></div>
</body>
</html>