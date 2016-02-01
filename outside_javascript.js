////////////// SIGNUP FOR ACCOUNT //////////////
$('#signup_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function signup_form()
	{var firstname = $('#firstname');
	var lastname = $('#lastname');
	var alias = $('#alias');
	var signup_email = $('#signup_email');
	var re_email = $('#re_email');
	var signup_password = $('#signup_password');
	var re_password = $('#re_password');
	var gender = $('#gender');
	var birthday_month = $('#birthday_month');
	var birthday_day = $('#birthday_day');
	var birthday_year = $('#birthday_year');
	if (firstname.val() == ''||lastname.val() == ''||alias.val() == ''||signup_email.val() == ''||re_email.val() == ''||signup_password.val() == ''||re_password.val() == ''||gender.val() == ''||birthday_month.val() == ''||birthday_day.val() == ''||birthday_year.val() == '')
		{$("#signup_status").html('Please Fill In All Fields!').show();}
	else
		{$("#signup_status").html('Loading...').show();
		$.post(interactive_outside,{interactive_outside:"signup",firstname:firstname.val(),lastname:lastname.val(),alias:alias.val(),signup_email:signup_email.val(),re_email:re_email.val(),signup_password:signup_password.val(),re_password:re_password.val(),gender:gender.val(),birthday_month:birthday_month.val(),birthday_day:birthday_day.val(),birthday_year:birthday_year.val(),invite_code:invite_code},function(data)
			{$('#signup_status').html(data).show();
			document.signup_form.signup_password.value='';
			document.signup_form.re_password.value='';});
		}
	}

////////////// FORGOT MY PASSWORD //////////////
$('#reset_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function reset_form()
	{var reset_field = $('#reset_field');
	if (reset_field.val() == '')
		{$("#reset_status").html('Please Fill In Email Field!').show();}
	else
		{$("#reset_status").html('Loading...').show();
		$.post(interactive_outside,{interactive_outside:"reset",reset_field:reset_field.val()},function(data)
			{$('#reset_status').html(data).show();
			document.reset_form.reset_field.value='';});
		}
	}

$(document).on('click', '#outside_pages a', function() {
    var panel = $(this).data('href');
    $.scrollTo(panel, 1000);
});