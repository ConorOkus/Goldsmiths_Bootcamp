// Toggle between adding and removing the "responsive" class to primary nav when the user clicks on the icon 
function myFunction() {
    document.getElementsByClassName("primary-nav")[0].classList.toggle("responsive");
}

// Check if user has entered a valid number and produce error message
document.registerform.onsubmit=function() {
 		
 		var theNumber = document.registerform.num.value;
 		
 		if (isNaN(theNumber)) {
 			document.getElementById("errormessage").innerHTML = "(Enter a valid number)";
 			return false;
 		} 
 		
 	}

