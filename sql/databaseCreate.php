<?php
include('../assets/config/databaseConfig.php');

$conn = mysqli_connect($servername, $username, $password);

$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if(mysqli_query($conn,$sql))
	echo "Success creating database\n.";
else 
	echo mysql_error($conn);

$sql = 'CREATE TABLE IF NOT EXISTS '.$dbName.'.user(
	fb_name VARCHAR(50) NOT NULL,
	fb_id BIGINT(64) UNSIGNED NOT NULL,
	role TINYINT(1) UNSIGNED DEFAULT 2
);';
if(mysqli_query($conn,$sql))
	echo "Success creating user table.\n";
else 
	echo mysqli_error($conn);

$sql = 'CREATE TABLE IF NOT EXISTS '.$dbName.'.userContent(
	id BIGINT(32) AUTO_INCREMENT,
	fb_id BIGINT(64) UNSIGNED NOT NULL,
	description varchar(500),
	picture_url VARCHAR(100) NOT NULL,
	post_id VARCHAR(100),
	timestamp INT(12) NOT NULL,
	PRIMARY KEY(id)
);';
if(mysqli_query($conn,$sql))
	echo "Success creating userContent table.\n";
else
 echo mysqli_error($conn);
?>