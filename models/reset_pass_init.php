<?php
/* Reset your password form, sends reset.php password link */
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
if (isset($_SESSION['previous'])) {
	unset($_SESSION['alert']);
}

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
	$_SESSION['message'] = 'Login failed!';
    header("location: ../views/error.php");
}
$query = "SELECT * FROM users WHERE email = :email";
$statement = $pdo->prepare($query);
$statement->execute(
	array(
		'email' => $email
	)
);
$count = $statement->rowCount();
if ( $count == 0 ) { 
    $_SESSION['message'] = "User with that email doesn't exist!";
    header("location: ../views/error.php");
} else {
	$user = $statement->fetchAll(PDO::FETCH_ASSOC); // $user becomes array with user data

	$email = $user[0]['email'];
	$hash = $user[0]['hash'];
	$first_name = $user[0]['first_name'];
	// Session message to display on success.php
	$_SESSION['message'] = "Please check your email $email"
	. " for a confirmation link to complete your password reset!";
	// Send registration confirmation link (reset.php)
	$to      = $email;
	$subject = 'Password Reset Link';
	$message_body = '
	Hello '.$first_name.',
	You have requested password reset!
	Please click this link to reset your password:
	http://localhost:8100/views/reset.php?email='.$email.'&hash='.$hash;  
	mail($to, $subject, $message_body);
	header("location: ../views/success.php");
}

?>
