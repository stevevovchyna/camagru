<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
date_default_timezone_set("Europe/Kiev");

// Output JSON
function outputJSON($msg, $file = '', $status = 'error'){
    header('Content-Type: application/json');
    die(json_encode(array(
		'data' => $msg,
		'file' => $file,
        'status' => $status
    )));
}

$random = bin2hex(random_bytes(10));
$file = "user_images/".$random.".png";

// Check for errors
if($_FILES['SelectedFile']['error'] > 0){
    outputJSON('An error ocurred when uploading.');
}

if(!getimagesize($_FILES['SelectedFile']['tmp_name'])){
    outputJSON('Please ensure you are uploading an image.');
}

if ($_FILES['SelectedFile']['type'] !== 'image/jpeg' &&
	$_FILES['SelectedFile']['type'] !== 'image/png' &&
	$_FILES['SelectedFile']['type'] !== 'image/jpg' &&
	$_FILES['SelectedFile']['type'] !== 'image/JPG' &&
	$_FILES['SelectedFile']['type'] !== 'image/gif') {
		outputJSON('Please ensure you are uploading png, jpg, jpeg or gif image file.');
}

// Check filesize
if($_FILES['SelectedFile']['size'] > 1000000){
    outputJSON('File uploaded exceeds maximum upload size.');
}

$png = $_POST['PNG'];
// Upload file
if (move_uploaded_file($_FILES['SelectedFile']['tmp_name'], $file)) {

	$source_image = $png;
	$dest_image = $file;
	
	$src = imagecreatefrompng($source_image);
	imagesavealpha($src, true);
	$cond = GetImageSize($dest_image);
	if ($cond[2] == 1) {
		$dest = imagecreatefromgif($dest_image);
	}
	if ($cond[2] == 2) {
		$dest = imagecreatefromjpeg($dest_image);
	}
	if ($cond[2] == 3) {
		$dest = imagecreatefrompng($dest_image);
	}
	imagesavealpha($dest, true);
	// header('Content-Type: image/png');
	$back = imagecreatetruecolor(imagesx($src), imagesy($src));
	imagecopyresized($back, $dest, 0, 0, 0, 0, imagesx($src), imagesy($src), imagesx($dest), imagesy($dest));
	imagecopy($back, $src, 0, 0, 0, 0, imagesx($src), imagesy($src));
	imagepng($back, $file);
	imagedestroy($src);
	imagedestroy($dest);
	imagedestroy($back);

	$query = "INSERT INTO posts (post_url, user_id, date_created) VALUES (:post_url, :user_id, :date_created)";
	$statement = $pdo->prepare($query);
	$result = $statement->execute(
		array(
			'post_url' => $file,
			'user_id' => $_SESSION['user_id'],
			'date_created' => date("Y-m-d H:i:s")
		)
	);
	if ($result) {
		$_SESSION['message'] = "Picture uploaded!";
	}	

	// Success!
	outputJSON('File uploaded successfully to ' . $file, $file, 'success');
}
?>
