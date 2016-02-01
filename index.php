<?php
if(preg_match('/(?i)msie [1-9]/',$_SERVER['HTTP_USER_AGENT']))
	{header("location: outside_browser.php");exit();}
include_once ("scripts/check_user_login.php");
?>