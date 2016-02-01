<?php
ob_start();
include_once "../config.php";
if(!isset($number)){$number="0";}
$cacheBuster = rand(9999999,99999999999);
$MemberDisplayList="";
$add_friend_button="";
$no_result="";
$and="";
$place="";
$filter_name="";
$filter_location="";
$filter_primary_school="";
$filter_secondary_school="";
$filter_post_secondary="";
$filter_employer="";
$filter_query_name="";
$filter_query_location="";
$filter_query_primary_school="";
$filter_query_secondary_school="";
$filter_query_post_secondary="";
$filter_query_employer="";
	
if(isset($_GET['number']))
	{$number=$_GET['number'];
	$id=$_GET['id'];
	$ids=$_GET['ids'];
	$_POST['filter_query_name']=$_GET['filter_query_name'];
	$_POST['filter_query_location']=$_GET['filter_query_location'];
	$_POST['filter_query_primary_school']=$_GET['filter_query_primary_school'];
	$_POST['filter_query_secondary_school']=$_GET['filter_query_secondary_school'];
	$_POST['filter_query_post_secondary']=$_GET['filter_query_post_secondary'];
	$_POST['filter_query_employer']=$_GET['filter_query_employer'];}
else if(isset($_POST['id']))
	{$id=$_POST['id'];
	$ids=$_POST['ids'];}
else {$id = $_SESSION['ids'];
	$ids = $_SESSION['ids'];}
	
if ((!isset($id))OR(!isset($ids)))
	{header("Location: ../index.php");exit();}
ob_flush();
	
$mysql1 = mysql_query("SELECT firstname,middlename,location,primary_school,secondary_school,post_secondary,lastname,friend_array,family_array FROM members WHERE id='$ids'");
while($row = mysql_fetch_array($mysql1))
	{$firstname = $row['firstname'];
	$middlename = $row['middlename'];
	$lastname = $row['lastname'];
	$location = $row['location'];
	$primary_school = $row['primary_school'];
	$secondary_school = $row['secondary_school'];
	$post_secondary = $row['post_secondary'];
	$friend_array = $row['friend_array'];
	$friendArray = explode(",",$friend_array);
	$friend_count = count($friendArray);
	$family_array = $row['family_array'];
	$familyArray = explode(",",$family_array);
	$family_count = count($familyArray);
	$total_count = $friend_count + $family_count;
	if(($friend_array!=="")AND($family_array!==""))
		{$FF_array=$friend_array.",".$family_array;}
	else if($family_array!==""){$FF_array=$family_array;}
	else if($friend_array!==""){$FF_array=$friend_array;}
	else {$FF_array="";}
	$FFArray = explode(",",$FF_array);
	$FFArray2 = join(',',$FFArray);}
	
if(((isset($_POST['filter_query_name']))AND($_POST['filter_query_name']!=""))OR((isset($_POST['filter_query_location']))AND($_POST['filter_query_location']!=""))OR((isset($_POST['filter_query_primary_school']))AND($_POST['filter_query_primary_school']!=""))
OR((isset($_POST['filter_query_secondary_school']))AND($_POST['filter_query_secondary_school']!=""))OR((isset($_POST['filter_query_post_secondary']))AND($_POST['filter_query_post_secondary']!=""))OR((isset($_POST['filter_query_employer']))AND($_POST['filter_query_employer']!="")))
	{if((isset($_POST['filter_query_name']))AND($_POST['filter_query_name']!=""))
		{$filter_name=preg_replace('#[^a-z A-Z -]#i','',$_POST['filter_query_name']);
		$filter_query_name="fullname LIKE '%$filter_name%'";}
	if((isset($_POST['filter_query_location']))AND($_POST['filter_query_location']!=""))
		{if($_POST['filter_query_name']!=""){$and=" AND ";}
		$filter_location=preg_replace('#[^a-z A-Z -]#i','',$_POST['filter_query_location']);
		$filter_query_location=$and."location LIKE '%$filter_location%'";}
	if((isset($_POST['filter_query_primary_school']))AND($_POST['filter_query_primary_school']!=""))
		{if(($_POST['filter_query_name']!="")OR($_POST['filter_query_location']!="")){$and=" AND ";}
		$filter_primary_school=preg_replace('#[^a-z A-Z -]#i','',$_POST['filter_query_primary_school']);
		$filter_query_primary_school=$and."primary_school LIKE '%$filter_primary_school%'";}
	if((isset($_POST['filter_query_secondary_school']))AND($_POST['filter_query_secondary_school']!=""))
		{if(($_POST['filter_query_name']!="")OR($_POST['filter_query_location']!="")OR($_POST['filter_query_primary_school']!="")){$and=" AND ";}
		$filter_secondary_school=preg_replace('#[^a-z A-Z -]#i','',$_POST['filter_query_secondary_school']);
		$filter_query_secondary_school=$and."secondary_school LIKE '%$filter_secondary_school%'";}
	if((isset($_POST['filter_query_post_secondary']))AND($_POST['filter_query_post_secondary']!=""))
		{if(($_POST['filter_query_name']!="")OR($_POST['filter_query_location']!="")OR($_POST['filter_query_primary_school']!="")OR($_POST['filter_query_secondary_school']!="")){$and=" AND ";}
		$filter_post_secondary=preg_replace('#[^a-z A-Z -]#i','',$_POST['filter_query_post_secondary']);
		$filter_query_post_secondary=$and."post_secondary LIKE '%$filter_post_secondary%'";}
	if((isset($_POST['filter_query_employer']))AND($_POST['filter_query_employer']!=""))
		{if(($_POST['filter_query_name']!="")OR($_POST['filter_query_location']!="")OR($_POST['filter_query_primary_school']!="")OR($_POST['filter_query_secondary_school']!="")OR($_POST['filter_query_post_secondary']!="")){$and=" AND ";}
		$filter_employer=preg_replace('#[^a-z A-Z -]#i','',$_POST['filter_query_employer']);
		$filter_query_employer=$and."employer LIKE '%$filter_employer%'";}
	if ($FF_array=="") 
		{$mysql_query="SELECT id, firstname, lastname, location, primary_school, secondary_school, post_secondary, friend_array, family_array FROM members WHERE email_activated='1' AND delete_member='1' AND id!='$ids' 
		AND ($filter_query_name $filter_query_location $filter_query_primary_school $filter_query_secondary_school $filter_query_post_secondary $filter_query_employer) ORDER BY id DESC LIMIT ".$number.",20";}
	else 
		{$mysql_query="SELECT id, firstname, lastname, location, primary_school, secondary_school, post_secondary, friend_array, family_array FROM members WHERE email_activated='1' AND delete_member='1' AND (id NOT IN ($FFArray2)) AND id!='$ids' 
		AND ($filter_query_name $filter_query_location $filter_query_primary_school $filter_query_secondary_school $filter_query_post_secondary $filter_query_employer) ORDER BY id DESC LIMIT ".$number.",20";}
	$mysql_name=mysql_query($mysql_query);
	$numRows=mysql_num_rows($mysql_name);
	
	if ($FF_array=="") 
		{$mysql_number="SELECT id, firstname, lastname, location, primary_school, secondary_school, post_secondary, friend_array, family_array FROM members WHERE email_activated='1' AND delete_member='1' AND id!='$ids' 
		AND ($filter_query_name $filter_query_location $filter_query_primary_school $filter_query_secondary_school $filter_query_post_secondary $filter_query_employer)";}
	else
		{$mysql_number="SELECT id, firstname, lastname, location, primary_school, secondary_school, post_secondary, friend_array, family_array FROM members WHERE email_activated='1' AND delete_member='1' AND (id NOT IN ($FFArray2)) AND id!='$ids' 
		AND ($filter_query_name $filter_query_location $filter_query_primary_school $filter_query_secondary_school $filter_query_post_secondary $filter_query_employer)";}
	$mysql_number=mysql_query($mysql_number);
	$mysql_number=mysql_num_rows($mysql_number);
	if ($mysql_number!=1) {$result_s="Results";}
		else {$result_s="Result";}
		$list_friends="<a href='#' onclick='return false' class='bold'>".$mysql_number." ".$result_s."</a>";
		
	if (($number=="0")AND($numRows>0))				
 		{$MemberDisplayList.= "<div class='bar_wrap'><div class='body_bars'>
							<div class='float_left'><img src='barterrain_friends_images/blank.gif' class='find_friends_bar'/><span class='heading_list'>Find Friends</span></div>
							<div class='float_right'>".$list_friends."</div>
						</div></div>";}
	else if (($number=="0")AND($numRows<1))				
 		{$MemberDisplayList.= "<div class='bar_wrap'><div class='body_bars'>
							<div class='float_left'><img src='barterrain_friends_images/blank.gif' class='find_friends_bar'/><span class='heading_list'>Find Friends</span></div>
							<div class='float_right'>".$list_friends."</div>
						</div></div>";}
	
	if($numRows>=1)
		{while ($row = mysql_fetch_array($mysql_name))
			{$person_location = "";
			$person_secondary_school = $row['secondary_school'];
			$person_post_secondary = "";
			$person_id = $row['id'];
			$person_firstname = $row['firstname'];
			$person_lastname = $row['lastname'];
			$person_location = $row['location'];
			$person_secondary_school = $row['secondary_school'];
			$person_post_secondary = $row['post_secondary'];
			$person_friend_array = $row['friend_array'];
			$person_family_array = $row['family_array'];
			
			$check_pic="../user_files/user$person_id/profile_thumb.jpg";
			$default_pic="../user_files/user0/default_profile_pic_thumb.png";
			if (file_exists($check_pic)){$user_pic="<img src='$check_pic?$cacheBuster' width='75px' class='thumb_background'/>";}
			else {$user_pic="<img src='$default_pic' width='75px' class='thumb_background' />";}
		
		if($person_post_secondary!==""){$place=$person_post_secondary;}
		else if($person_secondary_school!==""){$place=$person_secondary_school;}
		else if($person_location!==""){$place=$person_location;}
		else {$place="";}
		if(($person_friend_array!=="")AND($person_family_array!==""))
			{$FF_person_array=$person_friend_array.",".$person_family_array;}
		else if($person_family_array!==""){$FF_person_array=$person_family_array;}
		else if($person_friend_array!==""){$FF_person_array=$person_friend_array;}
		else {$FF_person_array="";}
		$FFpersonArray = explode(",",$FF_person_array);
		$FFpersonArray = array_intersect($FFpersonArray, $FFArray);
		$FFpersonArray_json_encode = json_encode($FFpersonArray);
		$FFArray_count=count($FFpersonArray);
		if ($FFArray_count!=1) {$mf_s="Friends";}
		else {$mf_s="Friend";}
		
		if ((empty($FFpersonArray))OR($FF_person_array=="")OR($FF_array=="")) {$FFArray_count="0";}
	else {$FFArray_count="<a title='Display Mutual Friends' href='#' onclick='return false' onmousedown='javascript:display_mutual_FF(".$id.",".$ids.",".$FFpersonArray_json_encode.");' class='bold display_button'>".$FFArray_count."</a>";}
		
		$MemberDisplayList.= "<div class='friend_wrap3'><div class='friend_request_1'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$person_id."'>".$user_pic."</a></div>
				<div class='friend_request_2'>
					<a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$person_id."'><b>".$person_firstname." ".$person_lastname."</b></a>
					<span class='places'>".$place."</span>
					<span>You Both Have ".$FFArray_count." Mutual ".$mf_s."</span><br/>
					<span id='request".$person_id."'>
						<a href='#' class='bar_link' onclick='return false' onmousedown='javascript:addAsFriend(".$ids.",".$person_id.");' >Add Friend</a>
					</span><span class='dot_divider'> &middot;</span>
						<a href='../messages/messages.php?message_id=".$person_id."' class='bar_link'>Message</a>
				</div></div>";
			}
		}
	}
else {
if ($FF_array=="") {$mysql = mysql_query("SELECT * FROM members WHERE email_activated='1' AND delete_member='1' AND id!='$ids'
					ORDER BY id DESC LIMIT ".$number.",20");}
else {$mysql = mysql_query("SELECT * FROM members WHERE email_activated='1' AND delete_member='1' AND (id NOT IN ($FFArray2)) AND id!='$ids'
					ORDER BY id DESC LIMIT ".$number.",20");}
$numRows=mysql_num_rows($mysql);
	
if (($number=="0")AND($numRows>0))			
 	{$MemberDisplayList.= "<div class='bar_wrap'><div class='body_bars'><img src='barterrain_friends_images/blank.gif' class='find_friends_bar'/><span class='heading_list'>Find Friends</span></div></div>";}
					
while($row = mysql_fetch_array($mysql))
	{$person_id = $row['id'];
	$person_firstname = $row['firstname'];
	$person_lastname = $row['lastname'];
	$person_location = $row['location'];
	$person_secondary_school = $row['secondary_school'];
	$person_post_secondary = $row['post_secondary'];
	$person_friend_array=$row['friend_array'];
	$person_family_array=$row['family_array'];
	$check_pic="../user_files/user$person_id/profile_thumb.jpg";
	$default_pic="../user_files/user0/default_profile_pic_thumb.png";
	if (file_exists($check_pic))
		{$user_pic="<img src='$check_pic?$cacheBuster' width='75px' class='thumb_background'/>";}
	else
		{$user_pic="<img src='$default_pic' width='75px' class='thumb_background' />";}

	if($person_post_secondary!==""){$place=$person_post_secondary;}
	else if($person_secondary_school!==""){$place=$person_secondary_school;}
	else if($person_location!==""){$place=$person_location;}
	else {$place="";}
	if(($person_friend_array!=="")AND($person_family_array!==""))
		{$FF_person_array=$person_friend_array.",".$person_family_array;}
	else if($person_family_array!==""){$FF_person_array=$person_family_array;}
	else if($person_friend_array!==""){$FF_person_array=$person_friend_array;}
	else {$FF_person_array="";}
	$FFpersonArray = explode(",",$FF_person_array);
	$FFpersonArray = array_intersect($FFpersonArray, $FFArray);
	$FFpersonArray_json_encode = json_encode($FFpersonArray);
	$FFArray_count=count($FFpersonArray);
	if ($FFArray_count!=1) {$mf_s="Friends";}
	else {$mf_s="Friend";}
	
	if ((empty($FFpersonArray))OR($FF_person_array=="")OR($FF_array=="")) {$FFArray_count="0";}
	else {$FFArray_count="<a title='Display Mutual Friends' href='#' onclick='return false' onmousedown='javascript:display_mutual_FF(".$id.",".$ids.",".$FFpersonArray_json_encode.");' class='bold display_button'>".$FFArray_count."</a>";}
		
	$MemberDisplayList.= "<div class='friend_wrap3'><div class='friend_request_1'><a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$person_id."'>".$user_pic."</a></div>
				<div class='friend_request_2'>
					<a class='profile_link' href='http://www.barterrain.com/profile/profile.php?id=".$person_id."'><b>".$person_firstname." ".$person_lastname."</b></a>
					<span class='places'>".$place."</span>
					<span>You Both Have ".$FFArray_count." Mutual ".$mf_s."</span><br/>
					<span id='request".$person_id."'>
						<a href='#' class='bar_link' onclick='return false' onmousedown='javascript:addAsFriend(".$ids.",".$person_id.");' >Add Friend</a>
					</span><span class='dot_divider'> &middot;</span>
						<a href='../messages/messages.php?message_id=".$person_id."' class='bar_link'>Message</a>
				</div></div>";
	}
}

echo $MemberDisplayList;
$number=$number+20;
?>
<script type="text/javascript">
// Add more Content at end of page
var id = "<?php echo $id; ?>";
var ids = "<?php echo $ids; ?>";
var number = "<?php echo $number; ?>";
var numRows = "<?php echo $numRows; ?>";
var filter_query_name = "<?php echo $filter_name; ?>";
var filter_query_location = "<?php echo $filter_location; ?>";
var filter_query_primary_school = "<?php echo $filter_primary_school; ?>";
var filter_query_secondary_school = "<?php echo $filter_secondary_school; ?>";
var filter_query_post_secondary = "<?php echo $filter_post_secondary; ?>";
var filter_query_employer = "<?php echo $filter_employer; ?>";
$(window).data('ajaxready1', true).scroll(function(e)
	{if ($(window).data('ajaxready1') == false) return;
	if($(window).scrollTop()>=$("#bottom_find_friends").height()-$(document).height())
		{$("div#expand_bottom_find_friends").hide();
		$("div#load_content_scroll").show();
		$(window).data('ajaxready1', false);
		$.ajax({cache: false,url:"find_friends_content.php?number="+number+"&id="+id+"&ids="+ids+"&filter_query_name="+filter_query_name+"&filter_query_location="+filter_query_location+"&filter_query_primary_school="+filter_query_primary_school+"&filter_query_secondary_school="+filter_query_secondary_school+"&filter_query_post_secondary="+filter_query_post_secondary+"&filter_query_employer="+filter_query_employer,
			success:function(html)
				{if(html){$("#bottom_find_friends").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_find_friends").show();}
				 $(window).data('ajaxready1', true);}
			});
		}
	});
	
$(document).ready(function()
{$("div#expand_bottom_find_friends").click(function(){
	{if ($(window).data('ajaxready1') == false) return;
	$("div#expand_bottom_find_friends").hide();
	$("div#load_content_scroll").show();
	$(window).data('ajaxready1', false);
	$.ajax({cache: false,url:"find_friends_content.php?number="+number+"&id="+id+"&ids="+ids+"&filter_query_name="+filter_query_name+"&filter_query_location="+filter_query_location+"&filter_query_primary_school="+filter_query_primary_school+"&filter_query_secondary_school="+filter_query_secondary_school+"&filter_query_post_secondary="+filter_query_post_secondary+"&filter_query_employer="+filter_query_employer,
			success:function(html)
				{if(html){$("#bottom_find_friends").append(html);$("div#load_content_scroll").hide();$("div#expand_bottom_find_friends").show();}
				 $(window).data('ajaxready1', true);}
			});
		}
	});
});
</script>