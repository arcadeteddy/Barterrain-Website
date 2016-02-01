<?php
include_once "../config.php";
$id = $_SESSION['ids'];

if (!isset($skipper))
	{$error_message = "";
	$success_message = "";}
	
if (($error_message!=="")||($success_message!==""))
	{$form2="2";}
else {$form2="";}
?>

<head>
<script type="text/javascript">
</script>
</head>

<body>
<div class="top_header">
	<span class="settings_heading">Economy Settings</span><img src="barterrain_settings_images/blank.gif" class="settings"/>
</div>
<div class="form_message<?php print"$form2";?>">
<font color="#dd4a4a"><?php print"$error_message";?></font>
<font color="#4773C4"><?php print"$success_message";?></font>
</div>

<div class="bottom_footer"><br/>
	<a class="button-line">There are various ways you can use your economy to get points.<br/>Points will be useful in the future for various reasons.<br/>
	<a href="delete_account.php" class="delete">Click here</a> to delete your account by using the self-destruct button.</a>
<br/><br/></div>
</body>