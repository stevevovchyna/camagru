<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();

$postID = $_POST['post_id'];

$query = "SELECT post_url FROM posts WHERE post_id = :post_id";
$statement = $pdo->prepare($query);
$statement->execute(
	array(
		'post_id' => $postID
	)
);
$file_to_delete = $statement->fetchAll(PDO::FETCH_ASSOC);
unlink($file_to_delete[0]['post_url']);

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
