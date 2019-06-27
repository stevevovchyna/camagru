function like(like) {
	var postID = like.name;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "like.php");
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.onreadystatechange = () => {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			like.setAttribute('onclick', 'unlike(this)');
			var word = xmlhttp.responseText === "1" ? " like" : " likes";
			like.querySelector('span').innerText = xmlhttp.responseText + word;
		}
	}
	xmlhttp.send("postID=" + postID);
}
function unlike(like) {
	var postID = like.name;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "unlike.php");
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.onreadystatechange = () => {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			like.setAttribute('onclick', 'like(this)');
			var word = xmlhttp.responseText === "1" ? " like" : " likes";
			like.querySelector('span').innerText = xmlhttp.responseText + word;
		}
	}
	xmlhttp.send("postID=" + postID);
}

function sanitize(str) {
	var temp = document.createElement('div');
	temp.textContent = str;
	return temp.innerHTML;
};

function submitComment(post) {
	var postID = post.name;
	var id = "comment" + postID;
	var content = sanitize(document.getElementById(postID).value);
	var content = content.replace(/;/g, '');
	var content = content.replace(/&/g, '');
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "comment_submit.php");
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.onreadystatechange = () => {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var resp = JSON.parse(xmlhttp.response);
			document.getElementById(postID).value = "";
			var commentBlockID = "comment-block" + resp.comment_id;

			var commentBlock = document.createElement('div');
			commentBlock.id = commentBlockID;
			
			var comment = document.createElement("div");
			comment.id = resp.comment_id;
			comment.setAttribute('onclick', 'showDelButton(this)');
			comment.innerText = resp.username + ": " + resp.content + " on " + resp.date;
			
			var delButton = document.createElement('button');
			delButton.id = resp.comment_id;
			delButton.classList.add('hidden');
			delButton.classList.add('small');
			delButton.classList.add('delete-button' + resp.comment_id);
			delButton.innerText = "Delete";
			delButton.setAttribute('onclick', 'deleteComment(this)');
			
			document.getElementById(id).appendChild(commentBlock);
			document.getElementById(commentBlockID).appendChild(comment);			
			document.getElementById(commentBlockID).appendChild(delButton);
		}
	}
	xmlhttp.send("postID=" + postID + "&content=" + content);
}

function deleteComment(but) {
	var commentID = but.id;
	var divID = "comment-block" + commentID;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "comment_delete.php");
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.onreadystatechange = () => {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var list = document.getElementById(divID);
			list.remove(list);
		}
	}
	xmlhttp.send("commentID=" + commentID);
}

function showDelButton(el) {
	var id = ".delete-button" + el.id;
	document.querySelector(id).classList.toggle('hidden');
}

function showActions(el) {
	var child = el.nextSibling;
	child.classList.toggle('hidden');
}
