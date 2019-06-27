<?php 
session_start();
if ( $_SESSION['logged_in'] != true ) {
	$_SESSION['message'] = "That's definitely not where you're meant to be, bastard!";
	header("location: error.php");    
}
?>
<div class="footer" style="position: fixed; left: 0; bottom: 0; width: 100%; color: white; border-top: 1px solid #555;">
		<p>Camagru by svovchyn</p>
</div>
