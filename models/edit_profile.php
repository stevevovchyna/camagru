<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['edit'])) {
		if ($_POST['email'] !== $email ||
			$_POST['username'] !== $username ||
			$_POST['notifications'] !== $notifications) {
			
$newusername = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
$newnotifications = filter_var($_POST['notifications'], FILTER_SANITIZE_STRING);
$currentusername = filter_var($_POST['currentusername'], FILTER_SANITIZE_STRING);
$currentnotifications = filter_var($_POST['currentnotifications'], FILTER_SANITIZE_STRING);
$message = "Data updated:";

$newemail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
if (filter_var($newemail, FILTER_VALIDATE_EMAIL) === false) {
	$_SESSION['message'] = 'Invalid parameters provided for data edit!';
	header("location: ../views/error.php");
}
$currentemail = filter_var($_POST['currentemail'], FILTER_SANITIZE_EMAIL);
if (filter_var($currentemail, FILTER_VALIDATE_EMAIL) === false) {
	$_SESSION['message'] = 'Invalid parameters provided for data edit!';
	header("location: ../views/error.php");
}
if (filter_var($newusername, FILTER_SANITIZE_STRING) === false) {
	$_SESSION['message'] = 'Invalid parameters provided for data edit!';
	header("location: ../views/error.php");
}
if (filter_var($currentusername, FILTER_SANITIZE_STRING) === false) {
	$_SESSION['message'] = 'Invalid parameters provided for data edit!';
	header("location: ../views/error.php");
}
if (filter_var($newnotifications, FILTER_SANITIZE_STRING) === false) {
	$_SESSION['message'] = 'Invalid parameters provided for data edit!';
	header("location: ../views/error.php");
}
if (filter_var($currentnotifications, FILTER_SANITIZE_STRING) === false) {
	$_SESSION['message'] = 'Invalid parameters provided for data edit!';
	header("location: ../views/error.php");
}


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
			'currentemail' => $currentemail
		)
	);
	if ($result) {
		$_SESSION['notifications'] = $newnotifications;
		$message = $message . " notifications";
	}
}
if ($message === "Data updated:") {
	$_SESSION['alert'] = "Please edit some data in order to submit changes!";
	header("location: ../views/edit_profile_page.php");
} else {
	$_SESSION['alert'] = $message . '.';
	header("location: ../views/edit_profile_page.php");
}

}
}
}




?>
