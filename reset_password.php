<?php
/* Password reset process, updates database with new user password */
require 'db.php';
session_start();

// Make sure the form is being submitted with method="post"
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

    // Make sure the two passwords match
    if ( $_POST['newpassword'] == $_POST['confirmpassword'] ) { 

        $new_password = password_hash($_POST['newpassword'], PASSWORD_BCRYPT);
        
        // We get $_POST['email'] from the hidden input field of reset.php form
        $email = $_POST['email'];
		$hash = $_POST['hash'];
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
        	header("location: success.php");    
        }
    }
    else {
        $_SESSION['message'] = "Two passwords you entered don't match, try again!";
        header("location: error.php");    
    }
}
?>
