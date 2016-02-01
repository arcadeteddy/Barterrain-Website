<?php
ob_start();
session_start();
include "../config.php";
$id=$_POST['id'];
$ids=$_POST['ids'];

if((!isset($_SESSION['id']))AND(!isset($_SESSION['ids'])))
	{header("Location: http://www.barterrain.com/settings/logout.php");exit();}

$error_message="";
$success_message="";

// Crypting Password
function cryptPass($input_password, $rounds = 8)
	{$salt = "";
	$saltChars = array_merge(range(0,9),range('A','Z'), range('a','z'));
	for ($i=0; $i<22; $i++) 
		{$salt .= $saltChars[array_rand($saltChars)];}
	return crypt($input_password, sprintf('$2y$%02d$', $rounds) . $salt);
	}
	
// Deleting Profile Pic
if((isset($_POST['interactive']))AND($_POST['interactive']=="remove_profile_pic"))
	{$planet_id=$_POST['planet_id'];
	unlink("../user_files/user".$ids."/profile_pic.jpg");
	unlink("../user_files/user".$ids."/profile_thumb.jpg");
	header("location: settings.php");exit();}
// Deleting Cover Pic
if((isset($_POST['interactive']))AND($_POST['interactive']=="remove_cover_pic"))
	{unlink("../user_files/user".$ids."/cover_pic.jpg");
	header("location: settings.php");exit();}
	
// Deleting Planets Pic
if((isset($_POST['interactive']))AND($_POST['interactive']=="remove_planets_pic"))
	{$planet_id=$_POST['planet_id'];
	$check_pic="../planet_files/planet".$planet_id."/planet_picture.jpg";
	$check_pic2="../planet_files/planet".$planet_id."/planet_picture.png";
	if (file_exists($check_pic))
		{unlink("../planet_files/planet".$planet_id."/planet_picture.jpg");}
	else if (file_exists($check_pic2))
		{unlink("../planet_files/planet".$planet_id."/planet_picture.png");}
	unlink("../planet_files/planet".$planet_id."/planet_thumb.jpg");
	unlink("../planet_files/planet".$planet_id."/planet_cover.jpg");
	header("location: settings.php?settings=planet&planet_id=".$planet_id."");}
// Deleting Planets Cover Pic
if((isset($_POST['interactive']))AND($_POST['interactive']=="remove_planets_cover_pic"))
	{$planet_id=$_POST['planet_id'];
	unlink("../planet_files/planet".$planet_id."/cover_pic.jpg");
	header("location: settings.php?settings=planet&planet_id=".$planet_id."");exit();}

// Section for Email.
if(isset($_POST['email']))
	{$skipper="Skip";
	$email = $_POST['email'];
	$alt_email = $_POST['alt_email'];
	$password_ver = $_POST['password_ver1'];
	
	$password_ver = "musemu838".$password_ver;
	$password_cookie = cryptPass(sha1(md5($password_ver)));
	$password_ver = cryptPass(md5(sha1($password_cookie)));	
	
	$mysql_email_check=mysql_query("SELECT email FROM members WHERE email='$email'");
	$email_check=mysql_num_rows($mysql_email_check);
	$mysql = mysql_query("SELECT * FROM members WHERE id=$ids");
	while($row = mysql_fetch_array($mysql))
		{$email_original = $row["email"];
		$alt_email_original = $row["alt_email"];
		$password = $row["password"];}
		
	if ((!$email)||(!$password_ver))
		{$error_message = "Please Fill In The Primary Email Field & The Verification Password Field!<br/><br/>";}
	else if ((strpbrk('@', $email) AND strpbrk('.', $email)) == false)
		{$error_message= "Primary Email Doesn't Seem To Be Real.<br/><br/>";}
	else if (($email != $email_original) AND ($email_check > 0))
			{$error_message="Primary Email Is Already Used By Someone Else. Please Try Another!<br/><br/>";}
	else if (($alt_email != $alt_email_original)AND ($alt_email!="") AND (strpbrk('@', $alt_email) AND strpbrk('.', $alt_email)) == false)
			{$error_message= "Secondary Email Doesn't Seem To Be Real.<br/><br/>";}
	else if ($password_ver != $password)
		{$error_message = "Incorrect Verification Password. Please Try Again!<br/><br/>";}
	else
		{$email = strip_tags($_POST['email']);
		$email=mysql_real_escape_string($email);
		$alt_email = strip_tags($_POST['alt_email']);
		$alt_email=mysql_real_escape_string($alt_email);
		$mysqlSave = mysql_query("UPDATE members SET alt_email='$alt_email' WHERE id='$ids' AND password='$password_ver'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "profile_settings.php";exit();
	}
	
// Section for Fullname
if(isset($_POST['firstname']))
	{$firstname = $_POST['firstname'];
	$middlename = $_POST['middlename'];
	$lastname = $_POST['lastname'];
	$skipper="Skip";
	
	if ((!$firstname)||(!$lastname))
		{$error_message = "Please Fill In The First Name Field & The Last Name Field!<br/><br/>";}
	else if ((preg_match('/[^A-Za-z]/i', $firstname))||(preg_match('/[^A-Za-z]/i', $lastname))||(preg_match('/[^A-Za-z]/i', $middlename)))
		{$error_message = "Name Doesn't Seem To Be Real.<br/><br/>";}
	else 
		{$firstname = preg_replace('#[^A-Za-z]#i', '', $_POST['firstname']);
		$middlename = preg_replace('#[^A-Za-z]#i', '', $_POST['middlename']);
		$lastname = preg_replace('#[^A-Za-z ]#i', '', $_POST['lastname']);
		$firstname = strip_tags($_POST['firstname']);
		$middlename = strip_tags($_POST['middlename']);
		$lastname = strip_tags($_POST['lastname']);
		$firstname=mysql_real_escape_string($firstname);
		$middlename=mysql_real_escape_string($middlename);
		$lastname=mysql_real_escape_string($lastname);
		$firstname=ucfirst($firstname);
		$middlename=ucfirst($middlename);
		$lastname=ucfirst($lastname);
		$fullname = "$firstname $lastname";
		$mysqlSave = mysql_query("UPDATE members SET fullname='$fullname', firstname='$firstname', middlename='$middlename', lastname='$lastname' WHERE id='$ids'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "profile_settings.php";exit();
	}
	
// Section for Gender.
if(isset($_POST['gender']))
	{$skipper="Skip";
	$gender = $_POST['gender'];
	if ($gender=="")
		{$error_message = "Please Fill In The Gender Field!<br/><br/>";}
	else 
		{$gender = strip_tags($_POST['gender']);
		$gender=mysql_real_escape_string($gender);
		$mysqlSave = mysql_query("UPDATE members SET gender='$gender' WHERE id='$ids'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "profile_settings.php";exit();
	}	

// Section for Birthday.
if(isset($_POST['birthday_month']))
	{$skipper="Skip";
	$birthday_month = $_POST['birthday_month'];
	$birthday_day = $_POST['birthday_day'];
	$birthday_year = $_POST['birthday_year'];
	$birthday_ymd=$birthday_year."-".$birthday_month."-".$birthday_day;
	
	if (($birthday_month=="")OR($birthday_day=="")OR($birthday_year==""))
		{$error_message = "Please Fill In All Fields!<br/><br/>";}
	else 
		{$birthday_month = preg_replace('#[^A-Za-z]#i', '', $_POST['birthday_month']);
		$birthday_day = preg_replace('#[^A-Za-z]#i', '', $_POST['birthday_day']);
		$birthday_year = preg_replace('#[^A-Za-z]#i', '', $_POST['birthday_year']);
		$birthday_month = strip_tags($_POST['birthday_month']);
		$birthday_day = strip_tags($_POST['birthday_day']);
		$birthday_year = strip_tags($_POST['birthday_year']);
		$birthday_month=mysql_real_escape_string($birthday_month);
		$birthday_day=mysql_real_escape_string($birthday_day);
		$birthday_year=mysql_real_escape_string($birthday_year);
		$mysqlSave = mysql_query("UPDATE members SET birthday_ymd='$birthday_ymd' WHERE id='$ids'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "profile_settings.php";exit();
	}
	
// Section for Personal Bio.
if(isset($_POST['personal_bio']))
	{$skipper="Skip";
	$personal_bio = $_POST['personal_bio'];
	$personal_bio = strip_tags($_POST['personal_bio']);
	$personal_bio=mysql_real_escape_string($personal_bio);
	$mysqlSave = mysql_query("UPDATE members SET personal_bio='$personal_bio' WHERE id='$ids'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
	include_once "profile_settings.php";exit();
	}	
	
// Section for Motto.
if((isset($_POST['motto1']))OR(isset($_POST['motto2'])))
	{$skipper="Skip";
	$motto1 = $_POST['motto1'];
	$motto1 = strip_tags($_POST['motto1']);
	$motto1=mysql_real_escape_string($motto1);
	$motto2 = $_POST['motto2'];
	$motto2 = strip_tags($_POST['motto2']);
	$motto2=mysql_real_escape_string($motto2);
	$mysqlSave = mysql_query("UPDATE members SET motto1='$motto1', motto2='$motto2' WHERE id='$ids'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
	include_once "profile_settings.php";exit();
	}	
	
// Section for Networks.
if(isset($_POST['location']))
	{$skipper="Skip";
	$location = $_POST['location'];
	$primary_school = $_POST['primary_school'];
	$secondary_school = $_POST['secondary_school'];
	$post_secondary = $_POST['post_secondary'];
	$employer = $_POST['employer'];
	
	$location = strip_tags($_POST['location']);
	$primary_school = strip_tags($_POST['primary_school']);
	$secondary_school = strip_tags($_POST['secondary_school']);
	$post_secondary = strip_tags($_POST['post_secondary']);
	$employer = strip_tags($_POST['employer']);
	
	$location=mysql_real_escape_string($location);
	$primary_school=mysql_real_escape_string($primary_school);
	$secondary_school=mysql_real_escape_string($secondary_school);
	$post_secondary=mysql_real_escape_string($post_secondary);
	$employer=mysql_real_escape_string($employer);
	
	$mysqlSave = mysql_query("UPDATE members SET location='$location',primary_school='$primary_school',secondary_school='$secondary_school',post_secondary='$post_secondary',employer='$employer' WHERE id='$ids'");
	if ($mysqlSave)
		{$success_message = "Successfully Saved!<br/><br/>";}
	else 
		{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
	include_once "profile_settings.php";exit();
	}
	
// Section for Relationship Status.
if(isset($_POST['relationship']))
	{$skipper="Skip";
	$relationship = $_POST['relationship'];
	if ($relationship=="")
		{$error_message = "Please Fill In The Relationship Status Field!<br/><br/>";}
	else 
		{$relationship = strip_tags($_POST['relationship']);
		$relationship=mysql_real_escape_string($relationship);
		$mysqlSave = mysql_query("UPDATE members SET relationship='$relationship' WHERE id='$ids'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "profile_settings.php";exit();
	}

// Section for Contact Information.
if(isset($_POST['cell_number']))
	{$skipper="Skip";
	$cell_number = $_POST['cell_number'];
	$tel_number = $_POST['tel_number'];
	
	if (preg_match('/[^0-9-() ]/i', $cell_number))
		{$error_message = "Cell Phone Number Doesn't Seem To Be Real.<br/><br/>";}
	else if (preg_match('/[^0-9-() ]/i', $tel_number))
		{$error_message = "Telephone Number Doesn't Seem To Be Real.<br/><br/>";}
	else 
		{$cell_number = strip_tags($_POST['cell_number']);
		$tel_number = strip_tags($_POST['tel_number']);
		$cell_number=mysql_real_escape_string($cell_number);
		$tel_number=mysql_real_escape_string($tel_number);
		$mysqlSave = mysql_query("UPDATE members SET cell_number='$cell_number', tel_number='$tel_number' WHERE id='$ids'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "profile_settings.php";exit();
	}
// Section for Scores
if(isset($_POST['scores']))
	{$skipper="Skip";
	$scores = $_POST['scores'];
	if ($scores == "")
		{$error_message = "Please Fill In The Profile Scores Field!<br/><br/>";}
	else 
		{$scores = strip_tags($_POST['scores']);
		$scores=mysql_real_escape_string($scores);
		$mysqlSave = mysql_query("UPDATE members SET scores='$scores' WHERE id='$ids'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "profile_settings.php";exit();
	}			
	
// Section for Alias.
if(isset($_POST['alias']))
	{$skipper="Skip";
	$alias = $_POST['alias'];
	$alias_activation = $_POST['alias_activation'];
	$password_ver = $_POST['password_ver1'];
	
	$password_ver = "musemu838".$password_ver;
	$password_cookie = cryptPass(sha1(md5($password_ver)));
	$password_ver = cryptPass(md5(sha1($password_cookie)));	
	
	$mysql_alias_check=mysql_query("SELECT alias FROM members_planets WHERE alias='$alias'");
	$alias_check=mysql_num_rows($mysql_alias_check);
	$mysql1 = mysql_query("SELECT * FROM members WHERE id=$ids");
	while($row = mysql_fetch_array($mysql1))
		{$password = $row["password"];}
	$mysql2 = mysql_query("SELECT * FROM members_planets WHERE id=$ids");
	while($row = mysql_fetch_array($mysql2))
		{$alias_original = $row["alias"];
		$alias_activation_original = $row["alias_activation"];}
		
	if (($alias=="")AND($alias_activation==""))
		{$error_message = "Please Fill In All Fields!<br/><br/>";}
	else if (strlen($alias) < 6)
		{$error_message = "Alias Must Be 6 - 20 Characters Long.<br/><br/>";} 
	else if (strlen($alias) > 20)
		{$error_message = "Alias Must Be 6 - 20 Characters Long.<br/><br/>";} 
	else if (preg_match('/[^A-Za-z0-9_.]/i', $alias))
		{$error_message = "Alias Can Only Contain Letters, Numbers, Periods, & Underscores.<br/><br/>";}
	else if ($alias_check > 0)
		{$error_message = "Alias Is Already Used. Please Try Another!<br/><br/>";}	
	else if ($password_ver != $password)
		{$error_message = "Incorrect Verification Password. Please Try Again!<br/><br/>";}
	else
		{$alias = preg_replace('#[^A-Za-z0-9_.]#i', '', $_POST['alias']);
		$alias = strip_tags($_POST['alias']);
		$alias=mysql_real_escape_string($alias);
		$mysqlSave = mysql_query("UPDATE members_planets SET alias='$alias',alias_activation='$alias_activation' WHERE id='$ids'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "planet_settings.php";exit();
	}	

// Section for Planet Email.
if(isset($_POST['planet_email1']))
	{$skipper="Skip";
	$planet_email1 = $_POST['planet_email1'];
	$planet_email2 = $_POST['planet_email2'];
	
	$mysql = mysql_query("SELECT planet_email1,planet_email2 FROM members_planets WHERE id=$ids");
	while($row = mysql_fetch_array($mysql))
		{$planet_email1_original = $row["planet_email1"];
		$planet_email2_original = $row["planet_email2"];}
		
	if (($planet_email1_original !== $planet_email1)AND($planet_email1 !="")AND(strpbrk('@', $planet_email1) AND strpbrk('.', $planet_email1)) == false)
		{$error_message= "Primary Creator Email Doesn't Seem To Be Real.<br/><br/>";}
	else if (($planet_email2_original !== $planet_email2)AND($planet_email2 !="")AND(strpbrk('@', $planet_email2) AND strpbrk('.', $planet_email2)) == false)
		{$error_message= "Secondary Creator Email Doesn't Seem To Be Real<br/><br/>";}
	else
		{$planet_email1 = strip_tags($_POST['planet_email1']);
		$planet_email1=mysql_real_escape_string($planet_email1);
		$planet_email2 = strip_tags($_POST['planet_email2']);
		$planet_email2=mysql_real_escape_string($planet_email2);
		$mysqlSave = mysql_query("UPDATE members_planets SET planet_email1='$planet_email1', planet_email2='$planet_email2' WHERE id='$ids'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "planet_settings.php";exit();
	}	
	
// Section for Planet Bio
if(isset($_POST['planet_bio']))
	{$skipper="Skip";
	$planet_bio = $_POST['planet_bio'];
	$planet_bio = strip_tags($planet_bio);
	$planet_bio=mysql_real_escape_string($planet_bio);
	$mysqlSave = mysql_query("UPDATE members_planets SET planet_bio='$planet_bio' WHERE id='$ids'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
	include_once "planet_settings.php";exit();
	}
	
// Section for Planet Motto.
if((isset($_POST['planet_motto1']))OR(isset($_POST['planet_motto2'])))
	{$skipper="Skip";
	$motto1 = $_POST['planet_motto1'];
	$motto1 = strip_tags($_POST['planet_motto1']);
	$motto1=mysql_real_escape_string($motto1);
	$motto2 = $_POST['planet_motto2'];
	$motto2 = strip_tags($_POST['planet_motto2']);
	$motto2=mysql_real_escape_string($motto2);
	$mysqlSave = mysql_query("UPDATE members_planets SET motto1='$motto1', motto2='$motto2' WHERE id='$ids'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
	include_once "planet_settings.php";exit();
	}	
	
// Section for Planet Contact Info.
if(isset($_POST['planet_contact_info1']))
	{$skipper="Skip";
	$planet_contact_info1 = $_POST['planet_contact_info1'];
	$planet_contact_info2 = $_POST['planet_contact_info2'];
	
	$mysql = mysql_query("SELECT contact_info1,contact_info2 FROM members_planets WHERE id=$ids");
	while($row = mysql_fetch_array($mysql))
		{$planet_contact_info1_original = $row["contact_info1"];
		$planet_contact_info2_original = $row["contact_info2"];}
		
	if (preg_match('/[^0-9-() ]/i', $planet_contact_info1))
		{$error_message = "Cell Phone Number Doesn't Seem To Be Real.<br/><br/>";}
	else if (preg_match('/[^0-9-() ]/i', $planet_contact_info2))
		{$error_message = "Telephone Number Doesn't Seem To Be Real.<br/><br/>";}
	else 
		{$planet_contact_info1 = strip_tags($_POST['planet_contact_info1']);
		$planet_contact_info1=mysql_real_escape_string($planet_contact_info1);
		$planet_contact_info2 = strip_tags($_POST['planet_contact_info2']);
		$planet_contact_info2=mysql_real_escape_string($planet_contact_info2);
		$mysqlSave = mysql_query("UPDATE members_planets SET contact_info1='$planet_contact_info1', contact_info2='$planet_contact_info2' WHERE id='$ids'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "planet_settings.php";exit();
	}	
	
// Section for Expanding Other Planet Settings
if(isset($_POST['planet_id']))
	{$skipper="Skip";
	$planet_id = $_POST['planet_id'];
	
	$mysql1 = mysql_query("SELECT * FROM planets WHERE id=$planet_id");
	while($row = mysql_fetch_array($mysql1))
		{$user_id = $row['user_id'];
		$creator_display = $row['creator_display'];
		$planet_name = $row['planet_name'];
		$planet_description = $row['planet_description'];
		$categories = $row['categories'];
		$like_array = $row['like_array'];
		$love_array = $row['love_array'];
		$like_array_create = $row['like_array'];
		$love_array_create = $row['love_array'];
		$likeArray_create = explode(",",$like_array_create);
		$loveArray_create = explode(",",$love_array_create);
		$like_array_count_create = count($likeArray_create);
		$love_array_count_create = count($loveArray_create);
		$admin_array = $row['admin_array'];
		$adminArray = explode(",",$admin_array);
		$admin_count = count($adminArray);
		$creator_array = $row['creator_array'];
		$creatorArray = explode(",",$creator_array);
		$creator_count = count($creatorArray);}
	
	include_once "planet_settings_2.php";exit();
	}	
	
// Section for Email Security.
if(isset($_POST['email_security']))
	{$skipper="Skip";
	$email = $_POST['email_security'];
	$alt_email = $_POST['alt_email'];
	$password_ver = $_POST['password_ver1'];
	
	$password_ver = "musemu838".$password_ver;
	$password_cookie = cryptPass(sha1(md5($password_ver)));
	$password_ver = cryptPass(md5(sha1($password_cookie)));	
	
	$mysql_email_check=mysql_query("SELECT email FROM members WHERE email='$email'");
	$email_check=mysql_num_rows($mysql_email_check);
	$mysql = mysql_query("SELECT * FROM members WHERE id=$ids");
	while($row = mysql_fetch_array($mysql))
		{$email_original = $row["email"];
		$alt_email_original = $row["alt_email"];
		$password = $row["password"];}
		
	if ((!$email)||(!$password_ver))
		{$error_message = "Please Fill In Primary Email Field & Verification Password Field!<br/><br/>";}
	else if ((strpbrk('@', $email) AND strpbrk('.', $email)) == false)
		{$error_message= "Primary Email Doesn't Seem To Be Real.<br/><br/>";}
	else if (($email != $email_original) AND ($email_check > 0))
			{$error_message="Primary Email Is Already Used By Someone Else. Please Try Another!<br/><br/>";}
	else if (($alt_email != $alt_email_original)AND ($alt_email!="") AND (strpbrk('@', $alt_email) AND strpbrk('.', $alt_email)) == false)
			{$error_message= "Secondary Email Doesn't Seem To Be Real.<br/><br/>";}
	else if ($password_ver !== $password)
		{$error_message = "Incorrect Verification Password. Please Try Again!<br/><br/>";}
	else
		{$email = strip_tags($_POST['email_security']);
		$email=mysql_real_escape_string($email);
		$alt_email = strip_tags($_POST['alt_email']);
		$alt_email=mysql_real_escape_string($alt_email);
		$mysqlSave = mysql_query("UPDATE members SET alt_email='$alt_email' WHERE id='$ids' AND password='$password_ver'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "security_settings.php";exit();
	}

// Section for Password Change
if(isset($_POST['password']))
	{$skipper="Skip";
	$password = $_POST['password'];
	$password_new = $_POST['password_new'];
	$password_con = $_POST['password_con'];
	
	$password = "musemu838".$password;
	$password_cookie = cryptPass(sha1(md5($password)));
	$password = cryptPass(md5(sha1($password_cookie)));	
	$mysql = mysql_query ("SELECT id FROM members WHERE id='$ids' AND (password='$password' OR temporary_password='$password')");
	$pass_check_num = mysql_num_rows($mysql);
	
	if ((!$password)||(!$password_new)||(!$password_con))
		{$error_message = "Please Fill In All Fields!<br/><br/>";}
	else if (strlen($password_new) < 6)
		{$error_message = "Password Must Be 6 - 20 Characters Long.<br/><br/>";} 
	else if (strlen($password_new) > 20)
		{$error_message = "Password Must Be 6 - 20 Characters Long.<br/><br/>";}
	else if ($password_new != $password_con)
		{$error_message = "Password Fields Do Not Match.<br/><br/>";}
	else if ($pass_check_num > 0)
		{$password_new = "musemu838".$password_new;
		$password_cookie = cryptPass(sha1(md5($password_new)));
		$password_new = cryptPass(md5(sha1($password_cookie)));
			
		$mysqlUpdate = mysql_query("UPDATE members SET password='$password_new', temporary_password='' WHERE id='$ids'");
		$_SESSION['user_password'] = $password_cookie;
		setcookie("passwordCookie", $password_cookie, time()+86400, "/");
		$success_message = "Successfully Saved!<br/><br/>";}
	else 
		{$error_message = "Incorrect Current Password, Please Try Again!<br/><br/>";}
	include_once "security_settings.php";exit();
	}

// PLANETS EXTRA PART //

// Section for Planet Scores
if(isset($_POST['creator_display']))
	{$skipper="Skip";
	$_GET['planet_id'] = $_POST['planet_idp'];
	$planet_id = $_POST['planet_idp'];
	$creator_display = $_POST['creator_display'];
	if ($creator_display == "")
		{$error_message = "Please Fill In The Display Creators Field!<br/><br/>";}
	else 
		{$creator_display = strip_tags($_POST['creator_display']);
		$creator_display=mysql_real_escape_string($creator_display);
		$mysqlSave = mysql_query("UPDATE planets SET creator_display='$creator_display' WHERE id='$planet_id'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "planet_settings.php";exit();
	}	

// Section for Planets Email.
if(isset($_POST['planets_email1']))
	{$skipper="Skip";
	$_GET['planet_id'] = $_POST['planet_idp'];
	$planet_id = $_POST['planet_idp'];
	$planets_email1 = $_POST['planets_email1'];
	$planets_email2 = $_POST['planets_email2'];
	
	$mysql = mysql_query("SELECT planets_email1,planets_email2 FROM planets WHERE id=$planet_id");
	while($row = mysql_fetch_array($mysql))
		{$planets_email1_original = $row["planets_email1"];
		$planets_email2_original = $row["planets_email2"];}
		
	if (($planets_email1_original !== $planets_email1)AND($planets_email1 !="")AND(strpbrk('@', $planets_email1) AND strpbrk('.', $planets_email1)) == false)
		{$error_message= "Primary Planet Email Doesn't Seem To Be Real.<br/><br/>";}
	else if (($planets_email2_original !== $planets_email2)AND($planets_email2 !="")AND(strpbrk('@', $planets_email2) AND strpbrk('.', $planets_email2)) == false)
		{$error_message= "Secondary Planet Email Doesn't Seem To Be Real<br/><br/>";}
	else
		{$planets_email1 = strip_tags($_POST['planets_email1']);
		$planets_email1=mysql_real_escape_string($planets_email1);
		$planets_email2 = strip_tags($_POST['planets_email2']);
		$planets_email2=mysql_real_escape_string($planets_email2);
		$mysqlSave = mysql_query("UPDATE planets SET planets_email1='$planets_email1', planets_email2='$planets_email2' WHERE id='$planet_id'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "planet_settings.php";exit();
	}	
	
// Section for Planet Name.
if(isset($_POST['planet_name']))
	{$skipper="Skip";
	$_GET['planet_id'] = $_POST['planet_idp'];
	$planet_id = $_POST['planet_idp'];
	$planet_name = $_POST['planet_name'];
	$password_ver = $_POST['password_ver1'];
	
	$password_ver = "musemu838".$password_ver;
	$password_cookie = cryptPass(sha1(md5($password_ver)));
	$password_ver = cryptPass(md5(sha1($password_cookie)));	
	$mysql = mysql_query ("SELECT id FROM members WHERE id='$ids' AND password='$password_ver'");
	$pass_check_num = mysql_num_rows($mysql);
		
	if (($planet_name=="")AND($password_ver==""))
		{$error_message = "Please Fill In All Fields!<br/><br/>";}
	else if ($pass_check_num < 1)
		{$error_message = "Incorrect Verification Password. Please Try Again!<br/><br/>";}
	else if ($pass_check_num > 0)
		{$planet_name = strip_tags($planet_name);
		$planet_name=mysql_real_escape_string($planet_name);
		$mysqlSave = mysql_query("UPDATE planets SET planet_name='$planet_name' WHERE id='$planet_id'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "planet_settings.php";exit();
	}	

// Section for Planet Description.
if(isset($_POST['planet_description']))
	{$skipper="Skip";
	$_GET['planet_id'] = $_POST['planet_idp'];
	$planet_id = $_POST['planet_idp'];
	$planet_description = $_POST['planet_description'];
	$planet_description = strip_tags($planet_description);
	$planet_description=mysql_real_escape_string($planet_description);
	$mysqlSave = mysql_query("UPDATE planets SET planet_description='$planet_description' WHERE id='$planet_id'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
	include_once "planet_settings.php";exit();
	}
	
// Section for Category.
if(isset($_POST['categories']))
	{$skipper="Skip";
	$_GET['planet_id'] = $_POST['planet_idp'];
	$planet_id = $_POST['planet_idp'];
	$categories = $_POST['categories'];
	$categories = strip_tags($categories);
	$categories=mysql_real_escape_string($categories);
	$mysqlSave = mysql_query("UPDATE planets SET categories='$categories' WHERE id='$planet_id'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
	include_once "planet_settings.php";exit();
	}

// Section for Planets Bio.
if(isset($_POST['planets_bio']))
	{$skipper="Skip";
	$_GET['planet_id'] = $_POST['planet_idp'];
	$planet_id = $_POST['planet_idp'];
	$planets_bio = $_POST['planets_bio'];
	$planets_bio = strip_tags($planets_bio);
	$planets_bio=mysql_real_escape_string($planets_bio);
	$mysqlSave = mysql_query("UPDATE planets SET planets_bio='$planets_bio' WHERE id='$planet_id'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
	include_once "planet_settings.php";exit();
	}
	
// Section for Planets Motto.
if((isset($_POST['planets_motto1']))OR(isset($_POST['planets_motto2'])))
	{$skipper="Skip";
	$_GET['planet_id'] = $_POST['planet_idp'];
	$planet_id = $_POST['planet_idp'];
	$planets_motto1 = $_POST['planets_motto1'];
	$planets_motto1 = strip_tags($_POST['planets_motto1']);
	$planets_motto1=mysql_real_escape_string($planets_motto1);
	$planets_motto2 = $_POST['planets_motto2'];
	$planets_motto2 = strip_tags($_POST['planets_motto2']);
	$planets_motto2=mysql_real_escape_string($planets_motto2);
	$mysqlSave = mysql_query("UPDATE planets SET planets_motto1='$planets_motto1', planets_motto2='$planets_motto2' WHERE id='$planet_id'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
	include_once "planet_settings.php";exit();
	}	
	
// Section for Planets Contact Info.
if(isset($_POST['planets_contact_info1']))
	{$skipper="Skip";
	$_GET['planet_id'] = $_POST['planet_idp'];
	$planet_id = $_POST['planet_idp'];
	$planets_contact_info1 = $_POST['planets_contact_info1'];
	$planets_contact_info2 = $_POST['planets_contact_info2'];
	
	$mysql = mysql_query("SELECT planets_contact_info1,planets_contact_info2 FROM planets WHERE id=$planet_id");
	while($row = mysql_fetch_array($mysql))
		{$planets_contact_info1_original = $row["planets_contact_info1"];
		$planets_contact_info2_original = $row["planets_contact_info2"];}
		
	if (preg_match('/[^0-9-() ]/i', $planets_contact_info1))
		{$error_message = "Cell Phone Number Doesn't Seem To Be Real.<br/><br/>";}
	else if (preg_match('/[^0-9-() ]/i', $planets_contact_info2))
		{$error_message = "Telephone Number Doesn't Seem To Be Real.<br/><br/>";}
	else 
		{$planets_contact_info1 = strip_tags($_POST['planets_contact_info1']);
		$planets_contact_info1=mysql_real_escape_string($planets_contact_info1);
		$planets_contact_info2 = strip_tags($_POST['planets_contact_info2']);
		$planets_contact_info2=mysql_real_escape_string($planets_contact_info2);
		$mysqlSave = mysql_query("UPDATE planets SET planets_contact_info1='$planets_contact_info1', planets_contact_info2='$planets_contact_info2' WHERE id='$planet_id'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "planet_settings.php";exit();
	}	
	
// Section for Planet Scores
if(isset($_POST['planet_scores']))
	{$skipper="Skip";
	$_GET['planet_id'] = $_POST['planet_idp'];
	$planet_id = $_POST['planet_idp'];
	$planet_scores = $_POST['planet_scores'];
	if ($planet_scores == "")
		{$error_message = "Please Fill In The Planet Scores Field!<br/><br/>";}
	else 
		{$planet_scores = strip_tags($_POST['planet_scores']);
		$planet_scores=mysql_real_escape_string($planet_scores);
		$mysqlSave = mysql_query("UPDATE planets SET scores='$planet_scores' WHERE id='$planet_id'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "planet_settings.php";exit();
	}	
	
// NOTIFICATION SETTINGS //

// Section for Profile Notifications
if(isset($_POST['profile_email_notification_select']))
	{$skipper="Skip";
	$_GET['id'] = $_POST['id'];
	$profile_email_notification_select = $_POST['profile_email_notification_select'];
	$profile_email_comment_notification_select = $_POST['profile_email_comment_notification_select'];
	if ($profile_email_notification_select == "")
		{$error_message = "Please Fill In The Item Notifications Field!<br/><br/>";}
	else if ($profile_email_comment_notification_select == "")
		{$error_message = "Please Fill In The Comment Notifications Field!<br/><br/>";}
	else 
		{$profile_email_notification_select = strip_tags($_POST['profile_email_notification_select']);
		$profile_email_notification_select=mysql_real_escape_string($profile_email_notification_select);
		$profile_email_comment_notification_select = strip_tags($_POST['profile_email_comment_notification_select']);
		$profile_email_comment_notification_select=mysql_real_escape_string($profile_email_comment_notification_select);
		$mysqlSave = mysql_query("UPDATE members SET email_notification_activation='$profile_email_notification_select', email_comment_notification_activation='$profile_email_comment_notification_select' WHERE id='$id'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "notification_settings.php";exit();
	}	
// Section for Planet Notifications
if(isset($_POST['planet_email_notification_select']))
	{$skipper="Skip";
	$_GET['id'] = $_POST['id'];
	$planet_email_notification_select = $_POST['planet_email_notification_select'];
	$planet_email_comment_notification_select = $_POST['planet_email_comment_notification_select'];
	if ($planet_email_notification_select == "")
		{$error_message = "Please Fill In The Item Notifications Field!<br/><br/>";}
	else if ($planet_email_comment_notification_select == "")
		{$error_message = "Please Fill In The Comment Notifications Field!<br/><br/>";}
	else 
		{$planet_email_notification_select = strip_tags($_POST['planet_email_notification_select']);
		$planet_email_notification_select=mysql_real_escape_string($planet_email_notification_select);
		$planet_email_comment_notification_select = strip_tags($_POST['planet_email_comment_notification_select']);
		$planet_email_comment_notification_select=mysql_real_escape_string($planet_email_comment_notification_select);
		$mysqlSave = mysql_query("UPDATE members_planets SET email_notification_activation='$planet_email_notification_select', email_comment_notification_activation='$planet_email_comment_notification_select' WHERE id='$id'");
		if ($mysqlSave)
			{$success_message = "Successfully Saved!<br/><br/>";}
		else 
			{$error_message = "Error: Please Contact Our Help Department. Thank You!<br/><br/>";}
		}
	include_once "notification_settings.php";exit();
	}	
	
// DELETE ACCOUNT SECTION //
	
if ($_POST['action'] == "delete_countdown")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$check_input = $_POST['check_input'];
	$check_input2 = $_POST['check_input2'];
	$password_delete_account_mixed = $_POST["password_delete_account"];
	
	$password_delete_account = "musemu838".$password_delete_account_mixed;
	$password_cookie = cryptPass(sha1(md5($password_delete_account)));
	$password_delete_account = cryptPass(md5(sha1($password_cookie)));	
	$mysql = mysql_query ("SELECT id FROM members WHERE id='$id' AND id='$ids' AND password='$password_delete_account'");
	$pass_check_num = mysql_num_rows($mysql);
	
	if ((($check_input!=="true")AND($check_input=="false"))AND(($check_input2!=="true")AND($check_input2=="false")))
		{echo "[Switch 1 And 2 Are Off]";}
	else if (($check_input!=="true")AND($check_input=="false"))
		{echo "[Switch 1 Is Off]";}
	else if (($check_input2!=="true")AND($check_input2=="false"))
		{echo "[Switch 2 Is Off]";}
	else if ($_POST["password_delete_account"]=="")
		{echo "[Missing Password]";}
	else if ($pass_check_num<1)
		{echo "[Incorrect Password]";}
	else if ($pass_check_num > 0)
		{echo "[Self-Destruction In ";include "delete_account_countdown.php";}
	}		

if ($_POST['action'] == "delete_account")
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$password_delete_account_mixed = $_POST["password_delete_account"];
	
	$password_delete_account = "musemu838".$password_delete_account_mixed;
	$password_cookie = cryptPass(sha1(md5($password_delete_account)));
	$password_delete_account = cryptPass(md5(sha1($password_cookie)));	
	$mysql = mysql_query ("SELECT id FROM members WHERE id='$id' AND id='$ids' AND password='$password_delete_account'");
	$pass_check_num = mysql_num_rows($mysql);
	
	if ($_POST["password_delete_account"]=="")
		{echo "[Missing Password]";}
	else if ($pass_check_num<1)
		{echo "[Incorrect Password]";}
	else if ($pass_check_num > 0)
		{mysql_query("UPDATE members SET delete_member='0' WHERE id='$ids'");
		mysql_query("UPDATE members_log SET delete_member='0' WHERE id='$ids'");
		mysql_query("UPDATE members_planets SET delete_member='0' WHERE id='$ids'");
		mysql_query("UPDATE economy SET delete_member='0' WHERE id='$ids'");
		if (file_exists("../user_files/user$ids/")){rename("../user_files/user$ids/","../user_files/delete_user$ids/");}
		mysql_query("DELETE FROM friend_requests WHERE (user_id='$ids' OR request_id='$ids') AND request_status='0'");
		
		mysql_query("UPDATE albums SET delete_item='0' WHERE user_id='$ids'");
		mysql_query("UPDATE albums_comments SET delete_comment='0' WHERE user_page_id='$ids' OR user_post_id='$ids'");
		mysql_query("UPDATE albums_posts SET delete_item='0' WHERE user_id='$ids'");
		mysql_query("UPDATE albums_posts_comments SET delete_comment='0' WHERE user_page_id='$ids' OR user_post_id='$ids'");
		mysql_query("UPDATE games SET delete_item='0' WHERE user_id='$ids'");
		mysql_query("UPDATE games_comments SET delete_comment='0' WHERE user_page_id='$ids' OR user_post_id='$ids'");
		mysql_query("UPDATE games_posts SET delete_item='0' WHERE user_id='$ids'");
		mysql_query("UPDATE games_posts_comments SET delete_comment='0' WHERE user_page_id='$ids' OR user_post_id='$ids'");
		mysql_query("UPDATE images SET delete_item='0' WHERE user_id='$ids'");
		mysql_query("UPDATE images_posts SET delete_item='0' WHERE user_id='$ids'");
		mysql_query("UPDATE images_posts_comments SET delete_comment='0' WHERE user_page_id='$ids' OR user_post_id='$ids'");
		mysql_query("UPDATE images_walls SET delete_item='0' WHERE user_id='$ids'");
		mysql_query("UPDATE images_walls_comments SET delete_comment='0' WHERE user_page_id='$ids' OR user_post_id='$ids'");
		mysql_query("UPDATE videos SET delete_item='0' WHERE user_id='$ids'");
		mysql_query("UPDATE videos_comments SET delete_comment='0' WHERE user_page_id='$ids' OR user_post_id='$ids'");
		mysql_query("UPDATE videos_posts SET delete_item='0' WHERE user_id='$ids'");
		mysql_query("UPDATE videos_posts_comments SET delete_comment='0' WHERE user_page_id='$ids' OR user_post_id='$ids'");
		
		mysql_query("UPDATE posts SET delete_item='0' WHERE user_page_id='$ids' OR user_post_id='$ids'");
		mysql_query("UPDATE posts_comments SET delete_comment='0' WHERE user_page_id='$ids' OR user_post_id='$ids'");
		mysql_query("UPDATE notes SET delete_item='0' WHERE user_id='$ids'");
		mysql_query("UPDATE notes_comments SET delete_comment='0' WHERE user_page_id='$ids' OR user_post_id='$ids'");}
	}	
	
ob_flush();
?>