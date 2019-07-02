<?php
$post_id = $postik['post_id'];
// CHECKING THE NUMBER OF LIKES
$query = "SELECT * FROM likes WHERE post_id = :post_id";
$statement = $pdo->prepare($query);
$statement->execute(
	array(
		'post_id' => $post_id
	)
);
$count = $statement->rowCount();


// CHECKING IF THERE'S A LIKE FROM THE CURRENT USER ALREADY

$query = "SELECT * FROM likes WHERE user_id = :user_id AND post_id = :post_id";
$statement = $pdo->prepare($query);
$statement->execute(
	array(
		'user_id' => $_SESSION['user_id'],
		'post_id' => $post_id
	)
);
$count2 = $statement->rowCount();
$like = $count2 > 0 ? "unlike(this)" : "like(this)";
$likeword = $count === 1 ? " like" : " likes";
?>
