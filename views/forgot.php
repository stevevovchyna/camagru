<?php
session_start();
if ($_SESSION['logged_in'] === true) {
	$_SESSION['message'] = "I bet you don't need this page rigth now";
	header("location: ../index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../style/login-register.css">
	<link rel="stylesheet" href="../style/header-footer.css">
	<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-dark.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Reset Your Password</title>
</head>
<body>
	<header class="sticky">
		<a href="index.php"><button>Home</button></a>
		<a href="signup_page.php"><button>Sign Up</button></a>
		<a href="login_page.php"><button>Log In</button></a>
		<a href="feed.php"><button>Feed</button></a>
	</header>
	<div class="login-register">
		<h1>Reset Your Password</h1>
		<form action="../models/reset_pass_init.php" method="post">
			<div>
				<label>Email Address</label>
				<input type="email" required autocomplete="off" name="email" />
			</div>
			<button>Reset</button>
		</form>
	</div>
	<?php include 'footer.php'; ?>
</body>
</html>
