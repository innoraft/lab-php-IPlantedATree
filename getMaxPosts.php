<?php
include('conn.php');

date_default_timezone_set("Asia/Kolkata");

$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$sql = "SELECT fb_id,count(timestamp) AS no_of_posts from userContent WHERE timestamp >= $startDate AND timestamp <= $endDate Group By fb_id Order by count(timestamp) DESC";
$rs = $conn->query($sql);
$row = mysqli_fetch_assoc($rs);
echo $row['no_of_posts'];
?>