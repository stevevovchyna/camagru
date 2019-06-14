<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();

$commentID = $_POST['commentID'];

$query = "DELETE FROM comments WHERE comment_id = :comment_id";
$statement = $pdo->prepare($query);
$result = $statement->execute(
	array(
		'comment_id' => $commentID
	)
);
?>
