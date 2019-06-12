<div class="frame" style="display:inline-block;">
	<div class="container">
		<video id="video" width="400" height="300"></video>
		<canvas id="canvas" width="400" height="300"></canvas>
		<span onclick="pngPickerCloseButton(this)" class="closebtn">&times;</span>
		<img id="expandedImg">
		<div id="imgtext"></div>
	</div>
	<div class="row">
		<div class="column">
			<img src="images/cartoon.png" alt="Nature" style="width:100%" onclick="pngPicker(this);">
		</div>
		<div class="column">
			<img src="images/disnep.png" alt="Snow" style="width:100%" onclick="pngPicker(this);">
		</div>
		<div class="column">
			<img src="images/trump.png" alt="Mountains" style="width:100%" onclick="pngPicker(this);">
		</div>
	</div>
	<div>
		<button id="capture" disabled >Take picture</button>
		<input type='file' id='_file'>
		<input type='button' id='_submit' value='Upload!' disabled >
		<p id="response"></p>
	</div>
</div>
