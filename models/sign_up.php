<?php

/* Registration process, inserts user info into the database 
   and sends account confirmation email message
 */

// Set session variables to be used on profile.php page
$_SESSION['email'] = $_POST['email'];
$_SESSION['username'] = $_POST['username'];

$username = $_POST['username'];
$email = $_POST['email'];
$password = (password_hash($_POST['password'], PASSWORD_BCRYPT));
$hash = md5(rand(0,1000));

// Check if user with that email already exists
$query = "SELECT * FROM users WHERE email = :email";
$statement = $pdo->prepare($query);
$statement->execute(
	array(
	'email' => $email
	)
);
$count = $statement->rowCount();

$query = "SELECT * FROM users WHERE username = :username";
$statement = $pdo->prepare($query);
$statement->execute(
	array(
	'username' => $username
	)
);
$count2 = $statement->rowCount();
// We know user email exists if the rows returned are more than 0
if ( $count > 0 || $count2 > 0) {
    
    $_SESSION['message'] = 'User with this email or username already exists!';
    header("location: ../views/error.php");
    
}
else { // Email doesn't already exist in a database, proceed...

    // active is 0 by DEFAULT (no need to include it here)
	$query = "INSERT INTO users (username, email, password, hash) VALUES (:username, :email, :password, :hash)";
	$statement = $pdo->prepare($query);
	$result = $statement->execute(
		array(
			'username' => $username,
			'email' => $email,
			'password' => $password,
			'hash' => $hash
		)
	);
    // Added user to the database
    if ($result){

        $_SESSION['active'] = 0; //0 until user activates their account with verify.php
        $_SESSION['logged_in'] = true; // So we know the user has logged in
        $_SESSION['message'] =
                
                 "Confirmation link has been sent to $email, please verify
                 your account by clicking on the link in the message!";

        // Send registration confirmation link (verify.php)
        $to      = $email;
        $subject = 'Account Verification';
        $message_body = '
        Hello '.$username.',

        Thank you for signing up!

        Please click this link to activate your account:

        http://localhost:8100/models/verify.php?email='.$email.'&hash='.$hash;  

        mail($to, $subject, $message_body);

        header("location: ../views/profile.php"); 

    }
    else {
        $_SESSION['message'] = 'Registration failed!';
        header("location: ../views/error.php");
    }
}
?>
