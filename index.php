<?php 
/* Main page with two forms: sign up and log in */
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style/index.css">
	<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-dark.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome to Camagru!</title>
</head>
<body>
	<div id="back">
		<header class="sticky">
			<a href="signup_page.php"><button>Sign Up</button></a>
			<a href="login_page.php"><button>Log In</button></a>
			<a href="feed.php"><button>Feed</button></a>
		</header>
		<p id="cama">Camagru</p>
	</div>
</body>
</html>
