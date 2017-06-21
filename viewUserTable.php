<?php
include('conn.php');
$sql = "SELECT * from user";
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
 <!-- Bootstrap scripts end -->
</head>
<body>
<div class="container">
	<table class="table table-responsive table-striped table-bordered table-hover">
		<thead>
			<tr>
				<?php
					for($i=0;$i<count($fieldArray);$i++){
						echo "<th>".$fieldArray[$i]."</th>";
					}
				?>
			</tr>
		</thead>
		<tbody>
			<?php
				for($i=0;$i<count($dataArray);$i++){
					echo "<tr>";
						for($j=0;$j<count($dataArray[0]);$j++){
							echo "<td>".$dataArray[$i][$fieldArray[$j]]."</td>";
						}
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>
</body>