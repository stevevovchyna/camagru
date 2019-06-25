<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style/app.css">
	<link rel="stylesheet" href="style/index.css">
	<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-dark.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Camagru</title>
</head>
<body>
	<header class="sticky">
		<?php
			if ( $_SESSION['logged_in'] === true ) {
				echo "<button> Welcome, ".$_SESSION['username']."</button>";
				echo "<a href=\"feed.php\"><button>Feed</button></a>";
				echo "<a href=\"profile.php\"><button>My Profile</button></a>";
				echo "<a href=\"logout.php\"><button>Log Out</button></a>";
			} else {
				echo "<a href=\"signup_page.php\"><button>Sign Up</button></a>";
				echo "<a href=\"login_page.php\"><button>Log In</button></a>";
				echo "<a href=\"feed.php\"><button>Feed</button></a>";
			}
		?>
	</header>
	<div class="feed-container">
		<?php

		$no_of_records_per_page = 3;
		$query = "SELECT * FROM posts";
		$statement = $pdo->prepare($query);
		$statement->execute();		
		$post = $statement->fetchAll(PDO::FETCH_ASSOC);
		$row_count = $statement->rowCount();
		$total_pages = ceil($row_count / $no_of_records_per_page);
		
		if (isset($_GET['pageno'])) {
			$pageno = $_GET['pageno'];
			if ($pageno <= 0)
				$pageno = 1;
			else if ($pageno > $total_pages)
				$pageno = $total_pages;
		} else {
			$pageno = 1;
		}
		$offset = ($pageno - 1) * $no_of_records_per_page;

		$query = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.user_id ORDER BY posts . date_created DESC LIMIT ".$offset. ", ".$no_of_records_per_page;
		$statement = $pdo->prepare($query);
		$statement->execute();		
		$post = $statement->fetchAll(PDO::FETCH_ASSOC);
		$row_count = $statement->rowCount();
		foreach ($post as $postik) {
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

			//POST LABEL
			echo "<div class=\"post\">";
			echo "<p class=\"author\">Post by ".$postik['username']." created on ".$postik['date_created']."</p>";
			echo "<img src=\"".$postik['post_url']."\">";

			if ($_SESSION['logged_in'] == true) {
				echo "<button name=\"".$postik['post_id']."\" onclick=\"".$like."\" class=\"like-button\"><span>".$count.$likeword."</button>";
				echo "<textarea id=\"".$postik['post_id']."\" rows=\"3\"></textarea>";
				echo '<button name="' .$postik['post_id']. '" type="button" onclick="submitComment(this)" class="comment-button">Submit Comment</button>';

				$query = "SELECT * FROM comments INNER JOIN users ON comments.user_id = users.user_id WHERE post_id = :post_id";
				$statement = $pdo->prepare($query);
				$statement->execute(
					array(
						'post_id' => $post_id
					)
				);
				$fetch_comment = $statement->fetchAll(PDO::FETCH_ASSOC);

				echo '<div class="comment" id="comment'.$post_id.'">';
				foreach ($fetch_comment as $comment) {
					echo "<div class=\"comment-block\" id=\"comment-block".$comment['comment_id']."\">";
					echo "<div onclick=\"showDelButton(this)\" id=\"".$comment['comment_id']."\">".$comment['content']." by ".$comment['username']."</div>";
					if ($comment['username'] === $_SESSION['username']) {
						echo "<button class=\"small hidden delete-button".$comment['comment_id']."\" id=\"".$comment['comment_id']."\" onclick=\"deleteComment(this)\">Delete</button>";
					}
					echo "</div>";
				}
				echo '</div>';
			} else {
				echo "<button class=\"like-button\"><span>".$count."</span> likes</button>";
			}
			echo "</div>";		
		}
		?>
		<form action="feed.php" method="get">
			<div class="row paginator">
				<button class="col-sm" <?php if($pageno <= 1) { echo "disabled";} ?> name="pageno" value="1">Start</button>
				<button class="col-sm" <?php if($pageno <= 1) {echo "disabled";} ?> name="pageno" value="<?php echo $pageno - 1 ?>">Previous</button>
				<button class="col-sm" <?php if($pageno >= $total_pages) {echo "disabled";} ?> name="pageno" value="<?php echo $pageno + 1 ?>">Next</button>
				<button class="col-sm" <?php if($pageno >= $total_pages) {echo "disabled";} ?> name="pageno" value="<?php echo $total_pages; ?>">End</button>
			</div>
		</form>
	</div>
	<script src="js/feed.js"></script>
</body>
</html>
