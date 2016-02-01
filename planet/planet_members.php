<?php
ob_start();
// Establish profile interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
$cacheBuster = $_SESSION['cacheBuster'];

include_once "../scripts/check_login.php";

$RequestsHead="";
$RequestsList="";
$RequestsFoot="";
$add_member="";
$mysql1 = mysql_query("SELECT * FROM planets WHERE id=$id");
while($row = mysql_fetch_array($mysql1))
	{$member_array = $row['member_array'];
	$memberArray = explode(",",$member_array);
	$member_count = count($memberArray);
	$admin_array = $row['admin_array'];
	$adminArray = explode(",",$admin_array);
	$admin_count = count($adminArray);
	$creator_array = $row['creator_array'];
	$creatorArray = explode(",",$creator_array);
	$creator_count = count($creatorArray);
	$total_count = $member_count + $admin_count;
	$MAArray = array_merge($adminArray,$memberArray);}
	
$MA_side="Members";
if ($admin_array!="")
	{$MA_side="Admins & Members";}

ob_flush();
?>

<script type="text/javascript">
var thisRandNum = "<?php echo $thisRandNum; ?>";
var memberRequestURL = "../scripts/request_as_member.php";
function acceptmemberRequest (x) 
	{$.post(memberRequestURL,{request:"acceptmember",requestID:x,thisWipit:thisRandNum},function(data)
		{$("#request"+x).html(data).show();});
	}
function rejectmemberRequest (x) 
	{$.post(memberRequestURL,{request:"rejectmember",requestID:x,thisWipit:thisRandNum} ,function(data) 
		{$("#request"+x).html(data).show();});
	} 
</script>

<body>
<font>
<div class="members_body">
<div id="creators_list">
<?php // creators
if (in_array($ids,$creatorArray))
	{include "planet_creators_list.php";}
?>
</div>
<div id="admins_list">
<?php // admins
include "planet_admins_list.php";
?>
</div>
<div id="members_list">
<?php // members
include "planet_members_list.php";
?>
</div>
</div>

</font>
</body>