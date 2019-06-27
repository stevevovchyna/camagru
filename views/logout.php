<?php
/* Log out process, unsets and destroys session variables */
session_start();
if ( $_SESSION['logged_in'] !== true ) {
	header("location: ../index.php");
}
session_unset();
session_destroy(); 
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../style/index.css">
	<link rel="stylesheet" href="../style/header-footer.css">
	<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-dark.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>See ya!</title>
</head>
<body>
	<div id="back">
		<header class="sticky logout-header"></header>
		<p id="logout">You have been logged out!</p>
		<div id="home-button">
			<a href="../index.php"><button>Home</button></a>
		</div>
	</div>
	<?php include 'footer.php'; ?>
</body>
</html>
