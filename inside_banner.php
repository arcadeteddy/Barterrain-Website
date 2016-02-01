<?php
// Establish profile interaction token.
$thisRandNum = rand(9999999999999,999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
$id_banner = $_SESSION['ids'];

$TransactionsDisplayList="";

$search="";
if (isset($_GET["search"]))
	{$search=$_GET["search"];}

// Points & FF
$mysql_points = mysql_query("SELECT points FROM economy WHERE id=$id_banner");
$mysql_profile = mysql_query("SELECT friend_array, family_array, planets_array FROM members WHERE id=$id_banner");
while($row = mysql_fetch_array($mysql_profile))
	{$friend_array = $row['friend_array'];
	$friendArray = explode(",",$friend_array);
	$family_array = $row['family_array'];
	$familyArray = explode(",",$family_array);
	$planets_array_bar = $row['planets_array'];
	$planetsArray_bar = explode(",",$planets_array_bar);
	if(($friend_array!=="")AND($family_array!==""))
		{$FF_array=$friend_array.",".$family_array;}
	else if($family_array!==""){$FF_array=$family_array;}
	else{$FF_array=$friend_array;}
	$FFArray = explode(",",$FF_array);}
while($row = mysql_fetch_array($mysql_points))
	{$points = $row['points'];
	if($points>999999)
		{$points=$points/1000000;
		$points=substr($points,0,-5);
		$points=$points." M";}
	else if($points>999999999)
		{$points=$points/1000000000;
		$points=substr($points,0,-8);
		$points=$points." B";}
	}
	
$mysql_planets = mysql_query("SELECT id FROM planets WHERE user_id=$id_banner");
while($row = mysql_fetch_array($mysql_planets))
	{$created_planets_array[] = $row['id'];}
if (!empty($created_planets_array)) {$PLANETS = join(',',$created_planets_array);}
	
// FF Title
$FF_banner="Friends";
$FF_banner_bottom="Friends";
if ($family_array!="")
	{$FF_banner="Family & Friends";}
if (($family_array!="")AND($friend_array!=""))
	{$FF_banner_bottom="Family & Friends";}
else if ($family_array!="")
	{$FF_banner_bottom="Family";}
	
if (!empty($created_planets_array)) {$mysql_planet = mysql_query("SELECT * FROM creator_requests WHERE (create_id IN ($PLANETS)) AND request_status = '0' ORDER BY id DESC LIMIT 3");}
else {$mysql_planet = mysql_query("SELECT * FROM creator_requests WHERE create_id = '0' AND request_status = '0' ORDER BY id DESC LIMIT 3");}
$numRows_planet_creator = mysql_num_rows($mysql_planet);

if (!empty($created_planets_array)) {$mysql_planet = mysql_query("SELECT * FROM admin_requests WHERE (create_id IN ($PLANETS)) AND request_status = '0' ORDER BY id DESC LIMIT 3");}
else {$mysql_planet = mysql_query("SELECT * FROM admin_requests WHERE create_id = '0' AND request_status = '0' ORDER BY id DESC LIMIT 3");}
$numRows_planet_admin = mysql_num_rows($mysql_planet);
?>

<head>
<meta name="description" content="A Fun Social Network For Everyone! Barterrain!"/>
<meta name="author" content="Arcade & Einstein"/>
<meta name="copyright" content="Barterrain 2013"/>
<meta name="keywords" content="Barterrain 2013"/>
<link rel="shortcut icon" href="http://www.barterrain.com/barterrain_banner_images/favicon.ico" type="image/x-icon"/>
<script type="text/javascript">
var thisRandNum = "<?php echo $thisRandNum; ?>";
var friendRequestURL_banner = "../scripts/request_as_friend.php";
var typex = "<?php echo "planets" ?>";
var DisplayArray = "../scripts/display_array.php";

function spiral()
	{$("div.full_page_loader").removeClass("full_page_loader_hidden");};
function spiral2()
	{$(".friends_button").removeClass("selected_button_bottom");
	$("fieldset#sub_button_friends").hide();
	$(".points_button").removeClass("selected_button_bottom");
	$("fieldset#sub_button_points").hide();
	$(".settings_button").removeClass("selected_button_bottom");
	$("fieldset#sub_button_settings").hide();
	$(".body").removeClass("darken");
	$("div.full_page_loader").removeClass("full_page_loader_hidden");};
</script>
<script src="http://www.barterrain.com/inside_banner_javascript.js" type="text/javascript" async></script> 
</head>

<body class="banner">
<font>
<div class="banner100">
<div class="banner" id="banner">

	<div class="banner_left">
		<a href="http://www.barterrain.com/index.php" class="title" title="Baterrain" onClick="spiral()" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>
        <a href="http://www.barterrain.com/profile/profile.php?id=<?php echo $id_banner;?>" class="profile_button" title="Profile" onClick="spiral()" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>
        <a href="http://www.barterrain.com/planets/planets.php" class="planets_button" title="Planets" onClick="spiral()" onMouseDown="if (event.preventDefault) event.preventDefault()"></a>
    </div>
    
    <div class="banner_middle">
    	<form action="javascript:search_box_query()" method="post" enctype="multipart/form-data">
			<input type="text" name="search_box_query" id="search_box_query" class="search_box" placeholder="Search" value="<?php echo $search;?>"/>
    	</form>
	</div>
    
	<div class="banner_right">
    <span class="head_button"><a href="#" class="settings_button" title="Settings" onMouseDown="if (event.preventDefault) event.preventDefault()"></a></span>
		<fieldset id="sub_button_settings"><div class="sub_button_settings sub_button">
            <div class="sub_button_bottom">
            	<a href="http://www.barterrain.com/settings/settings.php" onClick="spiral2()">Settings</a>
            	<a href="http://www.barterrain.com/settings/logout.php" onClick="spiral2()">Log Out</a>
			</div>
		</div></fieldset>
    <span class="head_button"><a href="#" class="friends_button" title="Friends" onMouseDown="if (event.preventDefault) event.preventDefault()"></a></span>
		<fieldset id="sub_button_friends"><div class="sub_button_friends sub_button">
            <div style="float:left;text-align:left;width:105px;"><b class="banner">Friend Requests</b></div>
			<div style="float:right;text-align:right;"></div>
			<div class='fmn_body_top'></div>
			<?php
			$mysql_friend = mysql_query("SELECT * FROM friend_requests WHERE request_id = '$id_banner' AND request_status = '0' ORDER BY id DESC LIMIT 5") or die ("Sorry, we have a system error!");
			$numRows_friend = mysql_num_rows($mysql_friend);
			if ($numRows_friend < 1)
				{echo "<div class='nothing_banner'><span class='nothing_banner'>No Friend Requests</span></div>";}
			else
				{while ($row_friend=mysql_fetch_array($mysql_friend))
					{$requestID_friend = $row_friend['id'];
					$user_id_friend = $row_friend['user_id'];
					$mysql_name_friend = mysql_query("SELECT firstname, lastname, secondary_school, post_secondary, location, friend_array, family_array FROM members WHERE id='$user_id_friend' LIMIT 1");
					while ($row_friend=mysql_fetch_array($mysql_name_friend))
						{$requester_firstname=$row_friend['firstname'];
						$requester_lastname=$row_friend['lastname'];
						$requester_friend_array=$row_friend['friend_array'];
						$requester_family_array=$row_friend['family_array'];
						$check_pic_friend1="user_files/user$user_id_friend/profile_thumb.jpg";
						$check_pic_friend2="../user_files/user$user_id_friend/profile_thumb.jpg";
						$default_pic_friend="http://www.barterrain.com/user_files/user0/default_profile_pic_thumb.png";
						$cacheBuster = rand(9999999,99999999999);
						if (file_exists($check_pic_friend1)){$user_pic_friend="<img src='$check_pic_friend1#$cacheBuster' class='thumb_background' width='55px' height='55px'/>";}
						else if (file_exists($check_pic_friend2)){$user_pic_friend="<img src='$check_pic_friend2#$cacheBuster' class='thumb_background' width='55px' height='55px'/>";}
						else{$user_pic_friend="<img src='$default_pic_friend' width='55px' height='55px' class='thumb_background'/>";}
						
						if(($requester_friend_array!=="")AND($requester_family_array!==""))
							{$FF_requester_array=$requester_friend_array.",".$requester_family_array;}
						else if($requester_family_array!==""){$FF_requester_array=$requester_family_array;}
						else{$FF_requester_array=$requester_friend_array;}
						$FFrequesterArray = explode(",",$FF_requester_array);
						$FFrequesterArray = array_intersect($FFrequesterArray, $FFArray);
						$FFpersonArray_json_encode = json_encode($FFrequesterArray);
						$FFArray_count=count($FFrequesterArray);
						if ($FFArray_count!=1) {$mf_s="Friends";}
						else {$mf_s="Friend";}
						
						if ($FFArray_count==0) {$FFArray_count="0";}
						else {$FFArray_count="<a title='Display Mutual Friends' href='#' onclick='return false' onmousedown='javascript:display_mutual_FF(".$id.",".$ids.",".$FFpersonArray_json_encode.");' class='bold display_button'>".$FFArray_count."</a>";}
						
						$php_self = $_SERVER['REQUEST_URI'];
						echo "<div class='banner_friend_wrap1'><div class='banner_friend_1'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$user_id_friend."'>".$user_pic_friend."</a></div>
							<div class='banner_friend_2'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$user_id_friend."'><b>".$requester_firstname." ".$requester_lastname."</b></a>
								<br/><span>You Both Have ".$FFArray_count." Mutual ".$mf_s."</span><br/>
								<form action='$php_self' name='banner_friend' method='post' enctype='multipart/form-data' class='right_top'>
								<span id='banner_request".$requestID_friend."'>
									<a href='#' class='bar_link' onclick='return false' onmousedown='javascript:banner_acceptFriendRequest(".$requestID_friend.");'>Accept</a><span class='dot_divider'> &middot;</span>
									<a href='#' class='bar_link' onclick='return false' onmousedown='javascript:banner_rejectFriendRequest(".$requestID_friend.");'>Reject</a></span>
									<span class='dot_divider'> &middot; </span><a href='http://www.barterrain.com/messages/messages.php?id=".$user_id_friend."' class='bar_link'>Message</a>
								</form>
							</div></div>";
						}
					}
				}
			?>
			<div class="fmn_body_middle"></div>
			<div class="sub_button_bottom">
            	<a href="http://www.barterrain.com/friends/friends.php" onClick="spiral2()">Find Friends</a>
                <a href="http://www.barterrain.com/friends/friends.php?friends=invite" onClick="spiral2()">Invite Friends</a>
                <a href="http://www.barterrain.com/friends/friends.php?friends=all" onClick="spiral2()">All <?php echo $FF_banner_bottom; ?></a>
            </div>
        </div></fieldset>
    <div id="point_reload">
    <span class="head_button"><a href="#" class="points_button" title="Points" onMouseDown="if (event.preventDefault) event.preventDefault()"><div class="points_fix">&#5528; <?php echo $points; ?></div></a></span>
		<fieldset id="sub_button_points"><div class="sub_button_points sub_button">
        	<div style="float:left;text-align:left;width:125px;"><b class="banner">Point Transactions</b></div>
			<div class='points_body_top'></div>
            <?php
			$mysql_points = mysql_query("(SELECT * FROM point_transactions WHERE (plus_id='$id_banner' OR minus_id='$id_banner') AND union_type='transactions') 
										UNION ALL(SELECT * FROM point_transactions_comments WHERE (plus_id='$id_banner' OR minus_id='$id_banner') AND union_type='comments_transactions')
										ORDER BY transaction_date DESC LIMIT 10");
			$numRows_points = mysql_num_rows($mysql_points);
			if ($numRows_points < 1)
				{echo "<div class='nothing_banner'><span class='nothing_banner'>No Point Transactions</span></div>";}
			else
				{$list_number="1";
				while ($row = mysql_fetch_array ($mysql_points))
					{$transaction_id = $row['id'];
					$transaction_date = $row['transaction_date'];
					$union_type = $row['union_type'];
	
					if ($union_type=="transactions")
						{$mysql1 = mysql_query("SELECT * FROM point_transactions WHERE id='$transaction_id' AND transaction_date='$transaction_date' LIMIT 1");}
					else if ($union_type=="comments_transactions") 
						{$mysql1 = mysql_query("SELECT * FROM point_transactions_comments WHERE id='$transaction_id' AND transaction_date='$transaction_date' LIMIT 1");}
					
					while ($row = mysql_fetch_array ($mysql1))
						{$transaction_id = $row['id'];
						$plus_id = $row['plus_id'];
						$minus_id = $row['minus_id'];
						$item_id = $row['item_id'];
						$create_type = $row['create_type'];
						$create_id = $row['create_id'];
						$transaction_type = $row['transaction_type'];
						$transaction_amount = $row['transaction_amount'];}
		
					if ($create_type=="profile") 
						{$create_text="profile";$location_text="";}
					else if ($create_type=="planet") 
						{$create_text="planets";$location_text="Planet";}
					$create_text_s=substr($create_text,0,-1);
					$creator_array="";
					$creator_display="0";
					
					$item_type=json_encode($transaction_type);
					$create_type_json=json_encode($create_type);
					
					if ($transaction_type=="images_walls") {$transaction_type="Imagess";}
					if ($transaction_type=="link_creates") {$transaction_type="Planet Links";}
					if ($transaction_type=="member_posts")
						{$transaction_type="Member Posts";}
					$transaction_type_s=substr($transaction_type,0,-1);
					$transaction_type_cs=ucwords(str_replace("s_"," ",$transaction_type_s));
					
					if ($create_type=="profile") 
						{$link_text="<a href='http://www.barterrain.com/points/points.php?points=profile' class='body display_image_button' onclick='spiral2()'>".$transaction_type_cs."</a>";}
					else if ($create_type=="planet") 
						{$link_text="<a href='http://www.barterrain.com/points/points.php?points=planet' class='body display_image_button' onclick='spiral2()'>".$transaction_type_cs."</a>";}
					
			/*if ($transaction_type=="images")
				{$mysql_images = mysql_query("SELECT user_page_id FROM planets_images WHERE id='$item_id' LIMIT 1");
				while ($row = mysql_fetch_array ($mysql_images))
					{$user_page_id = $row['user_page_id'];}
				$link_text="<a href='#' class='body display_image_button' onclick='return false' onmousedown='javascript:banner_display_image(".$user_page_id.",".$id_banner.",".$item_id.");'>".$transaction_type_cs."</a>";}
			else 
				{$link_text="<a href='#' class='body display_button' onclick='return false' onmousedown='javascript:banner_display_item(".$id_banner.",".$item_id.",".$item_type.",".$create_id.",".$create_type_json.");'>".$transaction_type_cs."</a>";}*/
	
					if ($plus_id==$id_banner) 
						{$transaction_amount="+ ".$transaction_amount;
						if ($create_type=="planet")
							{$mysql = mysql_query("SELECT user_id, creator_array, creator_display, ".$create_text_s."_name AS create_name FROM ".$create_text." WHERE id='$create_id' LIMIT 1");
							while ($row = mysql_fetch_array ($mysql))
								{$creators = $row['user_id'];
								$creator_array = $row['creator_array'];
								if ($creator_array!="") {$creators = $creator_array.",".$creators;}
								$creator_array = explode(",",$creators);
								$creator_display = $row['creator_display'];
								$create_name = $row['create_name'];}}
						$mysql = mysql_query("SELECT firstname, lastname FROM members WHERE id='$minus_id' LIMIT 1");
						while ($row = mysql_fetch_array ($mysql))
							{$firstname = $row['firstname'];
							$lastname = $row['lastname'];
							$fullname_banner = $firstname." ".$lastname;}
						$mysql = mysql_query("SELECT alias, alias_activation FROM members_planets WHERE id='$minus_id' LIMIT 1");
						while ($row = mysql_fetch_array ($mysql))
							{$banner_alias = $row['alias'];
							$banner_alias_activation = $row['alias_activation'];}
							
						if ($create_type=="planet")
							{$point_piture='<img src="blank.gif" width="1px" height="1px" class="banner_planet_transactions"/>';
							if ((in_array($minus_id,$creator_array))AND($creator_display=="1")) 
								{if ((strlen($create_name))>15){$create_name=substr($create_name, 0, 15).'...';}
								$minus_text="<a href='http://www.barterrain.com/create/page.php?id=".$create_id."' onclick='spiral2()' class='body'>".$create_name."</a>";}
							else if ($banner_alias_activation=="0") 
								{if ((strlen($fullname_banner))>15){$fullname_banner=substr($fullname_banner, 0, 15).'...';}
								$minus_text="<a href='http://www.barterrain.com/profile/profile.php?id=".$minus_id."' onclick='spiral2()' class='body'>".$fullname_banner."</a>";}
							else if ($banner_alias_activation=="1") 
								{if ((strlen($banner_alias))>15){$banner_alias=substr($banner_alias, 0, 15).'...';}
								$minus_text="<a href='#' onclick='return false' class='alias_body_link'>".$banner_alias."</a>";}
							}
						else if ($create_type=="profile")
							{$point_piture='<img src="blank.gif" width="1px" height="1px" class="banner_profile_transactions"/>';
							if ((strlen($fullname_banner))>15){$fullname_banner=substr($fullname_banner, 0, 15).'...';}
							$minus_text="<a href='http://www.barterrain.com/profile/profile.php?id=".$minus_id."' onclick='spiral2()' class='body'>".$fullname_banner."</a>";}
						$transaction_text=$point_piture."".$minus_text." | ".$link_text;
						}
					else if ($minus_id==$id_banner) 
						{$transaction_amount="- ".$transaction_amount;
						if ($create_type=="planet")
							{$mysql = mysql_query("SELECT user_id, creator_array, creator_display, ".$create_text_s."_name AS create_name FROM ".$create_text." WHERE id='$create_id' LIMIT 1");
							while ($row = mysql_fetch_array ($mysql))
								{$creators = $row['user_id'];
								$creator_array = $row['creator_array'];
								if ($creator_array!="") {$creators = $creator_array.",".$creators;}
								$creator_array = explode(",",$creators);
								$creator_display = $row['creator_display'];
								$create_name = $row['create_name'];}}
						$mysql = mysql_query("SELECT firstname, lastname FROM members WHERE id='$plus_id' LIMIT 1");
						while ($row = mysql_fetch_array ($mysql))
							{$firstname = $row['firstname'];
							$lastname = $row['lastname'];
							$fullname_banner = $firstname." ".$lastname;}
						$mysql = mysql_query("SELECT alias, alias_activation FROM members_planets WHERE id='$plus_id' LIMIT 1");
						while ($row = mysql_fetch_array ($mysql))
							{$banner_alias = $row['alias'];
							$banner_alias_activation = $row['alias_activation'];}
							
						if ($create_type=="planet")
							{$point_piture='<img src="blank.gif" width="1px" height="1px" class="banner_planet_transactions"/>';
							if ((in_array($plus_id,$creator_array))AND($creator_display=="1")) 
								{if ((strlen($create_name))>15){$create_name=substr($create_name, 0, 15).'...';}
								$plus_text="<a href='http://www.barterrain.com/create/page.php?id=".$create_id."' onclick='spiral2()' class='body'>".$create_name."</a>";}
							else if ($banner_alias_activation=="0") 
								{if ((strlen($fullname_banner))>15){$fullname_banner=substr($fullname_banner, 0, 15).'...';}
								$plus_text="<a href='http://www.barterrain.com/profile/profile.php?id=".$plus_id."' onclick='spiral2()' class='body'>".$fullname_banner."</a>";}
							else if ($banner_alias_activation=="1") 
								{if ((strlen($banner_alias))>15){$banner_alias=substr($banner_alias, 0, 15).'...';}
								$plus_text="<a href='#' onclick='return false' class='alias_body_link'>".$banner_alias."</a>";}
							}
						else if ($create_type=="profile")
							{$point_piture='<img src="blank.gif" width="1px" height="1px" class="banner_profile_transactions"/>';
							if ((strlen($fullname_banner))>15){$fullname_banner=substr($fullname_banner, 0, 15).'...';}
							$plus_text="<a href='http://www.barterrain.com/profile/profile.php?id=".$plus_id."' onclick='spiral2()' class='body'>".$fullname_banner."</a>";}
						$transaction_text=$point_piture."".$plus_text." | ".$link_text;
						}
		
					$TransactionsDisplayList .= "<table class='banner_points_list'><tr><td class='banner_points_list_".$list_number."' valign='middle'><span class='list_span'>".$transaction_text."</span></td>
								<td class='banner_points_list_pm_between'></td><td class='banner_points_list_pm_".$list_number."'><span class='list_span'>".$transaction_amount."</span></td></tr></table>";
					if ($list_number=="1") {$list_number="2";} else {$list_number="1";}
					}
				echo $TransactionsDisplayList;}
			
			?>
			<div class="points_body_middle"></div>
			<div class="sub_button_bottom">
            	<a href="http://www.barterrain.com/points/points.php" onClick="spiral2()">Profile Transactions</a>
                <a href="http://www.barterrain.com/points/points.php?points=planet" onClick="spiral2()">Planet Transactions</a>
                <a href="http://www.barterrain.com/points/points.php?points=totals" onClick="spiral2()">Total Points</a>
            </div>
		</div></fieldset>
    </div>
	</div>	
    
</div>
</div>
</font>
</body>