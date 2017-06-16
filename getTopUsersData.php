<?php

include("conn.php");
$number = $_POST['topPostsNumber'];
$sql = "SELECT user.fb_id, user.fb_name,count(id)
		FROM userContent,user
		WHERE user.fb_id=userContent.fb_id 
		GROUP BY fb_id
		ORDER BY count(id) DESC
";

if($number > 0)
	$sql .= " LIMIT ".$number;

$rs = $conn->query($sql);

$i = 0;
$fbId = array();

while($row = mysqli_fetch_assoc($rs)){
	$fbId[$i]['name'] = $row['fb_name'];
	$fbId[$i]['id'] = $row['fb_id'];
	$fbId[$i]['posts'] = $row['count(id)'];
	$i++;
}

$sql = "SELECT fb_id,fb_name from user WHERE fb_id IN(";
for($i=0;$i<count($fbId);$i++){
	$sql .= $fbId[$i]['id'].",";
}
$sql = substr($sql,0,-1);
$sql .= ")";

$rs = $conn->query($sql);
$conn->error;
$i = 0;


echo json_encode($fbId);

?>

