<?php
$host = 'localhost';
$user = 'root';
$pass = '123456';
$db = 'accounts';
$message = "";
//$mysqli = new mysqli( $host, $user, $pass,$db ) or die($mysqli->error);
try {
	$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
	$message = $error->getMessage();
}
?>
