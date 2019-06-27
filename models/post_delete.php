<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();

$postID = $_POST['post_id'];

$query = "DELETE FROM likes WHERE post_id = :post_id";
$statement = $pdo->prepare($query);
$result = $statement->execute(
	array(
		'post_id' => $postID
	)
);

$query = "DELETE FROM comments WHERE post_id = :post_id";
$statement = $pdo->prepare($query);
$result = $statement->execute(
	array(
		'post_id' => $postID
	)
);

$query = "DELETE FROM posts WHERE post_id = :post_id";
$statement = $pdo->prepare($query);
$result = $statement->execute(
	array(
		'post_id' => $postID
	)
);
?>
