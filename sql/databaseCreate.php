<?php
$servername = "localhost"; //Enter servername here
$username = "root"; //Enter username here
$password = "1234"; //Enter password here

$conn = mysqli_connect($servername, $username, $password);

$sql = "CREATE DATABASE IF NOT EXISTS treeplant";
if(mysqli_query($conn,$sql))
	echo "Success creating database\n.";
else 
	echo mysql_error($conn);

$sql = 'CREATE TABLE IF NOT EXISTS treeplant.user(
	fb_name VARCHAR(50) NOT NULL,
	fb_id BIGINT(64) UNSIGNED NOT NULL,
	fb_profile_pic_path VARCHAR(100) NOT NULL
);';
if(mysqli_query($conn,$sql))
	echo "Success creating user table.\n";
else 
	echo mysqli_error($conn);

$sql = 'CREATE TABLE IF NOT EXISTS treeplant.userContent(
	id BIGINT(32) AUTO_INCREMENT,
	fb_id BIGINT(64) UNSIGNED NOT NULL,
	description VARCHAR(200),
	picture_url VARCHAR(100) NOT NULL,
	post_id VARCHAR(100),
	PRIMARY KEY(id)
);';
if(mysqli_query($conn,$sql))
	echo "Success creating userContent table.\n";
else
 echo mysqli_error($conn);
?>