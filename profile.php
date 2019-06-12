<?php
/* Displays user information and some useful messages */
session_start();

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != true ) {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
  header("location: error.php");    
}
else {
    // Makes it easier to read
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
	$active = $_SESSION['active'];
	$notifications = $_SESSION['notifications'];
}
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Welcome, <?= $username ?></title>

  <style>
.frame {
	margin: 0;
	display: flex;
}
#canvas {
	display: none;
}

* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: Arial;
}

/* The grid: Four equal columns that floats next to each other */
.column {
  float: left;
  width: 33%;
  padding: 10px;
}

/* Style the images inside the grid */
.column img {
  opacity: 0.8; 
  cursor: pointer; 
}

.column img:hover {
  opacity: 1;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* The expanding image container */
.container {
  position: relative;
  display: none;
}

/* Closable button inside the expanded image */
.closebtn {
  position: absolute;
  top: 10px;
  right: 15px;
  color: white;
  font-size: 35px;
  cursor: pointer;
  color: black;
}

#video {
	position: relative;
	top: 0;
	left: 0;
	z-index: 1;
}

#expandedImg {
	position: absolute;
	top: 0;
	left: 0;
	z-index: 3;
}

</style>
</head>

<body>
  <div>

          <h1>Welcome</h1>
          
          <p>
          <?php 
          // Display message about account verification link only once
          if (isset($_SESSION['message']))
          {
              echo $_SESSION['message'];
              // Don't annoy the user with more messages upon page refresh
              unset($_SESSION['message']);
          }
          ?>
          </p>
          <?php
          // Keep reminding the user this account is not active, until they activate
          if (!$active){
              echo
              '<div class="info">
              Account is unverified, please confirm your email by clicking
              on the email link!
              </div>';
		  }
		  else {
			  include 'frame.php';
		  }
          ?>
          <h2><?= $username ?></h2>
          <p><?= $email ?></p>
		  <a href="edit_profile_page.php"><button>Edit Profile</button></a>
          <a href="logout.php"><button>Log Out</button></a>
    </div>
<script src="js/camera.js"></script>
</body>
</html>
