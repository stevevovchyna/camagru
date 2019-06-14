<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
?>
<!DOCTYPE html>
<html>

<head>
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
	<div>
		<div>
			<div>
				<div>
					<a href="index.php">Home</a>
				</div>
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
					<button type="submit" name="signup" />Sign Up</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
