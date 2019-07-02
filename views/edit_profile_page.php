<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
if ( $_SESSION['logged_in'] != true ) {
	$_SESSION['message'] = "You must log in first";
	header("location: error.php");    
}
else {
	// Makes it easier to read
	$username = $_SESSION['username'];
	$email = $_SESSION['email'];
	$active = $_SESSION['active'];
	$notifications = $_SESSION['notifications'];
	$hash = $_SESSION['hash'];
	$_SESSION['previous'] = basename($_SERVER['PHP_SELF']);
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Edit Your Profile Data</title>
		<link rel="stylesheet" href="../style/login-register.css">
		<link rel="stylesheet" href="../style/header-footer.css">
		<link rel="stylesheet" href="../style/feed.css">
		<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-dark.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="../js/feed.js"></script>
	</head>
<body>
	<header class="sticky">
		<?php
			if ($_SESSION['logged_in'] === true && $_SESSION['active'] == 1) {
				echo "<button id=\"welcome\"> Welcome, ".$_SESSION['username']."</button>";
				echo "<a href=\"../index.php\"><button>Home</button></a>";
				echo "<a href=\"../views/feed.php\"><button>Feed</button></a>";
				echo "<a href=\"../views/profile.php\"><button>My Profile</button></a>";
				echo "<a href=\"../views/logout.php\"><button>Log Out</button></a>";
			} else if ($_SESSION['logged_in'] === true && $_SESSION['active'] == 0) {
				echo "<button id=\"welcome\"> Welcome, ".$_SESSION['username']."</button>";
				echo "<a href=\"../index.php\"><button>Home</button></a>";
				echo "<a href=\"../views/feed.php\"><button>Feed</button></a>";
				echo "<a href=\"../views/logout.php\"><button>Log Out</button></a>";		
			}
		?>
	</header>
	<form action="../models/edit_profile.php" method="post" autocomplete="off" class="login-register-edit">
		<h2>Edit Your Profile Data</h2>
		<div>
			<div>
				<label>Username</label>
				<input type="text" required autocomplete="off" name='username' value="<?= $username ?>"/>
			</div>
		</div>
		<div>
			<label>Email Address</label>
			<input type="email" required autocomplete="off" name='email' value="<?= $email ?>"/>
		</div>
		<div>
			<label>Notifications</label>
			<div>
				<input type="radio" id="yes" name="notifications" value="1" <?php if ($notifications) {echo "checked";}?> >
				<label for="yes">Yes</label>
				<input type="radio" id="no" name="notifications" value="0" <?php if (!$notifications) {echo "checked";}?> >
				<label for="no">No</label>
			</div>
		</div>
		<input type="hidden" name="currentusername" value="<?= $username ?>">
		<input type="hidden" name="currentemail" value="<?= $email ?>">
		<input type="hidden" name="currentnotifications" value="<?= $notifications ?>">
		<button type="submit" name="edit" />Submit changes</button>
	</form>
	<div id="myModal" <?php if(isset($_SESSION['alert'])){echo "style=\"display: block;\"";} ?> class="modal">
		<div class="modal-content">
    		<span onclick="closeModal(this)" class="close">&times;</span>
    		<p id="message"><?php if(isset($_SESSION['alert'])){echo $_SESSION['alert']; unset($_SESSION['alert']);} ?></p>
		</div>
	</div>
	<form action="../models/reset_password.php" method="post" class="login-register-edit">
		<h2>Choose Your New Password</h2>
		<div>
			<label>New Password</label>
			<input type="password" required name="newpassword" autocomplete="off" />
		</div>
		<div>
			<label>Confirm New Password</label>
			<input type="password" required name="confirmpassword" autocomplete="off" />
		</div>
		<input type="hidden" name="email" value="<?= $email ?>">
		<input type="hidden" name="hash" value="<?= $hash ?>">
		<button class="button button-block" />Reset Password</button>
	</form>
	<?php include 'footer.php'; ?>
</body>
</html>
