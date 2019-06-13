<?php
session_start();
// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != true ) {
	$_SESSION['message'] = "You must log in before viewing your profile page!";
	header("location: error.php");    
} else {
    // Makes it easier to read
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
	$active = $_SESSION['active'];
	$notifications = $_SESSION['notifications'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style/app.css">
	<title>Welcome, <?= $username ?></title>
</head>
<body>
	<a href="edit_profile_page.php"><button>Edit Profile</button></a>
	<a href="logout.php"><button>Log Out</button></a>
	<a href="feed.php"><button>Feed</button></a>
	<p>
	<?php 
	// Display message about account verification link only once
	if (isset($_SESSION['message'])) {
	    echo $_SESSION['message'];
	    unset($_SESSION['message']);
	}
	?>
	</p>
	<?php
    // Keep reminding the user this account is not active, until they activate
	if (!$active){
		echo '<p> Account is unverified, please confirm your email by clicking on the email link!</p>';
	} else {
		include 'frame.php';
	}
	?>
	<?php if ($active == 1) { echo '<script src="js/camera.js"></script>';} ?>
</body>

</html>
