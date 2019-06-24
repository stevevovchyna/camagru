<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
?>
<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="style/login-register.css">
	<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-dark.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign Up</title>
</head>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['signup'])) {
        require 'sign_up.php';
    }
}
?>

<body>
	<div class="login-register">
		<h1>Sign Up</h1>
		<form action="signup_page.php" method="post" autocomplete="off">
			<div>
				<div>
					<label>
						How should we call you?
					</label>
					<input type="text" required autocomplete="off" name='username' />
				</div>
			</div>
			<div>
				<label>
					Email Address
				</label>
				<input type="email" required autocomplete="off" name='email' />
			</div>
			<div>
				<label>
					Password
				</label>
				<input type="password" required autocomplete="off" name='password' />
			</div>
			<button class="inverse" type="submit" name="signup" />Sign Up</button>
			<button><a href="index.php">Home</a></button>
		</form>
	</div>
</body>
</html>
