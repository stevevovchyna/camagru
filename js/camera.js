(function(){
	var video = document.getElementById('video');
	var canvas = document.getElementById('canvas');
	var context = canvas.getContext('2d');
	var photo = document.getElementById('photo');
	
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
		//any manipulations with the picture can be done here
		photo.setAttribute('src', canvas.toDataURL('mage/png'));
	});
		
})();
