<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
if (isset($_SESSION['previous'])) {
	unset($_SESSION['alert']);
}
// Check if user is logged in using the session variable
if ($_SESSION['logged_in'] != true) {
	$_SESSION['message'] = "You must log in before viewing your profile page!";
	header("location: error.php");    
} else if ($_SESSION['logged_in'] === true && $_SESSION['active'] == 0){
	$_SESSION['message'] = "Please activate your account first!";
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
	<link rel="stylesheet" href="../style/index.css">
	<link rel="stylesheet" href="../style/profile.css">
	<link rel="stylesheet" href="../style/header-footer.css">
	<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-dark.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome, <?= $username ?></title>
</head>
<body>
	<header class="sticky">
		<?php
			if ($_SESSION['logged_in'] === true) {
				echo "<a href=\"../index.php\"><button>Home</button></a>";
				echo "<a href=\"feed.php\"><button>Feed</button></a>";
				echo "<a href=\"edit_profile_page.php\"><button>Edit Profile</button></a>";
				echo "<a href=\"logout.php\"><button>Log Out</button></a>";
			}
		?>
	</header>
	<?php include 'frame.php'; ?>
	<script src="../js/camera.js"></script>
	<?php include 'footer.php'; ?>
	</body>
</html>
