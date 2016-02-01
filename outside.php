<?php
header("Content-Type: text/html; charset=utf-8");

include "config.php";
$error_message = "<br/>";
$br = "<br/>";
$email = "";
$password = "";
$invite_code = "";
$invite_code_url = "";

// Crypting Password
function cryptPass($input_password, $rounds = 8)
	{$salt = "";
	$saltChars = array_merge(range(0,9),range('A','Z'), range('a','z'));
	for ($i=0; $i<22; $i++) 
		{$salt .= $saltChars[array_rand($saltChars)];}
	return crypt($input_password, sprintf('$2y$%02d$', $rounds) . $salt);
	}

// Set Session Color
if (isset($_GET['color']))
	{$_SESSION['color']=$_GET['color'];
	$user_color=$_SESSION['color'];}
if (isset($_GET['invite_code']))
	{$invite_code=$_GET['invite_code'];
	$invite_code_url="&invite_code=".$invite_code;}
if (isset($_GET['activate_code']))
	{$activate_code=$_GET['activate_code'];
	$mysql_activate_check=mysql_query("SELECT activate_code FROM members WHERE email_activated='0' AND activate_code='$activate_code' LIMIT 1");
	$activate_check=mysql_num_rows($mysql_activate_check);
	mysql_query("UPDATE members SET email_activated='1', activate_date=UTC_TIMESTAMP() WHERE activate_code='$activate_code' LIMIT 1");
	
	if ($activate_check>0)
		{$mysql_invite_check=mysql_query("SELECT id, invite_code FROM members WHERE activate_code='$activate_code' LIMIT 1");
		while ($row=mysql_fetch_array($mysql_invite_check))
				{$id = $row['id'];
				$invite_code = $row['invite_code'];}
		$mysql_invite_check=mysql_query("SELECT * FROM friend_invites WHERE invite_code='$invite_code' LIMIT 1");
		$invite_check=mysql_num_rows($mysql_invite_check);
		if ($invite_check>0)
			{while($row = mysql_fetch_array($mysql_invite_check)) 
				{$invite_id = $row["user_id"];
				$invite_code = $row["invite_code"];
				$invite_email = $row["invite_email"];}
			
			mysql_query("UPDATE friend_invites SET invite_email_signup_id = '$id', invite_email_signup_date = UTC_TIMESTAMP() WHERE invite_email='$invite_email' AND invite_code='$invite_code'");
			mysql_query("UPDATE economy SET points = points + 100 WHERE id='$invite_id'");
			mysql_query("UPDATE point_totals_economy SET invite_plus = invite_plus + 100 WHERE id = '$invite_id'");
			mysql_query("INSERT INTO point_transactions_economy (plus_id,minus_id,create_type,create_id,transaction_amount,transaction_type,transaction_date) VALUES ('$invite_id','$id','outside','$id',100,'invite',UTC_TIMESTAMP())");
			
			$mysql_friend_array_1 = mysql_query("SELECT friend_array, invited_array FROM members WHERE id='$invite_id' LIMIT 1");
			$mysql_friend_array_2 = mysql_query("SELECT friend_array FROM members WHERE id='$id' LIMIT 1");
			while ($row=mysql_fetch_array($mysql_friend_array_1))
				{$friend_array_1 = $row['friend_array'];
				$invited_array = $row['invited_array'];}
			while ($row=mysql_fetch_array($mysql_friend_array_2))
				{$friend_array_2 = $row['friend_array'];}	
			if ($friend_array_1 != "")
				{$friend_array_1 = "$friend_array_1,$id";}
			else {$friend_array_1 = "$id";}
			if ($invited_array != "")
				{$invited_array = "$invited_array,$id";}
			else {$invited_array = "$id";}
			if ($friend_array_2 != "")
				{$friend_array_2 = "$friend_array_2,$invite_id";}
			else {$friend_array_2 = "$invite_id";}
			
			$UpdateArray1 = mysql_query("UPDATE members SET friend_array = '$friend_array_1', invited_array = '$invited_array' WHERE id='$invite_id'") or die (mysql_error());
			$UpdateArray2 = mysql_query("UPDATE members SET friend_array = '$friend_array_2' WHERE id='$id'") or die (mysql_error());
			}
		}
	}

if (isset($_POST['email'])) 
	{$email = $_POST['email'];
	$password = $_POST['password'];
	$email = stripslashes($email);
	$password = stripslashes($password);
	$email = strip_tags($email);
	$password = strip_tags($password);
	if (isset($_POST['remember'])) 
		{$remember = $_POST['remember'];}
	
// Error Handling Conditional Checks Go Here
	if ((!$email) || (!$password)) 
		{$error_message = 'Please Fill In All Fields!';}
	else if(preg_match('/(?i)msie [1-12]/',$_SERVER['HTTP_USER_AGENT']))
		{$error_message = 'Sorry, Internet Explorer Is Not Supported.';}
		
// Error Handling Is Complete So Process The Info If No Errors
	else 
		{$email = mysql_real_escape_string($email); // Secure String Before Adding To Query
	    $password = mysql_real_escape_string($password); // Secure String Before Adding To Query
		$password = "musemu838".$password;
		$password_cookie = cryptPass(sha1(md5($password)));
		$password_mysql = cryptPass(md5(sha1($password_cookie)));

        $mysql1 = mysql_query("SELECT id,email,temporary_password AS password FROM members WHERE email='$email' AND temporary_password='$password_mysql' AND email_activated='1'"); 
		$login_check1 = mysql_num_rows($mysql1);
		if ($login_check1<1)
			{$mysql1 = mysql_query("SELECT id,email,password FROM members WHERE email='$email' AND password='$password_mysql' AND email_activated='1'"); 
			$login_check1 = mysql_num_rows($mysql1);}
        $mysql2 = mysql_query("SELECT id,email,password FROM members WHERE email='$email' AND password='$password_mysql' AND email_activated='0'"); 
		$login_check2 = mysql_num_rows($mysql2);
		
// Checking If Email Is Activated
		if ($login_check2>0)
			{$error_message = "Please Check Email For Activation Link!";}
		else if ($login_check1>0)
			{while($row = mysql_fetch_array($mysql1))
				{$ids = $row["id"];   
				$_SESSION['ids'] = $ids;
				$user_email = $row["email"];
				$_SESSION['user_email'] = $user_email;
				$user_password = $row["password"];
				$_SESSION['user_password'] = $password_cookie;
				mysql_query("UPDATE members SET last_login_date=UTC_TIMESTAMP() WHERE id='$ids' LIMIT 1");}
	
// Remember Me Section // Cookie Will Expire In One Day
    		if(isset($_POST['remember']))
				{setcookie("idsCookie", $ids, time()+86400, "/");
    			setcookie("emailCookie", $email, time()+86400, "/");
			    setcookie("passwordCookie", $password_cookie, time()+86400, "/");
				setcookie("colorCookie", $color_changer, time()+86400, "/");}

// All Good! Send Them To Home Page!
    		header("location: index.php");
    		exit();} 
			
// Run This Code If Login Data Is Incorrect
		else
			{$error_message = "Incorrect Login Data, Please Try Again!";}
		} 
	}
?>

<?php include_once "outside_banner.php"; ?>

<!DOCTYPE html>
<html lang="en" id="barterrain">

<head>
<link rel="stylesheet" href="barterrain_banner.php" media="screen">
<link rel="stylesheet" href="barterrain_outside.php" media="screen"/>
<script src="http://www.barterrain.com/scripts/jquery-1.7.2.js" type="text/javascript"></script>
<script src="http://www.barterrain.com/scripts/jquery-scrollTo.js" type="text/javascript"></script> 
<script src="http://www.barterrain.com/scripts/date_changer.js" type="text/javascript" async></script> 
<script type="text/javascript">
var invite_code = "<?php echo $invite_code; ?>";
var interactive_outside = "scripts/interactive_outside.php";
</script>
<script src="http://www.barterrain.com/outside_javascript.js" type="text/javascript" async></script> 
<script type="text/javascript" async>
<?php if (isset($_GET['invite_code']))
	{echo '$(document).ready(function(){$.scrollTo("#outside_pages_2", 1000);});';}
else if ((isset($_GET['forgot_password']))AND($_GET['forgot_password']=="true"))
	{echo '$(document).ready(function(){$.scrollTo("#outside_pages_3", 1000);});';} ?>
</script>
</head>

<body>
<font>
<div class="side_colors_left"></div>

<div class="barterrain_outside_background">
	<div class="barterrain_outside content">
    	<div id="outside_pages_1">
        <div class="outside_pages_1">
		<table class="login_table">
		<form action="index.php" method="post">
			<tr class="space2"><td><font class="error_font"><?php print"$error_message";?></font></td></tr>
			<tr class="space"><td><input type="email" id="email" name="email" class="email" placeholder="Email" value="<?php echo "$email";?>"/></td></tr>
			<tr class="space"><td><input type="password" name="password" class="password" placeholder="Password"/></td></tr>
            <tr class="space"><td><div class="color_changer">
            	<?php 
				if ((isset($_SESSION['color']))AND($_SESSION['color']=="blue"))
					{echo '<a href="index.php?color=blue'.$invite_code_url.'" class="color_changer_blue2" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				else if ((isset($_SESSION['color']))AND(($_SESSION['color']=="green")OR($_SESSION['color']=="yellow")OR($_SESSION['color']=="orange")OR($_SESSION['color']=="red")OR($_SESSION['color']=="purple")OR($_SESSION['color']=="brown")OR($_SESSION['color']=="black")))
					{echo '<a href="index.php?color=blue'.$invite_code_url.'" class="color_changer_blue" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				else if (isset($_SESSION['color']))
					{echo '<a href="index.php?color=blue'.$invite_code_url.'" class="color_changer_blue2" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				else {echo '<a href="index.php?color=blue'.$invite_code_url.'" class="color_changer_blue2" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				
            	if ((isset($_SESSION['color']))AND($_SESSION['color']=="green"))
					{echo '<a href="index.php?color=green'.$invite_code_url.'" class="color_changer_green2" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				else {echo '<a href="index.php?color=green'.$invite_code_url.'" class="color_changer_green" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				
				if ((isset($_SESSION['color']))AND($_SESSION['color']=="yellow"))
					{echo '<a href="index.php?color=yellow'.$invite_code_url.'" class="color_changer_yellow2" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				else {echo '<a href="index.php?color=yellow'.$invite_code_url.'" class="color_changer_yellow" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				
				if ((isset($_SESSION['color']))AND($_SESSION['color']=="orange"))
					{echo '<a href="index.php?color=orange'.$invite_code_url.'" class="color_changer_orange2" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				else {echo '<a href="index.php?color=orange'.$invite_code_url.'" class="color_changer_orange" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				
				if ((isset($_SESSION['color']))AND($_SESSION['color']=="red"))
					{echo '<a href="index.php?color=red'.$invite_code_url.'" class="color_changer_red2" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				else {echo '<a href="index.php?color=red'.$invite_code_url.'" class="color_changer_red" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				
				if ((isset($_SESSION['color']))AND($_SESSION['color']=="purple"))
					{echo '<a href="index.php?color=purple'.$invite_code_url.'" class="color_changer_purple2" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				else {echo '<a href="index.php?color=purple'.$invite_code_url.'" class="color_changer_purple" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				
				if ((isset($_SESSION['color']))AND($_SESSION['color']=="brown"))
					{echo '<a href="index.php?color=brown'.$invite_code_url.'" class="color_changer_brown2" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				else {echo '<a href="index.php?color=brown'.$invite_code_url.'" class="color_changer_brown" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				
				if ((isset($_SESSION['color']))AND($_SESSION['color']=="black"))
					{echo '<a href="index.php?color=black'.$invite_code_url.'" class="color_changer_black2" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				else {echo '<a href="index.php?color=black'.$invite_code_url.'" class="color_changer_black" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>';}
				?>
            </div></td></tr>
			<tr class="space"><td id="outside_pages"><font class="body_font">
            	<input checked="checked" type="checkbox" name="remember" class="remember" id="remember" value="yes" /><label for="keep_login" class="remember">Remember Me!</label>
            	<span class="dot_divider"> &middot; </span><a class="body" data-href="#outside_pages_3" onMouseDown="if (event.preventDefault) event.preventDefault()">Forgot Your Password?</a>
            </font></td></tr>
			<tr class="space"><td><input src='barterrain_outside_images/blank.gif' type="image" name="submit" class="login_button"/></td></tr>
		</form>
			<tr class="space3"><td id="outside_pages"><font class="body_font">
            	Get An Account To <a class="body" data-href="#outside_pages_2" onMouseDown="if (event.preventDefault) event.preventDefault()">Join The Party!</a><br/>
                If You Need Help, <a class="body" data-href="#outside_pages_4" onMouseDown="if (event.preventDefault) event.preventDefault()">Contact Us.</a><br/><br/>
            </font></td></tr>
		</table>
        </div>
        </div>
        <div id="outside_pages_2">
        <div class="outside_pages_2">
        <table class="signup_table">
			<form  action="javascript:signup_form()" method="post" type="multipart/form-data" id="signup_form" name="signup_form">
				<tr class="space2"><td><font class="error_font" id="signup_status"><?php print"$br";?></font></td></tr>
				<tr class="space"><td><input id="firstname" name="firstname" class="signup_input" placeholder="Firstname"/></td></tr>
                <tr class="space"><td><input id="lastname" name="lastname" class="signup_input" placeholder="Lastname"/></td></tr>
                <tr class="space"><td><input id="alias" name="alias" class="signup_input" placeholder="Alias"/></td></tr>
                <tr class="space"><td><input type="email" id="signup_email" name="signup_email" class="signup_input" placeholder="Email"/></td></tr>
                <tr class="space"><td><input type="email" id="re_email" name="re_email" class="signup_input" placeholder="Re-Enter Email"/></td></tr>
                <tr class="space"><td><input type="password" id="signup_password" name="signup_password" class="signup_input" placeholder="Password"/></td></tr>
                <tr class="space"><td><input type="password" id="re_password" name="re_password" class="signup_input" placeholder="Re-Enter Password"/></td></tr>
                <tr class="space5"><td>
                	<select name="birthday_month" id="birthday_month" class="settings_birthday1" onChange="javascript:populate_month_day('birthday_month','birthday_day');">
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
					<select name="birthday_day" id="birthday_day" class="settings_birthday2" onChange="javascript:populate_day_year('birthday_month','birthday_day','birthday_year');">
						<option value="">Day:</option>
					</select>
					<select name="birthday_year" id="birthday_year" class="settings_birthday2">
						<option value="">Year:</option>
					</select>
    			</td></tr>
                <tr class="space5"><td>
                	<select name="gender" class="gender" id="gender">
                    	<option value="">Gender:</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </td></tr>
				<tr class="space"><td><input src='barterrain_outside_images/blank.gif' type="image" name="signup" class="signup_button"/></td></tr>
                <tr class="space3"><td id="outside_pages"><font class="body_font">
            		Do you already have an account?<br/>
                    If yes, then login in now! <a class="body" data-href="#outside_pages_1" onMouseDown="if (event.preventDefault) event.preventDefault()">&#8626;</a><br/><br/>
            	</font></td></tr>
           	</form>
        </table>
        </div>
        </div>
        <div id="outside_pages_3">
        <div class="outside_pages_3">
       	<table class="reset_table">
			<form  action="javascript:reset_form()" method="post" type="multipart/form-data" id="reset_form" name="reset_form">
				<tr class="space2"><td><font class="error_font" id="reset_status"><?php print"$br";?></font></td></tr>
				<tr class="space"><td><input type="email" id="reset_field" name="reset_field" class="forgot_email" placeholder="Email" value="<?php echo "$email";?>"/></td></tr>
				<tr class="space"><td><input src='barterrain_outside_images/blank.gif' type="image" name="reset" class="reset_button"/></td></tr>
           	</form>
            <tr class="space4"><td id="outside_pages"><font class="body_font"> 
            	We will send you a temporary password. <br/>If you don't get an email within a few minutes,<br/>please be sure to check your spam filter.
                <a class="body" data-href="#outside_pages_1" onMouseDown="if (event.preventDefault) event.preventDefault()">&#8626;</a><br/><br/>
			</font></td></tr>
        </table>
        </div>
        </div>
        <div id="outside_pages_4">
        <div class="outside_pages_4">
        <table class="contact_us_table" cellspacing="0">
			<tr class="contact_us_td"><td class="contact_us_top_left"></td><td class="contact_us_top_bottom"></td><td class="contact_us_top_right"></td></tr>
            <tr class="contact_us_td"><td class="contact_us_left_right"></td><td class="contact_us_td" id="outside_pages">
            	<font class="body_font">
            	Don't hesitate to contact us! Whether it's love or hate, we would still love to hear from you about anything.
                That is why we have dedicated our lives and sacrificed some to sit infront of a computer the whole day replying to questions. 
                <a class="body" data-href="#outside_pages_1" onMouseDown="if (event.preventDefault) event.preventDefault()">&#8626;</a><br/><br/>
                <b>Semi-Realistic Departments:</b><br/>
                	<span class="contact_us">&nbsp;&bull; Info ............................................... <a href="mailto:info@barterrain.com">info@barterrain.com</a></span>
                	<span class="contact_us">&nbsp;&bull; Help ............................................. <a href="mailto:help@barterrain.com">help@barterrain.com</a></span>
                    <span class="contact_us">&nbsp;&bull; Love ............................................. <a href="mailto:love@barterrain.com">love@barterrain.com</a></span>
              	  	<span class="contact_us">&nbsp;&bull; Hate ............................................. <a href="mailto:hate@barterrain.com">hate@barterrain.com</a></span>
               	<br/><b>Hypothetical Creators:</b><br/>
                	<span class="contact_us">&nbsp;&bull; Arcade Teddy ................... <a href="mailto:arcade.teddy@barterrain.com">arcade.teddy@barterrain.com</a></span>
              	  	<span class="contact_us">&nbsp;&bull; Einstein Monkey .......... <a href="mailto:einstein.monkey@barterrain.com">einstein.monkey@barterrain.com</a></span>
               	</font>
            </td><td class="contact_us_left_right"></td></tr>
            <tr class="contact_us_td"><td class="contact_us_bottom_left"></td><td class="contact_us_top_bottom"></td><td class="contact_us_bottom_right"></td></tr>
        </table>
        </div>
        </div>
	</div>
</div>

<div class="side_colors_right"></div>
</font>
</body>

</html>