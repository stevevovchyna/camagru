<?php
$servername = "localhost";
$username = "root";
$password = "123456";

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE camagru";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Database created successfully<br>";
} catch(PDOException $e) {
	echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASSWORD = '123456';
$DB_NAME = 'camagru';
$message = "failure!";
try {
	$pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = "CREATE TABLE users (user_id int(20) NOT NULL AUTO_INCREMENT, email VARCHAR(255) NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(255) NOT NULL, hash VARCHAR(32) NOT NULL, active BOOL NOT NULL DEFAULT 0, notifications BOOL NOT NULL DEFAULT 1, PRIMARY KEY (user_id))";
	$pdo->exec($query);
	$query = "CREATE TABLE posts (post_id int(20) NOT NULL AUTO_INCREMENT, user_id int(20) NOT NULL, post_url VARCHAR(255) NOT NULL, date_created DATETIME NOT NULL, PRIMARY KEY (post_id), FOREIGN KEY (user_id) REFERENCES users(user_id))";
	$pdo->exec($query);
	$query = "CREATE TABLE likes (like_id int(20) NOT NULL AUTO_INCREMENT, user_id int(20) NOT NULL, post_id int(20) NOT NULL, PRIMARY KEY (like_id), FOREIGN KEY (user_id) REFERENCES users(user_id), FOREIGN KEY (post_id) REFERENCES posts(post_id))";
	$pdo->exec($query);
	$query = "CREATE TABLE comments (comment_id INT(20) NOT NULL AUTO_INCREMENT, post_id INT(20) NOT NULL, user_id INT(20) NOT NULL, content TEXT NOT NULL, date_created DATETIME NOT NULL, PRIMARY KEY (comment_id), FOREIGN KEY (post_id) REFERENCES posts(post_id), FOREIGN KEY (user_id) REFERENCES users(user_id))";	
	$pdo->exec($query);
	echo "SUCCESS!!! Tables created!!!";
} catch (PDOException $error) {
	$message = $error->getMessage();
	echo $message;
}
?>




