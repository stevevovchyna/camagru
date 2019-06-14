<?php
include 'db.php';
session_start();
date_default_timezone_set("Europe/Kiev");

$postID = $_POST['postID'];
$userID = $_SESSION['user_id'];
$content = $_POST['content'];
$date = date("Y-m-d H:i:s");
$username = $_SESSION['username'];


$query = "INSERT INTO comments (post_id, user_id, content, date_created) VALUES (:post_id, :user_id, :content, :date_created)";
$statement = $pdo->prepare($query);
$statement->execute(
	array(
		'user_id' => $userID,
		'post_id' => $postID,
		'content' => $content,
		'date_created' => $date
	)
);
$query = "SELECT LAST_INSERT_ID()";
$statement = $pdo->prepare($query);
$statement->execute();
$arr = $statement->fetchAll(PDO::FETCH_ASSOC);
if ($arr) {
	header('Content-Type: application/json');
    die(json_encode(array(
		'content' => $content,
		'username' => $username,
		'comment_id' => $arr[0]['LAST_INSERT_ID()']
    )));
}
?>