<?php 
session_start();
include "../config.php";

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

// Crypting Password
function cryptPass($input_password, $rounds = 8)
	{$salt = "";
	$saltChars = array_merge(range(0,9),range('A','Z'), range('a','z'));
	for ($i=0; $i<22; $i++) 
		{$salt .= $saltChars[array_rand($saltChars)];}
	return crypt($input_password, sprintf('$2y$%02d$', $rounds) . $salt);
	}

// SIGNUP FOR ACCOUNT
if ($_POST["interactive_outside"] == "signup")
	{$firstname=$_POST['firstname'];
	$lastname=$_POST['lastname'];
	$alias=$_POST['alias'];
	$email=$_POST['signup_email'];
	$re_email=$_POST['re_email'];
	$password=$_POST['signup_password'];
	$re_password=$_POST['re_password'];
	$gender=$_POST['gender'];
	$birthday_month=$_POST['birthday_month'];
	$birthday_day=$_POST['birthday_day'];
	$birthday_year=$_POST['birthday_year'];
	$invite_code=$_POST['invite_code'];
	
	$firstname=stripslashes($firstname);
	$lastname=stripslashes($lastname);
	$alias=stripslashes($alias);
	$email=stripslashes($email);
	$re_email=stripslashes($re_email);
	$gender=stripslashes($gender);
	$birthday_month=stripslashes($birthday_month);
	$birthday_day=stripslashes($birthday_day);
	$birthday_year=stripslashes($birthday_year);
	
	$firstname=strip_tags($firstname);
	$lastname=strip_tags($lastname);
	$alias=strip_tags($alias);
	$email=strip_tags($email);
	$re_email=strip_tags($re_email);
	$gender=strip_tags($gender);
	$birthday_month=strip_tags($birthday_month);
	$birthday_day=strip_tags($birthday_day);
	$birthday_year=strip_tags($birthday_year);
	
	$mysql_email_check=mysql_query("SELECT id FROM members WHERE email='$email' AND email_activated='0'");
	while($row = mysql_fetch_array($mysql_email_check)) {$id = $row["id"];$delete_id = $row["id"];}   
	$email_check=mysql_num_rows($mysql_email_check);
	if ($email_check>0)
		{mysql_query("DELETE FROM members WHERE email='$email' AND email_activated='0'");
		mysql_query("DELETE FROM members_log WHERE id='$id'");
		mysql_query("DELETE FROM members_planets WHERE id='$id'");
		mysql_query("DELETE FROM economy WHERE id='$id'");
		mysql_query("DELETE FROM point_totals WHERE id='$id'");
		mysql_query("DELETE FROM point_totals_comments WHERE id='$id'");
		mysql_query("DELETE FROM point_totals_economy WHERE id='$id'");
		if (file_exists("../user_files/user$id/")){rename("../user_files/user$id/","../user_files/delete_user$id/");}}
	
	$mysql_email_check=mysql_query("SELECT email FROM members WHERE email='$email'");
	$email_check=mysql_num_rows($mysql_email_check);
	$mysql_alias_check=mysql_query("SELECT alias FROM members_planets WHERE alias='$alias'");
	$alias_check=mysql_num_rows($mysql_alias_check);
	
	// Error Checking
	if ((!$firstname)||(!$lastname)||(!$alias)||(!$email)||(!$re_email)||(!$password)||(!$re_password)||(!$gender)||(!$birthday_month)||(!$birthday_day)||(!$birthday_year))
		{echo "Please Fill In All Fields!";exit();}
	else if (preg_match('/[^A-Za-z]/i', $firstname))
		{echo "Firstname Doesn't Seem To Be Real.";exit();}
	else if (preg_match('/[^A-Za-z ]/i', $lastname))
		{echo "Lastname Doesn't Seem To Be Real.";exit();}
	else if (strlen($alias) < 6)
		{echo  "Alias Must Be 6 - 20 Characters Long.";exit();} 
	else if (strlen($alias) > 20)
		{echo  "Alias Must Be 6 - 20 Characters Long.";exit();} 
	else if (preg_match('/[^A-Za-z0-9_.]/i', $alias))
		{echo  "Alias Can Only Contain Letters, Numbers, Periods, & Underscores.";exit();}
	else if ($alias_check > 0)
		{echo "Alias Is Already Used. Please Try Another!";exit();}
	else if ((strpbrk('@', $email) AND strpbrk('.', $email)) == false)
		{echo  "Email Doesn't Seem To Be Real.";exit();}
	else if ($email_check > 0)
		{echo "Email Is Already Used. Please Try Another!";exit();}
	else if ($email != $re_email)
		{echo "Email Fields Do Not Match.";exit();}
	else if (strlen($password) < 6)
		{echo  "Password Must Be 6 - 20 Characters Long.";exit();} 
	else if (strlen($password) > 20)
		{echo  "Password Must Be 6 - 20 Characters Long.";exit();}
	else if ($password != $re_password)
		{echo "Password Fields Do Not Match.";exit();}

	else 
		{$firstname=mysql_real_escape_string($firstname);
		$lastname=mysql_real_escape_string($lastname);
		$alias=mysql_real_escape_string($alias);
		$email=mysql_real_escape_string($email);
		$re_email=mysql_real_escape_string($re_email);
		$password=mysql_real_escape_string($password);
		$re_password=mysql_real_escape_string($re_password);
		$gender=mysql_real_escape_string($gender);
		$birthday_month=mysql_real_escape_string($birthday_month);
		$birthday_day=mysql_real_escape_string($birthday_day);
		$birthday_year=mysql_real_escape_string($birthday_year);
		
		$firstname=ucfirst($firstname);
		$lastname=ucfirst($lastname);
		$fullname="$firstname $lastname";
		$password = "musemu838".$password;
		$password_cookie = cryptPass(sha1(md5($password)));
		$password_mysql = cryptPass(md5(sha1($password_cookie)));
		$birthday_ymd=$birthday_year."-".$birthday_month."-".$birthday_day;
		$ip_address = $_SERVER["REMOTE_ADDR"];
		
		mysql_query("INSERT INTO members (fullname, firstname, lastname, email, password, gender, birthday_ymd, sign_up_date, ip_address)
		VALUES ('$fullname','$firstname','$lastname', '$email', '$password_mysql','$gender','$birthday_ymd',UTC_TIMESTAMP(),'$ip_address')") or die("Error: ".mysql_error());
		
		$mysql = mysql_query("SELECT id FROM members WHERE email='$email' AND password='$password_mysql'"); 
		while($row = mysql_fetch_array($mysql)) {$id = $row["id"];}   
		
		mysql_query("INSERT INTO members_log (id) VALUES ('$id')") or die("Error: ".mysql_error());
		mysql_query("INSERT INTO members_planets (id, alias) VALUES ('$id','$alias')") or die("Error: ".mysql_error());
		mysql_query("INSERT INTO economy (id, points) VALUES ('$id','500')") or die("Error: ".mysql_error());
		mysql_query("INSERT INTO point_totals (id) VALUES ('$id')") or die("Error: ".mysql_error());
		mysql_query("INSERT INTO point_totals_comments (id) VALUES ('$id')") or die("Error: ".mysql_error());
		mysql_query("INSERT INTO point_totals_economy (id) VALUES ('$id')") or die("Error: ".mysql_error());
		
		mkdir("../user_files/user$id", 0755);
		mkdir("../user_files/user$id/tmp_folder", 0755);	
		
		$mysql_invite_check=mysql_query("SELECT * FROM friend_invites WHERE (invite_email='$email') AND (invite_code='$invite_code')");
		$invite_check=mysql_num_rows($mysql_invite_check);
		if ($invite_check>0)
			{mysql_query("UPDATE members SET invite_code = '$invite_code' WHERE id='$id'") or die (mysql_error());}
		
		$random_number = rand(100000000,999999999);
		$random_number = $random_number."-".$id;
		$activate_message="It wouldn't be Barterrain without you! Thank you for joining the party!";
		$activate_message=$activate_message."<br/>Activation Link: <a href='http://www.barterrain.com?activate_code=".$random_number."' style='color:".$color1.";font:12px helvetica, sans-serif;text-decoration:none;'>www.barterrain.com?activate_code=".$random_number."</a>";
		
		$subject = "Activation Link From Barterrain [".date("F jS, Y | H:i:s")."]";
		$headers = 'From: Barterrain <activate@barterrain.com>' . "\r\n"  .
						'Reply-To: Barterrain <activate@barterrain.com>' . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
			$message = "<html>
						<head>
    						<title>".$subject."</title>
						</head>";
			$message .= "<body style='z-index:20;overflow:hidden;height:45px;width:100%;margin:0px;padding:0px;'>
							<div style='z-index:20;text-align:center;position:relative;height:45px;width:100%;margin:0px;padding:0px;background-color:".$color1.";'>
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
            						<td style='text-align:left;float:left;vertical-align:top;'>
										<a href=\"http://www.barterrain.com/planet/planet.php?id=1\">
											<img src=\"http://www.barterrain.com/planet_files/planet1/planet_picture.jpg\" width='75px' height='75px' style='background-color:".$color2.";'/>
										</a>
									</td>
									<td style='text-align:left;width:450px;float:left;vertical-align:top;padding-left:15px;'>
										<a href=\"http://www.barterrain.com/planet/planet.php?id=1\" style='color:".$color1.";font:20px helvetica, sans-serif;font-weight:bold;text-decoration:none;margin:0px;padding:0px;'>BARTERRAIN</a>
										<br/>".$activate_message."
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
		
		mysql_query("UPDATE members SET activate_code = '$random_number' WHERE id='$id'") or die (mysql_error());
		mail($email,$subject,$message,$headers,'-factivate@barterrain.com');
	
		echo "Success! Check Email For Activation Link!";
		exit();}
	}

// FORGOT MY PASSWORD
if ($_POST["interactive_outside"] == "reset")
	{$email = $_POST["reset_field"];
	$mysql = mysql_query("SELECT id, firstname, lastname, email FROM members WHERE email='$email' LIMIT 1");
	$numrows = mysql_num_rows($mysql);
	
	if ($numrows == 0)
		{echo "Email Not In System, Please Try Again!";exit();}
	else
		{while($row = mysql_fetch_array($mysql))
			{$id = $row["id"];   
			$firstname = $row["firstname"];   
			$lastname = $row["lastname"];}
		$random_number=rand(100000000,999999999);
		$temporary_password_email = $random_number."-".$id;
		$temporary_password = "musemu838".$temporary_password_email;
		$temporary_password_cookie = cryptPass(sha1(md5($temporary_password)));
		$temporary_password_mysql = cryptPass(md5(sha1($temporary_password_cookie)));
		
		$subject = "Temporary Password From Barterrain [".date("F jS, Y | H:i:s")."]";
		$headers = 'From: Barterrain <password@barterrain.com>' . "\r\n"  .
						'Reply-To: Barterrain <password@barterrain.com>' . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
			$message = "<html>
						<head>
    						<title>".$subject."</title>
						</head>";
			$message .= "<body style='z-index:20;overflow:hidden;height:45px;width:100%;margin:0px;padding:0px;'>
							<div style='z-index:20;text-align:center;position:relative;height:45px;width:100%;margin:0px;padding:0px;background-color:".$color1.";'>
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
            						<td style='text-align:left;float:left;vertical-align:top;'>
										<a href=\"http://www.barterrain.com/planet/planet.php?id=1\">
											<img src=\"http://www.barterrain.com/planet_files/planet1/planet_picture.jpg\" width='75px' height='75px' style='background-color:".$color2.";'/>
										</a>
									</td>
									<td style='text-align:left;width:450px;float:left;vertical-align:top;padding-left:15px;'>
										<a href=\"http://www.barterrain.com/planet/planet.php?id=1\" style='color:".$color1.";font:20px helvetica, sans-serif;font-weight:bold;text-decoration:none;margin:0px;padding:0px;'>BARTERRAIN</a>
										<br/><font style='font:16px helvetica, sans-serif;margin:0px;padding:0px;'>Temporary Password: ".$temporary_password_email."</font>
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
		
		$change_mysql = mysql_query("UPDATE members SET temporary_password='$temporary_password_mysql' WHERE email='$email'");
		mail($email,$subject,$message,$headers,'-fpassword@barterrain.com');
		echo "Temporary Password Has Been Sent!";
		}
	exit();}
?>