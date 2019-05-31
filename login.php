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
    header("location: error.php");
}
else { // User exists
	$user = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ( password_verify($_POST['password'], $user[0]['password']) ) {
        
        $_SESSION['email'] = $user[0]['email'];
        $_SESSION['first_name'] = $user[0]['first_name'];
        $_SESSION['last_name'] = $user[0]['last_name'];
        $_SESSION['active'] = $user[0]['active'];
        
        // This is how we'll know the user is logged in
        $_SESSION['logged_in'] = true;

        header("location: profile.php");
    }
    else {
        $_SESSION['message'] = "You have entered wrong password, try again!";
        header("location: error.php");
    }
}
?>
