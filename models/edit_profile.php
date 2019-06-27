<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();

$newusername = $_POST['username'];
$newemail = $_POST['email'];
$newnotifications = $_POST['notifications'];
$currentemail = $_SESSION['email'];
$currentusername = $_SESSION['username'];
$currentnotifications = $_SESSION['notifications'];
$message = "Data updated:";

if ($newusername !== $currentusername) {
	$query = "UPDATE users SET username = :username WHERE email = :email";
	$statement = $pdo->prepare($query);
	$result = $statement->execute(
		array(
			'username' => $newusername,
			'email' => $currentemail
		)
	);
	if ($result) {
		$_SESSION['username'] = $newusername;
		$message = $message . " username";
	}
}
if ($newemail !== $currentemail) {
	$query = "UPDATE users SET email = :email WHERE email = :currentemail";
	$statement = $pdo->prepare($query);
	$result = $statement->execute(
		array(
			'email' => $newemail,
			'currentemail' => $currentemail
		)
	);
	if ($result) {
		$_SESSION['email'] = $newemail;
		$message = $message . " email";
	}
}
if ($newnotifications !== $currentnotifications) {
	$query = "UPDATE users SET notifications = :notifications WHERE email = :currentemail";
	$statement = $pdo->prepare($query);
	$result = $statement->execute(
		array(
			'notifications' => $newnotifications,
			'currentemail' => $_SESSION['email']
		)
	);
	if ($result) {
		$_SESSION['notifications'] = $newnotifications;
		$message = $message . " notifications";
	}
}

$_SESSION['alert'] = $message . '.';

header("location: edit_profile_page.php");


?>
