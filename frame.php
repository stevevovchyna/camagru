<div class="frame" style="display:inline-block;">
	<div>
		<button id="capture" disabled >Take picture</button>
		<input type='file' id='_file'>
		<input type='button' id='_submit' value='Upload!' disabled >
		<p id="response"></p>
	</div>
	<div class="container">
		<video id="video" width="500" height="375"></video>
		<canvas id="canvas" width="500" height="375"></canvas>
		<span onclick="pngPickerCloseButton(this)" class="closebtn">&times;</span>
		<img id="expandedImg">
	</div>
	<div class="row">
		<div class="column">
			<img src="images/cat_8.png" alt="Nature" style="width:100%" onclick="pngPicker(this);">
		</div>
		<div class="column">
			<img src="images/flames.png" alt="Snow" style="width:100%" onclick="pngPicker(this);">
		</div>
		<div class="column">
			<img src="images/violin.png" alt="Mountains" style="width:100%" onclick="pngPicker(this);">
		</div>
		<div class="column">
			<img src="images/vinette.png" alt="Mountains" style="width:100%" onclick="pngPicker(this);">
		</div>
	</div>
</div>
