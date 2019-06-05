<?php
$random = bin2hex(random_bytes(10));
$data = $_POST['imgData'];
$png = $_POST['png'];
$data = str_replace(' ', '+', $data);
$file = "tmp/".$random.".png";
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
echo $file;

?>
