<?php
ob_start();
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}

include_once "../scripts/check_login.php";
ob_flush();

$mysql_points = mysql_query("SELECT * FROM point_totals WHERE id=$ids");
while($row = mysql_fetch_array($mysql_points))
	{$profile_posts_plus = $row['profile_posts_plus'];
	$profile_posts_minus = $row['profile_posts_minus'];
	$profile_notes_plus = $row['profile_notes_plus'];
	$profile_notes_minus = $row['profile_notes_minus'];
	$profile_albums_plus = $row['profile_albums_plus'];
	$profile_albums_minus = $row['profile_albums_minus'];
	$profile_images_plus = $row['profile_images_plus'];
	$profile_images_minus = $row['profile_images_minus'];
	$profile_videos_plus = $row['profile_videos_plus'];
	$profile_videos_minus = $row['profile_videos_minus'];
	$profile_games_plus = $row['profile_games_plus'];
	$profile_games_minus = $row['profile_games_minus'];
	$profile_albums_posts_plus = $row['profile_albums_posts_plus'];
	$profile_albums_posts_minus = $row['profile_albums_posts_minus'];
	$profile_images_posts_plus = $row['profile_images_posts_plus'];
	$profile_images_posts_minus = $row['profile_images_posts_minus'];
	$profile_videos_posts_plus = $row['profile_videos_posts_plus'];
	$profile_videos_posts_minus = $row['profile_videos_posts_minus'];
	$profile_games_posts_plus = $row['profile_games_posts_plus'];
	$profile_games_posts_minus = $row['profile_games_posts_minus'];
	$profile_planets_plus = $row['profile_planets_plus'];
	$profile_planets_minus = $row['profile_planets_minus'];
	
	$planets_posts_plus = $row['planets_posts_plus'];
	$planets_posts_minus = $row['planets_posts_minus'];
	$planets_member_posts_plus = $row['planets_member_posts_plus'];
	$planets_member_posts_minus = $row['planets_member_posts_minus'];
	$planets_notes_plus = $row['planets_notes_plus'];
	$planets_notes_minus = $row['planets_notes_minus'];
	$planets_albums_plus = $row['planets_albums_plus'];
	$planets_albums_minus = $row['planets_albums_minus'];
	$planets_images_plus = $row['planets_images_plus'];
	$planets_images_minus = $row['planets_images_minus'];
	$planets_videos_plus = $row['planets_videos_plus'];
	$planets_videos_minus = $row['planets_videos_minus'];
	$planets_games_plus = $row['planets_games_plus'];
	$planets_games_minus = $row['planets_games_minus'];
	$planets_albums_posts_plus = $row['planets_albums_posts_plus'];
	$planets_albums_posts_minus = $row['planets_albums_posts_minus'];
	$planets_images_posts_plus = $row['planets_images_posts_plus'];
	$planets_images_posts_minus = $row['planets_images_posts_minus'];
	$planets_videos_posts_plus = $row['planets_videos_posts_plus'];
	$planets_videos_posts_minus = $row['planets_videos_posts_minus'];
	$planets_games_posts_plus = $row['planets_games_posts_plus'];
	$planets_games_posts_minus = $row['planets_games_posts_minus'];
	$planets_link_creates_plus = $row['planets_link_creates_plus'];
	$planets_link_creates_minus = $row['planets_link_creates_minus'];}
	
$mysql_points = mysql_query("SELECT * FROM point_totals_comments WHERE id=$ids");
while($row = mysql_fetch_array($mysql_points))
	{$profile_posts_plus_comments = $row['profile_posts_plus'];
	$profile_posts_minus_comments = $row['profile_posts_minus'];
	$profile_notes_plus_comments = $row['profile_notes_plus'];
	$profile_notes_minus_comments = $row['profile_notes_minus'];
	$profile_albums_plus_comments = $row['profile_albums_plus'];
	$profile_albums_minus_comments = $row['profile_albums_minus'];
	$profile_images_plus_comments = $row['profile_images_plus'];
	$profile_images_minus_comments = $row['profile_images_minus'];
	$profile_videos_plus_comments = $row['profile_videos_plus'];
	$profile_videos_minus_comments = $row['profile_videos_minus'];
	$profile_games_plus_comments = $row['profile_games_plus'];
	$profile_games_minus_comments = $row['profile_games_minus'];
	$profile_albums_posts_plus_comments = $row['profile_albums_posts_plus'];
	$profile_albums_posts_minus_comments = $row['profile_albums_posts_minus'];
	$profile_images_posts_plus_comments = $row['profile_images_posts_plus'];
	$profile_images_posts_minus_comments = $row['profile_images_posts_minus'];
	$profile_videos_posts_plus_comments = $row['profile_videos_posts_plus'];
	$profile_videos_posts_minus_comments = $row['profile_videos_posts_minus'];
	$profile_games_posts_plus_comments = $row['profile_games_posts_plus'];
	$profile_games_posts_minus_comments = $row['profile_games_posts_minus'];
	$profile_planets_plus_comments = $row['profile_planets_plus'];
	$profile_planets_minus_comments = $row['profile_planets_minus'];
	
	$planets_posts_plus_comments = $row['planets_posts_plus'];
	$planets_posts_minus_comments = $row['planets_posts_minus'];
	$planets_member_posts_plus_comments = $row['planets_member_posts_plus'];
	$planets_member_posts_minus_comments = $row['planets_member_posts_minus'];
	$planets_notes_plus_comments = $row['planets_notes_plus'];
	$planets_notes_minus_comments = $row['planets_notes_minus'];
	$planets_albums_plus_comments = $row['planets_albums_plus'];
	$planets_albums_minus_comments = $row['planets_albums_minus'];
	$planets_images_plus_comments = $row['planets_images_plus'];
	$planets_images_minus_comments = $row['planets_images_minus'];
	$planets_videos_plus_comments = $row['planets_videos_plus'];
	$planets_videos_minus_comments = $row['planets_videos_minus'];
	$planets_games_plus_comments = $row['planets_games_plus'];
	$planets_games_minus_comments = $row['planets_games_minus'];
	$planets_albums_posts_plus_comments = $row['planets_albums_posts_plus'];
	$planets_albums_posts_minus_comments = $row['planets_albums_posts_minus'];
	$planets_images_posts_plus_comments = $row['planets_images_posts_plus'];
	$planets_images_posts_minus_comments = $row['planets_images_posts_minus'];
	$planets_videos_posts_plus_comments = $row['planets_videos_posts_plus'];
	$planets_videos_posts_minus_comments = $row['planets_videos_posts_minus'];
	$planets_games_posts_plus_comments = $row['planets_games_posts_plus'];
	$planets_games_posts_minus_comments = $row['planets_games_posts_minus'];
	$planets_link_creates_plus_comments = $row['planets_link_creates_plus'];
	$planets_link_creates_minus_comments = $row['planets_link_creates_minus'];}
	
$mysql_points = mysql_query("SELECT * FROM point_totals_economy WHERE id=$ids");
while($row = mysql_fetch_array($mysql_points))
	{$daily_points_plus = $row['daily_points_plus'];
	$daily_points_minus = $row['daily_points_minus'];
	$invite_plus = $row['invite_plus'];
	$invite_minus = $row['invite_minus'];}
	
		// POSTS
			$profile_posts_plus_total=$profile_posts_plus+$profile_posts_plus_comments;
			$profile_posts_minus_total=$profile_posts_minus+$profile_posts_minus_comments;
			$planets_posts_plus_total=$planets_posts_plus+$planets_posts_plus_comments;
			$planets_posts_minus_total=$planets_posts_minus+$planets_posts_minus_comments;
			$planets_member_posts_plus_total=$planets_member_posts_plus+$planets_member_posts_plus_comments;
			$planets_member_posts_minus_total=$planets_member_posts_minus+$planets_member_posts_minus_comments;
			
			$profile_albums_posts_plus_total=$profile_albums_posts_plus+$profile_albums_posts_plus_comments;
			$profile_albums_posts_minus_total=$profile_albums_posts_minus+$profile_albums_posts_minus_comments;
			$planets_albums_posts_plus_total=$planets_albums_posts_plus+$planets_albums_posts_plus_comments;
			$planets_albums_posts_minus_total=$planets_albums_posts_minus+$planets_albums_posts_minus_comments;
			
			$profile_images_posts_plus_total=$profile_images_posts_plus+$profile_images_posts_plus_comments;
			$profile_images_posts_minus_total=$profile_images_posts_minus+$profile_images_posts_minus_comments;
			$planets_images_posts_plus_total=$planets_images_posts_plus+$planets_images_posts_plus_comments;
			$planets_images_posts_minus_total=$planets_images_posts_minus+$planets_images_posts_minus_comments;
			
			$profile_videos_posts_plus_total=$profile_videos_posts_plus+$profile_videos_posts_plus_comments;
			$profile_videos_posts_minus_total=$profile_videos_posts_minus+$profile_videos_posts_minus_comments;
			$planets_videos_posts_plus_total=$planets_videos_posts_plus+$planets_videos_posts_plus_comments;
			$planets_videos_posts_minus_total=$planets_videos_posts_minus+$planets_videos_posts_minus_comments;
			
			$profile_games_posts_plus_total=$profile_games_posts_plus+$profile_games_posts_plus_comments;
			$profile_games_posts_minus_total=$profile_games_posts_minus+$profile_games_posts_minus_comments;
			$planets_games_posts_plus_total=$planets_games_posts_plus+$planets_games_posts_plus_comments;
			$planets_games_posts_minus_total=$planets_games_posts_minus+$planets_games_posts_minus_comments;
			
			$profile_posts_plus_final_total=$profile_posts_plus_total+$profile_albums_posts_plus_total+$profile_images_posts_plus_total+$profile_videos_posts_plus_total+$profile_games_posts_plus_total;
			$profile_posts_minus_final_total=$profile_posts_minus_total+$profile_albums_posts_minus_total+$profile_images_posts_minus_total+$profile_videos_posts_minus_total+$profile_games_posts_minus_total;
			$planets_posts_plus_final_total=$planets_posts_plus_total+$planets_member_posts_plus_total+$planets_albums_posts_plus_total+$planets_images_posts_plus_total+$planets_videos_posts_plus_total+$planets_games_posts_plus_total;
			$planets_posts_minus_final_total=$planets_posts_minus_total+$planets_member_posts_minus_total+$planets_albums_posts_minus_total+$planets_images_posts_minus_total+$planets_videos_posts_minus_total+$planets_games_posts_minus_total;
			
			$posts_plus_total=$profile_posts_plus_final_total+$planets_posts_plus_final_total;
			$posts_minus_total=$profile_posts_minus_final_total+$planets_posts_minus_final_total;
			$posts_total=$posts_plus_total+$posts_minus_total;
			$list_number="1";
			$posts_table="";
        	
			if ($posts_total!=0)
        		{$posts_table .= "<div class='bar_wrap'>
				<div class='points_bars'><img src='blank.gif' width='1px' height='1px' class='posts_lists'/><span class='heading_list'>Posts</span></div>
       			<div class='plus_minus_bars'><span class='heading_list_pm'>&#8722; &#5528;</span></div>
        		<div class='plus_minus_bars'><span class='heading_list_pm'>+ &#5528;</span></div>
				</div>";
				if ($profile_posts_plus+$profile_posts_minus!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Posts Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_posts_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_posts_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_posts_plus_comments+$profile_posts_minus_comments!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Posts Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_posts_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_posts_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_albums_posts_plus+$profile_albums_posts_minus!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Album Posts Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_albums_posts_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_albums_posts_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_albums_posts_plus_comments+$profile_albums_posts_minus_comments!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Album Posts Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_albums_posts_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_albums_posts_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_images_posts_plus+$profile_images_posts_minus!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Image Posts Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_images_posts_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_images_posts_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_images_posts_plus_comments+$profile_images_posts_minus_comments!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Image Posts Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_images_posts_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_images_posts_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_videos_posts_plus+$profile_videos_posts_minus!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Video Posts Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_videos_posts_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_videos_posts_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_videos_posts_plus_comments+$profile_videos_posts_minus_comments!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Video Posts Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_videos_posts_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_videos_posts_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_games_posts_plus+$profile_games_posts_minus!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Game Posts Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_games_posts_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_games_posts_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_games_posts_plus_comments+$profile_games_posts_minus_comments!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Game Posts Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_games_posts_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_games_posts_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_posts_plus_final_total+$profile_posts_minus_final_total!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Total Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_posts_minus_final_total."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_posts_plus_final_total."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
					
				if ($planets_posts_minus+$planets_posts_plus!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Posts Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_posts_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_posts_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_posts_plus_comments+$planets_posts_minus_comments!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Posts Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_posts_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_posts_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_member_posts_minus+$planets_member_posts_plus!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Member Posts Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_member_posts_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_member_posts_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_member_posts_plus_comments+$planets_member_posts_minus_comments!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Member Posts Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_member_posts_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_member_posts_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_albums_posts_plus+$planets_albums_posts_minus!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Album Posts Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_albums_posts_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_albums_posts_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_albums_posts_plus_comments+$planets_albums_posts_minus_comments!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Album Posts Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_albums_posts_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_albums_posts_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_images_posts_plus+$planets_images_posts_minus!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Image Posts Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_images_posts_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_images_posts_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_images_posts_plus_comments+$planets_images_posts_minus_comments!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Image Posts Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_images_posts_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_images_posts_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_videos_posts_plus+$planets_videos_posts_minus!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Video Posts Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_videos_posts_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_videos_posts_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_videos_posts_plus_comments+$planets_videos_posts_minus_comments!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Video Posts Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_videos_posts_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_videos_posts_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_games_posts_plus+$planets_games_posts_minus!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Game Posts Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_games_posts_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_games_posts_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_games_posts_plus_comments+$planets_games_posts_minus_comments!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Game Posts Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_games_posts_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_games_posts_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_posts_plus_final_total+$planets_posts_minus_final_total!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Total Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_posts_minus_final_total."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_posts_plus_final_total."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				
				
				if ($posts_plus_total+$posts_minus_total!=0) 
					{$posts_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Total</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$posts_minus_total."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$posts_plus_total."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}

				$posts_table .= "<div class='points_bars_end'></div>";}
        
		// MEDIA
			$profile_albums_plus_total=$profile_albums_plus+$profile_albums_plus_comments;
			$profile_albums_minus_total=$profile_albums_minus+$profile_albums_minus_comments;
			$planets_albums_plus_total=$planets_albums_plus+$planets_albums_plus_comments;
			$planets_albums_minus_total=$planets_albums_minus+$planets_albums_minus_comments;
			$albums_plus_total=$profile_albums_plus_total+$planets_albums_plus_total;
			$albums_minus_total=$profile_albums_minus_total+$planets_albums_minus_total;
			
			$profile_images_plus_total=$profile_images_plus+$profile_images_plus_comments;
			$profile_images_minus_total=$profile_images_minus+$profile_images_minus_comments;
			$planets_images_plus_total=$planets_images_plus+$planets_images_plus_comments;
			$planets_images_minus_total=$planets_images_minus+$planets_images_minus_comments;
			$images_plus_total=$profile_images_plus_total+$planets_images_plus_total;
			$images_minus_total=$profile_images_minus_total+$planets_images_minus_total;
			
			$profile_games_plus_total=$profile_games_plus+$profile_games_plus_comments;
			$profile_games_minus_total=$profile_games_minus+$profile_games_minus_comments;
			$planets_games_plus_total=$planets_games_plus+$planets_games_plus_comments;
			$planets_games_minus_total=$planets_games_minus+$planets_games_minus_comments;
			$games_plus_total=$profile_games_plus_total+$planets_games_plus_total;
			$games_minus_total=$profile_games_minus_total+$planets_games_minus_total;
			
			$profile_videos_plus_total=$profile_videos_plus+$profile_videos_plus_comments;
			$profile_videos_minus_total=$profile_videos_minus+$profile_videos_minus_comments;
			$planets_videos_plus_total=$planets_videos_plus+$planets_videos_plus_comments;
			$planets_videos_minus_total=$planets_videos_minus+$planets_videos_minus_comments;
			$videos_plus_total=$profile_videos_plus_total+$planets_videos_plus_total;
			$videos_minus_total=$profile_videos_minus_total+$planets_videos_minus_total;
			
			$profile_media_plus_total=$profile_games_plus_total+$profile_albums_plus_total+$profile_images_plus_total+$profile_videos_plus_total;
			$profile_media_minus_total=$profile_games_minus_total+$profile_albums_minus_total+$profile_images_minus_total+$profile_videos_minus_total;
			$planets_media_plus_total=$planets_games_plus_total+$planets_albums_plus_total+$planets_images_plus_total+$planets_videos_plus_total;
			$planets_media_minus_total=$planets_games_minus_total+$planets_albums_minus_total+$planets_images_minus_total+$planets_videos_minus_total;
			
			$media_plus_total=$games_plus_total+$albums_plus_total+$images_plus_total+$videos_plus_total;
			$media_minus_total=$games_minus_total+$albums_minus_total+$images_minus_total+$videos_minus_total;
			$media_total=$media_plus_total+$media_minus_total;
			$list_number="1";
			$media_table="";
        	
        	if ($media_total!=0)
        		{$media_table .= "<div class='bar_wrap'>
				<div class='points_bars'><span class='heading_list'><img src='blank.gif' width='1px' height='1px' class='media_lists'/>Media</span></div>
       			<div class='plus_minus_bars'><span class='heading_list_pm'>&#8722; &#5528;</span></div>
        		<div class='plus_minus_bars'><span class='heading_list_pm'>+ &#5528;</span></div>
				</div>";
				if ($profile_albums_plus+$profile_albums_minus!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Albums Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_albums_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_albums_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_albums_plus_comments+$profile_albums_minus_comments!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Albums Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_albums_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_albums_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_images_plus+$profile_images_minus!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Images Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_images_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_images_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_images_plus_comments+$profile_images_minus_comments!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Images Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_images_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_images_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_videos_plus+$profile_videos_minus!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Videos Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_videos_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_videos_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_videos_plus_comments+$profile_videos_minus_comments!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Videos Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_videos_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_videos_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_games_plus+$profile_games_minus!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Games Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_games_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_games_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_games_plus_comments+$profile_games_minus_comments!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Games Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_games_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_games_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_media_plus_total+$profile_media_minus_total!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Total Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_media_minus_total."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_media_plus_total."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				
				if ($planets_albums_plus+$planets_albums_minus!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Albums Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_albums_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_albums_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_albums_plus_comments+$planets_albums_minus_comments!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Albums Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_albums_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_albums_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_images_plus+$planets_images_minus!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Images Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_images_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_images_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_images_plus_comments+$planets_images_minus_comments!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Images Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_images_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_images_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_videos_plus+$planets_videos_minus!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Videos Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_videos_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_videos_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_videos_plus_comments+$planets_videos_minus_comments!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Videos Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_videos_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_videos_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_videos_plus+$planets_videos_minus!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Games Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_games_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_games_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_games_plus_comments+$planets_games_minus_comments!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Games Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_games_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_games_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_media_plus_total+$planets_media_minus_total!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Total Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_media_minus_total."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_media_plus_total."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
					
				if ($media_plus_total+$media_minus_total!=0) 
					{$media_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Total</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$media_minus_total."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$media_plus_total."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
					
				$media_table .= "<div class='points_bars_end'></div>";}
				
		// NOTES
			$profile_notes_plus_total=$profile_notes_plus+$profile_notes_plus_comments;
			$profile_notes_minus_total=$profile_notes_minus+$profile_notes_minus_comments;
			$planets_notes_plus_total=$planets_notes_plus+$planets_notes_plus_comments;
			$planets_notes_minus_total=$planets_notes_minus+$planets_notes_minus_comments;
			
			$notes_plus_total=$profile_notes_plus_total+$planets_notes_plus_total;
			$notes_minus_total=$profile_notes_minus_total+$planets_notes_minus_total;
			$notes_total=$notes_plus_total+$notes_minus_total;
			$list_number="1";
			$notes_table="";
			
        	if ($notes_total!=0)
        		{$notes_table .= "<div class='bar_wrap'>
				<div class='points_bars'><span class='heading_list'><img src='blank.gif' width='1px' height='1px' class='notes_lists'/>Notes</span></div>
       			<div class='plus_minus_bars'><span class='heading_list_pm'>&#8722; &#5528;</span></div>
        		<div class='plus_minus_bars'><span class='heading_list_pm'>+ &#5528;</span></div>
				</div>";
				if ($profile_notes_plus+$profile_notes_minus!=0) 
					{$notes_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Notes Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_notes_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_notes_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_notes_plus_comments+$profile_notes_minus_comments!=0) 
					{$notes_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Notes Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_notes_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_notes_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_notes_plus_total+$profile_notes_minus_total!=0) 
					{$notes_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Total Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_notes_minus_total."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_notes_plus_total."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
					
				if ($planets_notes_plus+$planets_notes_minus!=0) 
					{$notes_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Notes Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_notes_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_notes_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_notes_plus_comments+$planets_notes_minus_comments!=0) 
					{$notes_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Notes Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_notes_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_notes_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_notes_plus_total+$planets_notes_minus_total!=0) 
					{$notes_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Total Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_notes_minus_total."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_notes_plus_total."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
					
				if ($notes_plus_total+$notes_minus_total!=0) 
					{$notes_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Total</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$notes_minus_total."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$notes_plus_total."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				
				$notes_table .= "<div class='points_bars_end'></div>";}
				
		// CREATES
			$profile_planets_plus_total=$profile_planets_plus+$profile_planets_plus_comments;
			$profile_planets_minus_total=$profile_planets_minus+$profile_planets_minus_comments;
			$planets_link_creates_plus_total=$planets_link_creates_plus+$planets_link_creates_plus_comments;
			$planets_link_creates_minus_total=$planets_link_creates_minus+$planets_link_creates_minus_comments;
			
			$profile_creates_plus_total=$profile_planets_plus_total;
			$profile_creates_minus_total=$profile_planets_minus_total;
			$planets_creates_plus_total=$planets_link_creates_plus_total;
			$planets_creates_minus_total=$planets_link_creates_minus_total;
			
			$creates_plus_total=$profile_planets_plus_total+$planets_link_creates_plus_total;
			$creates_minus_total=$profile_planets_minus_total+$planets_link_creates_minus_total;
			$creates_total=$creates_plus_total+$creates_minus_total;
			$list_number="1";
			$creates_table="";
        	
        	if ($creates_total!=0)
        		{$creates_table .= "<div class='bar_wrap'>
				<div class='points_bars'><span class='heading_list'><img src='blank.gif' width='1px' height='1px' class='creates_lists'/>Creates</span></div>
       			<div class='plus_minus_bars'><span class='heading_list_pm'>&#8722; &#5528;</span></div>
        		<div class='plus_minus_bars'><span class='heading_list_pm'>+ &#5528;</span></div>
				</div>";
				if ($profile_planets_plus+$profile_planets_minus!=0) 
					{$creates_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Planet Creations Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_planets_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_planets_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_planets_plus_comments+$profile_planets_minus_comments!=0) 
					{$creates_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On planet Creations Within Profiles</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_planets_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_planets_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($profile_creates_plus_total+$profile_creates_minus_total!=0) 
					{$creates_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Total Within Profile</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_creates_minus_total."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$profile_creates_plus_total."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
					
				if ($planets_link_creates_plus+$planets_link_creates_minus!=0) 
					{$creates_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Link Creations Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_link_creates_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_link_creates_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_link_creates_plus_comments+$planets_link_creates_minus_comments!=0) 
					{$creates_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Comments On Link Creations Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_link_creates_minus_comments."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_link_creates_plus_comments."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($planets_creates_plus_total+$planets_creates_minus_total!=0) 
					{$creates_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Total Within Planets</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_creates_minus_total."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$planets_creates_plus_total."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				
				if ($creates_plus_total+$creates_minus_total!=0) 
					{$creates_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Total</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$creates_minus_total."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$creates_plus_total."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
					
				$creates_table .= "<div class='points_bars_end'></div>";
				}
				
			$economy_plus_total=$daily_points_plus+$invite_plus;
			$economy_minus_total=$daily_points_minus+$invite_minus;
			$economy_total=$economy_plus_total+$economy_minus_total;
			$list_number="1";
			$economy_table="";
			
        	if ($economy_total!=0)
        		{$economy_table .= "<div class='bar_wrap'>
				<div class='points_bars'><span class='heading_list'><img src='blank.gif' width='1px' height='1px' class='economy_lists'/>Economy</span></div>
       			<div class='plus_minus_bars'><span class='heading_list_pm'>&#8722; &#5528;</span></div>
        		<div class='plus_minus_bars'><span class='heading_list_pm'>+ &#5528;</span></div>
				</div>";
				if ($daily_points_plus+$daily_points_minus!=0) 
					{$economy_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Daily Points</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$daily_points_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$daily_points_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($invite_plus+$invite_minus!=0) 
					{$economy_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Invited Friends</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$invite_minus."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$invite_plus."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				if ($economy_plus_total+$economy_minus_total!=0) 
					{$economy_table .= "<div class='points_list_".$list_number."'><span class='list_span'>Total</span></div>
					<div class='points_list_pm_".$list_number."'><span class='list_span'>".$economy_minus_total."</span></div>
        			<div class='points_list_pm_".$list_number."'><span class='list_span'>".$economy_plus_total."</span></div>";if ($list_number=="1") {$list_number="2";} else {$list_number="1";}}
				
				$economy_table .= "<div class='points_bars_end'></div>";
				}
?>

<body>
<div class="margin"></div>
<div class="points_sub_body" id="points_sub_body">
	<div class="bottom_point_totals" id="bottom_point_totals">
		<?php echo $posts_table;
			echo $media_table;
			echo $notes_table;
			echo $creates_table;
			echo $economy_table;
			if (($posts_table=="")AND($media_table=="")AND($creates_table=="")AND($notes_table=="")AND($economy_table==""))
				{echo "<div class='nothing'><span class='nothing'>No Point Totals</span></div>";}
		?>
	</div>
</div>
</body>