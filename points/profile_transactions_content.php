<?php
ob_start();
include_once "../config.php";
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;
if(!isset($number)){$number="0";}
$TransactionsDisplayList="";

if(isset($_GET['number']))
	{$number=$_GET['number'];
	$id=$_GET['id'];
	$ids=$_GET['ids'];
	$list_number=$_GET['list_number'];}
else if(isset($_POST['id']))
	{$id=$_POST['id'];
	$ids=$_POST['ids'];
	$list_number="1";}
else {$id = $_SESSION['ids'];
	$ids = $_SESSION['ids'];
	$list_number="1";}
	
ob_flush();
	
$mysql_union = mysql_query("(SELECT * FROM point_transactions WHERE (plus_id='$ids' OR minus_id='$ids') AND delete_transaction='1' AND create_type='profile') 
					UNION ALL(SELECT * FROM point_transactions_comments WHERE (plus_id='$ids' OR minus_id='$ids') AND delete_transaction='1' AND create_type='profile')
					ORDER BY transaction_date DESC LIMIT ".$number.",30");
$numRows=mysql_num_rows($mysql_union);
if ($numRows>0){
while ($row = mysql_fetch_array ($mysql_union))
	{$transaction_id = $row['id'];
	$transaction_date = $row['transaction_date'];
	$union_type = $row['union_type'];
	
if ($union_type=="transactions")
	{$mysql1 = mysql_query("SELECT * FROM point_transactions WHERE id='$transaction_id' AND transaction_date='$transaction_date' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql1))
		{$transaction_id = $row['id'];
		$plus_id = $row['plus_id'];
		$minus_id = $row['minus_id'];
		$item_id = $row['item_id'];
		$create_type = $row['create_type'];
		$create_id = $row['create_id'];
		$transaction_amount = $row['transaction_amount'];
		$transaction_type = $row['transaction_type'];
		$transaction_date = $row['transaction_date'];
		$convertedTime = ($myObject -> convert_datetime($transaction_date));
		$transaction_date = ($myObject -> make_ago($convertedTime));}
		
	$item_type=json_encode($transaction_type);
	$create_type_json=json_encode($create_type);
		
	$tt_text="This";
	if ($create_type=="profile") {$create_text="profiles";$location_text="Profile";}
	else if ($create_type=="planet") {$create_text="planets";$location_text="Planet";}
	$create_text_s=substr($create_text,0,-1);
	if ($transaction_type=="images_walls") {$transaction_type="Imagess";$tt_text="These";}
	if (($transaction_type=="pages_member_posts")OR($transaction_type=="groups_member_posts")OR($transaction_type=="events_member_posts")OR($transaction_type=="shops_member_posts"))
		{$transaction_type="Member Posts";$tt_text="This";}
	$transaction_type_s=substr($transaction_type,0,-1);
	$minus_amount="";
	$plus_amount="";
	$creator_array="";
	$creator_display="0";
	
	if ($minus_id==$ids) 
		{$minus_amount=$transaction_amount;
		if ($create_type!=="profile") {$mysql = mysql_query("SELECT user_id, creator_array, creator_display, ".$create_text_s."_name AS create_name FROM ".$create_text." WHERE id='$create_id' LIMIT 1");
								while ($row = mysql_fetch_array ($mysql))
									{$creators = $row['user_id'];
									$creator_array = $row['creator_array'];
									if ($creator_array!="") {$creators = $creator_array.",".$creators;}
									$creator_array = explode(",",$creators);
									$creator_display = $row['creator_display'];
									$create_name = $row['create_name'];}}
		$mysql = mysql_query("SELECT firstname,lastname FROM members WHERE id='$plus_id' LIMIT 1");
		while ($row = mysql_fetch_array ($mysql))
			{$firstname = $row['firstname'];
			$lastname = $row['lastname'];}
		$minus_text="You";
		if ($creator_array!="") 
			{if ((in_array($plus_id,$creator_array))AND($creator_display=="0")) {$plus_text="<a href='../".$create_type."/".$create_type.".php?id=".$create_id."' class='body'>".$create_name."</a>";}
			else {$plus_text="<a href='../profile/profile.php?id=".$plus_id."' class='body'>".$firstname." ".$lastname."</a>";}}
		else if ($creator_display=="0") {$plus_text="<a href='../profile/profile.php?id=".$plus_id."' class='body'>".$firstname." ".$lastname."</a>";}
		else if ($creator_display=="1") {$plus_text="<a href='../".$create_type."/".$create_type.".php?id=".$create_id."' class='body'>".$create_name."</a>";}
		$link_text=ucwords(str_replace("s_"," ",$transaction_type_s));
		if ($transaction_type=="images")
			{$link_text="<a href='#' onclick='return false' class='body display_image_button' onmousedown='javascript:display_image(".$id.",".$ids.",".$item_id.");'>".$link_text."</a>";}
		else 
			{$link_text="<a href='#' onclick='return false' class='body display_button' onmousedown='javascript:display_item(".$ids.",".$item_id.",".$item_type.",".$create_id.",".$create_type_json.");'>".$link_text."</a>";}
		}
	else if ($plus_id==$ids) 
		{$plus_amount=$transaction_amount;
		if ($create_type!=="profile") {$mysql = mysql_query("SELECT user_id, creator_array, creator_display, ".$create_text_s."_name AS create_name FROM ".$create_text." WHERE id='$create_id' LIMIT 1");
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
			$lastname = $row['lastname'];}
		$plus_text="You";
		if ($creator_array!="") 
			{if ((in_array($minus_id,$creator_array))AND($creator_display=="0")) {$minus_text="<a href='../".$create_type."/".$create_type.".php?id=".$create_id."' class='body'>".$create_name."</a>";}
			else {$minus_text="<a href='../profile/profile.php?id=".$minus_id."' class='body'>".$firstname." ".$lastname."</a>";}}
		else if ($creator_display=="0") {$minus_text="<a href='../profile/profile.php?id=".$minus_id."' class='body'>".$firstname." ".$lastname."</a>";}
		else if ($creator_display=="1") {$minus_text="<a href='../".$create_type."/".$create_type.".php?id=".$create_id."' class='body'>".$create_name."</a>";}
		$link_text=ucwords(str_replace("s_"," ",$transaction_type_s));
		if ($transaction_type=="images")
			{$link_text="<a href='#' onclick='return false' class='body display_image_button' onmousedown='javascript:display_image(".$id.",".$ids.",".$item_id.");'>".$link_text."</a>";}
		else 
			{$link_text="<a href='#' onclick='return false' class='body display_button' onmousedown='javascript:display_item(".$ids.",".$item_id.",".$item_type.",".$create_id.",".$create_type_json.");'>".$link_text."</a>";}
		}
	
	$transaction_text=$minus_text." Gave ".$plus_text." Points For ".$tt_text." ".$link_text."  ".$transaction_date;
		
	$TransactionsDisplayList .= "<table class='points_list'><tr><td class='points_list_".$list_number."'><span class='list_span'>".$transaction_text."</span></td><td class='points_list_pm_between'></td>
								<td class='points_list_pm_".$list_number."'><span class='list_span'>".$plus_amount."</span></td><td class='points_list_pm_between'></td>
        						<td class='points_list_pm_".$list_number."'><span class='list_span'>".$minus_amount."</span></td></tr></table>";
	if ($list_number=="1") {$list_number="2";} else {$list_number="1";}
	}
	
else if ($union_type=="comments_transactions")
	{$mysql1 = mysql_query("SELECT * FROM point_transactions_comments WHERE id='$transaction_id' AND transaction_date='$transaction_date' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql1))
		{$transaction_id = $row['id'];
		$plus_id = $row['plus_id'];
		$minus_id = $row['minus_id'];
		$item_id = $row['item_id'];
		$create_type = $row['create_type'];
		$create_id = $row['create_id'];
		$transaction_amount = $row['transaction_amount'];
		$transaction_type = $row['transaction_type'];
		$transaction_date = $row['transaction_date'];
		$convertedTime = ($myObject -> convert_datetime($transaction_date));
		$transaction_date = ($myObject -> make_ago($convertedTime));}
		
		$comments_item_type=$transaction_type;
		$comments_item_type_s=substr($comments_item_type,0,-1);
		$item_type=json_encode($transaction_type);
		$create_type_json=json_encode($create_type);
		
	$front_table="";	
	$tt_text="This";
	if ($create_type=="profile") {$create_text="profiles";$location_text="Profile";$front_table="";}
	else if ($create_type=="planet") {$create_text="planets";$location_text="Planet";$front_table="planets_";}
	if ($comments_item_type=="link_creates") {$front_table="";}
	$create_text_s=substr($create_text,0,-1);
	if ($transaction_type=="images_walls") {$transaction_type="Imagess";$tt_text="These";}
	if (($transaction_type=="pages_member_posts")OR($transaction_type=="groups_member_posts")OR($transaction_type=="events_member_posts")OR($transaction_type=="shops_member_posts"))
		{$transaction_type="Member Posts";$tt_text="This";}
	$transaction_type_s=substr($transaction_type,0,-1);
	$minus_amount="";
	$plus_amount="";
	$creator_array="";
	$creator_display="0";
	
	$mysql = mysql_query("SELECT ".$comments_item_type_s."_id AS comments_item_id FROM ".$front_table."".$comments_item_type."_comments WHERE id='$item_id' LIMIT 1");
	while ($row = mysql_fetch_array ($mysql))
		{$comments_item_id = $row['comments_item_id'];}
	
	if ($minus_id==$ids) 
		{$minus_amount=$transaction_amount;
		if ($create_type!=="profile") {$mysql = mysql_query("SELECT user_id, creator_array, creator_display, ".$create_text_s."_name AS create_name FROM ".$create_text." WHERE id='$create_id' LIMIT 1");
								while ($row = mysql_fetch_array ($mysql))
									{$creators = $row['user_id'];
									$creator_array = $row['creator_array'];
									if ($creator_array!="") {$creators = $creator_array.",".$creators;}
									$creator_array = explode(",",$creators);
									$creator_display = $row['creator_display'];
									$create_name = $row['create_name'];}}
		$mysql = mysql_query("SELECT firstname,lastname FROM members WHERE id='$plus_id' LIMIT 1");
		while ($row = mysql_fetch_array ($mysql))
			{$firstname = $row['firstname'];
			$lastname = $row['lastname'];}
		$minus_text="You";
		if ($creator_array!="") 
			{if ((in_array($plus_id,$creator_array))AND($creator_display=="0")) {$plus_text="<a href='../".$create_type."/".$create_type.".php?id=".$create_id."' class='body'>".$create_name."</a>";}
			else {$plus_text="<a href='../profile/profile.php?id=".$plus_id."' class='body'>".$firstname." ".$lastname."</a>";}}
		else if ($creator_display=="0") {$plus_text="<a href='../profile/profile.php?id=".$plus_id."' class='body'>".$firstname." ".$lastname."</a>";}
		else if ($creator_display=="1") {$plus_text="<a href='../".$create_type."/".$create_type.".php?id=".$create_id."' class='body'>".$create_name."</a>";}
		$link_text=ucwords(str_replace("s_"," ",$transaction_type_s));
		$link_text="<a href='#' onclick='return false' class='body display_button' onmousedown='javascript:display_item(".$ids.",".$comments_item_id.",".$item_type.",".$create_id.",".$create_type_json.");'>".$link_text."</a>";
		}
	else if ($plus_id==$ids) 
		{$plus_amount=$transaction_amount;
		if ($create_type!=="profile") {$mysql = mysql_query("SELECT user_id, creator_array, creator_display, ".$create_text_s."_name AS create_name FROM ".$create_text." WHERE id='$create_id' LIMIT 1");
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
			$lastname = $row['lastname'];}
		$plus_text="You";
		if ($creator_array!="") 
			{if ((in_array($minus_id,$creator_array))AND($creator_display=="0")) {$minus_text="<a href='../".$create_type."/".$create_type.".php?id=".$create_id."' class='body'>".$create_name."</a>";}
			else {$minus_text="<a href='../profile/profile.php?id=".$minus_id."' class='body'>".$firstname." ".$lastname."</a>";}}
		else if ($creator_display=="0") {$minus_text="<a href='../profile/profile.php?id=".$minus_id."' class='body'>".$firstname." ".$lastname."</a>";}
		else if ($creator_display=="1") {$minus_text="<a href='../".$create_type."/".$create_type.".php?id=".$create_id."' class='body'>".$create_name."</a>";}
		$link_text=ucwords(str_replace("s_"," ",$transaction_type_s));
		$link_text="<a href='#' onclick='return false' onmousedown='javascript:display_item(".$ids.",".$comments_item_id.",".$item_type.",".$create_id.",".$create_type_json.");' class='body display_button'>".$link_text."</a>";
		}
		
	$transaction_text=$minus_text." Gave ".$plus_text." Points For A Comment On ".$tt_text." ".$link_text." ".$transaction_date;
		
	$TransactionsDisplayList .= "<table class='points_list'><tr><td class='points_list_".$list_number."'><span class='list_span'>".$transaction_text."</span></td><td class='points_list_pm_between'></td>
								<td class='points_list_pm_".$list_number."'><span class='list_span'>".$plus_amount."</span></td><td class='points_list_pm_between'></td>
        						<td class='points_list_pm_".$list_number."'><span class='list_span'>".$minus_amount."</span></td></tr></table>";
	if ($list_number=="1") {$list_number="2";} else {$list_number="1";}
	}
}}

echo $TransactionsDisplayList;
if($numRows>0){$number=$number+30;}
?>
<script type="text/javascript">
// Add more Content at end of page
var id = "<?php echo $id; ?>";
var ids = "<?php echo $ids; ?>";
var number = "<?php echo $number; ?>";
var numRows = "<?php echo $numRows; ?>";
var list_number = "<?php echo $list_number; ?>";
$(window).data('ajaxready1', true).scroll(function(e)
	{if ($(window).data('ajaxready1') == false) return;
	if($(window).scrollTop()>=$("#bottom_profile_transactions").height()-$(document).height())
		{$("div#expand_bottom_point_transactions").hide();
		$("div#load_content_scroll").show();
		$(window).data('ajaxready1', false);
		$.ajax({cache: false,url:"profile_transactions_content.php?number="+number+"&id="+id+"&ids="+ids+"&list_number="+list_number,
			success:function(html)
				{if(html){$("#bottom_profile_transactions").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_point_transactions").show();}
				 $(window).data('ajaxready1', true);}
			});
		}
	});
	
$(document).ready(function()
{$("div#expand_bottom_point_transactions").click(function(){
	{if ($(window).data('ajaxready1') == false) return;
	$("div#expand_bottom_point_transactions").hide();
	$("div#load_content_scroll").show();
	$(window).data('ajaxready1', false);
	$.ajax({cache: false,url:"profile_transactions_content.php?number="+number+"&id="+id+"&ids="+ids+"&list_number="+list_number,
			success:function(html)
				{if(html){$("#bottom_profile_transactions").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_point_transactions").show();}
				 $(window).data('ajaxready1', true);}
			});
		}
	});
});
</script>