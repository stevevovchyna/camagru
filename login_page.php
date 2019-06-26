<?php 
/* Main page with two forms: sign up and log in */
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
if (isset($_SESSION['previous'])) {
	unset($_SESSION['alert']);
}
if ( $_SESSION['logged_in'] === true ) {
	header("location: feed.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="style/login-register.css">
	<link rel="stylesheet" href="style/header-footer.css">
	<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-dark.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (isset($_POST['login'])) { //user logging in
        require 'login.php';
    }
}
?>
<body>
	<header class="sticky">
		<a href="index.php"><button>Home</button></a>
		<a href="signup_page.php"><button>Sign Up</button></a>
		<a href="feed.php"><button>Feed</button></a>
	</header>
	<div class="login-register">
	<h1>Log In</h1>
		<form action="login_page.php" method="post" autocomplete="off" class="">
			<div>
				<label>
					Email Address
				</label>
				<input type="email" required autocomplete="off" value="steve@gmail.com" name="email" />
			</div>
			<div>
				<label>
					Password
				</label>
				<input type="password" value="111" required autocomplete="off" name="password" />
			</div>
			<p><a href="forgot.php">Forgot Password?</a></p>
			<button name="login" />Log In</button>
		</form>
	</div>
</body>
</html>
