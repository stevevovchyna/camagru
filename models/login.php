<?php
/* User login process, checks if user exists and password is correct */

// Escape email to protect against SQL injections
$email = $_POST['email'];
$query = "SELECT * FROM users WHERE email = :email";
$statement = $pdo->prepare($query);
$statement->execute(
	array(
		'email' => $email
	)
);
$count = $statement->rowCount();
if ( $count == 0 ){ // User doesn't exist
    $_SESSION['message'] = "User with that email doesn't exist!";
    header("location: ../views/error.php");
}
else { // User exists
	$user = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ( password_verify($_POST['password'], $user[0]['password']) ) {
        $_SESSION['email'] = $user[0]['email'];
        $_SESSION['username'] = $user[0]['username'];
		$_SESSION['active'] = $user[0]['active'];
		$_SESSION['notifications'] = $user[0]['notifications'];
		$_SESSION['hash'] = $user[0]['hash'];
		$_SESSION['user_id'] = $user[0]['user_id'];
        
        // This is how we'll know the user is logged in
        $_SESSION['logged_in'] = true;

        header("location: ../index.php");
    }
    else {
        $_SESSION['message'] = "Incorrect password, try again!";
        header("location: ../views/error.php");
    }
}
?>
