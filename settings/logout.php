<?php
session_start();
$_SESSION = array();

// Deleting cookies when killing the session.
if (isset($_COOKIE['idsCookie'])) 
	{setcookie("idsCookie", '', time()-86400, '/');
	setcookie("emailCookie", '', time()-86400, '/');
	setcookie("passwordCookie", '', time()-86400, '/');
	setcookie("colorCookie", '', time()-86400, "/");}
	
session_destroy();

if((!isset($_SESSION['id']))AND(!isset($_SESSION['ids'])))
	{header("location:index.php");} // Send them to a page after logout.
else 
	{print "<h1>Could Not Log Out, Sorry We Have A System Error.</h1>";exit();} 
?> 