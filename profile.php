<?php
/* Displays user information and some useful messages */
session_start();

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
  header("location: error.php");    
}
else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
}
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Welcome <?= $first_name.' '.$last_name ?></title>

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
  <div class="form">

          <h1>Welcome</h1>
          
          <p>
          <?php 
          // Display message about account verification link only once
          if ( isset($_SESSION['message']) )
          {
              echo $_SESSION['message'];
              // Don't annoy the user with more messages upon page refresh
              unset( $_SESSION['message'] );
          }
          ?>
          </p>
          <div class="frame" style="display:inline-block;">
          	<div class="container">
          		<video id="video" width="400" height="300"></video>
          		<canvas id="canvas" width="400" height="300"></canvas>
          		<span onclick="this.parentElement.style.display='none';png = ''" class="closebtn">&times;</span>
          		<img id="expandedImg">
          		<div id="imgtext"></div>
          	</div>
          	<div class="row">
          		<div class="column">
          			<img src="images/cartoon.png" alt="Nature" style="width:100%" onclick="myFunction(this);">
          		</div>
          		<div class="column">
          			<img src="images/disnep.png" alt="Snow" style="width:100%" onclick="myFunction(this);">
          		</div>
          		<div class="column">
          			<img src="images/trump.png" alt="Mountains" style="width:100%" onclick="myFunction(this);">
          		</div>
          	</div>
          	<div>
          		<button id="capture">Take picture</button>
				<input type='file' id='_file'>
				<input type='button' id='_submit' value='Upload!'>	
				<p id="response"></p>
          	</div>
          </div>
		  <?php
		  ?>
          <?php
          // Keep reminding the user this account is not active, until they activate
          if ( !$active ){
              echo
              '<div class="info">
              Account is unverified, please confirm your email by clicking
              on the email link!
              </div>';
          }
          ?>
          
          <h2><?php echo $first_name.' '.$last_name; ?></h2>
          <p><?= $email ?></p>
          
          <a href="logout.php"><button class="button button-block" name="logout"/>Log Out</button></a>

    </div>
    
<script src="js/camera.js"></script>

</body>
</html>
