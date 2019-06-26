<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
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

$query = "SELECT email, username, notifications FROM users INNER JOIN posts ON users.user_id = posts.user_id WHERE posts.post_id = :post_id";
$statement = $pdo->prepare($query);
$statement->execute(
	array(
		'post_id' => $postID
	)
);		
$email = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($email[0]['notifications'] == 1) {
	$to      = $email[0]['email'];
	$subject = "You've got a new comment!";
	$message_body = "Hi there, ".$email[0]['username']."! You have just received a new comment '".$content."' in Camagru! Go check it out!"; 
	mail($to, $subject, $message_body);
}
		
$query = "SELECT LAST_INSERT_ID()";
$statement = $pdo->prepare($query);
$statement->execute();
$arr = $statement->fetchAll(PDO::FETCH_ASSOC);
if ($arr) {
	header('Content-Type: application/json');
    die(json_encode(
			array(
				'content' => $content,
				'username' => $username,
				'comment_id' => $arr[0]['LAST_INSERT_ID()'],
				'testik' => $message_body
			)
		)
	);
}
?>
