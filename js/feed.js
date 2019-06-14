function like(like) {
	var postID = like.name;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "like.php");
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.onreadystatechange = () => {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			like.setAttribute('onclick', 'unlike(this)');
			like.querySelector('span').innerText = xmlhttp.responseText;
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
			like.querySelector('span').innerText = xmlhttp.responseText;
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
			comment.innerText = resp.content + " by " + resp.username;
			
			var delButton = document.createElement('button');
			delButton.id = resp.comment_id;
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