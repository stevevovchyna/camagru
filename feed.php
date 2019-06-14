<?php
require 'db.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style/app.css">
	<title>Camagru</title>
</head>
<body>
	<a href="index.php"><button>Home</button></a>
	<?php 
		if ($_SESSION['logged_in'] == true) {
			echo "<a href=\"profile.php\"><button>My Profile</button></a>"; 
			echo "<a href=\"logout.php\"><button>Log Out</button></a>";
			echo "<p>Welcome, ".$_SESSION['username']."</p>";
	}?>
	<div class="feed-container">
		<?php 
		
		$query = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.user_id ORDER BY posts . date_created DESC";
		$statement = $pdo->prepare($query);
		$statement->execute();		
		$post = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($post as $postik) {
			$post_id = $postik['post_id'];
			$query = "SELECT * FROM likes WHERE post_id = :post_id";
			$statement = $pdo->prepare($query);
			$statement->execute(
				array(
					'post_id' => $post_id
				)
			);
			$count = $statement->rowCount();

			$query = "SELECT * FROM likes WHERE user_id = :user_id AND post_id = :post_id";
			$statement = $pdo->prepare($query);
			$statement->execute(
				array(
					'user_id' => $_SESSION['user_id'],
					'post_id' => $post_id
				)
			);
			$count2 = $statement->rowCount();
			if ($count2 > 0) {
				$like = "unlike(this)";
			}
			else {
				$like = "like(this)";
			}

			echo "<p class=\"author\">Post by ".$postik['username']." created on ".$postik['date_created']."</p>";
			echo "<img src=\"".$postik['post_url']."\">";
			if ($_SESSION['logged_in'] == true) {
				echo "<button name=\"".$postik['post_id']."\" onclick=\"".$like."\" class=\"like-button\"><span>".$count."</span> likes</button>";
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
					echo "<div id=\"comment-block".$comment['comment_id']."\">";
					echo "<div id=\"".$comment['comment_id']."\">".$comment['content']." by ".$comment['username']."</div>";
					if ($comment['username'] === $_SESSION['username']) {
						echo "<button id=\"".$comment['comment_id']."\" onclick=\"deleteComment(this)\">Delete</button>";
					}
					echo "</div>";
				}
				echo '</div>';
			} else {
				echo "<button class=\"like-button\"><span>".$count."</span> likes</button>";
			}			
		}
		?>
	</div>
	<script src="js/feed.js"></script>
</body>
</html>
