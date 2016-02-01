<?php
ob_start();
$mysql = mysql_query("SELECT DATE_FORMAT(birthday_ymd, '%M') AS `month`, DATE_FORMAT(birthday_ymd, '%D') AS `day` FROM members WHERE id=$id");
while($row = mysql_fetch_array($mysql))
	{$month = $row['month'];
	$day = $row['day'];
	$birthday = $month." ".$day;}
	
include_once "../scripts/check_login.php";
$cacheBuster = $_SESSION['cacheBuster'];

$mysql = mysql_query("SELECT * FROM members WHERE id=$id");
while($row = mysql_fetch_array($mysql))
	{$firstname = $row['firstname'];
	$middlename = $row['middlename'];
	$lastname = $row['lastname'];
	$email = $row['email'];
	$alt_email = $row['alt_email'];
	$gender = $row['gender'];
	$relationship = $row['relationship'];
	$cell_number = $row['cell_number'];
	$tel_number = $row['tel_number'];
	$personal_bio = $row['personal_bio'];
	$motto1 = $row['motto1'];
	$motto2 = $row['motto2'];
	$location = $row['location'];
	$primary_school = $row['primary_school'];
	$secondary_school = $row["secondary_school"];
	$post_secondary = $row['post_secondary'];
	$employer = $row['employer'];
	$friend_array = $row['friend_array'];
	$friendArray = explode(",",$friend_array);
	$friend_count = count($friendArray);
	$family_array = $row['family_array'];
	$familyArray = explode(",",$family_array);
	$family_count = count($familyArray);
	$total_count = $friend_count + $family_count;
	$likes = $row['likes'];
	$loves = $row['loves'];
	$scores = $row['scores'];
	}
	
if (isset($_SESSION['ids']) && $_SESSION['ids'] != $id)
	{$message1="";}
else if (isset($_SESSION['ids']) && $_SESSION['ids'] == $id)
	{$message1="<a class='body' href='../settings/settings.php'>Settings</a>";}
	
ob_flush();
?>

<script src="profile.js" type="text/javascript" async></script>
<script type="text/javascript">
// Like/Love Pages
function Like_circle(a,b,c,d)
	{$.post(like_loveURL,{like_love:"Like_circle",id:a,ids:b,item_id:c,item_type:d,thisWipit:thisRandNum},function(data) 
		{$("#information_circle_"+d+c).html(data).show()});	
	}
function Love_circle(a,b,c,d)
	{$.post(like_loveURL,{like_love:"Love_circle",id:a,ids:b,item_id:c,item_type:d,thisWipit:thisRandNum},function(data) 
		{$("#information_circle_"+d+c).html(data).show()});	
	}
function unlikeLike_circle(a,b,c,d)
	{$.post(like_loveURL,{like_love:"unlikeLike_circle",id:a,ids:b,item_id:c,item_type:d,thisWipit:thisRandNum},function(data) 
		{$("#information_circle_"+d+c).html(data).show()});
	}
function unloveLove_circle(a,b,c,d)
	{$.post(like_loveURL,{like_love:"unloveLove_circle",id:a,ids:b,item_id:c,item_type:d,thisWipit:thisRandNum},function(data) 
		{$("#information_circle_"+d+c).html(data).show()});
	}
</script>

<body>
<font>
	
<div class="info_body">
<?php
// General Info
echo "<div class='middle_bars'>
		<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='profile_info_bar'/><span class='heading_list'>Profile Information</span></div>
		<div class='float_right'><b>".$message1."</b></div>
	</div>";
if ($middlename != "")
	{echo '<div class="info_box"><div class="info_box1"><b>Full Name:</b></div>
		<div class="info_box2">'.$firstname.' '.$middlename.' '.$lastname.'</div></div>';}
else 
	{echo '<div class="info_box"><div class="info_box1"><b>Full Name:</b></div>
		<div class="info_box2">'.$firstname.' '.$lastname.'</div></div>';}
if ($alt_email !== "")
	{echo '<div class="info_box"><div class="info_box1"><b>Emails:</b></div>
		<div class="info_box2">Primary Email: '.$email.'<br/>Secondary Email: '.$alt_email.'</div></div>';}
else 
	{echo '<div class="info_box"><div class="info_box1"><b>Email:</b></div>
		<div class="info_box2">'.$email.'</div></div>';}
echo '<div class="info_box"><div class="info_box1"><b>Gender:</b></div>
	<div class="info_box2">'.$gender.'</div></div>';
echo '<div class="info_box"><div class="info_box1"><b>Birthday:</b></div>
	<div class="info_box2">'.$birthday.'</div></div>';
if ($personal_bio != "")
	{echo '<div class="info_box"><div class="info_box1"><b>Personal Story:</b></div>
		<div class="info_box2">'.$personal_bio.'</div></div>';}	
if (($motto1 !== "")AND($motto2 !== ""))
	{echo '<div class="info_box"><div class="info_box1"><b>Personal Mottos:</b></div>
		<div class="info_box2">Personal Motto #1: '.$motto1.'<br/>Personal Motto #2: '.$motto2.'</div></div>';}
else if (($motto1 !== "")OR($motto2 !== ""))
	{echo '<div class="info_box"><div class="info_box1"><b>Personal Motto:</b></div>
		<div class="info_box2">'.$motto1.''.$motto2.'</div></div>';}
if (($cell_number !== "")AND($tel_number !==""))
	{echo '<div class="info_box"><div class="info_box1"><b>Contact Numbers:</b></div>
		<div class="info_box2">Cellphone Number: '.$cell_number.'<br/>Telephone Number: '.$tel_number.'</div></div>';}
else if ($cell_number !== "")
	{echo '<div class="info_box"><div class="info_box1"><b>Contact Number:</b></div>
		<div class="info_box2">Cellphone Number: '.$cell_number.'</div></div>';}
else if ($tel_number !== "")
	{echo '<div class="info_box"><div class="info_box1"><b>Contact Number:</b></div>
		<div class="info_box2">Telephone Number: '.$tel_number.'</div></div>';}
if ($location !="")
	{echo '<div class="info_box"><div class="info_box1"><b>Location:</b></div>
		<div class="info_box2">'.$location.'</div></div>';}
if ($primary_school !="")
	{echo '<div class="info_box"><div class="info_box1"><b>Primary School:</b></div>
		<div class="info_box2">'.$primary_school.'</div></div>';}
if ($secondary_school !="")
	{echo '<div class="info_box"><div class="info_box1"><b>Secondary School:</b></div>
		<div class="info_box2">'.$secondary_school.'</div></div>';}
if ($post_secondary !="")
	{echo '<div class="info_box"><div class="info_box1"><b>University Or College:</b></div>
		<div class="info_box2">'.$post_secondary.'</div></div>';}
if ($employer !="")
	{echo '<div class="info_box"><div class="info_box1"><b>Employer:</b></div>
		<div class="info_box2">'.$employer.'</div></div>';}
if (($relationship !="")AND($relationship !=="Undefined"))
	{echo '<div class="info_box"><div class="info_box1"><b>Relationship Status:</b></div>
		<div class="info_box2">'.$relationship.'</div></div>';}
if ($scores == 'b')
	{if ($likes !="")
		{echo '<div class="info_box"><div class="info_box1"><b>Likes:</b></div>
			<div class="info_box2">Total Of '.$likes.' Liked Items</div></div>';}
	if ($loves !="")
		{echo '<div class="info_box"><div class="info_box1"><b>Loves:</b></div>
			<div class="info_box2">Total Of '.$loves.' Loved Items</div></div>';}
	}
?>

</div>

</font>
</body>