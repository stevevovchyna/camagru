<?php
require $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
session_start();
date_default_timezone_set("Europe/Kiev");

$random = bin2hex(random_bytes(10));
$data = $_POST['imgData'];
$png = $_POST['png'];
$data = str_replace(' ', '+', $data);
$file = "user_images/".$random.".png";
$uri = substr($data, strpos($data, ",") + 1);
file_put_contents($file, base64_decode($uri));

$white_image = "http://localhost:8100/".$file;
$photo_to_paste = $png;

$im = imagecreatefrompng($white_image);
$condicion = GetImageSize($photo_to_paste); // image format?
if($condicion[2] == 1){
	$im2 = imagecreatefromgif("$photo_to_paste");
} //gif
if($condicion[2] == 2) {
	$im2 = imagecreatefromjpeg("$photo_to_paste");
} //jpg
if($condicion[2] == 3) {
	$im2 = imagecreatefrompng("$photo_to_paste");
} //png
imagecopy($im, $im2, (imagesx($im)/2)-(imagesx($im2)/2), (imagesy($im)/2)-(imagesy($im2)/2), 0, 0, imagesx($im2), imagesy($im2));

imagejpeg($im, $file, 90);
imagedestroy($im);
imagedestroy($im2);

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
$query = "SELECT LAST_INSERT_ID()";
$statement = $pdo->prepare($query);
$statement->execute();
$arr = $statement->fetchAll(PDO::FETCH_ASSOC);

function outputJSON($msg, $file = '', $post_id = '', $status = 'error'){
    header('Content-Type: application/json');
    die(json_encode(array(
		'data' => $msg,
		'file' => $file,
		'status' => $status,
		'post_id' => $post_id
    )));
}

outputJSON('File uploaded successfully to ' . $file, $file, $arr[0]['LAST_INSERT_ID()'], 'success');


?>
