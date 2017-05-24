<?php
session_start();
$logoutUrl = $_SESSION['logoutUrl'];
$_SESSION = array();
header('location:'.$logoutUrl);
?>