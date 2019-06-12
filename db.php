<?php
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASSWORD = '123456';
$DB_NAME = 'camagru';
$message = "";
try {
	$pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
	$message = $error->getMessage();
}
?>
