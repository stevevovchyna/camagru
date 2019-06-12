<div class="frame" style="display:inline-block;">
	<div class="container">
		<video id="video" width="400" height="300"></video>
		<canvas id="canvas" width="400" height="300"></canvas>
		<span onclick="this.parentElement.style.display='none';png = ''" class="closebtn">&times;</span>
		<img id="expandedImg">
		<div id="imgtext"></div>
	</div>
	<div class="row">
		<div class="column">
			<img src="images/cartoon.png" alt="Nature" style="width:100%" onclick="myFunction(this);">
		</div>
		<div class="column">
			<img src="images/disnep.png" alt="Snow" style="width:100%" onclick="myFunction(this);">
		</div>
		<div class="column">
			<img src="images/trump.png" alt="Mountains" style="width:100%" onclick="myFunction(this);">
		</div>
	</div>
	<div>
		<button id="capture">Take picture</button>
		<input type='file' id='_file'>
		<input type='button' id='_submit' value='Upload!'>
		<p id="response"></p>
	</div>
</div>
