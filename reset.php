<?php
/* The password reset form, the link to this page is included
   from the forgot.php email message
*/
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
if (isset($_SESSION['previous'])) {
	unset($_SESSION['alert']);
}

// Make sure email and hash variables aren't empty
if( isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
{
    $email = $_GET['email'];
    $hash = $_GET['hash']; 
    // Make sure user email with matching hash exist
	$query = "SELECT * FROM users WHERE email = :email AND hash = :hash";
	$statement = $pdo->prepare($query);
	$statement->execute(
		array(
			'email' => $email,
			'hash' => $hash
		)
	);
	$count = $statement->rowCount();
    if ( $count == 0 )
    { 
        $_SESSION['message'] = "You have entered invalid URL for password reset!";
        header("location: error.php");
    }
}
else {
    $_SESSION['message'] = "Sorry, verification failed, try again!";
    header("location: error.php");  
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style/login-register.css">
	<link rel="stylesheet" href="style/header-footer.css">
	<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-dark.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Reset Your Password</title>
</head>
<body>
	<div class="login-register">
		<h1>Choose Your New Password</h1>
		<form action="reset_password.php" method="post">
			<div>
				<label>
					New Password
				</label>
				<input type="password" required name="newpassword" autocomplete="off" />
			</div>
			<div>
				<label>
					Confirm New Password
				</label>
				<input type="password" required name="confirmpassword" autocomplete="off" />
			</div>
			<!-- This input field is needed, to get the email of the user -->
			<input type="hidden" name="email" value="<?= $email ?>">
			<input type="hidden" name="hash" value="<?= $hash ?>">
			<button>Apply</button>
		</form>
	</div>
</body>
</html>
