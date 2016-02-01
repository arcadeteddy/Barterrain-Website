<?php
ob_start();
include_once "../config.php";
$ids = $_SESSION['ids'];

if (!isset($skipper))
	{$error_message="";$success_message="";}
	
include_once "../scripts/check_login.php";
ob_flush();

$mysql1 = mysql_query("SELECT email_notification_activation, email_comment_notification_activation FROM members WHERE id='$ids'");
while($row = mysql_fetch_array($mysql1))
	{$profile_email_notification_activation = $row["email_notification_activation"];
	$profile_email_comment_notification_activation = $row['email_comment_notification_activation'];
	if ($profile_email_notification_activation=="1")
		{$profile_notification_show= "Activated";}
	else {$profile_notification_show= "Deactivated";}
	if ($profile_email_comment_notification_activation=="1")
		{$profile_comment_notification_show= "Activated";}
	else {$profile_comment_notification_show= "Deactivated";}
	}
$mysql2 = mysql_query("SELECT email_notification_activation, email_comment_notification_activation FROM members_planets WHERE id='$ids'");
while($row = mysql_fetch_array($mysql2))
	{$planet_email_notification_activation = $row["email_notification_activation"];
	$planet_email_comment_notification_activation = $row['email_comment_notification_activation'];
	if ($planet_email_notification_activation=="1")
		{$planet_notification_show= "Activated";}
	else {$planet_notification_show= "Deactivated";}
	if ($planet_email_comment_notification_activation=="1")
		{$planet_comment_notification_show= "Activated";}
	else {$planet_comment_notification_show= "Deactivated";}
	}
?>

<script type="text/javascript">
function profile_notifications()
	{$(".settings_1").removeClass("settings_1_active");
	$(".profile_notifications").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".profile_notifications2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function planet_notifications()
	{$(".settings_1").removeClass("settings_1_active");
	$(".planet_notifications").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".planet_notifications2").removeClass("hidden");
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
	
$('#profile_notification_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function profile_notification_form()
	{var profile_email_notification_select = $('#profile_email_notification_select');
	var profile_email_comment_notification_select = $('#profile_email_comment_notification_select');
	if (profile_email_notification_select.val() == '')
		{$("#interactive_error").html('Please Fill In The Item Notification Field!<br/><br/>').show();}
	else if (profile_email_comment_notification_select.val() == '')
		{$("#interactive_error").html('Please Fill In The Comment Notification Field!<br/><br/>').show();}
	else 
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$.post(InteractiveSetting,{id:id,ids:ids,profile_email_notification_select:profile_email_notification_select.val(),profile_email_comment_notification_select:profile_email_comment_notification_select.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
$('#planet_notification_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function planet_notification_form()
	{var planet_email_notification_select = $('#planet_email_notification_select');
	var planet_email_comment_notification_select = $('#planet_email_comment_notification_select');
	if (planet_email_notification_select.val() == '')
		{$("#interactive_error").html('Please Fill In The Item Notification Field!<br/><br/>').show();}
	else if (planet_email_comment_notification_select.val() == '')
		{$("#interactive_error").html('Please Fill In The Comment Notification Field!<br/><br/>').show();}
	else 
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$.post(InteractiveSetting,{id:id,ids:ids,planet_email_notification_select:planet_email_notification_select.val(),planet_email_comment_notification_select:planet_email_comment_notification_select.val(),thisWipit:thisRandNum},function(data)
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
<a onMouseDown="javascript:profile_notifications();javascript:showonlyone('settings1-2');" class="settings_1">
	<div class="settings_1 profile_notifications">
		<div class="settings_1_1"><b>Profile Notifications: </b></div>
		<div class="settings_1_2"><span>Item Notifications (<?php echo "$profile_notification_show";?>) | Comment Notifications (<?php echo "$profile_comment_notification_show";?>)</span></div>
	</div>
</a>
<form class="settings_2" action="javascript:profile_notification_form()" method="post" type="multipart/form-data" name="profile_notification_form" id="profile_notification_form">
<div class="settings_1_3 profile_notifications2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings1-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Item Notifications: </div>
		<div class="settings_2_2">
        <select id="profile_email_notification_select" name="profile_email_notification_select" class="settings_parts">
			<option value="<?php echo "$profile_email_notification_activation";?>">Item Notifications:</option>
			<option value="1">Activated - Profile Item Notifications Will Be Sent To Your Email</option>
			<option value="0">Deactivated - Profile Item Notifications Will Not Be Sent To Your Email</option>
		</select>
        </div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Comment Notifications: </div>
		<div class="settings_2_2">
        <select id="profile_email_comment_notification_select" name="profile_email_comment_notification_select" class="settings_parts">
			<option value="<?php echo "$profile_email_comment_notification_activation";?>">Comment Notifications:</option>
			<option value="1">Activated - Profile Comment Notifications Will Be Sent To Your Email</option>
			<option value="0">Deactivated - Profile Comment Notifications Will Not Be Sent To Your Email</option>
		</select>
        </div>
	</div>
</div>
</form>
</div>

<div class="settings_whole">
<a onMouseDown="javascript:planet_notifications();javascript:showonlyone('settings2-2');" class="settings_1">
	<div class="settings_1 planet_notifications" >
		<div class="settings_1_1"><b>Planet Notifications: </b></div>
		<div class="settings_1_2"><span>Item Notifications (<?php echo "$planet_notification_show";?>) | Comment Notifications (<?php echo "$planet_comment_notification_show";?>)</span></div>
	</div>
</a>
<form class="settings_2" action="javascript:planet_notification_form()" method="post" type="multipart/form-data" name="planet_notification_form" id="planet_notification_form">
<div class="settings_1_3 planet_notifications2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onClick="javascript:cancel();javascript:showonlyone('settings0-2');"/>
 	<input src="blank.gif" width="1px" height="1px" title="Save" type="image" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings2-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Item Notifications: </div>
		<div class="settings_2_2">
        <select id="planet_email_notification_select" name="planet_email_notification_select" class="settings_parts">
			<option value="<?php echo "$planet_email_notification_activation";?>">Item Notifications:</option>
			<option value="1">Activated - Planet Item Notifications Will Be Sent To Your Planet Email</option>
			<option value="0">Deactivated - Planet Item Notifications Will Not Be Sent To Your Planet Email</option>
		</select>
        </div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Comment Notifications: </div>
		<div class="settings_2_2">
        <select id="planet_email_comment_notification_select" name="planet_email_comment_notification_select" class="settings_parts">
			<option value="<?php echo "$planet_email_comment_notification_activation";?>">Comment Notifications:</option>
			<option value="1">Activated - Planet Comment Notifications Will Be Sent To Your Planet Email</option>
			<option value="0">Deactivated - Planet Comment Notifications Will Not Be Sent To Your Planet Email</option>
		</select>
        </div>
	</div>
</div>
</form>
</div>

<div class="bottom_footer"><br/>
	<a class="buttonline">Notifications are everything you missed since your last login.<br/>Filter what email notifications you want and what you don't want here.<br/>
	<a href="delete_account.php" class="body">Click here</a> to delete your account by using the self-destruct button.</a>
<br/><br/></div>
</body>