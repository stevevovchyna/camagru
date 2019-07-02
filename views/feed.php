<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
if (isset($_SESSION['previous'])) {
	unset($_SESSION['alert']);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../style/feed.css">
	<link rel="stylesheet" href="../style/header-footer.css">
	<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-dark.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Camagru</title>
</head>
<body>
	<header class="sticky">
		<?php if ( $_SESSION['logged_in'] === true && $_SESSION['active'] == 1) { ?>
			<button id="welcome"> Welcome, <?= $_SESSION['username'] ?> </button>
			<a href="../index.php"><button>Home</button></a>
			<a href="profile.php"><button>My Profile</button></a>
			<a href="edit_profile_page.php"><button>Edit Profile</button></a>
			<a href="logout.php"><button>Log Out</button></a>
		<?php } else if ($_SESSION['logged_in'] === true && $_SESSION['active'] == 0) { ?>
				<a href="../index.php"><button>Home</button></a>
				<a href="edit_profile_page.php"><button>Edit Profile</button></a>
				<a href="logout.php"><button>Log Out</button></a>
		<?php } else { ?>
				<a href="../index.php"><button>Home</button></a>
				<a href="signup_page.php"><button>Sign Up</button></a>
				<a href="login_page.php"><button>Log In</button></a>
		<?php } ?>

	</header>
	<div class="feed-container">
		<?php

		require $_SERVER['DOCUMENT_ROOT'] . '/models/pagination.php';

		$query = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.user_id ORDER BY posts.date_created DESC LIMIT ".$offset. ", ".$no_of_records_per_page;
		$statement = $pdo->prepare($query);
		$statement->execute();		
		$post = $statement->fetchAll(PDO::FETCH_ASSOC);
		$row_count = $statement->rowCount();


		foreach ($post as $postik) {
			include $_SERVER['DOCUMENT_ROOT'] . '/models/feed_post_query.php';
		?>
			<!-- POST LABEL -->
			<div class="post card">
				<div <?php if ( $_SESSION['logged_in'] === true && $_SESSION['active'] == 1) { echo 'onclick="show_more_button(this)"';}?>  class="image-container">
					<img src="../<?= $postik['post_url'] ?>">
					<div class="overlay">
						<p class="author">@<?= $postik['username'] ?> on <?= date("F j, Y, g:i a", strtotime($postik['date_created'])) ?> / <?= $count.$likeword ?></p>
					</div>
				</div>
		<?php if ($_SESSION['logged_in'] == true && $_SESSION['active'] == 1) { ?>

				<div class="info hidden">
					<button name="<?= $postik['post_id'] ?>" onclick="<?= $like ?>" class="like-button small secondary"><span><?= $count.$likeword ?></span></button>
					<hr>

			<?php	
				$query = "SELECT * FROM comments INNER JOIN users ON comments.user_id = users.user_id WHERE post_id = :post_id";
				$statement = $pdo->prepare($query);
				$statement->execute(
					array(
						'post_id' => $post_id
					)
				);
				$fetch_comment = $statement->fetchAll(PDO::FETCH_ASSOC);
			?>

				<div class="comment" id="comment<?=$post_id?>">
		<?php	foreach ($fetch_comment as $comment) { ?>
				
				<div class="comment-block" id="comment-block<?= $comment['comment_id']?>">
				<div class="comment-body" onclick="showDelButton(this)" id="<?= $comment['comment_id'] ?>"><span class="comment-author"><?= $comment['username'] ?>: </span><span class="comment-content"><?= $comment['content']?></span> <span class="comment-date">on <?= date("F j, Y, g:i a", strtotime($comment['date_created'])); ?></span></div>
			<?php	if ($comment['username'] === $_SESSION['username']) { ?>
						<button class="small hidden del-button delete-button<?= $comment['comment_id']?>" id="<?= $comment['comment_id']?>" onclick="deleteComment(this)">Delete</button>
			<?php	} ?>
					</div>
		<?php	} ?>
				</div>
				<textarea required id="<?= $postik['post_id']?>" rows="3"></textarea>
				<button name="<?= $postik['post_id'] ?>" type="button" onclick="submitComment(this)" class="comment-button">Submit Comment</button>
				</div>
	<?php	} ?>
			</div>	
<?php	} ?>
	</div>
	<div id="myModal" class="modal">
	<div class="modal-content">
    	<span onclick="closeModal(this)" class="close">&times;</span>
    	<p id="message"></p>
  	</div>
</div>
	<footer class="sticky">
		<form action="feed.php" method="get" class="paginator">
			<div class="row paginator">
				<button class="col-sm" <?php if($pageno <= 1) { echo "disabled";} ?> name="pageno" value="1">Start</button>
				<button class="col-sm" <?php if($pageno <= 1) {echo "disabled";} ?> name="pageno" value="<?php echo $pageno - 1 ?>">Previous</button>
				<button class="col-sm" <?php if($pageno >= $total_pages) {echo "disabled";} ?> name="pageno" value="<?php echo $pageno + 1 ?>">Next</button>
				<button class="col-sm" <?php if($pageno >= $total_pages) {echo "disabled";} ?> name="pageno" value="<?php echo $total_pages; ?>">End</button>
			</div>
		</form>
	</footer>
	<script src="../js/feed.js"></script>
</body>
</html>
