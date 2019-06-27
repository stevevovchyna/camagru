var png = "";

(function(){
	var video = document.getElementById('video');
	var canvas = document.getElementById('canvas');
	var context = canvas.getContext('2d');
	
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
	
	var video1 = document.getElementById('video1');
	
	navigator.getMedia = 	navigator.getUserMedia ||
							navigator.webkitGetUserMedia ||
							navigator.mozGetUserMedia ||
							navigator.msGetUserMedia;
	navigator.getMedia({
		video: true,
		audio: false
	}, function (stream){
		video1.srcObject = stream;
		video1.play();
	}, function (err){
		console.log(err.code);
	});
// NO WEB CAM UPLOAD
	document.getElementById('_submit').addEventListener('click', () => {
		var _file = document.getElementById('_file');
		if (_file.files.length === 0) {
			document.getElementById('response').innerText = "Please choose the file!";
			return;
		}
		var data = new FormData();
		data.append('SelectedFile', _file.files[0]);
		data.set('PNG', png);
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("POST", "../models/noWebCam.php");
		xmlhttp.onreadystatechange = () => {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				try {
					var resp = JSON.parse(xmlhttp.response);
					var newDiv = document.createElement("div");
					newDiv.setAttribute('id', "post" + resp.post_id);
					var newImage = document.createElement("img");
					newImage.setAttribute('src', "../" + resp.file);
					var delButton = document.createElement('button');
					delButton.setAttribute('class', 'small');
					delButton.setAttribute('id', resp.post_id);
					delButton.setAttribute('onclick', 'delPostButton(this)');
					delButton.innerText = "Delete";
					var thumb = document.getElementById('thumb');
					newDiv.appendChild(newImage);
					newDiv.appendChild(delButton);
					thumb.prepend(newDiv);
				} catch (e) {
					var resp = {
						status: "error",
						data: "Unknown error occured: " + xmlhttp.responseText
					};
				}
			}
		};
		xmlhttp.send(data);
	});
// WEB CAM UPLOAD
	document.getElementById('capture').addEventListener('click', () => {
		context.drawImage(video, 0, 0, 500, 375);
		picture = canvas.toDataURL("image/png");
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open("POST", "../models/picsmerge.php");
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.onreadystatechange = () => {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				try {
					var resp = JSON.parse(xmlhttp.response);
					var newDiv = document.createElement("div");
					newDiv.setAttribute('id', "post" + resp.post_id);
					var newImage = document.createElement("img");
					newImage.setAttribute('src', "../" + resp.file);
					var delButton = document.createElement('button');
					delButton.setAttribute('class', 'small');
					delButton.setAttribute('id', resp.post_id);
					delButton.setAttribute('onclick', 'delPostButton(this)');
					delButton.innerText = "Delete";
					var thumb = document.getElementById('thumb');
					newDiv.appendChild(newImage);
					newDiv.appendChild(delButton);
					thumb.prepend(newDiv);
				} catch (e) {
					var resp = {
						status: "error",
						data: "Unknown error occured: " + xmlhttp.responseText
					};
				}
			}
		}
		xmlhttp.send("imgData=" + picture + "&png=" + png);
	});
	
})();

function pngPicker(imgs) {
	var expandImg = document.getElementById("expandedImg");
	expandImg.src = imgs.src;
	expandImg.parentElement.style.display = "flex";
	document.getElementById('video1').style.display = "flex";
	png = imgs.src;
	document.getElementById('capture').disabled = false;
	document.getElementById('_submit').disabled = false;
	document.getElementById('video1').style.display = "none";
}

function pngPickerCloseButton(imgs) {
	imgs.parentElement.style.display='none';
	png = '';
	document.getElementById('capture').disabled = true;
	document.getElementById('_submit').disabled = true;
	document.getElementById('video1').style.display = "flex";
}

function delPostButton(el) {
	var postID = el.id;
	var divID = "post" + postID;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "../models/post_delete.php");
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.onreadystatechange = () => {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var list = document.getElementById(divID);
			list.remove(list);
		}
	}
	xmlhttp.send("post_id=" + postID);
}

