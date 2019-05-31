<?php
$host = 'localhost';
$user = 'root';
$pass = '123456';
$db = 'accounts';
$mysqli = new mysqli( $host, $user, $pass,$db ) or die($mysqli->error);
?>
