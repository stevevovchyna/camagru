<?php
//   VERIFY.PHP
/* Verifies registered user email, the link to this page
   is included in the register.php email message 
*/
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();

// Make sure email and hash variables aren't empty
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
{
    $email = $_GET['email']; 
    $hash = $_GET['hash'];
    
    // Select user with matching email and hash, who hasn't verified their account yet (active = 0)
    $query = "SELECT * FROM users WHERE email = :email AND hash = :hash AND active = '0'";
	$statement = $pdo->prepare($query);
	$statement->execute(
		array(
			'email' => $email,
			'hash' => $hash
		)
	);
	$count = $statement->rowCount();
    if ($count == 0)
    { 
        $_SESSION['message'] = "Account has already been activated or the URL is invalid!";
        header("location: error.php");
    }
    else {
        $_SESSION['message'] = "Your account has been activated!";
        // Set the user status to active (active = 1)
		$query = "UPDATE users SET active = '1' WHERE email = :email";
		$statement = $pdo->prepare($query);
		$statement->execute(
			array(
				'email' => $email
			)
		);		
        $_SESSION['active'] = 1;
        header("location: success.php");
    }
}
else {
    $_SESSION['message'] = "Invalid parameters provided for account verification!";
    header("location: error.php");
}     

?>
