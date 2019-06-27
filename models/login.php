<?php

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
	$_SESSION['message'] = 'Login failed!';
    header("location: ../views/error.php");
}
$pass = $_POST['password'];

$query = "SELECT * FROM users WHERE email = :email";
$statement = $pdo->prepare($query);
$statement->execute(
	array(
		'email' => $email
	)
);
$count = $statement->rowCount();
if ( $count == 0 ){
    $_SESSION['message'] = "User with that email doesn't exist!";
    header("location: ../views/error.php");
} else {
	$user = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (password_verify($pass, $user[0]['password'])) {
        $_SESSION['email'] = $user[0]['email'];
        $_SESSION['username'] = $user[0]['username'];
		$_SESSION['active'] = $user[0]['active'];
		$_SESSION['notifications'] = $user[0]['notifications'];
		$_SESSION['hash'] = $user[0]['hash'];
		$_SESSION['user_id'] = $user[0]['user_id'];
        $_SESSION['logged_in'] = true;
        header("location: ../index.php");
    } else {
        $_SESSION['message'] = "Incorrect password, try again!";
        header("location: ../views/error.php");
    }
}
?>
