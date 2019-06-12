<?php 
/* Main page with two forms: sign up and log in */
require 'db.php';
session_start();
?>
<!DOCTYPE html>
<html>

<head>
	<title>Sign-Up/Login Form</title>
</head>
<body>
		<ul class="tab-group">
			<li class="tab"><a href="signup_page.php">Sign Up</a></li>
			<li class="tab active"><a href="login_page.php">Log In</a></li>
		</ul>
</body>
</html>
