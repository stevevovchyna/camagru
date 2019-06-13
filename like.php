<?php
include 'db.php';
session_start();

$postID = $_POST['postID'];
$userID = $_SESSION['user_id'];

$query = "INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)";
$statement = $pdo->prepare($query);
$result = $statement->execute(
	array(
		'user_id' => $userID,
		'post_id' => $postID
	)
);

$query = "SELECT * FROM likes WHERE post_id = :post_id";
$statement = $pdo->prepare($query);
$statement->execute(
	array(
		'post_id' => $postID
	)
);
$count = $statement->rowCount();
echo $count;
?>
