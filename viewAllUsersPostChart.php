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
        $('#endDate').datepicker();
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
		        max: 0
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
      chart = new google.visualization.ColumnChart(document.getElementById('allUsersPostsChart'));
      chart.draw(data, options);
}

$(window).resize(function(){
	chart.draw(data,options);
	for(var i=0;i<individualUsersChartCount;i++){
		individualUsersChart[i].draw(individualUsersChartData[i],options2);
	}
});
</script>
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
</head>
<body>
<div class="jumbotron jumbo-mod">
	<h1>Admin Panel</h1>
</div>
<div id="allUsersPostsStats">
	<div class="container date-container">
		<form method="get" action="adminHome.php">
			<div class="col-md-12 center col-mod">
				<label>Start Date</label><input type="date" id="startDate" name="startDate" size="20" /><br>
			</div>
			<div class="col-md-12 center col-mod">
				<label>End Date</label><input type="date" id="endDate" name="endDate" size="20" /><br>
			</div>
			<div class="col-md-12 center col-mod">
				<input id="dateSubmit" type="Submit" value="Submit" name="dateSubmit"></p>
			</div>
		</form>
	</div>
	<div>
		<div id="allUsersPostsChart" style="height: 500px;margin: 0 auto;"></div>
	</div>
</div>
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
		// console.log(endDate);
		
        var request = $.ajax({
          url: "getChartDataJson3.php",
          method: "POST",
          data : {'startDate' : startDate , 'endDate' : endDate}
        });

        request.done(function(response){
        	// console.log(response);
        	data = new google.visualization.DataTable(response);
        	// console.log(data);
        	chart.draw(data, options);
        });
         
        request.fail(function( jqXHR, textStatus ) {
          console.log("Could not successfully complete AJAX request!");
        });
};	
</script>
</body>
</html>