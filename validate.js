function loginCheck() {
	var username = document.getElementById('username').value;
	var password = document.getElementById('password').value;

	if(!checkLength(username)) {
		alert('Enter username');
		return false;
	}

	if(!checkLength(password)) {
		alert('Enter password');
		return false;
	}
	return true;
}

function checkForm() {
	var username = document.getElementById('username').value;
	var password = document.getElementById('password').value;
	var email = document.getElementById('email').value;
	var errors = [];

	if(!checkLength(username)) {
		errors.push('Enter username');
	}

	if(!checkLength(password)) {
		errors.push('Enter password');
	}

	if(!validateEmail(email)) {
		errors.push('Your e-mail is pure shit!');
	}

	if(!checkPass()) {
		errors.push('Passwords dont match');
	}

	if(errors.length > 0) {
		reportErrors(errors);
		return false;
	}

	return true;
}

function checkLength(text) {
	min = 1;
	max = 30;

	if(text.length < min || text.length > max) {
		return false;
	}
	return true;
}

function reportErrors(errors) {
	var msg = "Damn it...\n";
	var numError;

	for(var i = 0; i<errors.length; i++) {
		msg += "\n" + errors[i];
	}
	alert(msg);
}

function checkPass() {
	var pass1 = document.getElementById('password');
	var pass2 = document.getElementById('password2');

	var message = document.getElementById('confirmMessage');

	var goodColor = "#66cc66";
	var badColor = "#ff6666";

	if(pass1.value == pass2.value) {
		pass2.style.backgroundColor = goodColor;
		message.style.color = goodColor;
		message.innerHTML = "Passwords match.";
		return true;
	} else {
		pass2.style.backgroundColor = badColor;
		message.style.color = badColor;
		message.innerHTML = "Passwords don't match";
		return false;
	}
}

function validateEmail(email) { 
    var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regex.test(email);
} 