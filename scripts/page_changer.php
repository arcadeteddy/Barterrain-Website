<?php
session_start();
include "../config.php";

if((!isset($_SESSION['id']))AND(!isset($_SESSION['ids'])))
	{header("Location: http://www.barterrain.com/settings/logout.php");exit();}

// Search Pages
if ($_POST["page"] == "search_window_1")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$search = $_POST['search_box'];
	$search_tab = mysql_query("UPDATE members_log SET search_tab='1' WHERE id='$ids'"); 
	include_once "../search/search_profiles.php";exit();}
if ($_POST["page"] == "search_window_2")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$search = $_POST['search_box'];
	$search_tab = mysql_query("UPDATE members_log SET search_tab='2' WHERE id='$ids'");
	include_once "../search/search_planets.php";exit();}
if ($_POST["page"] == "search_window_11")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$search = $_POST['search_box'];
	include_once "../search/search_profiles_posts.php";exit();}
if ($_POST["page"] == "search_window_12")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$search = $_POST['search_box'];
	include_once "../search/search_profiles_albums.php";exit();}
if ($_POST["page"] == "search_window_13")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$search = $_POST['search_box'];
	include_once "../search/search_profiles_games.php";exit();}
if ($_POST["page"] == "search_window_14")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$search = $_POST['search_box'];
	include_once "../search/search_profiles_videos.php";exit();}
if ($_POST["page"] == "search_window_15")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$search = $_POST['search_box'];
	include_once "../search/search_profiles_notes.php";exit();}
if ($_POST["page"] == "search_window_16")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$search = $_POST['search_box'];
	include_once "../search/search_profiles_profiles.php";exit();}
if ($_POST["page"] == "search_window_21")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$search = $_POST['search_box'];
	include_once "../search/search_planets_posts.php";exit();}
if ($_POST["page"] == "search_window_22")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$search = $_POST['search_box'];
	include_once "../search/search_planets_albums.php";exit();}
if ($_POST["page"] == "search_window_23")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$search = $_POST['search_box'];
	include_once "../search/search_planets_games.php";exit();}
if ($_POST["page"] == "search_window_24")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$search = $_POST['search_box'];
	include_once "../search/search_planets_videos.php";exit();}
if ($_POST["page"] == "search_window_25")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$search = $_POST['search_box'];
	include_once "../search/search_planets_notes.php";exit();}
if ($_POST["page"] == "search_window_26")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$search = $_POST['search_box'];
	include_once "../search/search_planets_planets.php";exit();}

// Inside Pages
if ($_POST["page"] == "inside_window_1")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../inside/news.php";exit();}
if ($_POST["page"] == "inside_window_2")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../inside/media.php";exit();}
if ($_POST["page"] == "inside_window_3")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../inside/notes.php";exit();}
if ($_POST["page"] == "inside_window_8")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../inside/planets.php";exit();}
if ($_POST["page"] == "inside_window_9")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../inside/family.php";exit();}
if ($_POST["page"] == "inside_window_10")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../inside/subscriptions.php";exit();}
	
// Side Bar Changes
if ($_POST["page"] == "planets_changer")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$planets_id = $_POST['planets_id'];
	include_once "../inside/planets.php";exit();}
if ($_POST["page"] == "subscriptions_changer")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$subscriptions_id = $_POST['subscriptions_id'];
	include_once "../inside/subscriptions.php";exit();}
if ($_POST["page"] == "family_changer")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$family_id = $_POST['family_id'];
	include_once "../inside/family.php";exit();}

// Profile Pages
if ($_POST["page"] == "profile_window_1")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../profile/info.php";exit();}
if ($_POST["page"] == "profile_window_2")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../profile/wall.php";exit();}
if ($_POST["page"] == "profile_window_3")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../profile/media.php";exit();}
if ($_POST["page"] == "profile_window_4")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../profile/notes.php";exit();}
if ($_POST["page"] == "profile_window_5")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../profile/subscriptions.php";exit();}
if ($_POST["page"] == "profile_window_6")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../profile/friends.php";exit();}
if ($_POST["page"] == "profile_window_7")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../profile/memory_box.php";exit();}
if ($_POST["page"] == "profile_window_8")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../profile/planets.php";exit();}

// Friends Pages	
if ($_POST["page"] == "friends_window_1")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../friends/find_friends.php";exit();}
if ($_POST["page"] == "friends_window_2")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../friends/invite_friends.php";exit();}
if ($_POST["page"] == "friends_window_3")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../friends/all_friends.php";exit();}
	
// Profile Media Opener
if ($_POST["page"] == "album_opener")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$album_id = $_POST['album_id'];
	include_once "../profile/view_album.php";exit();}
if ($_POST["page"] == "video_opener")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$video_id = $_POST['video_id'];
	include_once "../profile/view_video.php";exit();}
if ($_POST["page"] == "game_opener")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$game_id = $_POST['game_id'];
	include_once "../profile/view_game.php";exit();}
	
// Planet Pages
if ($_POST["page"] == "planet_window_1")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$idp = $_POST['id'];
	include_once "../planet/planet_info.php";exit();}
if ($_POST["page"] == "planet_window_2")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$idp = $_POST['id'];
	include_once "../planet/planet_wall.php";exit();}
if ($_POST["page"] == "planet_window_3")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$idp = $_POST['id'];
	include_once "../planet/planet_media.php";exit();}
if ($_POST["page"] == "planet_window_4")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$idp = $_POST['id'];
	include_once "../planet/planet_notes.php";exit();}
if ($_POST["page"] == "planet_window_5")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$idp = $_POST['id'];
	include_once "../planet/planet_members.php";exit();}
if ($_POST["page"] == "planet_window_6")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$idp = $_POST['id'];
	include_once "../planet/planet_memory_box.php";exit();}
if ($_POST["page"] == "planet_window_7")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$idp = $_POST['id'];
	include_once "../planet/planet_planets.php";exit();}
if ($_POST["page"] == "planet_window_8")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$idp = $_POST['id'];
	include_once "../planet/planet_member_posts.php";exit();}
	
// Planet Media Opener
if ($_POST["page"] == "planet_album_opener")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$idp = $_POST['id'];
	$album_id = $_POST['album_id'];
	include_once "../planet/planet_view_album.php";exit();}
if ($_POST["page"] == "planet_video_opener")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$idp = $_POST['id'];
	$video_id = $_POST['video_id'];
	include_once "../planet/planet_view_video.php";exit();}
if ($_POST["page"] == "planet_game_opener")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$idp = $_POST['id'];
	$game_id = $_POST['game_id'];
	include_once "../planet/planet_view_game.php";exit();}
	
// Planets Pages
if ($_POST["page"] == "planets_window_1")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$planets_tab = mysql_query("UPDATE members_log SET planets_tab='1' WHERE id='$ids'"); 
	include_once "../planets/planets_popular_recent.php";exit();}
if ($_POST["page"] == "planets_window_2")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$planets_tab = mysql_query("UPDATE members_log SET planets_tab='2' WHERE id='$ids'");
	include_once "../planets/planets_popular.php";exit();}
if ($_POST["page"] == "planets_window_3")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$planets_tab = mysql_query("UPDATE members_log SET planets_tab='3' WHERE id='$ids'");
	include_once "../planets/planets_recent.php";exit();}
if ($_POST["page"] == "planets_window_11")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$planets_tab = mysql_query("UPDATE members_log SET planets_tab='1' WHERE id='$ids'"); 
	include_once "../planets/planets_popular_recent_albums.php";exit();}
if ($_POST["page"] == "planets_window_12")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$planets_tab = mysql_query("UPDATE members_log SET planets_tab='1' WHERE id='$ids'"); 
	include_once "../planets/planets_popular_recent_games.php";exit();}
if ($_POST["page"] == "planets_window_13")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$planets_tab = mysql_query("UPDATE members_log SET planets_tab='1' WHERE id='$ids'"); 
	include_once "../planets/planets_popular_recent_videos.php";exit();}
if ($_POST["page"] == "planets_window_14")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$planets_tab = mysql_query("UPDATE members_log SET planets_tab='1' WHERE id='$ids'"); 
	include_once "../planets/planets_popular_recent_planets.php";exit();}
if ($_POST["page"] == "planets_window_21")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$planets_tab = mysql_query("UPDATE members_log SET planets_tab='2' WHERE id='$ids'"); 
	include_once "../planets/planets_popular_recent_albums.php";exit();}
if ($_POST["page"] == "planets_window_22")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$planets_tab = mysql_query("UPDATE members_log SET planets_tab='2' WHERE id='$ids'"); 
	include_once "../planets/planets_popular_recent_games.php";exit();}
if ($_POST["page"] == "planets_window_23")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$planets_tab = mysql_query("UPDATE members_log SET planets_tab='2' WHERE id='$ids'"); 
	include_once "../planets/planets_popular_recent_videos.php";exit();}
if ($_POST["page"] == "planets_window_24")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$planets_tab = mysql_query("UPDATE members_log SET planets_tab='2' WHERE id='$ids'"); 
	include_once "../planets/planets_popular_recent_planets.php";exit();}
if ($_POST["page"] == "planets_window_31")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$planets_tab = mysql_query("UPDATE members_log SET planets_tab='3' WHERE id='$ids'"); 
	include_once "../planets/planets_popular_recent_albums.php";exit();}
if ($_POST["page"] == "planets_window_32")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$planets_tab = mysql_query("UPDATE members_log SET planets_tab='3' WHERE id='$ids'"); 
	include_once "../planets/planets_popular_recent_games.php";exit();}
if ($_POST["page"] == "planets_window_33")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$planets_tab = mysql_query("UPDATE members_log SET planets_tab='3' WHERE id='$ids'"); 
	include_once "../planets/planets_popular_recent_videos.php";exit();}
if ($_POST["page"] == "planets_window_34")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	$planets_tab = mysql_query("UPDATE members_log SET planets_tab='3' WHERE id='$ids'"); 
	include_once "../planets/planets_popular_recent_planets.php";exit();}


// Points Pages
if ($_POST["page"] == "points_window_1")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../points/profile_transactions.php";exit();}
if ($_POST["page"] == "points_window_2")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../points/planet_transactions.php";exit();}
if ($_POST["page"] == "points_window_3")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../points/point_totals.php";exit();}

// Notifications Pages
if ($_POST["page"] == "notifications_window_1")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../notifications/all_notifications.php";exit();}
if ($_POST["page"] == "notifications_window_2")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../notifications/birthday_notifications.php";exit();}
if ($_POST["page"] == "notifications_window_3")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../notifications/new_reminder.php";exit();}

// Settings Pages
if ($_POST["page"] == "settings_window_1")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../settings/profile_settings.php";exit();}
if ($_POST["page"] == "settings_window_2")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../settings/circles_settings.php";exit();}
if ($_POST["page"] == "settings_window_3")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../settings/planet_settings.php";exit();}
if ($_POST["page"] == "settings_window_4")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../settings/economy_settings.php";exit();}
if ($_POST["page"] == "settings_window_5")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../settings/notification_settings.php";exit();}
if ($_POST["page"] == "settings_window_6")
	{$ids = $_POST['ids'];
	$id = $_POST['id'];
	include_once "../settings/security_settings.php";exit();}
?>