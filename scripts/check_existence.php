<?php
ob_start();

if (!isset($_GET['id']))
	{header("Location: ../index.php");exit();}
	
$mysql_planet = mysql_query("SELECT id FROM planets WHERE id='$id' AND delete_item='1'"); 
$mysql_existence = mysql_num_rows($mysql_planet);
if ($mysql_existence==0)
	{header("Location: ../index.php");exit();}

ob_flush();
?>