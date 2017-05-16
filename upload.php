<?php
session_start();


$fileName = $_SESSION['fileName'];
$target_file = $_SESSION['target_file'];
header('location:post.php?tagged_friends='.$_POST['tagged_friends'].'&fileName='.$fileName.'&description='.urlencode($_POST['description']));
echo "Hello";
die();
?>