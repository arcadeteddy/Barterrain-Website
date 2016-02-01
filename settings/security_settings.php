<?php
ob_start();
include_once "../config.php";
$ids = $_SESSION['ids'];

if (!isset($skipper))
	{$error_message="";$success_message="";}
	
include_once "../scripts/check_login.php";
ob_flush();

$mysql = mysql_query("SELECT * FROM members WHERE id=$ids");
while($row = mysql_fetch_array($mysql))
	{$id = $row["id"];
	$email = $row['email'];
	$alt_email = $row['alt_email'];
	if (($email!=="")AND($alt_email!==""))
		{$email_show= "Primary Email: $email<br/>Secondary Email: $alt_email";$email_s="s";}
	else {$email_show= "Primary Email: $email";$email_s="";}
	}
?>

<script type="text/javascript" async>
function email()
	{$(".settings_1").removeClass("settings_1_active");
	$(".email").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".email2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function security_password()
	{$(".settings_1").removeClass("settings_1_active");
	$(".security_password").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".security_password2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function cancel()
	{$(".settings_1").removeClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");}
function showonlyone(thechosenone) 
	{var settings = document.getElementsByTagName("div");
	for(var x=0; x<settings.length; x++) 
		{name = settings[x].getAttribute("name");
		if (name == 'settings_one') 
			{if (settings[x].id == thechosenone) 
				{if (settings[x].style.display == 'block') 
					{settings[x].style.display = 'none';
					$$('div.settings_1').set('id','');
                    }
                else 
					{settings[x].style.display = 'block';}
				}
			else
				{settings[x].style.display = 'none';}
            }
		}
	}	
	
$('#email_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function email_form()
	{var email = $('#email');
	var alt_email = $('#alt_email');
	var password_ver1 = $('#password_ver1');
	if (email.val() == '')
		{$("#interactive_error").html('Please Fill In The Primary Email Field!<br/><br/>').show();}
	else if (password_ver1.val() == '')
		{$("#interactive_error").html('Please Fill In The Password Verification Field!<br/><br/>').show();}
	else
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$.post(InteractiveSetting,{id:id,ids:ids,email_security:email.val(),alt_email:alt_email.val(),password_ver1:password_ver1.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}	
$('#password_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function password_form()
	{var password = $('#password');
	var password_new = $('#password_new');
	var password_con = $('#password_con');
	if (password.val() == '')
		{$("#interactive_error").html('Please Fill In All Fields!<br/><br/>').show();}
	else if (password_new.val() == '')
		{$("#interactive_error").html('Please Fill In All Fields!<br/><br/>').show();}
	else if (password_con.val() == '')
		{$("#interactive_error").html('Please Fill In All Fields!<br/><br/>').show();}
	else
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$.post(InteractiveSetting,{id:id,ids:ids,password:password.val(),password_new:password_new.val(),password_con:password_con.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
</script>

<body>
<div class="margin"></div>
<div class="interactive_error" id="interactive_error">
	<?php echo $error_message; echo $success_message; ?>
</div>

<div class="settings_whole" style="border-top:solid 1px #E5E5E5;">
<a onMouseDown="javascript:email();javascript:showonlyone('settings1-2');" class="settings_1">
	<div class="settings_1 email">
		<div class="settings_1_1"><b>Email<?php echo $email_s; ?>: </b></div>
		<div class="settings_1_2"><?php echo $email_show; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:email_form()" method="post" type="multipart/form-data" name="email_form" id="email_form">
<div class="settings_1_3 email2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings1-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Primary Email: </div>
		<div class="settings_2_2"><input class="settings_parts" name="email" id="email" type="text" value="<?php echo "$email" ?>" readonly="readonly" placeholder="Enter A Primary Email..."/></div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Secondary Email: </div>
		<div class="settings_2_2"><input class="settings_parts" name="alt_email" id="alt_email" type="text" value="<?php echo "$alt_email" ?>" placeholder="Enter A Secondary Email..."/></div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Password Verification: </div>
		<div class="settings_2_2"><input class="settings_parts" name="password_ver1" id="password_ver1" type="password" placeholder="Enter Password Verification..."/></div>
    </div>
</div>
</form>
</div>

<div class="settings_whole">
<a onMouseDown="javascript:security_password();javascript:showonlyone('settings2-2');" class="settings_1">
	<div class="settings_1 security_password" >
		<div class="settings_1_1"><b>Password: </b></div>
		<div class="settings_1_2"><span>&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</span></div>
	</div>
</a>
<form class="settings_2" action="javascript:password_form()" method="post" type="multipart/form-data" name="password_form" id="password_form">
<div class="settings_1_3 security_password2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onClick="javascript:cancel();javascript:showonlyone('settings0-2');"/>
 	<input src="blank.gif" width="1px" height="1px" title="Save" type="image" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings2-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings"> &bull;&nbsp;</span>Current Password: </div>
		<div class="settings_2_2"><input class="settings_parts" name="password" type="password" id="password" placeholder="Enter Current Password..."/></div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>New Password: </div>
		<div class="settings_2_2"><input class="settings_parts" name="password_new" type="password" id="password_new" placeholder="Enter New Password..."/></div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings"> &bull;&nbsp;</span>New Password Confirmation: </div>
		<div class="settings_2_2"><input class="settings_parts" name="password_con" type="password" id="password_con" placeholder="Enter New Password Confirmation..."/></div>
	</div>
</div>
</form>
</div>

<div class="bottom_footer"><br/>
	<a class="buttonline">Incase you don't remember your password,<br/>we will send a temporary password to your primary email.<br/>
	<a href="delete_account.php" class="body">Click here</a> to delete your account by using the self-destruct button.</a>
<br/><br/></div>
</body>