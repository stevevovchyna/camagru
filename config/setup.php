<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
//connection vars
$host = 'localhost';
$user = 'root';
$password = '123456';

//creating myssql connection
$mysqli = new mysqli($host,$user,$password);
if ($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_error);
    die();
}

// database creation
if ( !$mysqli->query('CREATE DATABASE camagru') ) {
    printf("Error: %s\n", $mysqli->error);
}

$mysql->query('CREATE TABLE `users`
(
`user_id` int(20) NOT NULL AUTO_INCREMENT,
`email` VARCHAR(255) NOT NULL,
`username` VARCHAR(25) NOT NULL,
`password` VARCHAR(255) NOT NULL,
`hash` VARCHAR(32) NOT NULL,
`active` BOOL NOT NULL DEFAULT 0,
`notifications` BOOL NOT NULL DEFAULT 1,
PRIMARY KEY (`user_id`)
);') or die($mysql->error);

$mysql->query('CREATE TABLE `posts`(
	`post_id` int(20) NOT NULL AUTO_INCREMENT,
	`user_id` int(20) NOT NULL,
	`post_url` VARCHAR(255) NOT NULL,
	`date_created` DATE NOT NULL,
	PRIMARY KEY (`post_id`),
	FOREIGN KEY (`user_id`) REFERENCES users(`user_id`)
	);') or die($mysql->error);

$mysql->query('CREATE TABLE `likes` (
	`like_id` int(20) NOT NULL AUTO_INCREMENT,
	`user_id` int(20) NOT NULL,
	`post_id` int(20) NOT NULL,
	PRIMARY KEY (`like_id`),
	FOREIGN KEY (`user_id`) REFERENCES users(`user_id`),
	FOREIGN KEY (`post_id`) REFERENCES posts(`post_id`)
);') or die($mysql->error);


$mysql->query('CREATE TABLE comments(
	`comment_id` INT(20) NOT NULL AUTO_INCREMENT,
	`post_id` INT(20) NOT NULL,
	`user_id` INT(20) NOT NULL,
	`content` TEXT NOT NULL,
	`date_created` DATETIME NOT NULL,
	PRIMARY KEY (`comment_id`),
	FOREIGN KEY (`post_id`) REFERENCES posts(`post_id`),
	FOREIGN KEY (`user_id`) REFERENCES users(`user_id`)
);') or die($mysql->error);

?>




