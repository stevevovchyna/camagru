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

	function dataTypeCheck(name) {
		var check = name;
		check = check.slice(check.indexOf(".") + 1);
		console.log(check);
		switch (check) {
			case 'png':
				return "";
			case 'gif':
				return "";
			case 'jpeg':
				return "";
			case 'jpg':
				return "";
			case 'JPG':
				return "";
			}
		return "Your file type is not png, gif, jpeg or jpg. Please provide a valid imamge file";
	}

	document.getElementById('_submit').addEventListener('click', () => {
		var _submit = document.getElementById('_submit');
		var _file = document.getElementById('_file');
		var _progress = document.getElementById('_progress');
		if (_file.files.length === 0) {
			return;
		}
		var typeError = dataTypeCheck(_file.files[0].name);
		document.getElementById('response').innerText = typeError;

		var data = new FormData();
		data.append('SelectedFile', _file.files[0]);
		data.set('PNG', png);
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("POST", "noWebCam.php");
		xmlhttp.onreadystatechange = () => {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				try {
					var resp = JSON.parse(xmlhttp.response);
					var newImage = document.createElement("img");
					newImage.setAttribute('src', resp.file);
					document.body.appendChild(newImage);
				} catch (e) {
					var resp = {
						status: "error",
						data: "Unknown error occured: " + xmlhttp.responseText
					};
				}
				console.log(resp.status + ': ' + resp.data);
		//		console.log(xmlhttp.responseText);
			}
		};
		xmlhttp.send(data);
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
