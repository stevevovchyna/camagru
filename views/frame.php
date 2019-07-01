<?php 
if ( $_SESSION['logged_in'] != true ) {
	$_SESSION['message'] = "That's definitely not where you're meant to be, bastard!";
	header("location: error.php");    
}
?>

<div class="frame">
	<div id="picture-png-buttons">
		<div class="video1">
			<video id="video1" width="500" height="375"></video>
			<canvas id="canvas" width="500" height="375"></canvas>
		</div>
		<div class="container">
			<video id="video" width="500" height="375"></video>
			<canvas id="canvas" width="500" height="375"></canvas>
			<span onclick="pngPickerCloseButton(this)" class="closebtn">&times;</span>
			<img id="expandedImg">
		</div>
		<div class="row">
			<?php
			$scanned_directory = array_diff(scandir($_SERVER['DOCUMENT_ROOT']."/images"), array('..', '.'));
			foreach($scanned_directory as $pic){ ?>
				<div class="column">
					<img src="../images/<?=$pic?>" onclick="pngPicker(this);">
				</div>
			<?php } ?>
		</div>
		<div id="take-pic">
			<button id="capture" disabled >Take picture</button>
		</div>
		<div id="upload-image">
			<input type='file' id='_file'>
			<label id="upload-label-button" class="button" for="_file">Choose a file</label>
			<input type='button' id='_submit' value='Upload!' disabled >
		</div>
	</div>
	<div class="thumb" id="thumb">
		<?php
		$query = "SELECT * FROM posts WHERE user_id = :user_id ORDER BY posts.date_created DESC";
		$statement = $pdo->prepare($query);
		$statement->execute(
			array(
				'user_id' => $_SESSION['user_id']
			)
		);
		$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($posts as $post) {
			echo "<div id=\"post".$post['post_id']."\">";
			echo "<img src=\"../".$post['post_url']."\">";
			echo "<button class=\"small\" id=\"".$post['post_id']."\" onclick=\"delPostButton(this)\">Delete</button>";
			echo "</div>";
		}
		?>
	</div>
</div>
<div id="myModal" class="modal">
	<div class="modal-content">
    	<span onclick="closeModal(this)" class="close">&times;</span>
    	<p id="message"></p>
  	</div>
</div>
