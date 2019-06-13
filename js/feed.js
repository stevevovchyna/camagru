function like(like) {
	var postID = like.name;
//	var currentLikes = Number(like.querySelector('span').innerText);
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "like.php");
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.onreadystatechange = () => {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			like.querySelector('span').innerText = xmlhttp.responseText;
			like.disabled = true;
		}
	}
	xmlhttp.send("postID=" + postID);
}
