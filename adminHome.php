<?php
session_start();
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
<!-- <script type="text/javascript">
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
</script> -->
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
	.table-container{
		width: auto;
	}
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
		border: 0px;
	}
	.btn-mod{
		border-radius: 0px;
		width: 100%;
		height: 60px;
		font-size: 22px;
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
<!-- <script type="text/javascript">
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

$("#dateSubmit").on("click", function(event){
        event.preventDefault();
        changeDateValues();
});


</script> -->
</head>
<body>
<div class="jumbotron jumbo-mod">
	<h1>Admin Panel</h1>
</div>
<!-- If super admin give the following option -->
<div class="container table-container" style="width: 25%;">
	<table class="table table-responsive text-center">
		<?php if($_SESSION['role'] == 0) { ?>
			<tr><td><button id="addAdmin" class="btn btn-lg btn-mod">Add Admin</button></td></tr>
		<?php } ?>
		<tr><td><button id="viewUserTable" class="btn btn-lg btn-mod">View User Table</button></td></tr>
		<tr><td><button id="viewContentTable" class="btn btn-lg btn-mod">View User Content Table</button></td></tr>
		<tr><td><button id="viewTopPosts" class="btn btn-lg btn-mod">Show Top Posts Chart</button></td></tr>
		<tr><td><button id="viewAllUsersPostChart" class="btn btn-lg btn-mod">Show Overall Posts Chart</button></td></tr>
	</table>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('#addAdmin').click(function(){
		window.location.href = "addAdmin.php";
	});
	$('#viewUserTable').click(function(){
		window.location.href = "viewUserTable.php";
	});
	$('#viewContentTable').click(function(){
		window.location.href = "viewUserContentTable.php";
	});		
	$('#viewTopPosts').click(function(){
		window.location.href = "viewTopUserPostsChart.php";
	});
	$('#viewAllUsersPostChart').click(function(){
		window.location.href = "viewAllUsersPostChart.php";
	});
});
</script>
</body>
</html>