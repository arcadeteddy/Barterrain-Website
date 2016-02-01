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
	$location = $row['location'];
	$primary_school = $row['primary_school'];
	$secondary_school = $row["secondary_school"];
	$post_secondary = $row['post_secondary'];
	$employer = $row['employer'];
	}
?>

<script type="text/javascript">
// DIFFERENT PARTS
function location()
	{$(".settings_1").removeClass("settings_1_active");
	$(".location").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".location2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function primary_school()
	{$(".settings_1").removeClass("settings_1_active");
	$(".primary_school").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".primary_school2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function secondary_school()
	{$(".settings_1").removeClass("settings_1_active");
	$(".secondary_school").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".secondary_school2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function post_secondary()
	{$(".settings_1").removeClass("settings_1_active");
	$(".post_secondary").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".post_secondary2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function employer()
	{$(".settings_1").removeClass("settings_1_active");
	$(".employer").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".employer2").removeClass("hidden");
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
		
$('#location_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function location_form()
	{var location = $('#location');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,location:location.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
$('#primary_school_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function primary_school_form()
	{var primary_school = $('#primary_school');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,primary_school:primary_school.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
$('#secondary_school_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function secondary_school_form()
	{var secondary_school = $('#secondary_school');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,secondary_school:secondary_school.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
$('#post_secondary_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function post_secondary_form()
	{var post_secondary = $('#post_secondary');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,post_secondary:post_secondary.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
$('#employer_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function employer_form()
	{var employer = $('#employer');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,employer:employer.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
</script>

<body>
<div class="margin"></div>
<div class="interactive_error" id="interactive_error">
	<?php echo $error_message; echo $success_message; ?>
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings3-2');" onClick="javascript:fullname();" class="settings_1">
	<div class="settings_1 fullname">
		<div class="settings_1_1"><b>Name: </b></div>
		<div class="settings_1_2"><?php echo "$firstname $middlename $lastname"; ?></div>
		<div class="settings_1_3"><img class="settings_1_3"/></div>
	</div>
</a>
<form class="settings_2" action="javascript:fullname_form()" method="post" type="multipart/form-data" name="fullname_form" id="fullname_form">
<div class="settings_1_3 fullname2 hidden">
  	<img src="barterrain_settings_images/blank.gif" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="barterrain_settings_images/blank.gif" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings3-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>First Name: </div>
		<div class="settings_2_2"><input class="settings_parts" name="firstname" id="firstname"  type="text" value="<?php echo "$firstname" ?>" placeholder="Enter A First Name..."/></div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Middle Name: </div>
		<div class="settings_2_2"><input class="settings_parts" name="middlename" id="middlename"  type="text" value="<?php echo "$middlename" ?>" placeholder="Enter A Middle Name..."/></div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Last Name: </div>
		<div class="settings_2_2"><input class="settings_parts" name="lastname" id="lastname" type="text" value="<?php echo "$lastname" ?>" placeholder="Enter A Last Name..."/></div>
	</div>
</div>
</form>	
</div>

<div class="bottom_footer"><br/>
<a class="button-line">Circles are networks that you are a part of.<br/> It helps others and you find each other easier.
<br/><a href="delete_account.php" class="body">Click here</a> to delete your account by using the self-destruct button!</a>
</div>
</body>