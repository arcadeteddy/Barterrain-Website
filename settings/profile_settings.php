<?php
ob_start();
include_once "../config.php";
$ids = $_SESSION['ids'];

$birthday_month = "Month:";
$birthday_day = "Day:";
$birthday_year = "Year:";

if (!isset($skipper))
	{$error_message="";$success_message="";}
	
include_once "../scripts/check_login.php";
ob_flush();

$mysql = mysql_query("SELECT * FROM members WHERE id=$ids");
while($row = mysql_fetch_array($mysql))
	{$id = $row["id"];
	$email = $row['email'];
	$alt_email = $row['alt_email'];
	$firstname = $row["firstname"];
	$middlename = $row["middlename"];
	$lastname = $row["lastname"];
	$gender = $row["gender"];	
	$birthday_ymd = $row["birthday_ymd"];
	$personal_bio = $row["personal_bio"];
	$personal_bio = str_replace("&amp;#39;","'", $personal_bio);
	$personal_bio = stripslashes($personal_bio);
	$motto1 = $row["motto1"];	
	$motto2 = $row["motto2"];	
	$location = $row['location'];
	$primary_school = $row['primary_school'];
	$secondary_school = $row["secondary_school"];
	$post_secondary = $row['post_secondary'];
	$employer = $row['employer'];
	$cell_number = $row["cell_number"];	
	$tel_number = $row["tel_number"];
	$relationship = $row["relationship"];
		
	$likes = $row["likes"];	
	$loves = $row["loves"];	
	$scores = $row["scores"];
		
	$check_pic="../user_files/user$id/profile_pic.jpg";
	$default_pic="../user_files/user0/default_profile_pic.jpg";
	if (file_exists($check_pic))
		{$pic_added="<a href='#' class='body' onclick='return false' onmousedown='remove_profile_pic(".$ids.")'>Remove</a>";
		$profile_pic='';}
	else {$pic_added="";$profile_pic="";}
	$check_cover="../user_files/user$id/cover_pic.jpg";
	if (file_exists($check_cover))
		{$cover_added="<a href='#' class='body' onclick='return false' onmousedown='remove_cover_pic(".$ids.")'>Remove</a>";
		$cover_pic='';}
	else {$cover_added="";$cover_pic="";}
	
	if (($email!=="")AND($alt_email!==""))
		{$email_show= "Primary Email: $email<br/>Secondary Email: $alt_email";$email_s="s";}
	else {$email_show= "Primary Email: $email";$email_s="";}
	$personal_bio_undefined="";
	if($personal_bio==""){$personal_bio_undefined="Undefined";}
	else{$personal_bio_undefined=$personal_bio;}
	if(($motto1=="")AND($motto2==""))
		{$motto_summary="Undefined";$motto_s="";}
	else if(($motto1!=="")AND($motto2!==""))
		{$motto_summary="Personal Motto #1: $motto1<br/>Personal Motto #2: $motto2";$motto_s="s";}
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
	if (($location=="")AND($primary_school=="")AND($secondary_school=="")AND($post_secondary=="")AND($employer==""))
		{$networks = "Undefined";}
	else
		{$networks = "";}
	if ($location!=="")
		{$networks .= "Location: $location<br/>";}
	if ($primary_school!=="")
		{$networks .= "Primary School: $primary_school<br/>";}
	if ($secondary_school!=="")
		{$networks .= "Secondary School: $secondary_school<br/>";}
	if ($post_secondary!=="")
		{$networks .= "University Or College: $post_secondary<br/>";}
	if ($employer!=="")
		{$networks .= "Employer: $employer<br/>";}
	if($relationship==""){$relationship="Undefined";}
	}
	if ($scores=="a")
		{$scores2="(Deactivated)";}
	else if ($scores=="b")
		{$scores2="(Activated)";}
	
$mysql = mysql_query("SELECT DATE_FORMAT(birthday_ymd, '%Y') AS `year`, DATE_FORMAT(birthday_ymd, '%M') AS `month`, DATE_FORMAT(birthday_ymd, '%D') AS `day` FROM members WHERE id=$ids");
while($row = mysql_fetch_array($mysql))
	{$year = $row['year'];
	$month = $row['month'];
	$day = $row['day'];
	$birthday = $month." ".$day.", ".$year;}
?>

<script type="text/javascript" async>
// DIFFERENT PARTS
function profile_picture()
	{$(".settings_1").removeClass("settings_1_active");
	$(".profile_picture").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".profile_picture2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function cover_picture()
	{$(".settings_1").removeClass("settings_1_active");
	$(".cover_picture").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".cover_picture2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function fullname()
	{$(".settings_1").removeClass("settings_1_active");
	$(".fullname").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".fullname2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function email()
	{$(".settings_1").removeClass("settings_1_active");
	$(".email").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".email2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function gender()
	{$(".settings_1").removeClass("settings_1_active");
	$(".gender").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".gender2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function birthday()
	{$(".settings_1").removeClass("settings_1_active");
	$(".birthday").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".birthday2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function personal_bio()
	{$(".settings_1").removeClass("settings_1_active");
	$(".personal_bio").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".personal_bio2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function motto()
	{$(".settings_1").removeClass("settings_1_active");
	$(".motto").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".motto2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function contact_info()
	{$(".settings_1").removeClass("settings_1_active");
	$(".contact_info").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".contact_info2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function networks()
	{$(".settings_1").removeClass("settings_1_active");
	$(".networks").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".networks2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function relationship()
	{$(".settings_1").removeClass("settings_1_active");
	$(".relationship").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".relationship2").removeClass("hidden");
	$('#interactive_error').html('').show();}
function scores()
	{$(".settings_1").removeClass("settings_1_active");
	$(".scores").addClass("settings_1_active");
	$(".settings_1_3").addClass("hidden");
	$(".scores2").removeClass("hidden");
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
	
function remove_profile_pic(a)
	{$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{interactive:"remove_profile_pic",ids:a,thisWipit:thisRandNum},function(data) 
		{$("body").html(data).show();
		$("div.full_page_loader").addClass("full_page_loader_hidden");});}
function remove_cover_pic(a)
	{$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{interactive:"remove_cover_pic",ids:a,thisWipit:thisRandNum},function(data) 
		{$("body").html(data).show();
		$("div.full_page_loader").addClass("full_page_loader_hidden");});}
		
$('#fullname_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function fullname_form()
	{var firstname = $('#firstname');
	var middlename = $('#middlename');
	var lastname = $('#lastname');
	if (firstname.val() == '')
		{$("#interactive_error").html('Please Fill In The First Name Field!<br/><br/>').show();}
	else if (lastname.val() == '')
		{$("#interactive_error").html('Please Fill In The Last Name Field!<br/><br/>').show();}
	else 
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$.post(InteractiveSetting,{id:id,ids:ids,firstname:firstname.val(),middlename:middlename.val(),lastname:lastname.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
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
		$.post(InteractiveSetting,{id:id,ids:ids,email:email.val(),alt_email:alt_email.val(),password_ver1:password_ver1.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}	
$('#gender_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function gender_form()
	{var gender = $('#gender');
	if (gender.val() == '')
		{$("#interactive_error").html('Please Fill In The Gender Field!<br/><br/>').show();}
	else 
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$.post(InteractiveSetting,{id:id,ids:ids,gender:gender.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
$('#birthday_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function birthday_form()
	{var birthday_day = $('#birthday_day');
	var birthday_month = $('#birthday_month');
	var birthday_year = $('#birthday_year');
	if (birthday_day.val() == '')
		{$("#interactive_error").html('Please Fill In All Fields!<br/><br/>').show();}
	else if (birthday_month.val() == '')
		{$("#interactive_error").html('Please Fill In All Fields!<br/><br/>').show();}
	else if (birthday_year.val() == '')
		{$("#interactive_error").html('Please Fill In All Fields!<br/><br/>').show();}
	else 
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$.post(InteractiveSetting,{id:id,ids:ids,birthday_day:birthday_day.val(),birthday_month:birthday_month.val(),birthday_year:birthday_year.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
$('#personal_bio_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function personal_bio_form()
	{var personal_bio = $('#personal_bio');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,personal_bio:personal_bio.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
$('#motto_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function motto_form()
	{var motto1 = $('#motto1');
	var motto2 = $('#motto2');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,motto1:motto1.val(),motto2:motto2.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
$('#contact_info_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function contact_info_form()
	{var cell_number = $('#cell_number');
	var tel_number = $('#tel_number');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,cell_number:cell_number.val(),tel_number:tel_number.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
$('#networks_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function networks_form()
	{var location = $('#location');
	var primary_school = $('#primary_school');
	var secondary_school = $('#secondary_school');
	var post_secondary = $('#post_secondary');
	var employer = $('#employer');
	$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(InteractiveSetting,{id:id,ids:ids,location:location.val(),primary_school:primary_school.val(),secondary_school:secondary_school.val(),post_secondary:post_secondary.val(),employer:employer.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
	}
$('#relationship_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function relationship_form()
	{var relationship = $('#relationship');
	if (relationship.val() == '')
		{$("#interactive_error").html('Please Fill In The Relationship Status Field!<br/><br/>').show();}
	else 
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$.post(InteractiveSetting,{id:id,ids:ids,relationship:relationship.val(),thisWipit:thisRandNum},function(data)
			{$('#settings_page_right').html(data).show();
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
$('#scores_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function scores_form()
	{var scores = $('#scores');
	if (scores.val() == '')
		{$("#interactive_error").html('Please Fill In The Profile Scores Field!<br/><br/>').show();}
	else 
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$.post(InteractiveSetting,{id:id,ids:ids,scores:scores.val(),thisWipit:thisRandNum},function(data)
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
<script src="http://www.barterrain.com/scripts/date_changer.js" type="text/javascript" async></script>

<body>
<div class="margin"></div>
<div class="interactive_error" id="interactive_error">
	<?php echo $error_message; echo $success_message; ?>
</div>

<div class="settings_whole" style="border-top:solid 1px #E5E5E5;">
<a href="javascript:showonlyone('settings1-2');" onClick="javascript:profile_picture();" class="settings_1">
	<div class="settings_1 profile_picture">
		<div class="settings_1_1"><b>Profile Picture</b></div>
		<div class="settings_1_2"><?php echo $pic_added; ?></div>
	</div>
</a>
<form class="settings_2" action="settings.php" method="post" enctype="multipart/form-data">
<div class="settings_1_3 profile_picture2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
    <input name="parse_var" type="hidden" value="profile_picture"/>
</div>
<div name="settings_one" id="settings1-2" class="settings_2" style="display:none;">
	<?php echo $profile_pic; ?>
    <div class="settings_parts">
		<div class="settings_2_1" style="margin-top:6px;vertical-align:top;"><span class="dot_divider_settings" >&bull;&nbsp;</span>Profile Picture: </div>
		<div class="settings_2_2">
        	<div id="fakeupload" class="fakeupload"></div>
			<div class="fakeupload2">
				<input onChange="display_picture()" name="fileField" id="fileField" type="file" class="picture_field" value="profile_picture" size="80"/>
			</div>
        </div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings2-2');" onClick="javascript:cover_picture();" class="settings_1">
	<div class="settings_1 cover_picture">
		<div class="settings_1_1"><b>Cover Picture</b></div>
		<div class="settings_1_2"><?php echo $cover_added; ?></div>
	</div>
</a>
<form class="settings_2" action="settings.php" method="post" enctype="multipart/form-data">
<div class="settings_1_3 cover_picture2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
    <input name="parse_var" type="hidden" value="cover_picture"/>
</div>
<div name="settings_one" id="settings2-2" class="settings_2" style="display:none;">
	<?php echo $cover_pic; ?>
    <div class="settings_parts">
		<div class="settings_2_1" style="margin-top:6px;vertical-align:top;"><span class="dot_divider_settings">&bull;&nbsp;</span>Cover Picture: </div>
		<div class="settings_2_2">
          	<div id="fakeupload2" class="fakeupload"></div>
			<div class="fakeupload2">
				<input onChange="display_picture2()" name="fileField2" id="fileField2" type="file" class="picture_field" value="cover_field" size="80"/>
			</div>
        </div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings3-2');" onClick="javascript:fullname();" class="settings_1">
	<div class="settings_1 fullname">
		<div class="settings_1_1"><b>Full Name: </b></div>
		<div class="settings_1_2"><?php echo "$firstname $middlename $lastname"; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:fullname_form()" method="post" type="multipart/form-data" name="fullname_form" id="fullname_form">
<div class="settings_1_3 fullname2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
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

<div class="settings_whole">
<a href="javascript:showonlyone('settings7-2');" onClick="javascript:email();" class="settings_1">
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
<div name="settings_one" id="settings7-2" class="settings_2" style="display:none;">

	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Primary Email: </div>
		<div class="settings_2_2"><input class="settings_parts" name="email" id="email" type="text" readonly="readonly" value="<?php echo "$email" ?>"placeholder="Enter A Primary Email..."/></div>
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
<a href="javascript:showonlyone('settings4-2');" onClick="javascript:gender();" class="settings_1">
	<div class="settings_1 gender">
		<div class="settings_1_1"><b>Gender: </b></div>
		<div class="settings_1_2"><?php echo "$gender"; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:gender_form()" method="post" type="multipart/form-data" name="gender_form">
<div class="settings_1_3 gender2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings4-2" class="settings_2" style="display:none;">

	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Gender: </div>
		<div class="settings_2_2"><select name="gender" id="gender" class="settings_parts"><option value="">Gender:</option><option value="Male">Male</option><option value="Female">Female</option></select></div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings5-2');" onClick="javascript:birthday();" class="settings_1">
	<div class="settings_1 birthday">
		<div class="settings_1_1"><b>Birthday: </b></div>
		<div class="settings_1_2"><?php echo "$birthday"; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:birthday_form()" method="post" type="multipart/form-data" name="birthday_form">
<div class="settings_1_3 birthday2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings5-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Birthday: </div>
		<div class="settings_2_2">
	<select name="birthday_month" id="birthday_month" class="settings_birthday" onChange="javascript:populate_month_day('birthday_month','birthday_day');">
			<option value="">Month:</option>
			<option value="01">January</option>
			<option value="02">February</option>
			<option value="03">March</option>
			<option value="04">April</option>
			<option value="05">May</option>
			<option value="06">June</option>
			<option value="07">July</option>
			<option value="08">August</option>
			<option value="09">September</option>
			<option value="10">October</option>
			<option value="11">November</option>
			<option value="12">December</option>
	</select>
	<select name="birthday_day" id="birthday_day" class="settings_birthday" onChange="javascript:populate_day_year('birthday_month','birthday_day','birthday_year');">
		<option value="">Day:</option>
	</select>
	<select name="birthday_year" id="birthday_year" class="settings_birthday">
		<option value="">Year:</option>
	</select>
    	</div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings10-2');" onClick="javascript:personal_bio();" class="settings_1">
	<div class="settings_1 personal_bio">
		<div class="settings_1_1"><b>My Personal Story: </b></div>
		<div class="settings_1_2"><?php echo "$personal_bio_undefined"; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:personal_bio_form()" method="post" type="multipart/form-data" name="personal_bio_form">
<div class="settings_1_3 personal_bio2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings10-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_3"><span class="dot_divider_settings">&bull;&nbsp;</span>Personal Story: </div>
		<div class="settings_2_2">
        	<textarea class="settings_parts" name="personal_bio" id="personal_bio" placeholder="Enter A Personal Story..."><?php echo $personal_bio; ?></textarea>
       	</div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings9-2');" onClick="javascript:motto();" class="settings_1">
	<div class="settings_1 motto">
		<div class="settings_1_1"><b>My Personal Motto<?php echo $motto_s; ?>: </b></div>
		<div class="settings_1_2"><?php echo $motto_summary; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:motto_form()" method="post" type="multipart/form-data" name="motto_form">
<div class="settings_1_3 motto2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings9-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Personal Motto #1: </div>
		<div class="settings_2_2"><input class="settings_parts" name="motto1" id="motto1" type="text" value="<?php echo $motto1; ?>" placeholder="Enter A Motto..."/></div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Personal Motto #2: </div>
		<div class="settings_2_2"><input class="settings_parts" name="motto2" id="motto2" type="text" value="<?php echo $motto2; ?>" placeholder="Enter A Motto..."/></div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings8-2');" onClick="javascript:contact_info();" class="settings_1">
	<div class="settings_1 contact_info">
		<div class="settings_1_1"><b>Contact Number<?php echo $contact_number_s; ?>: </b></div>
		<div class="settings_1_2"><?php echo "$numbers"; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:contact_info_form()" method="post" type="multipart/form-data" name="contact_info_form">
<div class="settings_1_3 contact_info2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings8-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Cellphone Number: </div>
		<div class="settings_2_2"><input class="settings_parts" name="cell_number" id="cell_number" type="text" value="<?php echo "$cell_number" ?>" placeholder="Enter A Cellphone Number..."/></div>
	</div>
		<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Telephone Number: </div>
		<div class="settings_2_2"><input class="settings_parts"  name="tel_number" id="tel_number" type="text" value="<?php echo "$tel_number" ?>" placeholder="Enter A Telephone Number"/></div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings13-2');" onClick="javascript:networks();" class="settings_1">
	<div class="settings_1 networks">
		<div class="settings_1_1"><b>Networks: </b></div>
		<div class="settings_1_2"><?php echo "$networks"; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:networks_form()" method="post" type="multipart/form-data" name="fullname_form" id="fullname_form">
<div class="settings_1_3 networks2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings13-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Location: </div>
		<div class="settings_2_2"><input class="settings_parts" name="location" id="location"  type="text" value="<?php echo "$location" ?>" placeholder="Enter A Location..."/></div>
	</div>
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Primary School: </div>
		<div class="settings_2_2"><input class="settings_parts" name="primary_school" id="primary_school"  type="text" value="<?php echo "$primary_school" ?>" placeholder="Enter A Primary School..."/></div>
	</div>
    <div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Secondary School: </div>
		<div class="settings_2_2"><input class="settings_parts" name="secondary_school" id="secondary_school"  type="text" value="<?php echo "$secondary_school" ?>" placeholder="Enter A Secondary School..."/></div>
	</div>
    <div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>University Or College: </div>
		<div class="settings_2_2"><input class="settings_parts" name="post_secondary" id="post_secondary"  type="text" value="<?php echo "$post_secondary" ?>" placeholder="Enter An University Or College..."/></div>
	</div>
    <div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Employer: </div>
		<div class="settings_2_2"><input class="settings_parts" name="employer" id="employer"  type="text" value="<?php echo "$employer" ?>" placeholder="Enter An Employer..."/></div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings12-2');" onClick="javascript:relationship();" class="settings_1">
	<div class="settings_1 relationship">
		<div class="settings_1_1"><b>Relationship Status: </b></div>
		<div class="settings_1_2"><?php echo "$relationship"; ?></div>
	</div>
</a>
<form class="settings_2" action="javascript:relationship_form()" method="post" type="multipart/form-data" name="relationship_form">
<div class="settings_1_3 relationship2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings12-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Relationship Status: </div>
		<div class="settings_2_2">
        <select id="relationship" name="relationship" class="settings_parts">
			<option value="">Relationship Status:</option>
            <option value="Divorced">Divorced</option>
            <option value="Engaged">Engaged</option>
            <option value="Forever Alone">Forever Alone</option>
            <option value="In A Relationship">In A Relationship</option>
			<option value="In An Open Relationship">In An Open Relationship</option>
            <option value="It's Complicated">It's Complicated</option>
			<option value="Married">Married</option>
            <option value="Married To Myself">Married To Myself</option>
            <option value="Seperated">Seperated</option>
			<option value="Single">Single</option>
			<option value="Widowed">Widowed</option>
			<option value="Undefined">Undefined</option>
		</select>
        </div>
	</div>
</div>
</form>	
</div>

<div class="settings_whole">
<a href="javascript:showonlyone('settings11-2');" onClick="javascript:scores();" class="settings_1">
	<div class="settings_1 scores">
		<div class="settings_1_1"><b>Profile Scores: </b></div>
		<div class="settings_1_2">Total Of <?php echo "$likes"; ?> Liked Items | Total Of <?php echo "$loves"; ?> Loved Items <?php echo $scores2;?> </div>
	</div>
</a>
<form class="settings_2" action="javascript:scores_form()" method="post" type="multipart/form-data" name="scores_form">
<div class="settings_1_3 scores2 hidden">
  	<img src="blank.gif" width="1px" height="1px" title="Cancel" name="Cancel" class="cancel_button" onMouseDown="javascript:cancel();javascript:showonlyone('settings0-2');"/>
   	<input src="blank.gif" width="1px" height="1px" type="image" title="Save" name="Save" class="save_button"/>
</div>
<div name="settings_one" id="settings11-2" class="settings_2" style="display:none;">
	<div class="settings_parts">
		<div class="settings_2_1"><span class="dot_divider_settings">&bull;&nbsp;</span>Profile Scores: </div>
		<div class="settings_2_2">
        	<select name="scores" id="scores" class="settings_parts">
            	<option value="">Profile Scores:</option>
                <option value="b">Activated - Scores Will Be Displayed Within Profile</option>
                <option value="a">Deactivated - No Scores Will Be Displayed Within Profile</option>
           	</select>
       	</div>
	</div>
</div>
</form>	
</div>

<div class="bottom_footer"><br/>
<a class="button-line">Your data will not be used by Barterrain for any commercial purposes.<br/> All information you add/delete, will also be added/deleted by Barterrain.
<br/><a href="delete_account.php" class="body">Click here</a> to delete your account by using the self-destruct button.</a>
</div>
</body>