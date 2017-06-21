<?php
session_start();
$_SESSION['role'] = 0;
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
		<tr><td><button id="viewOverallPosts" class="btn btn-lg btn-mod">Show Overall Posts Chart</button></td></tr>
	</table>
</div>

<script type="text/javascript">
function createUserTable(tableData){
	var isExistsDiv = document.getElementById("userTableDiv");
	if(!isExistsDiv){
		var userTableDiv = document.createElement("DIV");
		userTableDiv.setAttribute("id","userTableDiv");
		document.body.appendChild(userTableDiv);
	}
	else{
		isExistsDiv.parentNode.removeChild(isExistsDiv);
		var userTableDiv = document.createElement("DIV");
		userTableDiv.setAttribute("id","userTableDiv");
		document.body.appendChild(userTableDiv);
	}

	var isExistsTable = document.getElementById("userTable");
	if(isExistsTable)
		isExistsTable.parentNode.removeChild(isExistsTable);

	var userTableDiv = document.getElementById("userTableDiv");
	userTableDiv.setAttribute("class","container");
	var userTable = document.createElement('TABLE');
	userTable.setAttribute("id","userTable");
	userTable.setAttribute("class","table table-bordered table-striped table-hover table-responsive");
	userTable.border = 1;

	var userTableHead = document.createElement("THEAD");
	userTable.appendChild(userTableHead);
	var tr = document.createElement("TR");
	userTableHead.appendChild(tr);
	
	// var th;
	// tr.appendChild(th);
	// th.appendChild(document.createTextNode("Name"));
	
	// th = document.createElement("TH");
	// tr.appendChild(th);
	// th.appendChild(document.createTextNode("Posts"));
	
	// th = document.createElement("TH");
	// tr.appendChild(th);
	// th.appendChild(document.createTextNode("Graph for past one month"));
	// console.log(tableData);
	for(var i=0;i<tableData[0].length;i++){
		th = document.createElement("TH");
		tr.appendChild(th);
		th.appendChild(document.createTextNode(tableData[0][i]));		
	}
	
	var userTableBody = document.createElement("TBODY");
	userTable.appendChild(userTableBody);
	for(var i=0;i<tableData[1].length;i++){
		var tr = document.createElement("TR");
		userTableBody.appendChild(tr);
		for(var j=0;j<tableData[0].length;j++){
			var td = document.createElement("TD");
			tr.appendChild(td);
			td.appendChild(document.createTextNode(tableData[1][i][tableData[0][j]]));
		}	
	}	
	userTableDiv.appendChild(userTable);
	
	var closeButton = document.createElement("BUTTON");
	closeButton.appendChild(document.createTextNode("Close"));
	closeButton.setAttribute("id","closeButton");
	closeButton.setAttribute("class","btn btn-lg btn-primary");
	closeButton.setAttribute("style","margin : 30px auto;");
	userTableDiv.appendChild(closeButton);

	$("#closeButton").on("click",function(){
		userTableDiv.parentNode.removeChild(userTableDiv);
	});
}


function createUserContentTable(tableData){
	var isExistsDiv = document.getElementById("userContentTableDiv");
	if(!isExistsDiv){
		var userContentTableDiv = document.createElement("DIV");
		userContentTableDiv.setAttribute("id","userContentTableDiv");
		document.body.appendChild(userContentTableDiv);
	}
	else{
		isExistsDiv.parentNode.removeChild(isExistsDiv);
		var userContentTableDiv = document.createElement("DIV");
		userContentTableDiv.setAttribute("id","userContentTableDiv");
		document.body.appendChild(userContentTableDiv);
	}

	var isExistsTable = document.getElementById("userContentTable");
	if(isExistsTable)
		isExistsTable.parentNode.removeChild(isExistsTable);

	var userContentTableDiv = document.getElementById("userContentTableDiv");
	userContentTableDiv.setAttribute("class","container");
	var userContentTable = document.createElement('TABLE');
	userContentTable.setAttribute("id","userContentTable");
	userContentTable.setAttribute("class","table table-bordered table-condensed table-striped table-hover");
	userContentTable.border = 1;

	var userContentTableHead = document.createElement("THEAD");
	userContentTable.appendChild(userContentTableHead);
	var tr = document.createElement("TR");
	userContentTableHead.appendChild(tr);
	
	// var th;
	// tr.appendChild(th);
	// th.appendChild(document.createTextNode("Name"));
	
	// th = document.createElement("TH");
	// tr.appendChild(th);
	// th.appendChild(document.createTextNode("Posts"));
	
	// th = document.createElement("TH");
	// tr.appendChild(th);
	// th.appendChild(document.createTextNode("Graph for past one month"));
	// console.log(tableData);
	for(var i=0;i<tableData[0].length;i++){
		th = document.createElement("TH");
		tr.appendChild(th);
		th.appendChild(document.createTextNode(tableData[0][i]));		
	}
	
	var userContentTableBody = document.createElement("TBODY");
	userContentTable.appendChild(userContentTableBody);
	for(var i=0;i<tableData[1].length;i++){
		var tr = document.createElement("TR");
		userContentTableBody.appendChild(tr);
		for(var j=0;j<tableData[0].length;j++){
			var td = document.createElement("TD");
			tr.appendChild(td);
			td.appendChild(document.createTextNode(tableData[1][i][tableData[0][j]]));
		}	
	}	
	userContentTableDiv.appendChild(userContentTable);
	
	var closeButton = document.createElement("BUTTON");
	closeButton.appendChild(document.createTextNode("Close"));
	closeButton.setAttribute("id","closeButton");
	closeButton.setAttribute("class","btn btn-lg btn-primary");
	closeButton.setAttribute("style","margin : 30px auto;");
	userContentTableDiv.appendChild(closeButton);

	$("#closeButton").on("click",function(){
		userContentTableDiv.parentNode.removeChild(userContentTableDiv);
	});
}
</script>
<script type="text/javascript">
$(document).ready(function(){
	$('#addAdmin').click(function(){

	});
	$('#viewUserTable').click(function(){
		console.log("Cli");
		var request = $.ajax({
			url : 'viewUserTable.php',
			method : 'POST'
		});

		request.done(function(response){	
			response = JSON.parse(response);
			createUserTable(response);
		});

		request.fail(function(jqXHR, textStatus){
			console.log("AJAX request could not be completed successfully!");
		});
	});
	$('#viewContentTable').click(function(){
		var request = $.ajax({
			url : 'viewUserContentTable.php',
			method : 'POST'
		});

		request.done(function(response){	
			console.log(response);
			response = JSON.parse(response);
			createUserContentTable(response);
		});

		request.fail(function(jqXHR, textStatus){
			console.log("AJAX request could not be completed successfully!");
		});
	});		
	$('#viewTopPosts').click(function(){
		
	});
	$('#viewOverallPosts').click(function(){
		
	});
});
</script>
</body>
</html>