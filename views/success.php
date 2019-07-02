<?php
session_start();
if (isset($_SESSION['previous'])) {
	unset($_SESSION['alert']);
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../style/index.css">
	<link rel="stylesheet" href="../style/header-footer.css">
	<link rel="stylesheet" href="../style/login-register.css">
	<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-dark.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<title>Success</title>
</head>

<body>
	<div id="back">
		<header class="sticky logout-header"></header>
		<p id="logout"><?php 
			if(isset($_SESSION['message']) && !empty($_SESSION['message'])) {
				echo $_SESSION['message'];
				unset($_SESSION['message']);
			} else {
				header("location: ../index.php");
			}
    	?></p>
		<div id="home-button">
			<a href="../index.php"><button>Home</button></a>
		</div>
	</div>
	<?php include 'footer.php'; ?>
</body>
</html>
