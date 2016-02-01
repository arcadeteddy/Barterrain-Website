<?php
session_start();
include "../config.php";
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;

if((!isset($_SESSION['id']))AND(!isset($_SESSION['ids'])))
	{header("Location: http://www.barterrain.com/settings/logout.php");exit();}

$cacheBuster = rand(9999999,99999999999);
$id = $_SESSION['ids'];
$ids = $_SESSION['ids'];

///////////////// DAILY POINTS /////////////////
if((isset($_POST['daily_points1']))OR(isset($_POST['daily_points2'])))
	{$id = $_POST['id'];
	$ids = $_POST['ids'];
	$file_location = $_POST['file_location'];
	
	$transaction=mysql_query("SELECT daily_points1_date, daily_points2_date FROM members_log WHERE id='$ids' AND ((daily_points1_date>DATE_SUB(UTC_TIMESTAMP(),INTERVAL 24 HOUR))
								AND (daily_points2_date>DATE_SUB(UTC_TIMESTAMP(),INTERVAL 24 HOUR))) LIMIT 1") or die (mysql_error());
	$numRows=mysql_num_rows($transaction);
	if($numRows>0)
		{echo "<a href='#' onclick='return false'><table class='daily_points_0' height='123px' width='123px'><tr><td><span class='daily_points'>&#5528; 0</span></td></tr></table></a>";exit();}
	
	mysql_query("UPDATE economy SET points = points + 25 WHERE id='$ids'");
	if (isset($_POST['daily_points1'])) {mysql_query("UPDATE members_log SET daily_points1_date = UTC_TIMESTAMP() WHERE id='$ids'");}
	if (isset($_POST['daily_points2'])) {mysql_query("UPDATE members_log SET daily_points2_date = UTC_TIMESTAMP() WHERE id='$ids'");}
	mysql_query("UPDATE point_totals_economy SET daily_points_plus = daily_points_plus + 25 WHERE id = '$ids'");
	
	$transaction=mysql_query("SELECT transaction_date FROM point_transactions_economy WHERE plus_id='$ids' AND minus_id='0' AND transaction_type='daily_points'
								AND transaction_date>DATE_SUB(UTC_TIMESTAMP(),INTERVAL 24 HOUR) ORDER BY transaction_date DESC LIMIT 1") or die (mysql_error());
	$numRows=mysql_num_rows($transaction);
	if($numRows>0)
		{while ($row = mysql_fetch_array ($transaction))
			{$transaction_date = $row['transaction_date'];}
		mysql_query("UPDATE point_transactions_economy SET transaction_amount = transaction_amount + 25 WHERE plus_id='$ids' AND transaction_type='daily_points' AND transaction_date='$transaction_date'");}
	else {mysql_query("INSERT INTO point_transactions_economy (plus_id,create_type,create_id,transaction_amount,transaction_type,transaction_date) VALUES ('$ids','$file_location','$id',25,'daily_points',UTC_TIMESTAMP())");}
	
	echo "<a href='#' onclick='return false'><table class='daily_points_0' height='123px' width='123px'><tr><td><span class='daily_points'>&#5528; 0</span></td></tr></table></a>";
	exit();}
?>