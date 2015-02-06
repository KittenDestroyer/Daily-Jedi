function checkForm(form) {
	var username = form.username.value;
	var password = form.password.value;
	var errors = [];

	if(!checkLength(username)) {
		errors.push('Enter username');
	}

	if(!checkLength(password)) {
		errors.push('Enter password');
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