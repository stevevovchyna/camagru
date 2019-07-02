function like(like) {
	var postID = like.name;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "../models/like.php");
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
	xmlhttp.open("POST", "../models/unlike.php");
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
	if (document.getElementById(postID).value === "") {
		showModal("Your comment can't be empty!");
		return;
	}
	var id = "comment" + postID;
	var content = sanitize(document.getElementById(postID).value);
	var content = content.replace(/;/g, '');
	var content = content.replace(/&/g, '');
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "../models/comment_submit.php");
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
			comment.classList.add('comment-body');
			comment.setAttribute('onclick', 'showDelButton(this)');
			comment.innerHTML = '<span class="comment-author">' + resp.username + ':</span> <span class="comment-content">' + resp.content + '</span> <span class="comment-date">on ' + resp.date + '</span>';
			
			var delButton = document.createElement('button');
			delButton.id = resp.comment_id;
			delButton.classList.add('hidden');
			delButton.classList.add('small');
			delButton.classList.add('del-button');
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
	xmlhttp.open("POST", "../models/comment_delete.php");
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
	var child = el.nextElementSibling;
	child.classList.toggle('hidden');
}

function closeModal(el) {
	var modal = document.getElementById("myModal");
	var message = document.getElementById('message');
	message.innerText = "";
	modal.style.display = "none";
}

function showModal(resp) {
	var modal = document.getElementById("myModal");
	var message = document.getElementById('message');
	message.innerText = resp;
	modal.style.display = "block";
}

function show_more_button(el) {
	el.nextElementSibling.classList.toggle('hidden');
}

