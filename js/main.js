// Toggle between adding and removing the "responsive" class to primary nav when the user clicks on the icon 
function mainMenu() {
    document.getElementsByClassName("primary-nav")[0].classList.toggle("responsive");
}


// Form Validation
function formValidate() {
	
	var name = document.memberform.name.value;
	var email = document.memberform.email.value;
	var phonenumber = document.memberform.name.value;
	
	if(name == "" || email == "" || phonenumber == "") {
		document.getElementsClassName("error").innerHTML = "Please fill in all the fields!"
		return false;
	} else {
		return true;
	 }
}




