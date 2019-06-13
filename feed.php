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
	}?>
	<div class="feed-container">
		<?php 
		$query = "SELECT * FROM posts";
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
				$disabled = "disabled";
			}
			else {
				$disabled = "";
			}
			echo "<p>Post by ".$postik['username']."</p>";
			echo "<img src=\"".$postik['post_url']."\">";
			if ($_SESSION['logged_in'] == true) {
				echo "<button ".$disabled." name=\"".$postik['post_id']."\" onclick=\"like(this)\" class=\"like-button\"><span>".$count."</span> likes</button>";
				echo "<textarea rows=\"3\"></textarea>";
				echo "<button class=\"comment-button\">Submit Comment</button>";
			} else {
				echo "<button class=\"like-button\"><span>".$count."</span> likes</button>";
			}			
		}
		?>
	</div>
	<script src="js/feed.js"></script>
</body>
</html>
