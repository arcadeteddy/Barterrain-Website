<?php
ob_start();
include_once "../config.php";
$ids = $_SESSION['ids'];

if (!isset($skipper))
	{$error_message="";$success_message="";}
	
include_once "../scripts/check_login.php";
ob_flush();

$mysql = mysql_query("SELECT * FROM planets WHERE id=$planet_id");
while($row = mysql_fetch_array($mysql))
	{$planet_idp = $row['id'];
	$creator_display = $row['creator_display'];
	$creator_array = $row['creator_array'];
	$creatorArray = explode(",",$creator_array);
	$CREATORS = join(',',$creatorArray);
	$planet_name = $row['planet_name'];
	$planet_description = $row['planet_description'];
	$categories = $row['categories'];
	$planets_email1 = $row["planets_email1"];
	$planets_email2 = $row["planets_email2"];
	$planets_bio = $row["planets_bio"];
	$planets_motto1 = $row["planets_motto1"];	
	$planets_motto2 = $row["planets_motto2"];
	$cell_number = $row['planets_contact_info1'];
	$tel_number = $row['planets_contact_info2'];
	$scores = $row['scores'];
	$likes = $row['likes'];
	$loves = $row['loves'];
		
	$check_pic="../planet_files/planet$planet_id/planet_picture.jpg";
	$check_pic2="../planet_files/planet$planet_id/planet_picture.png";
	$check_pic3="../planet_files/planet$planet_id/planet_picture.gif";
	$default_pic="../planet_files/planet0/planet_picture.png";
	if ((file_exists($check_pic))OR(file_exists($check_pic2))OR(file_exists($check_pic3)))
		{$pic_added="<a href='#' class='body' onclick='return false' onmousedown='remove_planets_pic(".$planet_id.")'>Remove</a>";
		$planet_pic='';}
	else {$pic_added="";$planet_pic="";}
	$check_cover="../planet_files/planet$planet_id/cover_pic.jpg";
	if (file_exists($check_cover))
		{$cover_added="<a href='#' class='body' onclick='return false' onmousedown='remove_planets_cover_pic(".$planet_id.")'>Remove</a>";
		$cover_pic='';}
	else {$cover_added="";$cover_pic="";}
	
	$creators="";
	$mysql_creators1 = mysql_query("SELECT id, alias, alias_activation FROM members_planets WHERE id IN ($CREATORS)");
	while($row = mysql_fetch_array($mysql_creators1))
		{$id_c = $row['id'];
		$alias_c = $row['alias'];
		$alias_activation_c = $row['alias_activation'];
		$mysql_creators2 = mysql_query("SELECT firstname, lastname FROM members WHERE id=$id_c");
		while($row = mysql_fetch_array($mysql_creators2))
			{$firstname_c = $row['firstname'];
			$lastname_c = $row['lastname'];}
		if($creators=="")
			{if($alias_activation_c=="0"){$creators .= $firstname_c." ".$lastname_c;}
			else if($alias_activation_c=="1"){$creators .= $alias_c;}}
		else if($creators!=="")
			{if($alias_activation_c=="0"){$creators .= " | ".$firstname_c." ".$lastname_c;}
			else if($alias_activation_c=="1"){$creators .= " | ".$alias_c;}}
		}
	
	if($creator_display=="1"){$creators = $creators." (Activated)";}
	else if($creator_display=="0"){$creators = $creators." (Deactivated)";}
	if($planet_description==""){$planet_description_summary="Undefined";}
	else{$planet_description_summary=$planet_description;}
	if($categories==""){$categories="Undefined";}
	else{$categories=$categories;}
	if (($planets_email1!=="")AND($planets_email2!==""))
		{$email_show= "Primary Planet Email: $planets_email1<br/>Secondary Planet Email: $planets_email2";$email_s="s";}
	else if ($planets_email1!=="") {$email_show= "Primary Planet Email: $planets_email1";$email_s="";}
	else if ($planets_email2!=="") {$email_show= "Secondary Planet Email: $planets_email2";$email_s="";}
	else {$email_show= "Undefined";$email_s="";}
	$planets_bio_undefined="";
	if($planets_bio==""){$planets_bio_undefined="Undefined";}
	else{$planets_bio_undefined=$planets_bio;}
	if(($planets_motto1=="")AND($planets_motto2==""))
		{$planets_motto_summary="Undefined";$planets_motto_s="";}
	else if(($planets_motto1!=="")AND($planets_motto2!==""))
		{$planets_motto_summary="Planet Motto #1: $planets_motto1<br/>Planet Motto #2: $planets_motto2";$planets_motto_s="s";}
	else if($planets_motto1!=="")
		{$planets_motto_summary="$planets_motto1";$planets_motto_s="";}
	else if($planets_motto2!=="")
		{$planets_motto_summary="$planets_motto2";$planets_motto_s="";}
	if (($cell_number)AND($tel_number))
		{$numbers= "Cell Phone Number: $cell_number<br/>Telephone Number: $tel_number";$contact_number_s="s";}
	else if ($cell_number)
		{$numbers= "Cell Phone Number: $cell_number";$contact_number_s="";}
	else if ($tel_number)
		{$numbers= "Telephone Number: $tel_number";$contact_number_s="";}
	else
		{$numbers="Undefined";$contact_number_s="";}
	}
	if ($scores=="a")
		{$scores2="(Deactivated)";}
	else if ($scores=="b")
		{$scores2="(Activated)";}
?>

<script type="text/javascript">
var planet_idp = "<?php echo $planet_idp; ?>";
// DIFFERENT PARTS
function planet_picture()
	{$(".extra_settings_1").removeClass("settings_1_active");
	$(".planet_picture").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".planet_picture2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function cover_picture()
	{$(".extra_settings_1").removeClass("settings_1_active");
	$(".cover_picture").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".cover_picture2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function creator_display()
	{$(".extra_settings_1").removeClass("settings_1_active");
	$(".creator_display").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".creator_display2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function planet_name()
	{$(".extra_settings_1").removeClass("settings_1_active");
	$(".planet_name").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".planet_name2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function planets_emails()
	{$(".extra_settings_1").removeClass("settings_1_active");
	$(".planets_emails").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".planets_emails2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function planet_description()
	{$(".extra_settings_1").removeClass("settings_1_active");
	$(".planet_description").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".planet_description2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function categories()
	{$(".extra_settings_1").removeClass("settings_1_active");
	$(".categories").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".categories2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function planets_bio()
	{$(".extra_settings_1").removeClass("settings_1_active");
	$(".planets_bio").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".planets_bio2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function planets_motto()
	{$(".extra_settings_1").removeClass("settings_1_active");
	$(".planets_motto").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".planets_motto2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function planets_contact_infos()
	{$(".extra_settings_1").removeClass("settings_1_active");
	$(".planets_contact_infos").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".planets_contact_infos2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function planet_scores()
	{$(".extra_settings_1").removeClass("settings_1_active");
	$(".planet_scores").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".planet_scores2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function extra_cancel()
	{$(".extra_settings_1").removeClass("settings_1_active");
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
	
function remove_planets_pic(a)
	{$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{interactive:"remove_planets_pic",id:id,ids:ids,planet_id:a,thisWipit:thisRandNum},function(data) 
		{$("body").html(data).show();
		$("div.full_page_loader").addClass("full_page_loader_hidden");});}
function remove_planets_cover_pic(a)
	{$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{interactive:"remove_planets_cover_pic",id:id,ids:ids,planet_id:a,thisWipit:thisRandNum},function(data) 
		{$("body").html(data).show();
		$("div.full_page_loader").addClass("full_page_loader_hidden");});}

$('#creator_display_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function creator_display_form()
	{var creator_display = $('#creator_display');
	if (creator_display.val() == '')
		{$("#interactive_error").html('Please Fill In The Display Creators Field!<br/><br/>').show();}
	else 
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$.post(InteractiveSetting,{id:id,ids:ids,planet_idp:planet_idp,creator_display:creator_display.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
$('#planet_name_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function planet_name_form()
	{var planet_name = $('#planet_name');
	var planet_password_ver1 = $('#planet_password_ver1');
	if (planet_name.val() == '')
		{$("#interactive_error").html('Please Fill In All Fields!<br/><br/>').show();}
	else if (planet_password_ver1.val() == '')
		{$("#interactive_error").html('Please Fill In All Fields!<br/><br/>').show();}
	else
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$.post(InteractiveSetting,{id:id,ids:ids,planet_idp:planet_idp,planet_name:planet_name.val(),password_ver1:planet_password_ver1.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}		
$('#planet_emails_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function planets_emails_form()
	{var planets_email1 = $('#planets_email1');
	var planets_email2 = $('#planets_email2');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,planet_idp:planet_idp,planets_email1:planets_email1.val(),planets_email2:planets_email2.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}	
$('#planet_description_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function planet_description_form()
	{var planet_description = $('#planet_description');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,planet_idp:planet_idp,planet_description:planet_description.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
$('#categories_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function categories_form()
	{var categories = $('#categories');
	if (categories.val() == '')
		{$("#interactive_error").html('Please Fill In The Category Field!<br/><br/>').show();}
	else 
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$.post(InteractiveSetting,{id:id,ids:ids,planet_idp:planet_idp,categories:categories.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
$('#planets_bio_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function planets_bio_form()
	{var planets_bio = $('#planets_bio');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,planet_idp:planet_idp,planets_bio:planets_bio.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
$('#planets_motto_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function planets_motto_form()
	{var planets_motto1 = $('#planets_motto1');
	var planets_motto2 = $('#planets_motto2');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,planet_idp:planet_idp,planets_motto1:planets_motto1.val(),planets_motto2:planets_motto2.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
$('#planets_contact_infos_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function planets_contact_infos_form()
	{var planets_contact_info1 = $('#planets_contact_info1');
	var planets_contact_info2 = $('#planets_contact_info2');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,planet_idp:planet_idp,planets_contact_info1:planets_contact_info1.val(),planets_contact_info2:planets_contact_info2.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
$('#planet_scores_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function planet_scores_form()
	{var planet_scores = $('#planet_scores');
	if (planet_scores.val() == '')
		{$("#interactive_error").html('Please Fill In The Planet Scores Field!<br/><br/>').show();}
	else 
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$.post(InteractiveSetting,{id:id,ids:ids,planet_idp:planet_idp,planet_scores:planet_scores.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
	
function display_picture()
	{var a=document.getElementById('fileField').value;
    var b=a.replace("C:\\fakepath\\","");
		document.getElementById("fakeupload").innerHTML=b;}
function display_picture2()
	{var a=document.getElementById('fileField2').value;
    var b=a.replace("C:\\fakepath\\","");
		document.getElementById("fakeupload2").innerHTML=b;}
</script>

<div class="settings_whole extra_settings_top">
<a href="javascript:showonlyone('settings11-2');" onClick="javascript:planet_picture();" class="settings_1">
	<div class="settings_1_hover extra_settings_1 planet_picture">
		<div class="settings_1_1"><b>Planet Picture</b></div>
		<div class="settings_1_2"><?php echo $pic_added;?></div>
	</div>
</a>
<form class="settings_2" action="settings.php?settings=planet&planet_id=<?php echo $planet_id; ?>" method="post" enctype="multipart/form-data">
<div class="settings_1_3 planet_picture2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:extra_cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
    <input name="parse_var" type="hidden" value="planet_picture"/>
    <input name="planet_id" type="hidden" value="<?php echo $planet_id; ?>"/>
</div>
<div name="settings_one" id="settings11-2" class="settings_2" style="display:none;">
	<?php echo $planet_pic; ?>
    <div class="settings_parts">
		<div class="settings_2_1" style="margin-top:6px;vertical-align:top;"><span class="dot_divider_settings" >&bull;&nbsp;</span>Planet Picture: </div>
		<div class="settings_2_2">
        	<div id="fakeupload" class="fakeupload"></div>
			<div class="fakeupload2">
				<input onChange="display_picture()" name="fileField" id="fileField" type="file" class="picture_field" value="planet_picture" size="80"/>
			</div>
        </div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings12-2');" onClick="javascript:cover_picture();" class="settings_1">
	<div class="settings_1_hover extra_settings_1 cover_picture">
		<div class="settings_1_1"><b>Cover Picture</b></div>
		<div class="settings_1_2"><?php echo $cover_added; ?></div>
	</div>
</a>
<form class="settings_2" action="settings.php?settings=planet&planet_id=<?php echo $planet_id; ?>" method="post" enctype="multipart/form-data">
<div class="settings_1_3 cover_picture2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:extra_cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
    <input name="parse_var" type="hidden" value="planet_cover_picture"/>
     <input name="planet_id" type="hidden" value="<?php echo $planet_id; ?>"/>
</div>
<div name="settings_one" id="settings12-2" class="settings_2" style="display:none;">
	<?php echo $cover_pic; ?>
    <div class="settings_parts">
		<div class="settings_2_1" style="margin-top:6px;vertical-align:top;"><span class="dot_divider_settings">&bull;&nbsp;</span>Cover Picture: </div>
		<div class="settings_2_2">
          	<div id="fakeupload2" class="fakeupload"></div>
			<div class="fakeupload2">
				<input onChange="display_picture2()" name="fileField2" id="fileField2" type="file" class="picture_field" value="planet_cover_picture" size="80"/>
			</div>
        </div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings21-2');" onClick="javascript:creator_display();" class="settings_1">
	<div class="settings_1_hover extra_settings_1 creator_display">
		<div class="settings_1_1"><b>Display Creators: </b></div>
		<div class="settings_1_2"><?php echo $creators;?> </div>
	</div>
</a>
<form class="settings_2" action="javascript:creator_display_form()" method="post" type="multipart/form-data" name="creator_display_form">
<div class="settings_1_3 creator_display2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:extra_cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings21-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Display Creators: </div>
		<div class="settings_2_2">
        	<select name="creator_display" id="creator_display" class="settings_parts">
            	<option value="">Display Creators:</option>
                <option value="1">Activated - Display Creators Of This Planet</option>
                <option value="0">Deactivated - Don't Display Creators Of This Planet</option>
           	</select>
       	</div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings14-2');" onClick="javascript:planet_name();" class="settings_1">
	<div class="settings_1_hover extra_settings_1 planet_name">
		<div class="settings_1_1"><b>Planet Name: </b></div>
		<div class="settings_1_2"><?php echo "$planet_name"; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:planet_name_form()" method="post" type="multipart/form-data" name="planet_name_form" id="planet_name_form">
<div class="settings_1_3 planet_name2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:extra_cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings14-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Planet Name: </div>
		<div class="settings_2_2"><input class="settings_parts" name="planet_name" id="planet_name"  type="text" value="<?php echo "$planet_name" ?>" placeholder="Enter A Planet Name..."/></div>
	</div>
    <div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Password Verification: </div>
		<div class="settings_2_2"><input class="settings_parts" name="planet_password_ver1" id="planet_password_ver1" type="password" placeholder="Enter Password Verification..."/></div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings13-2');" onClick="javascript:planets_emails();" class="settings_1">
	<div class="settings_1_hover extra_settings_1 planets_emails">
		<div class="settings_1_1"><b>Planet Email<?php echo $email_s; ?>: </b></div>
		<div class="settings_1_2"><?php echo $email_show; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:planets_emails_form()" method="post" type="multipart/form-data" name="planets_emails_form" id="planets_emails_form">
<div class="settings_1_3 planets_emails2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:extra_cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings13-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Primary Planet Email: </div>
		<div class="settings_2_2"><input class="settings_parts" name="planets_email1" id="planets_email1" type="text" value="<?php echo "$planets_email1" ?>" placeholder="Enter A Primary Planet Email..."/></div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Secondary Planet Email: </div>
		<div class="settings_2_2"><input class="settings_parts" name="planets_email2" id="planets_email2" type="text" value="<?php echo "$planets_email2" ?>" placeholder="Enter A Secondary Planet Email..."/></div>
	</div>
</div>
</form>
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings15-2');" onClick="javascript:planet_description();" class="settings_1">
	<div class="settings_1_hover extra_settings_1 planet_description">
		<div class="settings_1_1"><b>Planet Description: </b></div>
		<div class="settings_1_2"><?php echo "$planet_description_summary"; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:planet_description_form()" method="post" type="multipart/form-data" name="planet_description_form" id="planet_description_form">
<div class="settings_1_3 planet_description2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:extra_cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings15-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_3"><span class="dot_divider_settings">&bull;&nbsp;</span>Planet Description: </div>
		<div class="settings_2_2">
        	<textarea class="settings_parts" name="planet_description" id="planet_description" placeholder="Enter A Planet Description..."><?php echo $planet_description; ?></textarea>
        </div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings16-2');" onClick="javascript:categories();" class="settings_1">
	<div class="settings_1_hover extra_settings_1 categories">
		<div class="settings_1_1"><b>Category: </b></div>
		<div class="settings_1_2"><?php echo "$categories"; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:categories_form()" method="post" type="multipart/form-data" name="categories_form">
<div class="settings_1_3 categories2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:extra_cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings16-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Category: </div>
		<div class="settings_2_2">
        	<select name="categories" id="categories" class="settings_parts">
        	<option value="">Category:</option>
            <option value="Artist">Artist</option>
			<option value="Brand / Product">Brand / Product</option>
			<option value="Business / Company / Organization">Business / Company / Organization</option>
            <option value="Critic">Critic</option>
            <option value="Education">Education</option>
			<option value="Entertainment">Entertainment</option>
            <option value="Indefinable">Indefinable</option>
			<option value="Non-Profit Cause">Non-Profit Cause</option>
            <option value="Personal">Personal</option>
			<option value="Public Figure">Public Figure</option>
			<option value="Other">Other</option>
            <option value="Undefined">Undefined</option>
            </select>
        </div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings17-2');" onClick="javascript:planets_bio();" class="settings_1">
	<div class="settings_1_hover extra_settings_1 planets_bio">
		<div class="settings_1_1"><b>My Planet Story: </b></div>
		<div class="settings_1_2"><?php echo "$planets_bio_undefined"; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:planets_bio_form()" method="post" type="multipart/form-data" name="planets_bio_form" id="planets_bio_form">
<div class="settings_1_3 planets_bio2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:extra_cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings17-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_3"><span class="dot_divider_settings">&bull;&nbsp;</span>Planet Story: </div>
		<div class="settings_2_2">
        	<textarea class="settings_parts" name="planets_bio" id="planets_bio" placeholder="Enter A Planet Story..."><?php echo $planets_bio; ?></textarea>
        </div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings18-2');" onClick="javascript:planets_motto();" class="settings_1">
	<div class="settings_1_hover extra_settings_1 planets_motto">
		<div class="settings_1_1"><b>My Planet Motto<?php echo $planets_motto_s; ?>: </b></div>
		<div class="settings_1_2"><?php echo $planets_motto_summary; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:planets_motto_form()" method="post" type="multipart/form-data" name="planets_motto_form">
<div class="settings_1_3 planets_motto2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:extra_cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings18-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Planet Motto #1: </div>
		<div class="settings_2_2"><input class="settings_parts" name="planets_motto1" id="planets_motto1" type="text" value="<?php echo $planets_motto1; ?>" placeholder="Enter A Motto..."/></div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Planet Motto #2: </div>
		<div class="settings_2_2"><input class="settings_parts" name="planets_motto2" id="planets_motto2" type="text" value="<?php echo $planets_motto2; ?>" placeholder="Enter A Motto..."/></div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings19-2');" onClick="javascript:planets_contact_infos();" class="settings_1">
	<div class="settings_1_hover extra_settings_1 planets_contact_infos">
		<div class="settings_1_1"><b>Contact Number<?php echo $contact_number_s; ?>: </b></div>
		<div class="settings_1_2"><?php echo "$numbers"; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:planets_contact_infos_form()" method="post" type="multipart/form-data" name="planets_contact_infos_form" id="planets_contact_infos_form">
<div class="settings_1_3 planets_contact_infos2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:extra_cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings19-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Cellphone Number: </div>
		<div class="settings_2_2"><input class="settings_parts" name="planets_contact_info1" id="planets_contact_info1" type="text" value="<?php echo "$cell_number" ?>" placeholder="Enter A Cellphone Number..."/></div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Telephone Number: </div>
		<div class="settings_2_2"><input class="settings_parts" name="planets_contact_info2" id="planets_contact_info2" type="text" value="<?php echo "$tel_number" ?>" placeholder="Enter A Telephone Number..."/></div>
	</div>
</div>
</form>
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings20-2');" onClick="javascript:planet_scores();" class="settings_1">
	<div class="settings_1_hover extra_settings_1 planet_scores">
		<div class="settings_1_1"><b>Planet Scores: </b></div>
		<div class="settings_1_2">Total Of <?php echo "$likes"; ?> Liked Items | Total Of <?php echo "$loves"; ?> Loved Items <?php echo $scores2;?> </div>
	</div>
</a>
<form class="settings_2" action="javascript:planet_scores_form()" method="post" type="multipart/form-data" name="planet_scores_form">
<div class="settings_1_3 planet_scores2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:extra_cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings20-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Planet Scores: </div>
		<div class="settings_2_2">
        	<select name="planet_scores" id="planet_scores" class="settings_parts">
            	<option value="">Planet Scores:</option>
                <option value="b">Activated - Scores Will Be Displayed Within Planet</option>
                <option value="a">Deactivated - No Scores Will Be Displayed Within Planet</option>
           	</select>
       	</div>
	</div>
</div>
</form>	
</div>