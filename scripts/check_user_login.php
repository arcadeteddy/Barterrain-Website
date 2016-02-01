<?php
ob_start();
session_start(); 
include "config.php";

if(!isset($_SESSION['user_password']))
	{include_once "outside.php";
	exit();}

// If Session Variable & Cookie Variable Is Not Set
if ((!isset($_SESSION['ids']))AND(!isset($_COOKIE['idsCookie'])))
	{include_once "outside.php";
	exit();}
					
// If Session Variable Is Set Without Remember Me Feature
if (isset($_SESSION['ids'])) 
	{$ids = $_SESSION['ids'];
	header("location: inside/index.php");exit();
	exit();} 
	
// If Cookie Variable Is Set Without A Session Variable
else if (isset($_COOKIE['idsCookie'])) 
	{$ids=$_COOKIE['idsCookie'];
	$user_email=$_COOKIE['emailCookie'];
	$user_password=$_COOKIE['passwordCookie'];
	$user_color=$_COOKIE['colorCookie'];
	
	// Kill Their Cookies If They Are No Longer Members
	$mysql = mysql_query("SELECT * FROM members WHERE id='$ids' AND password='$user_password' LIMIT 1");
	$numRows = mysql_num_rows($mysql);

	if ($numRows < 1) 
		{setcookie("idsCookie", '', time()-86400, '/');
		setcookie("emailCookie", '', time()-86400, '/');
		setcookie("passwordCookie", '', time()-86400, '/');
    	include_once "outside.php";
		exit();} 
	
	$_SESSION['ids'] = $ids;
	$_SESSION['email'] = $user_email;
	$_SESSION['password'] = $user_password;
	$_SESSION['color'] = $user_color;
	
	$ids = $_SESSION['ids'];
	
	$mysql = mysql_query("UPDATE members SET last_login_date=UTC_TIMESTAMP() WHERE id='$ids'");
	header("location: inside/index.php");exit();
	exit();}
	
ob_flush();
?>