<?php
$id = $_POST['id'];
include('conn.php');
$sql = "UPDATE user
		SET role=1
		WHERE fb_id= $id
		";

if($conn->query($sql))
	echo '1';
else
	echo '0';
?>