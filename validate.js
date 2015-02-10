$(document).ready(function(){

  $("#")

  $("#regForm").validate({
  	rules: {
  		username: "required",
  		email: {
  			required: true,
  			email: true
  		},
  		password: {
  			required: true,
  			minlength: 5
  		},
  		password2: {
  			required: true,
  			minlength: 5,
  			equalTo: "#password"
  		}
  	},

  	messages: {

  	},

  	submitHandler: function(form) {
  		from.submit();
  	}
  });
});