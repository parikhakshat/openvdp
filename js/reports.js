function changeTitle() {
	var container =  document.getElementById('editSummary');
	if (typeof(container) == 'undefined' || container == null) {
		var node = document.querySelector(".summary");
		var output = document.createElement("DIV");
		output.setAttribute("id", "editSummary");
		output.innerHTML = "<button onclick='removeEdit()'>Close</button";
		node.parentNode.insertBefore(output, node.nextSibling);
	}
	var element =  document.getElementById('changeTitle');
	if (typeof(element) == 'undefined' || element == null) {
	container = document.getElementById("editSummary");
	var url = window.location.href.replace(window.origin, '');
	var output = document.createElement("DIV");
	output.setAttribute("id", "changeTitle");
	output.innerHTML =  ("<h2>Change Title: <form action='" + url + "' method='post'><input type='text' name='title'><input type='submit'></form>");
	container.appendChild(output);
}
}

function changeCategory() {
	var container =  document.getElementById('editSummary');
	if (typeof(container) == 'undefined' || container == null) {
		var node = document.querySelector(".summary");
		var output = document.createElement("DIV");
		output.setAttribute("id", "editSummary");
		output.innerHTML = "<button onclick='removeEdit()'>Close</button";
		node.parentNode.insertBefore(output, node.nextSibling);
	}
	var element =  document.getElementById('changeCategory');
	if (typeof(element) == 'undefined' || element == null) {
	container = document.getElementById("editSummary");
	var url = window.location.href.replace(window.origin, '');
	var output = document.createElement("DIV");
	output.setAttribute("id", "changeCategory");
	output.innerHTML =  ("<h2>Change Category: <form action='" + url + "' method='post'><input type='text' name='category'><input type='submit'></form>");
	container.appendChild(output);
}
}
function changeCvss() {
	var container =  document.getElementById('editSummary');
	if (typeof(container) == 'undefined' || container == null) {
		var node = document.querySelector(".summary");
		var output = document.createElement("DIV");
		output.setAttribute("id", "editSummary");
		output.innerHTML = "<button onclick='removeEdit()'>Close</button";
		node.parentNode.insertBefore(output, node.nextSibling);
	}
	var element =  document.getElementById('changeCvss');
	if (typeof(element) == 'undefined' || element == null) {
	container = document.getElementById("editSummary");
	var url = window.location.href.replace(window.origin, '');
	var output = document.createElement("DIV");
	output.setAttribute("id", "changeCvss");
	output.innerHTML =  ("<h2>Change CVSS: <form action='" + url + "' method='post'><input type='text' name='cvss'><input type='submit'></form>");
	container.appendChild(output);
}
}
function changeStatus() {
	var container =  document.getElementById('editSummary');
	if (typeof(container) == 'undefined' || container == null) {
		var node = document.querySelector(".summary");
		var output = document.createElement("DIV");
		output.setAttribute("id", "editSummary");
		output.innerHTML = "<button onclick='removeEdit()'>Close</button";
		node.parentNode.insertBefore(output, node.nextSibling);
	}
	var element =  document.getElementById('changeStatus');
	if (typeof(element) == 'undefined' || element == null) {
	container = document.getElementById("editSummary");
	var url = window.location.href.replace(window.origin, '');
	var output = document.createElement("DIV");
	output.setAttribute("id", "changeStatus");
	output.innerHTML =  ("<h2>Change Status: <form action='" + url + "' method='post'><button type=\"submit\" name=\"closed\" value=\"true\">Close Report!</button><button type=\"submit\" name=\"open\" value=\"true\">Open Report!</button><button type=\"submit\" name=\"fixed\" value=\"true\">Fix Report!</button><button type=\"submit\" name=\"triaged\" value=\"true\">Triage Report!</button></form>");
	container.appendChild(output);
}
}

function removeEdit() {
	var junk = document.getElementById("editSummary");
	if (junk != undefined && junk.length != 0) {
	junk.remove();
}

}