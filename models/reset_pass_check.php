<?php

require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
if (isset($_SESSION['previous'])) {
	unset($_SESSION['alert']);
}
	// Make sure email and hash variables aren't empty
	if( isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
	{

		$email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			$_SESSION['message'] = 'Invalid parameters provided for password reset!';
			header("location: ../views/error.php");
		}
		$hash = filter_var($_GET['hash'], FILTER_SANITIZE_STRING);
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
			header("location: ../views/error.php");
		}
	}
	else {
		$_SESSION['message'] = "Sorry, verification failed, try again!";
		header("location: ../views/error.php");  
	}
?>
