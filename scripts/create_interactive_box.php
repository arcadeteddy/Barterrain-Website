<?php
session_start();
include "../config.php";
if(isset($_POST['file_location']))
	{$file_location = $_POST['file_location'];
	if ($file_location == "planet") {$header_location = "../planet/planet_";}
	else {$header_location = "profile";$header_location="../planet/planet_";}}
else {$header_location = "../planet/planet_";}
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;

if((!isset($_SESSION['id']))AND(!isset($_SESSION['ids'])))
	{header("Location: http://www.barterrain.com/settings/logout.php");exit();}

$thisWipit = $_POST['thisWipit'];
$sessWipit = base64_decode($_SESSION['wipit']);
$cacheBuster = rand(9999999,99999999999);
$PostsDisplayList="";
$id = $_SESSION['id'];
$ids = $_SESSION['ids'];

$color=$_SESSION['color'];
if (isset($color))
	{if ($color=="blue")
		{$color1="#295FCC";
		$color1_2="#295FCC";
		$color2="#B4C7ED";
		$color3="#CCD9F3";
		$color4="#E3EAF9";}
	else if ($color=="green")
		{$color1="#36B336";
		$color1_2="#36B336";
		$color2="#B9E4B9";
		$color3="#CFEDCF";
		$color4="#E5F5E5";}
	else if ($color=="yellow")
		{$color1="#E5E517";
		$color1_2="#E5E517";
		$color2="#F6F6AE";
		$color3="#F9F9C8";
		$color4="#FCFCE1";}
	else if ($color=="orange")
		{$color1="#E57E17";
		$color1_2="#E57E17";
		$color2="#F6D2AE";
		$color3="#F9E0C8";
		$color4="#FCEEE1";}
	else if ($color=="red")
		{$color1="#CC2929";
		$color1_2="#CC2929";
		$color2="#EDB4B4";
		$color3="#F3CCCC";
		$color4="#F9E3E3";}
	else if ($color=="purple")
		{$color1="#8836B3";
		$color1_2="#8836B3";
		$color2="#D5B9E4";
		$color3="#E3CFED";
		$color4="#F0E5F5";}
	else if ($color=="brown")
		{$color1="#663D14";
		$color1_2="#663D14";
		$color2="#CABBAD";
		$color3="#DAD1C7";
		$color4="#EBE6E1";}
	else if ($color=="black")
		{$color1="#17171A";
		$color1_2="#2A62CA";
		$color2="#AEAEAF";
		$color3="#C8C8C8";
		$color4="#E1E1E1";}
	else
		{$color1="#2A62CA";
		$color1_2="#295FCC";
		$color2="#B4C7ED";
		$color3="#CCD9F3";
		$color4="#E7EDF8";}
	}
else
	{$color1="#295FCC";
	$color1_2="#295FCC";
	$color2="#B4C7ED";
	$color3="#CCD9F3";
	$color4="#E3EAF8";}

////////////////////////////////////////////////
///////////////// POSTING STUFF /////////////////
if(isset($_POST['post']))
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$post=$_POST['post'];
	$post_type=$_POST['post_type'];
	$type=$_POST['type'];
	$post = stripslashes($post);
	$post = strip_tags($post);
	$post = mysql_real_escape_string($post);
	
	$mysql = mysql_query("SELECT user_id, planet_name, creator_array FROM ".$type." WHERE id='$id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$user_id = $row['user_id'];
		$planet_name = $row['planet_name'];
		$creator_array = $row['creator_array'];
		$creator_array = explode(",",$creator_array);}
		
	if(($ids!==$user_id)AND(!in_array($ids,$creator_array)))
		{$mysql1 = mysql_query("SELECT planet_email1, planet_email2, email_notification_activation FROM members_planets WHERE id='$user_id'");
		while($row = mysql_fetch_array($mysql1))
			{$planet_email1 = $row['planet_email1'];
			$planet_email2 = $row['planet_email2'];
			$email_notification_activation = $row['email_notification_activation'];}
		if ($planet_email2!=="") {$planet_email = $planet_email2;}
		else if ($planet_email1!=="") {$planet_email = $planet_email1;}
		else {$planet_email = "";}
		$mysql2 = mysql_query("SELECT firstname, lastname FROM members WHERE id='$ids'");
		while($row = mysql_fetch_array($mysql2))
			{$firstname = $row['firstname'];
			$lastname = $row['lastname'];}
		$mysql2 = mysql_query("SELECT alias, alias_activation FROM members_planets WHERE id='$ids'");
		while($row = mysql_fetch_array($mysql2))
			{$alias = $row['alias'];
			$alias_activation = $row['alias_activation'];}
			
		$email_check_pic = "../user_files/user".$ids."/profile_thumb.jpg";
		$email_default_pic = "http://www.barterrain.com/user_files/user0/default_profile_pic_thumb.png";
		if (file_exists($email_check_pic)) 
			{$email_pic = "<img src='http://www.barterrain.com/user_files/user".$ids."/profile_thumb.jpg' width='75px' height='75px' style='background-color:".$color2.";'/>";} 
		else {$email_pic = "<img src='$email_default_pic' width='75px' height='75px' style='background-color:".$color2.";'/>";}

		if ($alias_activation=="1") 
			{$user_pic="<a href='#' onclick='return false'>".$email_pic."</a>";
			$profile_text=$alias;
			$profile_link="<font style='color:#000000;font:20px helvetica, sans-serif;font-weight:bold;text-decoration:none;margin:0px;padding:0px;'>".$alias."</font>";}
		else if ($alias_activation=="0") 
			{$user_pic="<a href='http://www.barterrain.com/profile/profile.php?id=".$ids."'>".$email_pic."</a>";
			$profile_text=$firstname." ".$lastname;
			$profile_link="<a style='color:".$color1.";font:20px helvetica, sans-serif;font-weight:bold;text-decoration:none;margin:0px;padding:0px;' href='http://www.barterrain.com/profile/profile.php?id=".$ids."'>".$firstname." ".$lastname."</a>";}
			
		if (($email_notification_activation=="1")AND($planet_email!==""))
			{$subject = "New Planet Member Post From ".$profile_text." [".date("F jS, Y | H:i:s")."]";
			$headers = 'From: Barterrain <post@barterrain.com>' . "\r\n"  .
						'Reply-To: Barterrain <post@barterrain.com>' . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
			$message = "<html>
						<head>
    						<title>".$subject."</title>
						</head>";
			$message .= "<body style='z-index:20;overflow:hidden;height:45px;width:100%;margin:0px;padding:0px;'>
							<div style='z-index:20;text-align:center;position:relative;height:45px;width:100%;margin:0px;padding:0px;background-color:".$color1.";float:left;'>
							<table style='z-index:20;text-align:center;position:relative;height:45px;width:150px;margin:0px;padding:0px;margin:auto;vertical-align:top;' align='center'><tr><td>
   		 					<a href='http://www.barterrain.com/' style='text-decoration:none;height:40px;width:150px;margin:0px;padding:0px;' title='Baterrain'>
								<img src=\"http://www.barterrain.com/barterrain_email_images/main_title.png\" style='margin:auto;max-height:40px;width:150px;background:url(\"http://www.barterrain.com/barterrain_email_images/main_title.png\") no-repeat 0 0;' onMouseDown='if (event.preventDefault) event.preventDefault()'/>
							</a>
							</td></tr></table></div>
						</body>";
			$message .= "<body style='z-index:10;overflow:hidden;height:45px;width:100%;margin:0px;padding:0px;float:left;'>
						<div style='z-index:10;text-align:center;position:relative;height:auto;width:100%;margin:0px;padding:0px;background-color:".$color4.";float:left;'>
						<table style='margin:auto;border:0px;border-spacing:0px;text-align:justify;text-align-last:justify;padding-top:23px;padding-bottom:23px;' cellspacing='0' cellpadding='0' align='center'>
							<tr style='position:relative;'>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -0px -0px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_top_left.png\"></td>
							<td style='height:15px;background-color:#FFFFFF;'></td>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -235px -0px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_top_right.png\"></td>
							</tr>
        	   				<tr style='position:relative;'>
							 	<td style='width:15px;background-color:#FFFFFF;'></td>
								<td style='width:580px;height:50px;background-color:#FFFFFF;vertical-align:top;'>
								<table><tr>
            						<td style='text-align:left;float:left;vertical-align:top;'>".$user_pic."</td>
									<td style='text-align:left;width:450px;float:left;vertical-align:top;padding-left:15px;'>
										".$profile_link."
										<font style='color:black;font-size:20px;'> &#9658; Planet: </font>
										<a href=\"http://www.barterrain.com/planet/planet.php?id=".$id."\" style='color:".$color1.";font:20px helvetica, sans-serif;font-weight:bold;text-decoration:none;margin:0px;padding:0px;'>".$planet_name."</a>
										<br/><font style='font:16px helvetica, sans-serif;margin:0px;padding:0px;'> New Planet Member Post: <i>\"".$post."\"</i></font>
									</td>
								</tr></table>
            					</td>
								<td style='width:15px;background-color:#FFFFFF;'></td>
							</tr>
            				<tr style='position:relative;'>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -0px -15px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_bottom_left.png\"></td>
							<td style='height:15px;background-color:#FFFFFF;'></td>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -235px -15px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_bottom_right.png\"></td>			
							</tr>
							<tr><td></td><td style='padding-top:23px;'>
								<div style='z-index:10;text-align:center;position:relative;' align='center'>
								<font style='color:#000000'>
									Forgot your Barterrain password? 
									<a href=\"http://www.barterrain.com?forgot_password=true\" style='color:".$color1.";font:12px helvetica, sans-serif;text-decoration:none;'>
										Click here</a> to get a temporary password.
									<br/>Want to unsubscribe from these notification emails? 
									<a href=\"http://www.barterrain.com/settings/settings.php?settings=notification\" style='color:".$color1.";font:12px helvetica, sans-serif;text-decoration:none;'>
										Click here</a> to change notification settings.
								 	<br/>Received this email in error? Did you not sign up for Barterrain? 
									Contact <a href=\"mailto:error@barterrain.com\" style='color:".$color1.";font:12px helvetica, sans-serif;text-decoration:none;'>error@barterrain.com</a>!
								</font>
								</div>
							</td><td></td></tr>
        				</table>
						</div></body>
						</html>";
		
			mail($planet_email,$subject,$message,$headers,'-fpost@barterrain.com');
			}
		}
	
	if(($ids!==$user_id)AND(!in_array($ids,$creator_array)))
		{$mysql = mysql_query("INSERT INTO ".$type."_member_posts (user_page_id, user_post_id, the_post, post_date, member_post_type) VALUES ('$id', '$ids', '$post', UTC_TIMESTAMP(), '$post_type')") or die (mysql_error());}
	else {$mysql = mysql_query("INSERT INTO ".$type."_posts (user_page_id, user_post_id, the_post, post_date, post_type) VALUES ('$id', '$ids', '$post', UTC_TIMESTAMP(), '$post_type')") or die (mysql_error());}
		
	include_once $header_location."wall_content.php";
exit();}

if(isset($_POST['media_post']))
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$post=$_POST['media_post'];
	$type=$_POST['type'];
	$typex=$_POST['typex'];
	$media_id=$_POST['media_id'];
	$media_type=$_POST['media_type'];
	$media_type_s = substr($media_type, 0, -1);
	$media_type_c = ucfirst($media_type_s);
	$post = stripslashes($post);
	$post = strip_tags($post);
	$post = mysql_real_escape_string($post);
	
	$mysql = mysql_query("SELECT user_id, planet_name, creator_array FROM ".$typex." WHERE id='$id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$user_id = $row['user_id'];
		$planet_name = $row['planet_name'];
		$creator_array = $row['creator_array'];
		$creator_array = explode(",",$creator_array);}
		
	if(($ids!==$user_id)AND(!in_array($ids,$creator_array)))
		{$mysql1 = mysql_query("SELECT planet_email1, planet_email2, email_notification_activation FROM members_planets WHERE id='$user_id'");
		while($row = mysql_fetch_array($mysql1))
			{$planet_email1 = $row['planet_email1'];
			$planet_email2 = $row['planet_email2'];
			$email_notification_activation = $row['email_notification_activation'];}
		if ($planet_email2!=="") {$planet_email = $planet_email2;}
		else if ($planet_email1!=="") {$planet_email = $planet_email1;}
		else {$planet_email = "";}
		$mysql2 = mysql_query("SELECT firstname, lastname FROM members WHERE id='$ids'");
		while($row = mysql_fetch_array($mysql2))
			{$firstname = $row['firstname'];
			$lastname = $row['lastname'];}
		$mysql2 = mysql_query("SELECT alias, alias_activation FROM members_planets WHERE id='$ids'");
		while($row = mysql_fetch_array($mysql2))
			{$alias = $row['alias'];
			$alias_activation = $row['alias_activation'];}
		$mysql3 = mysql_query("SELECT ".$media_type_s."_name AS media_name FROM ".$typex."_".$media_type." WHERE id='$media_id'");
		while($row = mysql_fetch_array($mysql3))
			{$media_name = $row['media_name'];}
			
		$email_check_pic = "../user_files/user".$ids."/profile_thumb.jpg";
		$email_default_pic = "http://www.barterrain.com/user_files/user0/default_profile_pic_thumb.png";
		if (file_exists($email_check_pic)) 
			{$email_pic = "<img src='http://www.barterrain.com/user_files/user".$ids."/profile_thumb.jpg' width='75px' height='75px' style='background-color:".$color2.";'/>";} 
		else {$email_pic = "<img src='$email_default_pic' width='75px' height='75px' style='background-color:".$color2.";'/>";}

		if ($alias_activation=="1") 
			{$user_pic="<a href='#' onclick='return false'>".$email_pic."</a>";
			$profile_text=$alias;
			$profile_link="<font style='color:#000000;font:20px helvetica, sans-serif;font-weight:bold;text-decoration:none;margin:0px;padding:0px;'>".$alias."</font>";}
		else if ($alias_activation=="0") 
			{$user_pic="<a href='http://www.barterrain.com/profile/profile.php?id=".$ids."'>".$email_pic."</a>";
			$profile_text=$firstname." ".$lastname;
			$profile_link="<a style='color:".$color1.";font:20px helvetica, sans-serif;font-weight:bold;text-decoration:none;margin:0px;padding:0px;' href='http://www.barterrain.com/profile/profile.php?id=".$ids."'>".$firstname." ".$lastname."</a>";}
			
		if (($email_notification_activation=="1")AND($planet_email!==""))
			{$subject = "New Planet ".$media_type_c." Post From ".$profile_text." [".date("F jS, Y | H:i:s")."]";
			$headers = 'From: Barterrain <post@barterrain.com>' . "\r\n"  .
						'Reply-To: Barterrain <post@barterrain.com>' . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
			$message = "<html>
						<head>
    						<title>".$subject."</title>
						</head>";
			$message .= "<body style='z-index:20;overflow:hidden;height:45px;width:100%;margin:0px;padding:0px;'>
							<div style='z-index:20;text-align:center;position:relative;height:45px;width:100%;margin:0px;padding:0px;background-color:".$color1.";float:left;'>
							<table style='z-index:20;text-align:center;position:relative;height:45px;width:150px;margin:0px;padding:0px;margin:auto;vertical-align:top;' align='center'><tr><td>
   		 					<a href='http://www.barterrain.com/' style='text-decoration:none;height:40px;width:150px;margin:0px;padding:0px;' title='Baterrain'>
								<img src=\"http://www.barterrain.com/barterrain_email_images/main_title.png\" style='margin:auto;max-height:40px;width:150px;background:url(\"http://www.barterrain.com/barterrain_email_images/main_title.png\") no-repeat 0 0;' onMouseDown='if (event.preventDefault) event.preventDefault()'/>
							</a>
							</td></tr></table></div>
						</body>";
			$message .= "<body style='z-index:10;overflow:hidden;height:45px;width:100%;margin:0px;padding:0px;float:left;'>
						<div style='z-index:10;text-align:center;position:relative;height:auto;width:100%;margin:0px;padding:0px;background-color:".$color4.";float:left;'>
						<table style='margin:auto;border:0px;border-spacing:0px;text-align:justify;text-align-last:justify;padding-top:23px;padding-bottom:23px;' cellspacing='0' cellpadding='0' align='center'>
							<tr style='position:relative;'>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -0px -0px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_top_left.png\"></td>
							<td style='height:15px;background-color:#FFFFFF;'></td>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -235px -0px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_top_right.png\"></td>
							</tr>
        	   				<tr style='position:relative;'>
							 	<td style='width:15px;background-color:#FFFFFF;'></td>
								<td style='width:580px;height:50px;background-color:#FFFFFF;vertical-align:top;'>
								<table><tr>
            						<td style='text-align:left;float:left;vertical-align:top;'>".$user_pic."</td>
									<td style='text-align:left;width:450px;float:left;vertical-align:top;padding-left:15px;'>
										".$profile_link."
										<font style='color:black;font-size:20px;'> &#9658; Planet ".$media_type_c.": </font>
										<a href=\"http://www.barterrain.com/planet/planet.php?id=".$id."&force_".$media_type_s."=".$media_id."\" style='color:".$color1.";font:20px helvetica, sans-serif;font-weight:bold;text-decoration:none;margin:0px;padding:0px;'>".$media_name."</a>
										<br/><font style='font:16px helvetica, sans-serif;margin:0px;padding:0px;'> New Planet ".$media_type_c." Post: <i>\"".$post."\"</i></font>
									</td>
								</tr></table>
            					</td>
								<td style='width:15px;background-color:#FFFFFF;'></td>
							</tr>
            				<tr style='position:relative;'>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -0px -15px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_bottom_left.png\"></td>
							<td style='height:15px;background-color:#FFFFFF;'></td>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -235px -15px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_bottom_right.png\"></td>			
							</tr>
							<tr><td></td><td style='padding-top:23px;'>
								<div style='z-index:10;text-align:center;position:relative;' align='center'>
								<font style='color:#000000'>
									Forgot your Barterrain password? 
									<a href=\"http://www.barterrain.com?forgot_password=true\" style='color:".$color1.";font:12px helvetica, sans-serif;text-decoration:none;'>
										Click here</a> to get a temporary password.
									<br/>Want to unsubscribe from these notification emails? 
									<a href=\"http://www.barterrain.com/settings/settings.php?settings=notification\" style='color:".$color1.";font:12px helvetica, sans-serif;text-decoration:none;'>
										Click here</a> to change notification settings.
								 	<br/>Received this email in error? Did you not sign up for Barterrain? 
									Contact <a href=\"mailto:error@barterrain.com\" style='color:".$color1.";font:12px helvetica, sans-serif;text-decoration:none;'>error@barterrain.com</a>!
								</font>
								</div>
							</td><td></td></tr>
        				</table>
						</div></body>
						</html>";
		
			mail($planet_email,$subject,$message,$headers,'-fpost@barterrain.com');
			}
		}
	
	$mysql = mysql_query("INSERT INTO ".$typex."_".$media_type."_posts (user_page_id, user_post_id, the_post, post_date, ".$media_type_s."_id, ".$media_type."_post_type)
	VALUES ('$id','$ids', '$post', UTC_TIMESTAMP(), '$media_id','$type')") or die (mysql_error());
		
	include_once "".$header_location."".$media_type."_posts_content.php";
exit();} 

if(isset($_POST['image_post']))
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$image_post=$_POST['image_post'];
	$image_type=$_POST['image_type'];
	$image_id=$_POST['image_id'];
	$typex=$_POST['typex'];
	$image_post = stripslashes($image_post);
	$image_post = strip_tags($image_post);
	$image_post = mysql_real_escape_string($image_post);
	
	$mysql = mysql_query("SELECT album_id FROM ".$typex."_images WHERE id='$image_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$album_id = $row['album_id'];}
		
	$mysql = mysql_query("SELECT user_id, planet_name, creator_array FROM ".$typex." WHERE id='$id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$user_id = $row['user_id'];
		$planet_name = $row['planet_name'];
		$creator_array = $row['creator_array'];
		$creator_array = explode(",",$creator_array);}
		
	if(($ids!==$user_id)AND(!in_array($ids,$creator_array)))
		{$mysql1 = mysql_query("SELECT planet_email1, planet_email2, email_notification_activation FROM members_planets WHERE id='$user_id'");
		while($row = mysql_fetch_array($mysql1))
			{$planet_email1 = $row['planet_email1'];
			$planet_email2 = $row['planet_email2'];
			$email_notification_activation = $row['email_notification_activation'];}
		if ($planet_email2!=="") {$planet_email = $planet_email2;}
		else if ($planet_email1!=="") {$planet_email = $planet_email1;}
		else {$planet_email = "";}
		$mysql2 = mysql_query("SELECT firstname, lastname FROM members WHERE id='$ids'");
		while($row = mysql_fetch_array($mysql2))
			{$firstname = $row['firstname'];
			$lastname = $row['lastname'];}
		$mysql2 = mysql_query("SELECT alias, alias_activation FROM members_planets WHERE id='$ids'");
		while($row = mysql_fetch_array($mysql2))
			{$alias = $row['alias'];
			$alias_activation = $row['alias_activation'];}
		$mysql3 = mysql_query("SELECT album_id, ext FROM ".$typex."_images WHERE id='$image_id'");
		while($row = mysql_fetch_array($mysql3))
			{$album_id = $row['album_id'];
			$ext = $row['ext'];}
			
		$email_check_pic = "../user_files/user".$ids."/profile_thumb.jpg";
		$email_default_pic = "http://www.barterrain.com/user_files/user0/default_profile_pic_thumb.png";
		if (file_exists($email_check_pic)) 
			{$email_pic = "<img src='http://www.barterrain.com/user_files/user".$ids."/profile_thumb.jpg' width='75px' height='75px' style='background-color:".$color2.";'/>";} 
		else {$email_pic = "<img src='$email_default_pic' width='75px' height='75px' style='background-color:".$color2.";'/>";}

		if ($alias_activation=="1") 
			{$user_pic="<a href='#' onclick='return false'>".$email_pic."</a>";
			$profile_text=$alias;
			$profile_link="<font style='color:#000000;font:20px helvetica, sans-serif;font-weight:bold;text-decoration:none;margin:0px;padding:0px;'>".$alias."</font>";}
		else if ($alias_activation=="0") 
			{$user_pic="<a href='http://www.barterrain.com/profile/profile.php?id=".$ids."'>".$email_pic."</a>";
			$profile_text=$firstname." ".$lastname;
			$profile_link="<a style='color:".$color1.";font:20px helvetica, sans-serif;font-weight:bold;text-decoration:none;margin:0px;padding:0px;' href='http://www.barterrain.com/profile/profile.php?id=".$ids."'>".$firstname." ".$lastname."</a>";}
			
		if (($email_notification_activation=="1")AND($planet_email!==""))
			{$subject = "New Planet Image Post From ".$profile_text." [".date("F jS, Y | H:i:s")."]";
			$headers = 'From: Barterrain <post@barterrain.com>' . "\r\n"  .
						'Reply-To: Barterrain <post@barterrain.com>' . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
			$message = "<html>
						<head>
    						<title>".$subject."</title>
						</head>";
			$message .= "<body style='z-index:20;overflow:hidden;height:45px;width:100%;margin:0px;padding:0px;'>
							<div style='z-index:20;text-align:center;position:relative;height:45px;width:100%;margin:0px;padding:0px;background-color:".$color1.";float:left;'>
							<table style='z-index:20;text-align:center;position:relative;height:45px;width:150px;margin:0px;padding:0px;margin:auto;vertical-align:top;' align='center'><tr><td>
   		 					<a href='http://www.barterrain.com/' style='text-decoration:none;height:40px;width:150px;margin:0px;padding:0px;' title='Baterrain'>
								<img src=\"http://www.barterrain.com/barterrain_email_images/main_title.png\" style='margin:auto;max-height:40px;width:150px;background:url(\"http://www.barterrain.com/barterrain_email_images/main_title.png\") no-repeat 0 0;' onMouseDown='if (event.preventDefault) event.preventDefault()'/>
							</a>
							</td></tr></table></div>
						</body>";
			$message .= "<body style='z-index:10;overflow:hidden;height:45px;width:100%;margin:0px;padding:0px;float:left;'>
						<div style='z-index:10;text-align:center;position:relative;height:auto;width:100%;margin:0px;padding:0px;background-color:".$color4.";float:left;'>
						<table style='margin:auto;border:0px;border-spacing:0px;text-align:justify;text-align-last:justify;padding-top:23px;padding-bottom:23px;' cellspacing='0' cellpadding='0' align='center'>
							<tr style='position:relative;'>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -0px -0px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_top_left.png\"></td>
							<td style='height:15px;background-color:#FFFFFF;'></td>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -235px -0px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_top_right.png\"></td>
							</tr>
        	   				<tr style='position:relative;'>
							 	<td style='width:15px;background-color:#FFFFFF;'></td>
								<td style='width:580px;height:50px;background-color:#FFFFFF;vertical-align:top;'>
								<table><tr>
            						<td style='text-align:left;float:left;vertical-align:top;'>".$user_pic."</td>
									<td style='text-align:left;width:450px;float:left;vertical-align:top;padding-left:15px;'>
										".$profile_link."
										<font style='color:black;font-size:20px;'> &#9658; </font>
										<a href=\"http://www.barterrain.com/planet/planet.php?id=".$id."&force_album=".$album_id."\" style='color:".$color1.";font:20px helvetica, sans-serif;font-weight:bold;text-decoration:none;margin:0px;padding:0px;'>Planet Image</a>
										<br/><font style='font:16px helvetica, sans-serif;margin:0px;padding:0px;'> New Planet Image Post: <i>\"".$image_post."\"</i></font>
										<img src='http://www.barterrain.com/planet_files/planet".$id."/planet_album_".$album_id."/planet_album_".$album_id."_pic_".$image_id.".".$ext."' style='position:relative;width:485px;margin:0px;padding:0px;padding-top:15px;'/>
									</td>
								</tr></table>
            					</td>
								<td style='width:15px;background-color:#FFFFFF;'></td>
							</tr>
            				<tr style='position:relative;'>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -0px -15px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_bottom_left.png\"></td>
							<td style='height:15px;background-color:#FFFFFF;'></td>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -235px -15px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_bottom_right.png\"></td>			
							</tr>
							<tr><td></td><td style='padding-top:23px;'>
								<div style='z-index:10;text-align:center;position:relative;' align='center'>
								<font style='color:#000000'>
									Forgot your Barterrain password? 
									<a href=\"http://www.barterrain.com?forgot_password=true\" style='color:".$color1.";font:12px helvetica, sans-serif;text-decoration:none;'>
										Click here</a> to get a temporary password.
									<br/>Want to unsubscribe from these notification emails? 
									<a href=\"http://www.barterrain.com/settings/settings.php?settings=notification\" style='color:".$color1.";font:12px helvetica, sans-serif;text-decoration:none;'>
										Click here</a> to change notification settings.
								 	<br/>Received this email in error? Did you not sign up for Barterrain? 
									Contact <a href=\"mailto:error@barterrain.com\" style='color:".$color1.";font:12px helvetica, sans-serif;text-decoration:none;'>error@barterrain.com</a>!
								</font>
								</div>
							</td><td></td></tr>
        				</table>
						</div></body>
						</html>";
		
			mail($planet_email,$subject,$message,$headers,'-fpost@barterrain.com');
			}
		}
	
	$mysql = mysql_query("INSERT INTO ".$typex."_images_posts (user_page_id, user_post_id,the_post, post_date, album_id, image_id, images_post_type)
	VALUES ('$id','$ids','$image_post', UTC_TIMESTAMP(),'$album_id','$image_id','$image_type')") or die (mysql_error());
		
	include_once "../scripts/create_images_posts_content.php";
exit();} ///////////////// FINSHED POSTING STUFF WALL /////////////////

if(isset($_POST['post2']))
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$post=$_POST['post2'];
	$post_type=$_POST['post_type'];
	$type=$_POST['type'];
	$typex=$type;
	$post = stripslashes($post);
	$post = strip_tags($post);
	$post = mysql_real_escape_string($post);
	
	$mysql = mysql_query("SELECT user_id, planet_name, creator_array FROM ".$type." WHERE id='$id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$user_id = $row['user_id'];
		$planet_name = $row['planet_name'];
		$creator_array = $row['creator_array'];
		$creator_array = explode(",",$creator_array);}
		
	if(($ids!==$user_id)AND(!in_array($ids,$creator_array)))
		{$mysql1 = mysql_query("SELECT planet_email1, planet_email2, email_notification_activation FROM members_planets WHERE id='$user_id'");
		while($row = mysql_fetch_array($mysql1))
			{$planet_email1 = $row['planet_email1'];
			$planet_email2 = $row['planet_email2'];
			$email_notification_activation = $row['email_notification_activation'];}
		if ($planet_email2!=="") {$planet_email = $planet_email2;}
		else if ($planet_email1!=="") {$planet_email = $planet_email1;}
		else {$planet_email = "";}
		$mysql2 = mysql_query("SELECT firstname, lastname FROM members WHERE id='$ids'");
		while($row = mysql_fetch_array($mysql2))
			{$firstname = $row['firstname'];
			$lastname = $row['lastname'];}
		$mysql2 = mysql_query("SELECT alias, alias_activation FROM members_planets WHERE id='$ids'");
		while($row = mysql_fetch_array($mysql2))
			{$alias = $row['alias'];
			$alias_activation = $row['alias_activation'];}
			
		$email_check_pic = "../user_files/user".$ids."/profile_thumb.jpg";
		$email_default_pic = "http://www.barterrain.com/user_files/user0/default_profile_pic_thumb.png";
		if (file_exists($email_check_pic)) 
			{$email_pic = "<img src='http://www.barterrain.com/user_files/user".$ids."/profile_thumb.jpg' width='75px' height='75px' style='background-color:".$color2.";'/>";} 
		else {$email_pic = "<img src='$email_default_pic' width='75px' height='75px' style='background-color:".$color2.";'/>";}

		if ($alias_activation=="1") 
			{$user_pic="<a href='#' onclick='return false'>".$email_pic."</a>";
			$profile_text=$alias;
			$profile_link="<font style='color:#000000;font:20px helvetica, sans-serif;font-weight:bold;text-decoration:none;margin:0px;padding:0px;'>".$alias."</font>";}
		else if ($alias_activation=="0") 
			{$user_pic="<a href='http://www.barterrain.com/profile/profile.php?id=".$ids."'>".$email_pic."</a>";
			$profile_text=$firstname." ".$lastname;
			$profile_link="<a style='color:".$color1.";font:20px helvetica, sans-serif;font-weight:bold;text-decoration:none;margin:0px;padding:0px;' href='http://www.barterrain.com/profile/profile.php?id=".$ids."'>".$firstname." ".$lastname."</a>";}
			
		if (($email_notification_activation=="1")AND($planet_email!==""))
			{$subject = "New Planet Member Post From ".$profile_text." [".date("F jS, Y | H:i:s")."]";
			$headers = 'From: Barterrain <post@barterrain.com>' . "\r\n"  .
						'Reply-To: Barterrain <post@barterrain.com>' . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
			$message = "<html>
						<head>
    						<title>".$subject."</title>
						</head>";
			$message .= "<body style='z-index:20;overflow:hidden;height:45px;width:100%;margin:0px;padding:0px;'>
							<div style='z-index:20;text-align:center;position:relative;height:45px;width:100%;margin:0px;padding:0px;background-color:".$color1.";float:left;'>
							<table style='z-index:20;text-align:center;position:relative;height:45px;width:150px;margin:0px;padding:0px;margin:auto;vertical-align:top;' align='center'><tr><td>
   		 					<a href='http://www.barterrain.com/' style='text-decoration:none;height:40px;width:150px;margin:0px;padding:0px;' title='Baterrain'>
								<img src=\"http://www.barterrain.com/barterrain_email_images/main_title.png\" style='margin:auto;max-height:40px;width:150px;background:url(\"http://www.barterrain.com/barterrain_email_images/main_title.png\") no-repeat 0 0;' onMouseDown='if (event.preventDefault) event.preventDefault()'/>
							</a>
							</td></tr></table></div>
						</body>";
			$message .= "<body style='z-index:10;overflow:hidden;height:45px;width:100%;margin:0px;padding:0px;float:left;'>
						<div style='z-index:10;text-align:center;position:relative;height:auto;width:100%;margin:0px;padding:0px;background-color:".$color4.";float:left;'>
						<table style='margin:auto;border:0px;border-spacing:0px;text-align:justify;text-align-last:justify;padding-top:23px;padding-bottom:23px;' cellspacing='0' cellpadding='0' align='center'>
							<tr style='position:relative;'>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -0px -0px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_top_left.png\"></td>
							<td style='height:15px;background-color:#FFFFFF;'></td>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -235px -0px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_top_right.png\"></td>
							</tr>
        	   				<tr style='position:relative;'>
							 	<td style='width:15px;background-color:#FFFFFF;'></td>
								<td style='width:580px;height:50px;background-color:#FFFFFF;vertical-align:top;'>
								<table><tr>
            						<td style='text-align:left;float:left;vertical-align:top;'>".$user_pic."</td>
									<td style='text-align:left;width:450px;float:left;vertical-align:top;padding-left:15px;'>
										".$profile_link."
										<font style='color:black;font-size:20px;'> &#9658; Planet: </font>
										<a href=\"http://www.barterrain.com/planet/planet.php?id=".$id."\" style='color:".$color1.";font:20px helvetica, sans-serif;font-weight:bold;text-decoration:none;margin:0px;padding:0px;'>".$planet_name."</a>
										<br/><font style='font:16px helvetica, sans-serif;margin:0px;padding:0px;'> New Planet Member Post: <i>\"".$post."\"</i></font>
									</td>
								</tr></table>
            					</td>
								<td style='width:15px;background-color:#FFFFFF;'></td>
							</tr>
            				<tr style='position:relative;'>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -0px -15px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_bottom_left.png\"></td>
							<td style='height:15px;background-color:#FFFFFF;'></td>
							<td style='width:15px;height:15px;background:url(\"http://www.barterrain.com/barterrain_outside_images/email_pass_background.png\") -235px -15px;background-repeat:no-repeat;overflow:hidden;' background=\"http://www.barterrain.com/barterrain_email_images/td_bottom_right.png\"></td>			
							</tr>
							<tr><td></td><td style='padding-top:23px;'>
								<div style='z-index:10;text-align:center;position:relative;' align='center'>
								<font style='color:#000000'>
									Forgot your Barterrain password? 
									<a href=\"http://www.barterrain.com?forgot_password=true\" style='color:".$color1.";font:12px helvetica, sans-serif;text-decoration:none;'>
										Click here</a> to get a temporary password.
									<br/>Want to unsubscribe from these notification emails? 
									<a href=\"http://www.barterrain.com/settings/settings.php?settings=notification\" style='color:".$color1.";font:12px helvetica, sans-serif;text-decoration:none;'>
										Click here</a> to change notification settings.
								 	<br/>Received this email in error? Did you not sign up for Barterrain? 
									Contact <a href=\"mailto:error@barterrain.com\" style='color:".$color1.";font:12px helvetica, sans-serif;text-decoration:none;'>error@barterrain.com</a>!
								</font>
								</div>
							</td><td></td></tr>
        				</table>
						</div></body>
						</html>";
		
			mail($planet_email,$subject,$message,$headers,'-fpost@barterrain.com');
			}
		}
	
	if(($ids!==$user_id)AND(!in_array($ids,$creator_array)))
		{$mysql = mysql_query("INSERT INTO ".$type."_member_posts (user_page_id, user_post_id, the_post, post_date, member_post_type) VALUES ('$id', '$ids', '$post', UTC_TIMESTAMP(), '$post_type')") or die (mysql_error());}
	else {$mysql = mysql_query("INSERT INTO ".$type."_posts (user_page_id, user_post_id, the_post, post_date, post_type) VALUES ('$id', '$ids', '$post', UTC_TIMESTAMP(), '$post_type')") or die (mysql_error());}
		
	include_once $header_location."member_posts_content.php";
exit();}
///////////////// POSTING STUFF END /////////////////
////////////////////////////////////////////////////

////////////////////////////////////////////////
///////////////// NOTING STUFF /////////////////
if(isset($_POST['note']))
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$subject=$_POST['subject'];
	$note=$_POST['note'];
	$type=$_POST['type'];
	$typex=$type;
	$note_type=$_POST['note_type'];
	$subject = stripslashes($subject);
	$subject = strip_tags($subject);
	$subject = mysql_real_escape_string($subject);
	$note = stripslashes($note);
	$note = strip_tags($note);
	$note = mysql_real_escape_string($note);
	
	$mysql = mysql_query("INSERT INTO ".$type."_notes (user_page_id, user_post_id, the_note_subject, the_note, note_date, note_type)
	VALUES ('$id', '$ids', '$subject', '$note', UTC_TIMESTAMP(), '$note_type')") or die (mysql_error());

	include_once $header_location."wall_content.php";
exit();} 

if(isset($_POST['note2']))
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$subject=$_POST['subject'];
	$note=$_POST['note2'];
	$type=$_POST['type'];
	$typex=$type;
	$note_type=$_POST['note_type'];
	$subject = stripslashes($subject);
	$subject = strip_tags($subject);
	$subject = mysql_real_escape_string($subject);
	$note = stripslashes($note);
	$note = strip_tags($note);
	$note = mysql_real_escape_string($note);
	
	$mysql = mysql_query("INSERT INTO ".$type."_notes (user_page_id, user_post_id, the_note_subject, the_note, note_date, note_type)
	VALUES ('$id', '$ids', '$subject', '$note', UTC_TIMESTAMP(), '$note_type')") or die (mysql_error());

	include_once $header_location."notes_content.php";
exit();} 
///////////////// NOTING STUFF END /////////////////
////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////
//////////////////////// INTERACTIVE ////////////////////////
/////////////////////////////////////////////////////////////
if (isset($_POST['interactive'])){
///////////////// OPTION BOX POINT - ITEM /////////////////
if ($_POST["interactive"] == "point2")
	{$ids=$_POST['ids'];
	$item_id=$_POST['item_id'];
	$item_type=$_POST['item_type'];
	$typex=$_POST['typex'];
	if ($item_type=="posts"){$table="user_post_id";}
	else{$table="user_post_id";}
	
	if ($typex=="planets"){$create_type="planet";}
	else if ($typex=="pages"){$create_type="page";}
	else if ($typex=="groups"){$create_type="group";}
	else if ($typex=="events"){$create_type="event";}
	else if ($typex=="shops"){$create_type="shop";}
	else{$create_type="profile";}
	
	if($item_type=="link_creates"){$mysql = mysql_query("SELECT  ".$table." AS user_id,point_array FROM link_creates WHERE id='$item_id' LIMIT 1");}
	else{$mysql = mysql_query("SELECT ".$table." AS user_id,point_array FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1");}
	while ($row = mysql_fetch_array ($mysql))
		{$user_id = $row['user_id'];
		$point_array_post = $row['point_array'];
		$pointArray_post = explode(",",$point_array_post);
		$point_array_count_post = count($pointArray_post);
		if($point_array_post==""){$point_array_count_post="0";}}
	$mysql = mysql_query("SELECT points FROM economy WHERE id='$ids' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$user_lose_points = $row['points'];}
	$mysql = mysql_query("SELECT id, points FROM economy WHERE id='$user_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$user_gain_points = $row['points'];}
		
	if($user_lose_points>9)
		{$user_lose_points=$user_lose_points-10;
		$user_gain_points=$user_gain_points+10;
		if (($item_type == "images_walls")OR($item_type == "pages_images_walls")OR($item_type == "groups_images_walls")OR($item_type == "events_images_walls")OR($item_type == "shops_images_walls"))
			{$item_type_total = "images";}
		else if (($item_type == "pages_member_posts")OR($item_type == "groups_member_posts")OR($item_type == "events_member_posts")OR($item_type == "shops_member_posts"))
			{$item_type_total = "member_posts";}
		else {$item_type_total = $item_type;}
		if ($point_array_post != ""){$point_array_post = "$point_array_post,$ids";}
		else {$point_array_post = "$ids";}
		mysql_query("UPDATE economy SET points='$user_lose_points' WHERE id='$ids'");
		mysql_query("UPDATE economy SET points='$user_gain_points' WHERE id='$user_id'");
		mysql_query("UPDATE point_totals SET ".$typex."_".$item_type_total."_plus = ".$typex."_".$item_type_total."_plus + 10 WHERE id='$user_id'");
		mysql_query("UPDATE point_totals SET ".$typex."_".$item_type_total."_minus = ".$typex."_".$item_type_total."_minus + 10 WHERE id = '$ids'");
		if($item_type=="link_creates"){mysql_query("UPDATE link_creates SET point_array='$point_array_post' WHERE id='$item_id'");}
		else{mysql_query("UPDATE ".$typex."_".$item_type." SET point_array='$point_array_post' WHERE id='$item_id'");}
		
		if($item_type=="link_creates"){$mysql_create_id = mysql_query("SELECT user_page_id FROM link_creates WHERE id='$item_id' LIMIT 1");}
		else{$mysql_create_id = mysql_query("SELECT user_page_id FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1");}
		while ($row = mysql_fetch_array ($mysql_create_id))
			{$create_id = $row['user_page_id'];}
		
		$transaction=mysql_query("SELECT transaction_date FROM point_transactions WHERE minus_id='$ids' AND plus_id='$user_id' AND item_id='$item_id' AND create_type='$create_type' AND create_id='$create_id' 
									AND transaction_type='$item_type' AND transaction_date>DATE_SUB(UTC_TIMESTAMP(),INTERVAL 24 HOUR) ORDER BY transaction_date DESC LIMIT 1");
		$numRows=mysql_num_rows($transaction);
		if($numRows>0)
			{while ($row = mysql_fetch_array ($transaction))
				{$transaction_date = $row['transaction_date'];}
			mysql_query("UPDATE point_transactions SET transaction_amount = transaction_amount + 10 WHERE minus_id='$ids' AND plus_id='$user_id' AND item_id='$item_id' 
							AND create_type='$create_type' AND transaction_type='$item_type' AND transaction_date='$transaction_date'");}
		else {mysql_query("INSERT INTO point_transactions (minus_id,plus_id,item_id,create_type,create_id,transaction_amount,transaction_type,transaction_date) 
							VALUES ('$ids','$user_id','$item_id','$create_type','$create_id',10,'$item_type',UTC_TIMESTAMP())");}
	
		if($item_type=="link_creates"){$mysql = mysql_query("SELECT point_array FROM link_creates WHERE id='$item_id' LIMIT 1");}
		else{$mysql = mysql_query("SELECT point_array FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1");}
		while ($row = mysql_fetch_array ($mysql))
			{$point_array_post = $row['point_array'];
			$pointArray_post = explode(",",$point_array_post);
			$point_array_count_post = count($pointArray_post);
			$point_array_count_post = $point_array_count_post*10;
			if($point_array_post==""){$point_array_count_post="0";}}
		$item_type= json_encode($item_type);
		echo "<a href='#' title='Give Points For Awesomeness!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$item_id.",".$item_type.");'></a><b class='point'>".$point_array_count_post."</b>";
		}
	else
		{$point_array_count_post = $point_array_count_post*10;
		echo "<a href='#' title='Not Enough Points!' class='point1' onclick='return false' onmousedown='javascript:point1(".$ids.",".$item_id.",".$item_type.");'></a><b title='Not Enough Points!' class='point2'>".$point_array_count_post."</b>";}
exit();}
///////////////// OPTION BOX TYPE CHANGE - WALL STUFF /////////////////
if ($_POST["interactive"] == "type_change")
	{$item_id=$_POST['item_id'];
	$item_type=$_POST['item_type'];
	$typex=$_POST['typex'];
	$comment_type=json_encode($item_type);
	$item_type_s = substr($item_type, 0, -1);
	if($item_type=="link_creates"){$mysql=mysql_query("SELECT ".$item_type_s."_type AS type FROM link_creates WHERE id='$item_id' LIMIT 1");}
	else{$mysql=mysql_query("SELECT ".$item_type_s."_type AS type FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1");}
	while ($row =mysql_fetch_array ($mysql))
		{$type=$row['type'];}
		if($type=="a"){$new_string="b";$new_type="<a href='#' title='Display To Members' class='bff_type22' onclick='return false' onmousedown='javascript:type_change(".$item_id.",".$comment_type.");'></a>";}
	else if($type=="b"){$new_string="c";$new_type="<a href='#' title='Display To Admins' class='bff_type32' onclick='return false' onmousedown='javascript:type_change(".$item_id.",".$comment_type.");'></a>";}
	else if($type=="c"){$new_string="a";$new_type="<a href='#' title='Display To All' class='bff_type12' onclick='return false' onmousedown='javascript:type_change(".$item_id.",".$comment_type.");'></a>";}
	if($item_type=="link_creates"){mysql_query("UPDATE link_creates SET ".$item_type_s."_type='$new_string' WHERE id='$item_id'");}
	else{mysql_query("UPDATE ".$typex."_".$item_type." SET ".$item_type_s."_type='$new_string' WHERE id='$item_id'");}
	echo $new_type;
	exit();}
///////////////// OPTION BOX MEMORY BOX - WALL STUFF /////////////////
if ($_POST["interactive"] == "memory_box")
	{$item_id=$_POST['item_id'];
	$item_type=$_POST['item_type'];
	$typex=$_POST['typex'];
	$comment_type=json_encode($item_type);
	if($item_type=="link_creates"){$mysql=mysql_query("SELECT memory_type AS type FROM link_creates WHERE id='$item_id' LIMIT 1");}
	else{$mysql=mysql_query("SELECT memory_type AS type FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1");}
	while ($row =mysql_fetch_array ($mysql))
		{$type=$row['type'];}
	if($type=="a"){$new_string="b";$new_type="<a href='#' title='Remove From Memory Box' class='mm_box2' onclick='return false' onmousedown='javascript:memory_box(".$item_id.",".$comment_type.");'></a>";}
	else if($type=="b"){$new_string="a";$new_type="<a href='#' title='Store In Memory Box' class='mm_box1' onclick='return false' onmousedown='javascript:memory_box(".$item_id.",".$comment_type.");'></a>";}
	if($item_type=="link_creates"){mysql_query("UPDATE link_creates SET memory_type='$new_string' WHERE id='$item_id'");}
	else{mysql_query("UPDATE ".$typex."_".$item_type." SET memory_type='$new_string' WHERE id='$item_id'");}
	echo $new_type;
	exit();}
	
///////////////// OPTION BOX DELETE - ALBUM /////////////////
if ($_POST["interactive"] == "delete_folder2")
	{$item_id=$_POST['item_id'];
	$id=$_POST['id'];
	$ids=$_POST['ids'];
	$item_type=$_POST['item_type'];
	$typex=$_POST['typex'];
	$typex_s=substr($typex, 0, -1);
	if($item_type=="games")
		{mysql_query("UPDATE ".$typex."_games SET delete_item='0' WHERE id='$item_id' AND user_page_id='$id'");
		mysql_query("UPDATE ".$typex."_games_comments SET delete_comment='0' WHERE game_id='$item_id'");
		$delete_array_query=mysql_query("SELECT comment_array FROM ".$typex."_games_posts WHERE game_id='$item_id'");
		while ($row =mysql_fetch_array ($delete_array_query))
			{$comment_array=$row['comment_array'];
			$commentArray = explode(",", $comment_array);
			foreach ($commentArray as $key => $value) 
				{mysql_query("UPDATE ".$typex."_games_posts_comments SET delete_comment='0' WHERE id='$value'");}}
		mysql_query("UPDATE ".$typex."_games_posts SET delete_item='0' WHERE game_id='$item_id'");
		rename("../planet_files/planet$id/planet_game_".$item_id."/","../planet_files/planet$id/delete_planet_game_".$item_id."/");
		include "../planet/planet_albums_list.php";exit();}
	else if($item_type=="videos")
		{mysql_query("UPDATE ".$typex."_videos SET delete_item='0' WHERE id='$item_id' AND user_page_id='$id'");
		mysql_query("UPDATE ".$typex."_videos_comments SET delete_comment='0' WHERE video_id='$item_id'");
		$delete_array_query=mysql_query("SELECT comment_array FROM ".$typex."_videos_posts WHERE video_id='$item_id'");
		while ($row =mysql_fetch_array ($delete_array_query))
			{$comment_array=$row['comment_array'];
			$commentArray = explode(",", $comment_array);
			foreach ($commentArray as $key => $value) 
				{mysql_query("UPDATE ".$typex."_videos_posts_comments SET delete_comment='0' WHERE id='$value'");}}
		mysql_query("UPDATE ".$typex."_videos_posts SET delete_item='0' WHERE video_id='$item_id'");
		rename("../planet_files/planet$id/planet_video_".$item_id."/","../planet_files/planet$id/delete_planet_video_".$item_id."/");
		include "../planet/planet_videos_list.php";exit();}
	else if($item_type=="albums")
		{mysql_query("UPDATE ".$typex."_albums SET delete_item='0' WHERE id='$item_id' AND user_page_id='$id'");
		mysql_query("UPDATE ".$typex."_albums_comments SET delete_comment='0' WHERE album_id='$item_id'");
		$delete_array_query=mysql_query("SELECT comment_array FROM ".$typex."_albums_posts WHERE album_id='$item_id'");
		while ($row =mysql_fetch_array ($delete_array_query))
			{$comment_array=$row['comment_array'];
			$commentArray = explode(",", $comment_array);
			foreach ($commentArray as $key => $value) 
				{mysql_query("UPDATE ".$typex."_albums_posts_comments SET delete_comment='0' WHERE id='$value'");}}
		mysql_query("UPDATE ".$typex."_albums_posts SET delete_item='0' WHERE album_id='$item_id'");
		mysql_query("UPDATE ".$typex."_images_walls SET delete_item='0' WHERE album_id='$item_id'");
		$delete_array_query=mysql_query("SELECT comment_array FROM ".$typex."_images_walls WHERE album_id='$item_id'");
		while ($row =mysql_fetch_array ($delete_array_query))
			{$comment_array=$row['comment_array'];
			$commentArray = explode(",", $comment_array);
			foreach ($commentArray as $key => $value) 
				{mysql_query("UPDATE ".$typex."_images_walls_comments SET delete_comment='0' WHERE id='$value'");}}
		mysql_query("UPDATE ".$typex."_images_walls SET delete_item='0' WHERE album_id='$item_id'");
		rename("../planet_files/planet$id/planet_album_".$item_id."/","../planet_files/planet$id/delete_planet_album_".$item_id."/");
		rename("../planet_files/planet$id/planet_album_thumbs_".$item_id."/","../planet_files/planet$id/delete_planet_album_thumbs_".$item_id."/");
		
		mysql_query("UPDATE ".$typex."_images SET delete_item='0' WHERE album_id='$item_id' and user_page_id='$id'");
		$delete_array_query=mysql_query("SELECT comment_array FROM ".$typex."_images_posts WHERE album_id='$item_id'");
		while ($row =mysql_fetch_array ($delete_array_query))
			{$comment_array=$row['comment_array'];
			$commentArray = explode(",", $comment_array);
			foreach ($commentArray as $key => $value) 
				{mysql_query("UPDATE ".$typex."_images_posts_comments SET delete_comment='0' WHERE id='$value'");}}
		mysql_query("UPDATE ".$typex."_images_posts SET delete_item='0' WHERE album_id='$item_id'");
		include "../planet/planet_games_list.php";exit();}
	}
	
///////////////// OPTION BOX DELETE - MEDIA /////////////////
if ($_POST["interactive"] == "delete_media2")
	{$item_id=$_POST['item_id'];
	$id=$_POST['id'];
	$ids=$_POST['ids'];
	$item_type=$_POST['item_type'];
	$typex=$_POST['typex'];
	$typex_s=substr($typex, 0, -1);
	if($item_type=="games")
		{mysql_query("UPDATE ".$typex."_games SET delete_item='0' WHERE id='$item_id' AND user_page_id='$id'");
		mysql_query("UPDATE ".$typex."_games_comments SET delete_comment='0' WHERE game_id='$item_id'");
		$delete_array_query=mysql_query("SELECT comment_array FROM ".$typex."_games_posts WHERE game_id='$item_id'");
		while ($row =mysql_fetch_array ($delete_array_query))
			{$comment_array=$row['comment_array'];
			$commentArray = explode(",", $comment_array);
			foreach ($commentArray as $key => $value) 
				{mysql_query("UPDATE ".$typex."_games_posts_comments SET delete_comment='0' WHERE id='$value'");}}
		mysql_query("UPDATE ".$typex."_games_posts SET delete_item='0' WHERE game_id='$item_id'");
		rename("../planet_files/planet$id/planet_game_".$item_id."/","../planet_files/planet$id/delete_planet_game_".$item_id."/");
		include "../planet/planet_media.php";exit();}
	else if($item_type=="videos")
		{mysql_query("UPDATE ".$typex."_videos SET delete_item='0' WHERE id='$item_id' AND user_page_id='$id'");
		mysql_query("UPDATE ".$typex."_videos_comments SET delete_comment='0' WHERE video_id='$item_id'");
		$delete_array_query=mysql_query("SELECT comment_array FROM ".$typex."_videos_posts WHERE video_id='$item_id'");
		while ($row =mysql_fetch_array ($delete_array_query))
			{$comment_array=$row['comment_array'];
			$commentArray = explode(",", $comment_array);
			foreach ($commentArray as $key => $value) 
				{mysql_query("UPDATE ".$typex."_videos_posts_comments SET delete_comment='0' WHERE id='$value'");}}
		mysql_query("UPDATE ".$typex."_videos_posts SET delete_item='0' WHERE video_id='$item_id'");
		rename("../planet_files/planet$id/planet_video_".$item_id."/","../planet_files/planet$id/delete_planet_video_".$item_id."/");
		include "../planet/planet_media.php";exit();}
	else if($item_type=="albums")
		{mysql_query("UPDATE ".$typex."_albums SET delete_item='0' WHERE id='$item_id' AND user_page_id='$id'");
		mysql_query("UPDATE ".$typex."_albums_comments SET delete_comment='0' WHERE album_id='$item_id'");
		$delete_array_query=mysql_query("SELECT comment_array FROM ".$typex."_albums_posts WHERE album_id='$item_id'");
		while ($row =mysql_fetch_array ($delete_array_query))
			{$comment_array=$row['comment_array'];
			$commentArray = explode(",", $comment_array);
			foreach ($commentArray as $key => $value) 
				{mysql_query("UPDATE ".$typex."_albums_posts_comments SET delete_comment='0' WHERE id='$value'");}}
		mysql_query("UPDATE ".$typex."_albums_posts SET delete_item='0' WHERE album_id='$item_id'");
		mysql_query("UPDATE ".$typex."_images_walls SET delete_item='0' WHERE album_id='$item_id'");
		$delete_array_query=mysql_query("SELECT comment_array FROM ".$typex."_images_walls WHERE album_id='$item_id'");
		while ($row =mysql_fetch_array ($delete_array_query))
			{$comment_array=$row['comment_array'];
			$commentArray = explode(",", $comment_array);
			foreach ($commentArray as $key => $value) 
				{mysql_query("UPDATE ".$typex."_images_walls_comments SET delete_comment='0' WHERE id='$value'");}}
		mysql_query("UPDATE ".$typex."_images_walls SET delete_item='0' WHERE album_id='$item_id'");
		rename("../planet_files/planet$id/planet_album_".$item_id."/","../planet_files/planet$id/delete_planet_album_".$item_id."/");
		rename("../planet_files/planet$id/planet_album_thumbs_".$item_id."/","../planet_files/planet$id/delete_planet_album_thumbs_".$item_id."/");
		
		mysql_query("UPDATE ".$typex."_images SET delete_item='0' WHERE album_id='$item_id' and user_page_id='$id'");
		$delete_array_query=mysql_query("SELECT comment_array FROM ".$typex."_images_posts WHERE album_id='$item_id'");
		while ($row =mysql_fetch_array ($delete_array_query))
			{$comment_array=$row['comment_array'];
			$commentArray = explode(",", $comment_array);
			foreach ($commentArray as $key => $value) 
				{mysql_query("UPDATE ".$typex."_images_posts_comments SET delete_comment='0' WHERE id='$value'");}}
		mysql_query("UPDATE ".$typex."_images_posts SET delete_item='0' WHERE album_id='$item_id'");
		include "../planet/planet_media.php";exit();}
	}
	
///////////////// OPTION BOX DELETE - IMAGE /////////////////
if ($_POST["interactive"] == "delete_image2")
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$image_id=$_POST['item_id'];
	$typex=$_POST['typex'];
	$image_query=mysql_query("SELECT album_id,ext FROM ".$typex."_images WHERE id='$image_id' LIMIT 1");
	while ($row =mysql_fetch_array ($image_query))
		{$album_id=$row['album_id'];
		$image_ext=$row['ext'];}
	$album_query=mysql_query("SELECT image_array FROM ".$typex."_albums WHERE id='$album_id' LIMIT 1");
	while ($row =mysql_fetch_array ($album_query))
		{$image_array=$row['image_array'];
		$imageArray = explode(",", $image_array);}
	$images_wall_query=mysql_query("SELECT id, images FROM ".$typex."_images_walls WHERE album_id='$album_id'");
	while ($row =mysql_fetch_array ($images_wall_query))
		{$images_wall_id=$row['id'];
		$images=$row['images'];
		$images = explode(",", $images);
		foreach ($images as $key => $value) 
			{if ($value == $image_id)
				{unset($images[$key]);}}
		$images = implode(",",$images);
		$mysql = mysql_query("UPDATE ".$typex."_images_walls SET images='$images' WHERE id='$images_wall_id'");
		}
	mysql_query("UPDATE ".$typex."_images SET delete_item='0' WHERE id='$image_id' and user_page_id='$id'");
	foreach ($imageArray as $key => $value) 
		{if ($value == $image_id)
			{unset($imageArray[$key]);}}
	$new_string = implode(",",$imageArray);
	$mysql = mysql_query("UPDATE ".$typex."_albums SET image_array='$new_string' WHERE id='$album_id'");
	rename("../planet_files/planet$id/planet_album_".$album_id."/planet_album_".$album_id."_pic_".$image_id.".".$image_ext."","../planet_files/planet$id/planet_album_".$album_id."/delete_planet_album_".$album_id."_pic_".$image_id.".".$image_ext."");
	rename("../planet_files/planet$id/planet_album_thumbs_".$album_id."/planet_album_".$album_id."_thumb_".$image_id.".jpg","../planet_files/planet$id/planet_album_thumbs_".$album_id."/delete_planet_album_".$album_id."_thumb_".$image_id.".jpg");
	include "../planet/planet_images_list.php";exit();}
///////////////// OPTION BOX DELETE - POST /////////////////
if ($_POST["interactive"] == "delete_post2")
	{$post_id=$_POST['post_id'];
	$typex=$_POST['typex'];
	mysql_query("UPDATE ".$typex."_posts SET delete_item='0' WHERE id='$post_id'");
	mysql_query("UPDATE ".$typex."_posts_comments SET delete_comment='0' WHERE post_id='$post_id'");
	echo '';
	exit();}
///////////////// OPTION BOX DELETE - MEMBER POST /////////////////
if ($_POST["interactive"] == "delete_member_post2")
	{$post_id=$_POST['post_id'];
	$typex=$_POST['typex'];
	mysql_query("UPDATE ".$typex."_member_posts SET delete_item='0' WHERE id='$post_id'");
	mysql_query("UPDATE ".$typex."_member_posts_comments SET delete_comment='0' WHERE post_id='$post_id'");
	echo '';
	exit();}
///////////////// OPTION BOX DELETE - NOTE /////////////////
if ($_POST["interactive"] == "delete_note2")
	{$note_id=$_POST['note_id'];
	$typex=$_POST['typex'];
	mysql_query("UPDATE ".$typex."_notes SET delete_item='0' WHERE id='$note_id'");
	mysql_query("UPDATE ".$typex."_notes_comments SET delete_comment='0' WHERE note_id='$note_id'");
	echo '';
	exit();}
///////////////// OPTION BOX DELETE - WALL STUFF /////////////////
if ($_POST["interactive"] == "delete_item2")
	{$item_id=$_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type_s=substr($item_type,0,-1);
	$typex=$_POST['typex'];
	$new_string="";
	
	if($item_type=="games")
		{mysql_query("UPDATE ".$typex."_games SET delete_item='0' WHERE id='$item_id' AND user_page_id='$id'");
		mysql_query("UPDATE ".$typex."_games_comments SET delete_comment='0' WHERE game_id='$item_id'");
		$delete_array_query=mysql_query("SELECT comment_array FROM ".$typex."_games_posts WHERE game_id='$item_id'");
		while ($row =mysql_fetch_array ($delete_array_query))
			{$comment_array=$row['comment_array'];
			$commentArray = explode(",", $comment_array);
			foreach ($commentArray as $key => $value) 
				{mysql_query("UPDATE ".$typex."_games_posts_comments SET delete_comment='0' WHERE id='$value'");}}
		mysql_query("UPDATE ".$typex."_games_posts SET delete_item='0' WHERE game_id='$item_id'");
		rename("../planet_files/planet$id/planet_game_".$item_id."/","../planet_files/planet$id/delete_planet_game_".$item_id."/");}
	else if($item_type=="videos")
		{mysql_query("UPDATE ".$typex."_videos SET delete_item='0' WHERE id='$item_id' AND user_page_id='$id'");
		mysql_query("UPDATE ".$typex."_videos_comments SET delete_comment='0' WHERE video_id='$item_id'");
		$delete_array_query=mysql_query("SELECT comment_array FROM ".$typex."_videos_posts WHERE video_id='$item_id'");
		while ($row =mysql_fetch_array ($delete_array_query))
			{$comment_array=$row['comment_array'];
			$commentArray = explode(",", $comment_array);
			foreach ($commentArray as $key => $value) 
				{mysql_query("UPDATE ".$typex."_videos_posts_comments SET delete_comment='0' WHERE id='$value'");}}
		mysql_query("UPDATE ".$typex."_videos_posts SET delete_item='0' WHERE video_id='$item_id'");
		rename("../planet_files/planet$id/planet_video_".$item_id."/","../planet_files/planet$id/delete_planet_video_".$item_id."/");}
	else if($item_type=="albums")
		{mysql_query("UPDATE ".$typex."_albums SET delete_item='0' WHERE id='$item_id' AND user_page_id='$id'");
		mysql_query("UPDATE ".$typex."_albums_comments SET delete_comment='0' WHERE album_id='$item_id'");
		$delete_array_query=mysql_query("SELECT comment_array FROM ".$typex."_albums_posts WHERE album_id='$item_id'");
		while ($row =mysql_fetch_array ($delete_array_query))
			{$comment_array=$row['comment_array'];
			$commentArray = explode(",", $comment_array);
			foreach ($commentArray as $key => $value) 
				{mysql_query("UPDATE ".$typex."_albums_posts_comments SET delete_comment='0' WHERE id='$value'");}}
		mysql_query("UPDATE ".$typex."_albums_posts SET delete_item='0' WHERE album_id='$item_id'");
		mysql_query("UPDATE ".$typex."_images_walls SET delete_item='0' WHERE album_id='$item_id'");
		$delete_array_query=mysql_query("SELECT comment_array FROM ".$typex."_images_walls WHERE album_id='$item_id'");
		while ($row =mysql_fetch_array ($delete_array_query))
			{$comment_array=$row['comment_array'];
			$commentArray = explode(",", $comment_array);
			foreach ($commentArray as $key => $value) 
				{mysql_query("UPDATE ".$typex."_images_walls_comments SET delete_comment='0' WHERE id='$value'");}}
		mysql_query("UPDATE ".$typex."_images_walls SET delete_item='0' WHERE album_id='$item_id'");
		rename("../planet_files/planet$id/planet_album_".$item_id."/","../planet_files/planet$id/delete_planet_album_".$item_id."/");
		rename("../planet_files/planet$id/planet_album_thumbs_".$item_id."/","../planet_files/planet$id/delete_planet_album_thumbs_".$item_id."/");
		
		mysql_query("UPDATE ".$typex."_images SET delete_item='0' WHERE album_id='$item_id' and user_page_id='$id'");
		$delete_array_query=mysql_query("SELECT comment_array FROM ".$typex."_images_posts WHERE album_id='$item_id'");
		while ($row =mysql_fetch_array ($delete_array_query))
			{$comment_array=$row['comment_array'];
			$commentArray = explode(",", $comment_array);
			foreach ($commentArray as $key => $value) 
				{mysql_query("UPDATE ".$typex."_images_posts_comments SET delete_comment='0' WHERE images_post_id='$value'");}}
		mysql_query("UPDATE ".$typex."_images_posts SET delete_item='0' WHERE album_id='$item_id'");}
	else if($item_type=="link_creates")
		{mysql_query("UPDATE link_creates SET delete_item='0' WHERE id='$item_id'");
		mysql_query("UPDATE link_creates_comments SET delete_comment='0' WHERE link_create_id='$item_id'");}
	else
		{mysql_query("UPDATE ".$typex."_".$item_type." SET delete_item='0' WHERE id='$item_id'");
		mysql_query("UPDATE ".$typex."_".$item_type."_comments SET delete_comment='0' WHERE ".$item_type_s."_id='$item_id'");}
	echo "";
	exit();}
///////////////////////////////////////////////////
	}	///////// INTERACTIVE END /////////////////
///////////////////////////////////////////////////
?>