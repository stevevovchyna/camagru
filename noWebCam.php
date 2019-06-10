<?php
error_reporting(E_ALL);

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
$file = "tmp/".$random.".png";

//ADD CHECK FOR FOLDER - IF NO FOLDER - CREATE!!!!!!!!!!!

// Check for errors
if($_FILES['SelectedFile']['error'] > 0){
    outputJSON('An error ocurred when uploading.');
}

if(!getimagesize($_FILES['SelectedFile']['tmp_name'])){
    outputJSON('Please ensure you are uploading an image.');
}

// Check filesize
if($_FILES['SelectedFile']['size'] > 500000){
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
	header('Content-Type: image/png');
	$back = imagecreatetruecolor(400, 300);
	imagecopy($back, $dest, 0,0,0,0,400,300);
	imagecopy($back, $src, 0,0,0,0,400,300);
	imagepng($back, $file);
	imagedestroy($src);
	imagedestroy($dest);

	// Success!
	outputJSON('File uploaded successfully to ' . $file, $file, 'success');
} else {
	echo "posossi!";
}
	
	?>
