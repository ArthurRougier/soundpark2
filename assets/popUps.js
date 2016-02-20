var curatorPopup = function(callback)
{
	var containerDiv = document.createElement("div");
	containerDiv.id="popUpContainer";


	var darkOverlay = document.createElement("div");
	darkOverlay.id="darkOverlay";
	darkOverlay.className ="darkOverlay"

	var closeIcon = document.createElement("img");
	closeIcon.setAttribute("src", "../assets/pictures/close_cross.svg");
	closeIcon.id = "closeCross";

	var curatorForm = document.createElement("form");
	curatorForm.setAttribute("name","curatorForm");
	curatorForm.setAttribute("method","post");
	curatorForm.id = "curatorForm";

	curatorForm.onsubmit = function(){return false;};

	var submitForm = function(pseudo) {
		console.log('iuefzbhfezfezfezfezfezeffe');
		$.ajax({
		  url: "../control/make_curator.php?curatorPseudo="+pseudo,
		  cache: false,
		  success: function(success) {
		    console.log("Made curator success! Launching callBack...");
		    var element = document.getElementById('popUpContainer');
		    element.parentNode.removeChild(element);
		    callback();
		  }.bind(this),
		  error: function(xhr, status, err) {
		    console.error("../control/make_curator.php", status, err.toString());
		  }.bind(this)
		});
	}
		
	var text = document.createElement("h2");
	text.id = "popUpText";
	text.innerHTML = "Yiha! Please chose your curator name: "

	var nameInput = document.createElement("input");
	nameInput.setAttribute("name","curatorName");
	nameInput.setAttribute("type","text");
	nameInput.setAttribute("autocorrect","off");
	nameInput.setAttribute("autocapitalize","off");
	nameInput.setAttribute("id","curatorName");

	var submit = document.createElement("div");
	submit.className="submitButton";
	submit.innerHTML = "GO";
	submit.id = "submitButton";


	var helperDiv = document.createElement("div");
	helperDiv.className = "helper";

	curatorForm.appendChild(text);
	curatorForm.appendChild(nameInput);
	curatorForm.appendChild(submit);
	darkOverlay.appendChild(closeIcon);
	darkOverlay.appendChild(helperDiv);
	darkOverlay.appendChild(curatorForm);
	containerDiv.appendChild(darkOverlay);


	document.body.appendChild(containerDiv);
	document.getElementById('closeCross').addEventListener('click', function(){
		var element = document.getElementById('popUpContainer');
		element.parentNode.removeChild(element);
	}, false);

	document.getElementById('submitButton').addEventListener('click', function(){
		var pseudo = document.getElementById('curatorName').value;
		console.log(pseudo);
		document.getElementById('popUpText').innerHTML = "Welcome " + pseudo + ". Redirecting you to the curator Space...";
		setTimeout(submitForm.bind(pseudo), 3000);
	}, false);
}

module.exports = curatorPopup;