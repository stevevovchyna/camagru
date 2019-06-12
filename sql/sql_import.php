<?php

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
if ( !$mysqli->query('CREATE DATABASE accounts') ) {
    printf("Error: %s\n", $mysqli->error);
}

//creating users table

// $mysql->query('CREATE TABLE `accounts`.`users` 
// (
//     `id` INT NOT NULL AUTO_INCREMENT,
//     `first_name` VARCHAR(50) NOT NULL,
//     `last_name` VARCHAR(50) NOT NULL,
//     `email` VARCHAR(100) NOT NULL,
//     `password` VARCHAR(100) NOT NULL,
//     `hash` VARCHAR(32) NOT NULL,
//     `active` BOOL NOT NULL DEFAULT 0,
// PRIMARY KEY (`id`) 
// );') or die($mysqli->error);


$mysql->query('CREATE TABLE `accounts`,`users`
(
`id` int(20) NOT NULL AUTO_INCREMENT,
`email` VARCHAR(255) NOT NULL,
`username` VARCHAR(25) NOT NULL,
`password` VARCHAR(255) NOT NULL,
`hash` VARCHAR(32) NOT NULL,
`active` BOOL NOT NULL DEFAULT 0,
PRIMARY KEY (`id`)
);') or die($mysql->error);


?>
