<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '123456');
define('DB_NAME', 'accounts');

$pdoOptions = array(
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
);

try {
	$pdo = new PDO(
		"mysql:host=" . DB_HOST . ";dbname=" . DB_NAME ,
		DB_USER,
		DB_PASS,
		$pdoOptions
	);
} catch (PDOException $e){
	echo "Connection failed: " . $e->getMessage();
}
// $mysqli = new mysqli( $host, $user, $pass,$db ) or die($mysqli->error);
?>
