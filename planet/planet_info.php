<?php
ob_start();
$creator_list="";

$mysql = mysql_query("SELECT DATE_FORMAT(create_date, '%M') AS `month`, DATE_FORMAT(create_date, '%D') AS `day` FROM planets WHERE id=$id");
while($row = mysql_fetch_array($mysql))
	{$month = $row['month'];
	$day = $row['day'];
	$create_date = $month." ".$day;}
	
include_once "../scripts/check_login.php";

$mysql = mysql_query("SELECT * FROM planets WHERE id=$id");
while($row = mysql_fetch_array($mysql))
	{$creator_display = $row['creator_display'];
	$user_id = $row['user_id'];
	$creator_array = $row['creator_array'];
	$planet_name = $row['planet_name'];
	$planet_description = $row['planet_description'];
	$categories = $row['categories'];
	$planets_email1 = $row["planets_email1"];
	$planets_email2 = $row["planets_email2"];
	$planets_bio = $row["planets_bio"];
	$planets_motto1 = $row["planets_motto1"];	
	$planets_motto2 = $row["planets_motto2"];
	$planets_contact_info1 = $row['planets_contact_info1'];
	$planets_contact_info2 = $row['planets_contact_info2'];
	$admin_array = $row['admin_array'];
	$member_array = $row['member_array'];
	$block_array = $row['block_array'];
	$planets_array = $row['planets_array'];
	$likes = $row['likes'];
	$loves = $row['loves'];
	$scores = $row['scores'];
	
	$creatorArray=explode(",",$creator_array);
	$CREATORS=join(',',$creatorArray);
	}
	
if ($creator_display=="1")
	{$mysql = mysql_query("SELECT * FROM members_planets WHERE id IN ($CREATORS)");
	while($row = mysql_fetch_array($mysql))
		{$creator_id = $row['id'];
		$alias = $row['alias'];
		$creator_name=$alias;
		$creator_name_plain=$alias;
		$alias_activation = $row['alias_activation'];
		$planet_email1 = $row['planet_email1'];
		$planet_email2 = $row['planet_email2'];
		$planet_bio = $row['planet_bio'];
		$motto1 = $row['motto1'];
		$motto2 = $row['motto2'];
		$creator_contact_info1 = $row['contact_info1'];
		$creator_contact_info2 = $row['contact_info2'];
		
		if ($alias_activation == "0") 
			{$mysql_name = mysql_query("SELECT firstname, lastname FROM members WHERE id='$creator_id'");
			while($row = mysql_fetch_array($mysql_name))
				{$firstname = $row['firstname'];
				$lastname = $row['lastname'];
				$creator_name="<a href='../profile/profile.php?id=".$creator_id."'>".$firstname." ".$lastname."</a>";}
				$creator_name_plain=$firstname." ".$lastname;
			}
			
		if ((isset($_SESSION['ids']))AND($ids!==$creator_id))
			{$message2="";}
		else if ((isset($_SESSION['ids']))AND($ids==$creator_id))
			{$message2="<a class='body' href='../settings/settings.php?settings=planet'>Settings</a>";}
		
		$creator_list .="<br/><div class='middle_bars'>
							<div class='float_left'>
								<img src='blank.gif' width='1px' height='1px' class='profile_info_bar'/><span class='heading_list'>Creator Information - ".$creator_name."</span>
							</div>
							<div class='float_right'><b>".$message2."</b></div>
						</div>";
		$creator_list .= '<div class="info_box"><div class="info_box1"><b>Creator Name:</b></div>
						<div class="info_box2">'.$creator_name_plain.'</div></div>';
		if (($planet_email1 !== "")AND($planet_email2 != ""))
			{$creator_list .= '<div class="info_box"><div class="info_box1"><b>Creator Emails:</b></div>
							<div class="info_box2">Primary Creator Email: '.$planet_email1.'<br/>Secondary Creator Email: '.$planet_email2.'</div></div>';}
		else if ($planet_email1 !== "")
			{$creator_list .= '<div class="info_box"><div class="info_box1"><b>Creator Email:</b></div>
							<div class="info_box2">'.$planet_email1.'</div></div>';}
		else if ($planet_email2 !== "")
			{$creator_list .= '<div class="info_box"><div class="info_box1"><b>Creator Email:</b></div>
							<div class="info_box2">'.$planet_email2.'</div></div>';}
		if ($planet_bio !== "")
			{$creator_list .= '<div class="info_box"><div class="info_box1"><b>Creator Story:</b></div>
							<div class="info_box2">'.$planet_bio.'</div></div>';}
		if (($motto1 !== "")AND($motto2 !== ""))
			{$creator_list .= '<div class="info_box"><div class="info_box1"><b>Creator Mottos:</b></div>
							<div class="info_box2">Creator Motto #1: '.$motto1.'<br/>Creator Motto #2: '.$motto2.'</div></div>';}
		else if (($motto1 !== "")OR($motto2 !== ""))
			{$creator_list .= '<div class="info_box"><div class="info_box1"><b>Creator Motto:</b></div>
							<div class="info_box2">'.$motto1.''.$motto2.'</div></div>';}
		if (($creator_contact_info1 !== "")AND($creator_contact_info2 != ""))
			{$creator_list .= '<div class="info_box"><div class="info_box1"><b>Contact Numbers:</b></div>
							<div class="info_box2">Cellphone Number: '.$creator_contact_info1.'<br/>Telephone Number: '.$creator_contact_info2.'</div></div>';}
		else if ($creator_contact_info1 !== "")
			{$creator_list .= '<div class="info_box"><div class="info_box1"><b>Contact Number:</b></div>
							<div class="info_box2">Cellphone Number: '.$creator_contact_info1.'</div></div>';}
		else if ($creator_contact_info2 !== "")
			{$creator_list .= '<div class="info_box"><div class="info_box1"><b>Contact Number:</b></div>
							<div class="info_box2">Telephone Number: '.$creator_contact_info2.'</div></div>';}
		}
	}
	
if ((isset($_SESSION['ids']))AND(!in_array($ids, $creatorArray)))
	{$message1="";}
else if ((isset($_SESSION['ids']))AND(in_array($ids, $creatorArray)))
	{$message1="<a class='body' href='../settings/settings.php?settings=planet&planet_id=".$id."'>Settings</a>";}
	
ob_flush();
?>

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
		<div class='float_left'><img src='blank.gif' width='1px' height='1px' class='planet_info_bar'/><span class='heading_list'>Planet Information</span></div>
		<div class='float_right'><b>".$message1."</b></div>
	</div>";
echo '<div class="info_box"><div class="info_box1"><b>Planet Name:</b></div>
		<div class="info_box2">'.$planet_name.'</div></div>';
if (($planets_email1 !== "")AND($planets_email2 != ""))
	{echo'<div class="info_box"><div class="info_box1"><b>Planet Emails:</b></div>
				<div class="info_box2">Primary Planet Email: '.$planets_email1.'<br/>Secondary Planet Email: '.$planets_email2.'</div></div>';}
else if ($planets_email1 !== "")
	{echo '<div class="info_box"><div class="info_box1"><b>Planet Email:</b></div>
					<div class="info_box2">'.$planets_email1.'</div></div>';}
else if ($planets_email2 !== "")
	{echo '<div class="info_box"><div class="info_box1"><b>Planet Email:</b></div>
							<div class="info_box2">'.$planets_email2.'</div></div>';}
if ($planet_description !== "")
	{echo '<div class="info_box"><div class="info_box1"><b>Planet Description:</b></div>
		<div class="info_box2">'.$planet_description.'</div></div>';}
if ($categories !== "")
	{echo '<div class="info_box"><div class="info_box1"><b>Category:</b></div>
		<div class="info_box2">'.$categories.'</div></div>';}
if ($planets_bio !== "")
	{echo '<div class="info_box"><div class="info_box1"><b>Planet Story:</b></div>
					<div class="info_box2">'.$planets_bio.'</div></div>';}
if (($planets_motto1 !== "")AND($planets_motto2 !== ""))
	{echo '<div class="info_box"><div class="info_box1"><b>Planet Mottos:</b></div>
					<div class="info_box2">Planet Motto #1: '.$planets_motto1.'<br/>Planet Motto #2: '.$planets_motto2.'</div></div>';}
else if (($planets_motto1 !== "")OR($planets_motto2 !== ""))
	{echo '<div class="info_box"><div class="info_box1"><b>Planet Motto:</b></div>
					<div class="info_box2">'.$planets_motto1.''.$planets_motto2.'</div></div>';}
if (($planets_contact_info1 !== "")AND($planets_contact_info2 != ""))
	{echo '<div class="info_box"><div class="info_box1"><b>Contact Numbers:</b></div>
					<div class="info_box2">Cellphone Number: '.$planets_contact_info1.'<br/>Telephone Number: '.$planets_contact_info2.'</div></div>';}
else if ($planets_contact_info1 !== "")
	{echo '<div class="info_box"><div class="info_box1"><b>Contact Number:</b></div>
					<div class="info_box2">Cellphone Number: '.$planets_contact_info1.'</div></div>';}
else if ($planets_contact_info2 !== "")
	{echo '<div class="info_box"><div class="info_box1"><b>Contact Number:</b></div>
					<div class="info_box2">Telephone Number: '.$planets_contact_info2.'</div></div>';}
if ($scores == 'b')
	{if ($likes !="")
		{echo '<div class="info_box"><div class="info_box1"><b>Likes:</b></div>
			<div class="info_box2">Total of '.$likes.' Liked Items</div></div>';}
	if ($loves !="")
		{echo '<div class="info_box"><div class="info_box1"><b>Loves:</b></div>
			<div class="info_box2">Total of '.$loves.' Loved Items</div></div>';}
	}
	
echo $creator_list;
?>

</div>

</font>
</body>