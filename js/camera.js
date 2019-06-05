var png = "";

(function(){
	var video = document.getElementById('video');
	var canvas = document.getElementById('canvas');
	var context = canvas.getContext('2d');
	var photo = document.getElementById('photo');
	var secretik = document.getElementById('secretik');
	
	navigator.getMedia = 	navigator.getUserMedia ||
							navigator.webkitGetUserMedia ||
							navigator.mozGetUserMedia ||
							navigator.msGetUserMedia;
	navigator.getMedia({
		video: true,
		audio: false
	}, function (stream){
		video.srcObject = stream;
		video.play();
	}, function (err){
		console.log(err.code);
	});


	document.getElementById('capture').addEventListener('click', () => {
		context.drawImage(video, 0, 0, 400, 300);
		picture = canvas.toDataURL("image/png");
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("POST", "picsmerge.php");
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.onreadystatechange = () => {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var newImage = document.createElement("img");
				newImage.setAttribute('src', xmlhttp.responseText);
				document.body.appendChild(newImage);
			}
		}
		xmlhttp.send("imgData=" + picture + "&png=" + png);
	});
	
})();

function myFunction(imgs) {
	var expandImg = document.getElementById("expandedImg");
	var imgText = document.getElementById("imgtext");
	expandImg.src = imgs.src;
	imgText.innerHTML = imgs.alt;
	expandImg.parentElement.style.display = "block";
	png = imgs.src;
}

// function loadFile(event) {
// 	var image = document.getElementById('output');
// 	image.src = URL.createObjectURL(event.target.files[0]);
// 	var picture = URL.createObjectURL(event.target.files[0]);
// 	var xmlhttp = new XMLHttpRequest();
// 		xmlhttp.open("POST", "noWebCam.php");
// 		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
// 		xmlhttp.onreadystatechange = () => {
// 			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
// 				// var newImage = document.createElement("img");
// 				// newImage.setAttribute('src', xmlhttp.responseText);
// 				// document.body.appendChild(newImage);
// 				console.log(xmlhttp.responseText);
// 			}
// 		}
// 		xmlhttp.send("imgData=" + picture + "&png=" + png);
// };
