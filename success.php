<?php
/* Displays all error messages */
session_start();
if (isset($_SESSION['previous'])) {
	unset($_SESSION['alert']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Success</title>
</head>
<body>
<div>
    <h1>Success</h1>
    <p>
    <?php 
    if(isset($_SESSION['message']) && !empty($_SESSION['message'])) {
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	} else {
        header("location: index.php");
	}
    ?>
    </p>     
    <a href="index.php"><button>Home</button></a>
</div>
</body>
</html>
