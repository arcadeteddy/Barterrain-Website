<?php 
ob_start();
if (isset($_GET['id']))
	{header("location: ../profile/profile.php?id=".$_GET['id']);exit();}
else if (isset($_GET['message_id']))
	{header("location: ../profile/profile.php?id=".$_GET['message_id']);exit();}
else	
	{header("location: ../index.php");exit();}
ob_flush();
?>