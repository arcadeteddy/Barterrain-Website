<?php
ob_start();
include_once "../config.php";
$id = $_SESSION['ids'];

if (!isset($skipper))
	{$error_message="";$success_message="";}
	
include_once "../scripts/check_login.php";
ob_flush();

$cacheBuster = $_SESSION['cacheBuster'];
$mysql = mysql_query("SELECT * FROM members_planets WHERE id=$ids");
while($row = mysql_fetch_array($mysql))
	{$id = $row["id"];
	$alias = $row["alias"];
	$alias_activation = $row["alias_activation"];
	$planet_email1 = $row["planet_email1"];
	$planet_email2 = $row["planet_email2"];
	$planet_bio = $row["planet_bio"];
	$motto1 = $row["motto1"];	
	$motto2 = $row["motto2"];	
	$cell_number = $row["contact_info1"];
	$tel_number = $row["contact_info2"];

	if($alias_activation=="1"){$alias_summary = $alias." (Activated)";}
	else if($alias_activation=="0"){$alias_summary = $alias." (Deactivated)";}
	if (($planet_email1!=="")AND($planet_email2!==""))
		{$email_show= "Primary Creator Email: $planet_email1<br/>Secondary Creator Email: $planet_email2";$email_s="s";}
	else if ($planet_email1!=="") {$email_show= "Primary Creator Email: $planet_email1";$email_s="";}
	else if ($planet_email2!=="") {$email_show= "Secondary Creator Email: $planet_email2";$email_s="";}
	else {$email_show= "Undefined";$email_s="";}
	$planet_bio_undefined="";
	if($planet_bio==""){$planet_bio_undefined="Undefined";}
	else{$planet_bio_undefined=$planet_bio;}
	if(($motto1=="")AND($motto2==""))
		{$motto_summary="Undefined";$motto_s="";}
	else if(($motto1!=="")AND($motto2!==""))
		{$motto_summary="Creator Motto #1: $motto1<br/>Creator Motto #2: $motto2";$motto_s="s";}
	else if($motto1!=="")
		{$motto_summary="$motto1";$motto_s="";}
	else if($motto2!=="")
		{$motto_summary="$motto2";$motto_s="";}
	if (($cell_number)AND($tel_number))
		{$numbers= "Cell Phone Number: $cell_number<br/>Telephone Number: $tel_number";$contact_number_s="s";}
	else if ($cell_number)
		{$numbers= "Cell Phone Number: $cell_number";$contact_number_s="";}
	else if ($tel_number)
		{$numbers= "Telephone Number: $tel_number";$contact_number_s="";}
	else
		{$numbers="Undefined";$contact_number_s="";}
	}
	
$mysql1 = mysql_query("SELECT id FROM planets WHERE user_id='$ids' AND delete_item='1'");
while ($row = mysql_fetch_array($mysql1))
	{$planet_id = $row['id'];
	if (isset($planets_array)) {$planets_array = $planets_array.",".$planet_id;}
	else {$planets_array = $row['id'];}}
if (!isset($planets_array)) {$planets_array="";}
$planetsArray = explode(",",$planets_array);
$planets_count = count($planetsArray);
if ($planets_count>1) {$planets_s="s";}
else {$planets_s="";}

if (isset($_GET['planet_id']))
	{$planet_id_get=$_GET['planet_id'];
	$mysql_check = mysql_query("SELECT id FROM planets WHERE id='$planet_id_get'");
	$planet_id_check = mysql_num_rows($mysql_check);}
?>

<script type="text/javascript" async>
// DIFFERENT PARTS
function alias()
	{$(".settings_thumbs").removeClass("selected_settings_thumbs");
	$('#selected_planet_settings').html("").show();
	$(".settings_1").removeClass("settings_1_active");
	$(".alias").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".alias2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function planet_emails()
	{$(".settings_thumbs").removeClass("selected_settings_thumbs");
	$('#selected_planet_settings').html("").show();
	$(".settings_1").removeClass("settings_1_active");
	$(".planet_emails").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".planet_emails2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function planet_bio()
	{$(".settings_thumbs").removeClass("selected_settings_thumbs");
	$('#selected_planet_settings').html("").show();
	$(".settings_1").removeClass("settings_1_active");
	$(".planet_bio").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".planet_bio2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function motto()
	{$(".settings_thumbs").removeClass("selected_settings_thumbs");
	$('#selected_planet_settings').html("").show();
	$(".settings_1").removeClass("settings_1_active");
	$(".motto").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".motto2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function planet_contact_infos()
	{$(".settings_thumbs").removeClass("selected_settings_thumbs");
	$('#selected_planet_settings').html("").show();
	$(".settings_1").removeClass("settings_1_active");
	$(".planet_contact_infos").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".planet_contact_infos2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function planets()
	{$(".settings_1").removeClass("settings_1_active");
	$(".extra_settings_1").removeClass("settings_1_active");
	$(".planets").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".planets2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function planets2()
	{$(".settings_1").removeClass("settings_1_active");
	$(".extra_settings_1").removeClass("settings_1_active");
	$(".planets").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".planets2").removeClass("hidden");}
function cancel()
	{$(".settings_thumbs").removeClass("selected_settings_thumbs");
	$('#selected_planet_settings').html("").show();
	$(".settings_1").removeClass("settings_1_active");
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
	
// FORMS
$('#alias_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function alias_form()
	{var alias = $('#alias');
	var alias_activation = $('#alias_activation');
	var password_ver1 = $('#password_ver1');
	if (alias.val() == '')
		{$("#interactive_error").html('Please Fill In All Fields!<br/><br/>').show();}
	else if (password_ver1.val() == '')
		{$("#interactive_error").html('Please Fill In All Fields!<br/><br/>').show();}
	else
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$.post(InteractiveSetting,{id:id,ids:ids,alias_activation:alias_activation.val(),alias:alias.val(),password_ver1:password_ver1.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
$('#planet_emails_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function planet_emails_form()
	{var planet_email1 = $('#planet_email1');
	var planet_email2 = $('#planet_email2');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,planet_email1:planet_email1.val(),planet_email2:planet_email2.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}	
$('#planet_bio_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function planet_bio_form()
	{var planet_bio = $('#planet_bio');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,planet_bio:planet_bio.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
$('#planet_motto_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function planet_motto_form()
	{var motto1 = $('#planet_motto1');
	var motto2 = $('#planet_motto2');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,planet_motto1:motto1.val(),planet_motto2:motto2.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
$('#planet_contact_infos_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function planet_contact_infos_form()
	{var planet_contact_info1 = $('#planet_contact_info1');
	var planet_contact_info2 = $('#planet_contact_info2');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,planet_contact_info1:planet_contact_info1.val(),planet_contact_info2:planet_contact_info2.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
		
function extra_planet_settings(a)
	{$(".settings_thumbs").removeClass("selected_settings_thumbs");
	$('#selected_planet_settings').html("").show();
	$("#settings_thumbs_"+a).addClass("selected_settings_thumbs");
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$('#interactive_error').html('').show();
	$.post(InteractiveSetting,{id:id,ids:ids,planet_id:a,thisWipit:thisRandNum},function(data)
			{$('#selected_planet_settings').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
</script>
<script src="http://www.barterrain.com/scripts/date_changer.js" type="text/javascript" async></script>

<body id="planet_settings">
<div class="margin"></div>
<div class="interactive_error" id="interactive_error">
	<?php echo $error_message; echo $success_message; ?>
</div>

<div class="settings_whole" style="border-top:solid 1px #E5E5E5;">
<a href="javascript:showonlyone('settings1-2');" onClick="javascript:alias();" class="settings_1">
	<div class="settings_1 alias">
		<div class="settings_1_1"><b>Alias Name: </b></div>
		<div class="settings_1_2"><?php echo "$alias_summary"; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:alias_form()" method="post" type="multipart/form-data" name="alias_form" id="alias_form">
<div class="settings_1_3 alias2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings1-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Alias Name: </div>
		<div class="settings_2_2"><input class="settings_parts" name="alias" id="alias" type="text" value="<?php echo "$alias" ?>" placeholder="Enter An Alias Name..."/></div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Alias Activation: </div>
		<div class="settings_2_2">
        <select id="alias_activation" name="alias_activation" class="settings_parts">
			<option value="<?php echo "$alias_activation";?>">Alias Activation:</option>
			<option value="0">Activated - Alias Will Be Displayed Within Planets</option>
			<option value="1">Deactivated - Full Name Will Be Displayed Within Planets</option>
		</select>
        </div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Password Verification: </div>
		<div class="settings_2_2"><input class="settings_parts" name="password_ver1" id="password_ver1" type="password" placeholder="Enter Password Verification..."/></div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings2-2');" onClick="javascript:planet_emails();" class="settings_1">
	<div class="settings_1 planet_emails">
		<div class="settings_1_1"><b>Creator Email<?php echo $email_s; ?>: </b></div>
		<div class="settings_1_2"><?php echo $email_show; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:planet_emails_form()" method="post" type="multipart/form-data" name="planet_emails_form" id="planet_emails_form">
<div class="settings_1_3 planet_emails2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings2-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Primary Creator Email: </div>
		<div class="settings_2_2"><input class="settings_parts" name="planet_email1" id="planet_email1" type="text" value="<?php echo "$planet_email1" ?>" placeholder="Enter A Primary Creator Email..."/></div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Secondary Creator Email: </div>
		<div class="settings_2_2"><input class="settings_parts" name="planet_email2" id="planet_email2" type="text" value="<?php echo "$planet_email2" ?>" placeholder="Enter A Secondary Creator Email..."/></div>
	</div>
</div>
</form>
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings3-2');" onClick="javascript:planet_bio();" class="settings_1">
	<div class="settings_1 planet_bio">
		<div class="settings_1_1"><b>My Creator Story: </b></div>
		<div class="settings_1_2"><?php echo "$planet_bio_undefined"; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:planet_bio_form()" method="post" type="multipart/form-data" name="planet_bio_form" id="planet_bio_form">
<div class="settings_1_3 planet_bio2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings3-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_3"><span class="dot_divider_settings">&bull;&nbsp;</span>Creator Story: </div>
		<div class="settings_2_2">
        	<textarea class="settings_parts" name="planet_bio" id="planet_bio" placeholder="Enter A Creator Story..."><?php echo $planet_bio; ?></textarea>
        </div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings4-2');" onClick="javascript:motto();" class="settings_1">
	<div class="settings_1 motto">
		<div class="settings_1_1"><b>My Creator Motto<?php echo $motto_s; ?>: </b></div>
		<div class="settings_1_2"><?php echo $motto_summary; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:planet_motto_form()" method="post" type="multipart/form-data" name="planet_motto_form">
<div class="settings_1_3 motto2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings4-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Creator Motto #1: </div>
		<div class="settings_2_2"><input class="settings_parts" name="planet_motto1" id="planet_motto1" type="text" value="<?php echo $motto1; ?>" placeholder="Enter A Motto..."/></div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Creator Motto #2: </div>
		<div class="settings_2_2"><input class="settings_parts" name="planet_motto2" id="planet_motto2" type="text" value="<?php echo $motto2; ?>" placeholder="Enter A Motto..."/></div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings5-2');" onClick="javascript:planet_contact_infos();" class="settings_1">
	<div class="settings_1 planet_contact_infos">
		<div class="settings_1_1"><b>Contact Number<?php echo $contact_number_s; ?>: </b></div>
		<div class="settings_1_2"><?php echo "$numbers"; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:planet_contact_infos_form()" method="post" type="multipart/form-data" name="planet_contact_infos_form" id="planet_contact_infos_form">
<div class="settings_1_3 planet_contact_infos2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings5-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Cellphone Number: </div>
		<div class="settings_2_2"><input class="settings_parts" name="planet_contact_info1" id="planet_contact_info1" type="text" value="<?php echo "$cell_number" ?>" placeholder="Enter A Cellphone Number..."/></div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Telephone Number: </div>
		<div class="settings_2_2"><input class="settings_parts" name="planet_contact_info2" id="planet_contact_info2" type="text" value="<?php echo "$tel_number" ?>" placeholder="Enter A Telephone Number..."/></div>
	</div>
</div>
</form>
</div>
    
<?php 
if ($planets_array !== "")
	{echo '<div class="settings_whole">
	<a href="javascript:showonlyone(\'settings10-2\');" onClick="javascript:planets();" class="settings_1">
		<div class="settings_1 planets">
			<div class="settings_1_1"><b>Created Planet'.$planets_s.': </b></div>
			<div class="settings_1_2">Total Of '.$planets_count.' Created Planet'.$planets_s.'</div>
		</div>
	</a>
	<div class="settings_1_3 planets2 hidden">
  		<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone(\'settings0-2\');"/>
	</div>
	<div name="settings_one" id="settings10-2" class="settings_2" style="display:none;">
   		<div class="settings_parts">
			<div class="settings_2_3"><span class="dot_divider_settings">&bull;&nbsp;</span>Created Planet'.$planets_s.': </div>
			<div class="settings_2_2">';
        		$i = 0;
				foreach ($planetsArray as $key => $value)
					{$i++;
					$check_pic_planet="../planet_files/planet$value/planet_thumb.jpg";
					$default_pic_planet="../planet_files/planet0/planet_thumb.png";
					$mysqlArray = mysql_query("SELECT id, planet_name FROM planets WHERE id='$value' LIMIT 1");
					while ($row = mysql_fetch_array($mysqlArray))
						{$planet_id = $row['id'];
						$planet_name = $row['planet_name'];}
					
					if (file_exists($check_pic_planet))
						{$user_pic_planet="<a href='#' onclick='return false' onmousedown='javascript:extra_planet_settings(".$planet_id.");' title='".$planet_name."' style='text-decoration:none;'>
												<img src='$check_pic_planet#$cacheBuster' class='settings_thumbs' id='settings_thumbs_".$planet_id."'/>
											</a>";}
					else {$user_pic_planet="<a href='#' onclick='return false' onmousedown='javascript:extra_planet_settings(".$planet_id.");' title='".$planet_name."' style='text-decoration:none;'>
												<img src='$default_pic_planet#$cacheBuster' class='settings_thumbs' id='settings_thumbs_".$planet_id."'/>
											</a>";}
					echo "$user_pic_planet";
					} 
       		echo '</div>
		</div>
	</div>
		<div id="selected_planet_settings">
		</div>
	</div>';
	}  
?>
<script type="text/javascript">
<?php 
if ((isset($planet_id_get))AND($planet_id_check>0))
	{echo 'var planet_id_get = "'.$planet_id_get.'";
	onload = showonlyone(\'settings10-2\');onload = planets2();
	$(".settings_thumbs").removeClass("selected_settings_thumbs");
	$("#selected_planet_settings").html("").show();
	$("#settings_thumbs_"+planet_id_get).addClass("selected_settings_thumbs");
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,planet_id:planet_id_get,thisWipit:thisRandNum},function(data)
			{$("#selected_planet_settings").html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});';
	}
?>
</script>
	
<div class="bottom_footer"><br/>
<a class="button-line">Your planet information can be seen by everyone in the world.<br/>Only add information that you want everyone to see.
<br/><a href="delete_account.php" class="body">Click here</a> to delete your account by using the self-destruct button.</a>
<br/></div>
</body>
