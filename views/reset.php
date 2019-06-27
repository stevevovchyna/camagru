<?php
session_start();
if ($_SESSION['logged_in'] === true) {
	header("location: ../index.php");
}
require '../models/reset_pass_check.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../style/login-register.css">
	<link rel="stylesheet" href="../style/header-footer.css">
	<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-dark.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Reset Your Password</title>
</head>
<body>
	<div class="login-register">
		<h1>Choose Your New Password</h1>
		<form action="../models/reset_password.php" method="post">
			<div>
				<label>New Password</label>
				<input type="password" required name="newpassword" autocomplete="off" />
			</div>
			<div>
				<label>Confirm New Password</label>
				<input type="password" required name="confirmpassword" autocomplete="off" />
			</div>
			<!-- This input field is needed, to get the email of the user -->
			<input type="hidden" name="email" value="<?= $email ?>">
			<input type="hidden" name="hash" value="<?= $hash ?>">
			<button>Apply</button>
		</form>
	</div>
	<?php include 'footer.php'; ?>
</body>
</html>
