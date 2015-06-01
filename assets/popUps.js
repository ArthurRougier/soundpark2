function curatorPopup()
{
	var darkOverlay = document.createElement("div");
	darkOverlay.id="darkOverlay";
	darkOverlay.className ="darkOverlay"

	var closeIcon = document.createElement("img");
	closeIcon.setAttribute("src", "../assets/pictures/close_cross.svg");
	closeIcon.id = "closeCross";

	var curatorForm = document.createElement("form");
	curatorForm.setAttribute("name","curatorForm");
	curatorForm.setAttribute("action","../control/make_curator.php");
	curatorForm.setAttribute("method","post");
	curatorForm.id = "curatorForm";
		
	var text = document.createElement("h2");
	text.innerHTML = "Yiha! Please chose your curator name: "

	var nameInput = document.createElement("input");
	nameInput.setAttribute("name","curatorName");
	nameInput.setAttribute("type","text");
	nameInput.setAttribute("autocorrect","off");
	nameInput.setAttribute("autocapitalize","off");
	nameInput.setAttribute("id","curatorName");

	var submit = document.createElement("button");
	submit.setAttribute("alt","submit");
	submit.className="submitButton";
	submit.innerHTML = "GO";


	var helperDiv = document.createElement("div");
	helperDiv.className = "helper";

	curatorForm.appendChild(text);
	curatorForm.appendChild(nameInput);
	curatorForm.appendChild(submit);
	darkOverlay.appendChild(closeIcon);
	darkOverlay.appendChild(helperDiv);
	darkOverlay.appendChild(curatorForm);


	document.body.appendChild (darkOverlay);
}