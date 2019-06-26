<?php
/* Reset your password form, sends reset.php password link */
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
if (isset($_SESSION['previous'])) {
	unset($_SESSION['alert']);
}
// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) 
{   
    $email = $_POST['email'];
	$query = "SELECT * FROM users WHERE email = :email";
	$statement = $pdo->prepare($query);
	$statement->execute(
		array(
			'email' => $email
		)
	);
	$count = $statement->rowCount();
    if ( $count == 0 ) // User doesn't exist
    { 
        $_SESSION['message'] = "User with that email doesn't exist!";
        header("location: error.php");
    }
    else { // User exists (num_rows != 0)

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

        http://localhost/reset.php?email='.$email.'&hash='.$hash;  

        mail($to, $subject, $message_body);

        header("location: success.php");
  }
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>Reset Your Password</title>
	<?php include 'css/css.html'; ?>
</head>

<body>

	<div class="form">

		<h1>Reset Your Password</h1>

		<form action="forgot.php" method="post">
			<div class="field-wrap">
				<label>
					Email Address<span class="req">*</span>
				</label>
				<input type="email" required autocomplete="off" name="email" />
			</div>
			<button class="button button-block" />Reset</button>
		</form>
	</div>

	<!-- <script src="js/index.js"></script> -->
</body>

</html>
