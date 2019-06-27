<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
if (isset($_SESSION['previous'])) {
	unset($_SESSION['alert']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		$_SESSION['message'] = 'Invalid parameters provided for password renewal!';
		header("location: ../views/error.php");
	}
	$hash = filter_var($_POST['hash'], FILTER_SANITIZE_STRING);
	$newpassword = filter_var($_POST['newpassword'], FILTER_SANITIZE_STRING);
	$confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_STRING);

    // Make sure the two passwords match
    if ($newpassword === $confirmpassword) { 

        $new_password = password_hash($newpassword, PASSWORD_BCRYPT);
		$query = "UPDATE users SET password = :new_password WHERE email = :email AND hash = :hash";
		$statement = $pdo->prepare($query);
		$result = $statement->execute(
			array(
				'email' => $email,
				'new_password' => $new_password,
				'hash' => $hash
			)
		);
        if ($result) {
        	$_SESSION['message'] = "Your password has been reset successfully!";
        	header("location: ../views/success.php");    
        }
    }
    else {
        $_SESSION['message'] = "Two passwords you entered don't match, try again!";
        header("location: ../views/error.php");    
    }
}
?>
