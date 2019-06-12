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
	<a href="index.php">,<button>Home</button></a>
	<div class="feed-container">
		<?php 
		$query = "SELECT post_url FROM posts";
		$statement = $pdo->prepare($query);
		$statement->execute();		
		$post = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($post as $postik) {
			echo "<img src=\"".$postik['post_url']."\">";
		}		
		?>
	</div>
</body>
</html>
