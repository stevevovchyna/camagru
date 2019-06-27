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
				if ( $_SESSION['logged_in'] === true ) {
					echo "<a href=\"views/feed.php\"><button>Feed</button></a>";
					echo "<a href=\"views/profile.php\"><button>My Profile</button></a>";
					echo "<a href=\"views/edit_profile_page.php\"><button>Edit Profile</button></a>";
					echo "<a href=\"views/logout.php\"><button>Log Out</button></a>";
				} else {
					echo "<a href=\"views/signup_page.php\"><button>Sign Up</button></a>";
					echo "<a href=\"views/login_page.php\"><button>Log In</button></a>";
					echo "<a href=\"views/feed.php\"><button>Feed</button></a>";
				}
			?>
		</header>
		
		<?php
				if ( $_SESSION['logged_in'] === true ) {
					echo "<p id=\"cama\">Welcome to the Camagru, ".$_SESSION['username']."</p>";
				} else {
					echo "<p id=\"cama\">Camagru</p>";
				}
		?>
	</div>
	<?php include './views/footer.php'; ?>
</body>
</html>
