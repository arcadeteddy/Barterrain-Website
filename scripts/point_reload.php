<?php
session_start();
include_once "../config.php";
$id_banner = $_SESSION['ids'];

// Points & FF
$mysql_points = mysql_query("SELECT points FROM economy WHERE id=$id_banner");
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
?>
<script type="text/javascript">
// Points
$(document).ready(function() 
	{$(".points_button").click(function(e) 
		{e.preventDefault();
        $("fieldset#sub_button_points").toggle();
		$(".body").addClass("darken");
		$(".points_button").toggleClass("selected_button_bottom");});
		$("fieldset#sub_button_points").mouseup(function() 
			{return false});
        $(document).mouseup(function(e)
			{if($(e.target).parent("div.points_button").length==0)
				{$(".points_button").removeClass("selected_button_bottom");
				$(".body").removeClass("darken");
				$("fieldset#sub_button_points").hide();}
            });           
	});
</script>

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
            	<a href="http://www.barterrain.com/points/points.php" onclick="spiral2()">Profile Transactions</a>
                <a href="http://www.barterrain.com/points/points.php?points=planet" onclick="spiral2()">Planet Transactions</a>
                <a href="http://www.barterrain.com/points/points.php?points=totals" onclick="spiral2()">Total Points</a>
            </div>
		</div></fieldset>