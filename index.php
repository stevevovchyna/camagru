<?php 
/* Main page with two forms: sign up and log in */
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
if (isset($_SESSION['previous'])) {
	unset($_SESSION['alert']);
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style/index.css">
	<link rel="stylesheet" href="style/header-footer.css">
	<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-dark.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome to Camagru!</title>
</head>
<body>
	<div id="back">
		<header class="sticky">
			<?php
				if ($_SESSION['logged_in'] === true && $_SESSION['active'] == 1) {
					echo "<a href=\"views/feed.php\"><button>Feed</button></a>";
					echo "<a href=\"views/profile.php\"><button>My Profile</button></a>";
					echo "<a href=\"views/edit_profile_page.php\"><button>Edit Profile</button></a>";
					echo "<a href=\"views/logout.php\"><button>Log Out</button></a>";
				} else if ($_SESSION['logged_in'] === true && $_SESSION['active'] == 0) {
					echo "<a href=\"views/feed.php\"><button>Feed</button></a>";
					echo "<a href=\"views/edit_profile_page.php\"><button>Edit Profile</button></a>";
					echo "<a href=\"views/logout.php\"><button>Log Out</button></a>";				
				} else {
					echo "<a href=\"views/signup_page.php\"><button>Sign Up</button></a>";
					echo "<a href=\"views/login_page.php\"><button>Log In</button></a>";
					echo "<a href=\"views/feed.php\"><button>Feed</button></a>";
				}
			?>
		</header>
		<p>
		<!-- Display message about account verification link only once -->
		<?php if (isset($_SESSION['message'])) { ?>
			<div id="one-time-alarm">
					<p><?=$_SESSION['message']?></p>
			</div>
		<?php unset($_SESSION['message']); } ?>
		</p>
		
		<?php
				if ( $_SESSION['logged_in'] === true ) {
					echo "<p id=\"cama\">Welcome to the Camagru, ".$_SESSION['username']."</p>";
				} else {
					echo "<p id=\"cama\">Camagru</p>";
				}
		?>
	</div>
	<?php if (isset($_SESSION['active']) && $_SESSION['active'] == 0){
		echo '<span id="one-time-alarm" class="toast"> Account is unverified, please confirm your email by clicking on the email link!</span>';
	} ?>
	<?php include './views/footer.php'; ?>
</body>
</html>
