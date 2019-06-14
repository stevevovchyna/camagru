<?php 
/* Main page with two forms: sign up and log in */
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
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
	<div>
		<a href="index.php">Home</a>
	</div>
	<h1>Log In</h1>
	<div>
		<form action="login_page.php" method="post" autocomplete="off">
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
