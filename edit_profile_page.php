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
  }
  ?>
<!DOCTYPE html>
<html>

<head>
	<title>Edit your profile data</title>
</head>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['edit'])) {
		if ($_POST['email'] !== $email ||
			$_POST['username'] !== $username ||
			$_POST['notifications'] !== $notifications) {
			require 'edit_profile.php';
		}
		else {
			$_SESSION['message'] = "Please change some data in order to submit changes!";
		}
    }
}
?>

<body>
	<div>
		<a href="profile.php">Back to the Profile</a>
	</div>
	<h2>Edit your Profile data</h2>
	<form action="edit_profile_page.php" method="post" autocomplete="off">
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
	<p><?=$_SESSION['message'];?></p>
	<div>
		<h2>Choose Your New Password</h2>
		<form action="reset_password.php" method="post">
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
</body>
</html>
