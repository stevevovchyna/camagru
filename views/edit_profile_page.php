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
		<title>Edit your profile data</title>
		<link rel="stylesheet" href="../style/login-register.css">
		<link rel="stylesheet" href="../style/header-footer.css">
		<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-dark.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['edit'])) {
		if ($_POST['email'] !== $email ||
			$_POST['username'] !== $username ||
			$_POST['notifications'] !== $notifications) {
			require $_SERVER['DOCUMENT_ROOT'] . '/models/edit_profile.php';
		}
		else {
			$_SESSION['alert'] = "Please edit some data in order to submit changes!";
		}
    }
}
?>
<body>
	<header class="sticky">
		<?php
			if ( $_SESSION['logged_in'] === true ) {
				echo "<button> Welcome, ".$_SESSION['username']."</button>";
				echo "<a href=\"../index.php\"><button>Home</button></a>";
				echo "<a href=\"../views/feed.php\"><button>Feed</button></a>";
				echo "<a href=\"../views/profile.php\"><button>My Profile</button></a>";
				echo "<a href=\"../views/logout.php\"><button>Log Out</button></a>";
			}
		?>
	</header>

	<form action="edit_profile_page.php" method="post" autocomplete="off" class="login-register-edit">
		<h2>Edit your Profile data</h2>
		<div>
			<div>
				<label>
					Username
				</label>
				<input type="text" required autocomplete="off" name='username' value="<?= $username ?>"/>
			</div>
		</div>
		<div>
			<label>
				Email Address
			</label>
			<input type="email" required autocomplete="off" name='email' value="<?= $email ?>"/>
		</div>
		<div>
			<label>
				Notifications
			</label>
			<div>
				<input type="radio" id="yes" name="notifications" value="1" <?php if ($notifications) {echo "checked";}?> >
				<label for="yes">Yes</label>
				<input type="radio" id="no" name="notifications" value="0" <?php if (!$notifications) {echo "checked";}?> >
				<label for="no">No</label>
			</div>
		</div>
		<button type="submit" name="edit" />Submit changes</button>
	</form>
	<span class="editing-toast toast <?php if(!isset($_SESSION['alert']) || $_SESSION['alert'] === ""){echo "hidden";}?>"><?=$_SESSION['alert']?></span>
	<div>
		<form action="../models/reset_password.php" method="post" class="login-register-edit">
			<h2>Choose Your New Password</h2>
			<div>
				<label>
					New Password
				</label>
				<input type="password" required name="newpassword" autocomplete="off" />
			</div>
			<div>
				<label>
					Confirm New Password
				</label>
				<input type="password" required name="confirmpassword" autocomplete="off" />
			</div>
			<button class="button button-block" />Reset Password</button>
		</form>
	</div>
	<?php include 'footer.php'; ?>
</body>
</html>
