<?php
ob_start();
if(!isset($_SESSION['id']))
	{$_SESSION['id']=$_SESSION['ids'];
	$id = $_SESSION['id'];
	$ids = $_SESSION['ids'];}

if(!isset($_SESSION['user_password']))
	{header("Location: http://www.barterrain.com/settings/logout.php");exit();}
$password_cookie = $_SESSION['user_password'];

if(isset($_COOKIE['idsCookie']))
	{$ids=$_COOKIE['idsCookie'];
	$_SESSION['ids']=$ids;}

if((!isset($_COOKIE['idsCookie']))AND(!isset($_SESSION['ids'])))
	{header("Location: http://www.barterrain.com/settings/logout.php");exit();}
	
$mysql_profile = mysql_query("SELECT password, temporary_password FROM members WHERE id='$ids'"); 
while($row = mysql_fetch_array($mysql_profile))
	{$password = $row["password"];
	$temporary_password = $row["temporary_password"];}

// Crypting Password
function cryptPass_check($input_password, $rounds = 8)
	{$salt = "";
	$saltChars = array_merge(range(0,9),range('A','Z'), range('a','z'));
	for ($i=0; $i<22; $i++) 
		{$salt .= $saltChars[array_rand($saltChars)];}
	return crypt($input_password, sprintf('$2y$%02d$', $rounds) . $salt);
	}
	
$password_mysql = cryptPass_check(md5(sha1($password_cookie)));
if(($password!==$password_mysql)AND($temporary_password!==$password_mysql))
	{header("Location: http://www.barterrain.com/settings/logout.php");exit();}

ob_flush();
?>