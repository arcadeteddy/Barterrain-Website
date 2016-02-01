<?php
session_start();
include "../config.php";
include_once ("../scripts/time_ago_format.php");
$myObject = new time_ago_format;

if((!isset($_SESSION['id']))AND(!isset($_SESSION['ids'])))
	{header("Location: http://www.barterrain.com/settings/logout.php");exit();}

$cacheBuster = rand(9999999,99999999999);
$PostsDisplayList ="";
$ids = $_SESSION['ids'];

///////////////// OPTION BOX POINT - ITEM /////////////////
if ($_POST["interactive"] == "point1")
	{$ids=$_POST['ids'];
	$item_id=$_POST['item_id'];
	$item_type=$_POST['item_type'];
	$typex=$_POST['typex'];
	if($item_type=="link_creates"){$mysql = mysql_query("SELECT point_array FROM link_creates WHERE id='$item_id' LIMIT 1");}
	else{$mysql = mysql_query("SELECT point_array FROM ".$typex."_".$item_type." WHERE id='$item_id' LIMIT 1");}
	while ($row = mysql_fetch_array ($mysql))
		{$point_array_post = $row['point_array'];
		$pointArray_post = explode(",",$point_array_post);
		$point_array_count_post = count($pointArray_post);
		$point_array_count_post = $point_array_count_post*10;
		if($point_array_post==""){$point_array_count_post="0";}}
	$item_type= json_encode($item_type);
	echo "<a href='#' title='Give Points For Awesomeness!' class='point2' onclick='return false' onmousedown='javascript:point2(".$ids.",".$item_id.",".$item_type.");'></a><b class='point'>".$point_array_count_post."</b>";
	exit();}
	
///////////////// OPTION BOX DELETE - FOLDER /////////////////
if ($_POST["interactive"] == "delete_folder1")
	{$item_id=$_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type= json_encode($item_type);
	echo "<a href='#' title='Delete' class='top_options_delete2' onclick='return false' onmousedown='javascript:delete_folder2(".$item_id.",".$item_type.");'></a>";
	exit();}
///////////////// OPTION BOX DELETE - IMAGE /////////////////
if ($_POST["interactive"] == "delete_image1")
	{$item_id=$_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type= json_encode($item_type);
	echo "<a href='#' title='Delete' class='top_options_delete2' onclick='return false' onmousedown='javascript:delete_image2(".$item_id.",".$item_type.");'></a>";
	exit();}
///////////////// OPTION BOX DELETE - MEDIA /////////////////
if ($_POST["interactive"] == "delete_media1")
	{$item_id=$_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type= json_encode($item_type);
	echo "<a href='#' title='Delete' class='top_options_delete2' onclick='return false' onmousedown='javascript:delete_media2(".$item_id.",".$item_type.");'></a>";
	exit();}
///////////////// OPTION BOX DELETE - POST /////////////////
if ($_POST["interactive"] == "delete_post1")
	{$post_id=$_POST['post_id'];
	echo "<a href='#' title='Delete Post' class='delete2' onclick='return false' onmousedown='javascript:delete_post2(".$post_id.");'></a>";
	exit();}
///////////////// OPTION BOX DELETE - POST /////////////////
if ($_POST["interactive"] == "delete_member_post1")
	{$post_id=$_POST['post_id'];
	echo "<a href='#' title='Delete Post' class='delete2' onclick='return false' onmousedown='javascript:delete_member_post2(".$post_id.");'></a>";
	exit();}
///////////////// OPTION BOX DELETE - NOTE /////////////////
if ($_POST["interactive"] == "delete_note1")
	{$note_id=$_POST['note_id'];
	echo "<a href='#' title='Delete Note' class='delete2' onclick='return false' onmousedown='javascript:delete_note2(".$note_id.");'></a>";
	exit();}
///////////////// OPTION BOX DELETE - ITEM /////////////////
if ($_POST["interactive"] == "delete_item1")
	{$item_id=$_POST['item_id'];
	$item_type=$_POST['item_type'];
	$item_type= json_encode($item_type);
	echo "<a href='#' title='Delete From Wall' class='delete2' onclick='return false' onmousedown='javascript:delete_item2(".$item_id.",".$item_type.");'></a>";
	exit();}

// UNCHANGED BOXES
if ($_POST["interactive"] == "media_post")
	{echo '<div class="bottom_half_box2"><form class="post_form" action="javascript:media_post_form()" method="post" type="multipart/form-data" name="media_post_form" id="media_post_form">
			<textarea class="post_field" name="post_field" id="post_field" placeholder="Post Something..."></textarea>
			<div class="bottom_box_input">	
				<div class="bottom_box_input1">
					<input class="radio" type="radio" name="post_type" id="post_type" value="a" checked="checked"/> Both
					<input type="radio" name="post_type" id="post_type" value="b" /> Members
					<input type="radio" name="post_type" id="post_type" value="c" /> Admins
				</div>
				<div class="bottom_box_input2"><input src="blank.gif" type="image" name="post" class="post_button"/></div>
			</div></form></div>';exit();
	}
	
	
if ($_POST["interactive"] == "image_post")
	{echo '<div class="bottom_half_box2"><form class="post_form" action="javascript:image_post_form()" method="post" type="multipart/form-data" name="image_post_form">
			<textarea class="post_field" name="image_post_field" id="image_post_field" placeholder="Post Something..."></textarea>
			<div class="bottom_box_input">	
				<div class="bottom_box_input1">
					<input class="radio" type="radio" name="post_type" id="post_type" value="a" checked="checked"/> Both
					<input type="radio" name="post_type" id="post_type" value="b" /> Members
					<input type="radio" name="post_type" id="post_type" value="c" /> Admins
				</div>
				<div class="bottom_box_input2"><input src="blank.gif" type="image" name="post" class="post_button"/></div>
			</div></form></div>';exit();
	}
	
//////////////////// UPLOADING CHOICES ////////////////////
if ($_POST["interactive"] == "upload")
	{echo '<div id="bottom_half_box3"><div class="bottom_half_box3">
	<a href="#" src="blank.gif" class="upload_choice_images" onclick="return false" onmousedown="javascript:UploadImages();"></a>
	<a href="#" src="blank.gif" class="upload_choice_videos" onclick="return false" onmousedown="javascript:UploadVideos();"></a>
	<a href="#" src="blank.gif" class="upload_choice_gifs" onclick="return false" onmousedown="javascript:UploadGifs();"></a>
	<a href="#" src="blank.gif" class="upload_choice_games" onclick="return false" onmousedown="javascript:UploadGames();"></a>
	</div></div>';exit();}
	
// NEW OR OLD ALBUM CHOICE
if ($_POST["interactive"] == "add_new_album")
	{echo '	<input class="upload_field" name="upload_name" id="upload_name" placeholder="Album Name..." maxlength="128"/>
	<textarea class="upload_field" name="upload_field" id="upload_field" rows="3" placeholder="Album Description..." maxlength="250"></textarea>
	<input name="member_album_active" type="hidden" value="a"/>';exit();}
	if ($_POST["interactive"] == "add_new_member_album")
	{echo '	<input class="upload_field" name="upload_name" id="upload_name" placeholder="Member Album Name..." maxlength="128"/>
	<textarea class="upload_field" name="upload_field" id="upload_field" rows="3" placeholder="Member Album Description..." maxlength="250"></textarea>
	<input name="member_album_active" type="hidden" value="b"/>';exit();}
if ($_POST["interactive"] == "remove_new_album")
	{echo '';exit();}
	
// UPLOADING IMAGES //
if ($_POST["interactive"] == "images")
	{$id=$_POST["id"];
	$ids=$_POST["ids"];
	$type=$_POST["type"];
	$existing_albums="";
	$mysql = mysql_query("SELECT id, album_name FROM ".$type."_albums WHERE user_page_id=$id AND delete_item='1'");
	while($row = mysql_fetch_array($mysql))
	{$album_id=$row['id'];
	$album_name=$row['album_name'];
	$existing_albums .= '<option value="'.$album_id.'">'.$album_name.'</option>';}
	
	echo '<div class="bottom_half_box2">
	<form name="uploadImages_form" id="uploadImages_form" action="../scripts/create_interactive_parse.php" method="post" enctype="multipart/form-data" id="uploadForm">
	<select name="upload_images" id="upload_images" class="select_choice" onchange="javascript:add_remove_new_album();">
		<option name="member_album_active" id="member_album_active" value="a" selected="selected">New Album...</option>
		<option name="member_album_active" id="member_album_active" value="b">New Member Album...</option>
		'.$existing_albums.'
	</select>
	<div id="remove_new_album">
		<input class="upload_field" name="upload_name" id="upload_name" placeholder="Album Name..." maxlength="128"/>
		<textarea class="upload_field" name="upload_field" id="upload_field" rows="3" placeholder="Album Description..." maxlength="250"></textarea>
		<input name="member_album_active" type="hidden" value="a"/>
	</div>
	<div id="fakeupload" class="fakeupload"></div>
	<div class="upload_files3">
		<input onchange="display_pictures()"  id="upload_files" class="upload_files" type="file" size="76" name="upload_files[]" multiple="multiple" min="1" max="100"/>
	</div>
	<div class="bottom_box_input">	
		<div class="bottom_box_input1">
			<input class="radio" type="radio" name="upload_type2" id="upload_type2" value="a" checked="checked"/> Both
			<input type="radio" name="upload_type2" id="upload_type2" value="b" /> Members
			<input type="radio" name="upload_type2" id="upload_type2" value="c" /> Admins
		</div>
		<div class="bottom_box_input3"><a href="javascript:uploadImages_form();"><img src="blank.gif" name="upload" class="upload_button"/>
			<input name="id" type="hidden" value="'.$id.'"/>
			<input name="type" type="hidden" value="'.$type.'"/>
		<input name="parse_var" type="hidden" value="album_creation"/></div>
	</div></form></div>';exit();
	}
	
// UPLOADING IMAGES //
if ($_POST["interactive"] == "images2")
	{$id=$_POST["id"];
	$ids=$_POST["ids"];
	$type=$_POST["type"];
	$existing_albums="";
	$mysql = mysql_query("SELECT id, album_name FROM ".$type."_albums WHERE user_page_id=$id");
	while($row = mysql_fetch_array($mysql))
	{$album_id=$row['id'];
	$album_name=$row['album_name'];
	$existing_albums .= '<option value="'.$album_id.'">'.$album_name.'</option>';}
	
	echo '<div class="bottom_half_box2">
	<form name="uploadImages_form" id="uploadImages_form" action="../scripts/create_interactive_parse.php" method="post" enctype="multipart/form-data" id="uploadForm">
	<select name="upload_images" id="upload_images" class="select_choice" onchange="javascript:add_remove_new_album();">
		<option name="member_album_active" value="a" selected="selected">New Album...</option>
		<option name="member_album_active" value="b">New Member Album...</option>
		'.$existing_albums.'
	</select>
	<div id="remove_new_album">
		<input class="upload_field" name="upload_name" id="upload_name" placeholder="Album Name..." maxlength="128"/>
		<textarea class="upload_field" name="upload_field" id="upload_field" rows="3" placeholder="Album Description..." maxlength="250"></textarea>
		<input name="member_album_active" id="member_album_active" type="hidden" value="a"/>
	</div>
	<div id="fakeupload" class="fakeupload"></div>
	<div class="upload_files3">
		<input onchange="display_pictures()"  id="upload_files" class="upload_files" type="file" size="76" name="upload_files[]" multiple="multiple" min="1" max="100"/>
	</div>
	<div class="bottom_box_input">	
		<div class="bottom_box_input1">
			<input class="radio" type="radio" name="upload_type2" id="upload_type2" value="a" checked="checked"/> Both
			<input type="radio" name="upload_type2" id="upload_type2" value="b" /> Members
			<input type="radio" name="upload_type2" id="upload_type2" value="c" /> Admins
		</div>
		<div class="bottom_box_input3"><a href="javascript:uploadImages_form();"><img src="blank.gif" name="upload" class="upload_button"/>
			<input name="id" type="hidden" value="'.$id.'"/>
			<input name="type" type="hidden" value="'.$type.'"/>
		<input name="parse_var" type="hidden" value="album_creation"/></div>
	</div></form></div>';exit();
	}

// UPLOADING VIDEOS 
if ($_POST["interactive"] == "videos")
	{$id=$_POST["id"];
	$ids=$_POST["ids"];
	$type=$_POST["type"];
	
	echo '<div class="bottom_half_box2">
	<form name="uploadVideos_form" id="uploadVideos_form" action="../scripts/create_interactive_parse.php" method="post" enctype="multipart/form-data" id="uploadForm">
		<input class="upload_field" name="upload_name" id="upload_name" placeholder="Video Name..." maxlength="128"/>
		<textarea class="upload_field" name="upload_field" id="upload_field" rows="3" placeholder="Video Description..." maxlength="250"></textarea>
	<div id="fakeupload" class="fakeupload"></div>
	<div class="upload_files4"  style="margin-bottom:6px;">
		<input onchange="display_video()" id="upload_files" class="upload_files" type="file" size="76" name="upload_file"/>
	</div>
	<div class="upload_files2">
		<div id="fakeupload2" class="fakeupload"></div>
		<input onchange="display_picture()" id="upload_files2" class="upload_files2" type="file" size="76" name="upload_picture"/>
	</div>		
	<div class="bottom_box_input">	
		<div class="bottom_box_input1">
			<input class="radio" type="radio" name="upload_type2" id="upload_type2" value="a" checked="checked"/> Both
			<input type="radio" name="upload_type2" id="upload_type2" value="b" /> Members
			<input type="radio" name="upload_type2" id="upload_type2" value="c" /> Admins
		</div>
		<div class="bottom_box_input3"><a href="javascript:uploadVideos_form();"><img src="blank.gif" name="upload" class="upload_button"/>
			<input name="id" type="hidden" value="'.$id.'"/>
			<input name="type" type="hidden" value="'.$type.'"/>
		<input name="parse_var" type="hidden" value="video_creation"/></div>
	</div></form></div>';exit();
	}
	
// UPLOADING GIFS //
if ($_POST["interactive"] == "gifs")
	{$id=$_POST["id"];
	$ids=$_POST["ids"];
	$type=$_POST["type"];
	$existing_albums="";
	$number=1;
	$number2=5;
	$inputs="";
	$mysql = mysql_query("SELECT id, album_name FROM ".$type."_albums WHERE user_page_id=$id AND delete_item='1'");
	while($row = mysql_fetch_array($mysql))
	{$album_id=$row['id'];
	$album_name=$row['album_name'];
	$existing_albums .= '<option value="'.$album_id.'">'.$album_name.'</option>';}
	
	for ($number=1; $number<=5; $number++)
		{if (($number=="5")OR($number=="10")OR($number=="15")OR($number=="20")) {$number2="2";}
		else {$number2="5";}
		$inputs .='<div id="fakeupload'.$number.'" class="fakeupload"><font style="color:#696969;">'.$number.'</font></div>
				<div class="upload_files'.$number2.' class" >
					<input onchange="display_gifs('.$number.')"  name="upload_files'.$number.'" id="upload_files'.$number.'" class="upload_files" type="file" size="76" name="upload_picture"/>
				</div>';}
				
	echo '<div class="bottom_half_box2">
	<form name="uploadGifs_form" id="uploadGifs_form" action="../scripts/create_interactive_parse.php" method="post" enctype="multipart/form-data" id="uploadForm">
	<select name="upload_images" id="upload_images" class="select_choice" onchange="javascript:add_remove_new_album();">
		<option name="member_album_active" value="a" selected="selected">New Album...</option>
		<option name="member_album_active" value="b">New Member Album...</option> 
		'.$existing_albums.'
	</select>
	<div id="remove_new_album">
		<input class="upload_field" name="upload_name" id="upload_name" placeholder="Album Name..." maxlength="128"/>
		<textarea class="upload_field" name="upload_field" id="upload_field" rows="3" placeholder="Album Description..." maxlength="250"></textarea>
		<input name="member_album_active" id="member_album_active" type="hidden" value="a"/>
	</div>
	<select name="speed" id="speed" class="select_choice">
			<option value="1000">0.1 Frames/Second</option>
			<option value="400">0.25 Frames/Second</option>
			<option value="200">0.5 Frames/Second</option>
			<option value="100">1 Frames/Second</option>
			<option value="50">2 Frames/Second</option>
			<option value="20" selected="selected">5 Frames/Second</option>
			<option value="10">10 Frames/Second</option>
			<option value="7">15 Frames/Second</option>
			<option value="5">20 Frames/Second</option>
	</select>
	'.$inputs.'
	<div id="gif_part_2"></div>
	<div id="gif_part_3"></div>
	<div id="gif_part_4"></div>
	<div class="bottom_box_input">	
		<div class="bottom_box_input1">
			<input class="radio" type="radio" name="upload_type2" id="upload_type2" value="a" checked="checked"/> Both
			<input type="radio" name="upload_type2" id="upload_type2" value="b" /> Members
			<input type="radio" name="upload_type2" id="upload_type2" value="c" /> Admins
		</div>
		<div class="bottom_box_input3"><a href="javascript:uploadGifs_form();"><img src="blank.gif" name="upload" class="upload_button"/>
		 	<input name="id" type="hidden" value="'.$id.'"/>
			<input name="type" type="hidden" value="'.$type.'"/>
		<input name="parse_var" type="hidden" value="gif_creation"/></div>
	</div></form></div>';exit();
	}
	
// UPLOADING GAMES //
if ($_POST["interactive"] == "games")
	{$id=$_POST["id"];
	$ids=$_POST["ids"];
	$type=$_POST["type"];
	echo '<div class="bottom_half_box2">
	<form name="uploadGames_form" id="uploadGames_form" action="../scripts/create_interactive_parse.php" method="post" enctype="multipart/form-data">
		<input class="upload_field" name="upload_name" id="upload_name" placeholder="Game Name..." maxlength="128"/>
		<textarea class="upload_field" name="upload_field" id="upload_field" rows="3" placeholder="Game Description..." maxlength="250"></textarea>
		<select name="categories" id="categories" class="select_choice">
			<option value="Undefined">Choose a Category...</option>
			<option value="Action">Action</option>
			<option value="Adventure">Adventure</option>
			<option value="Multiplayer">Multiplayer</option>
			<option value="Puzzle">Puzzle</option>
			<option value="Role-Playing">Role-Playing</option>
			<option value="Simulation">Simulation</option>
			<option value="Sports">Sports</option>
			<option value="Strategy">Strategy</option>
			<option value="Other">Other</option>
		</select>
		<div class="upload_files1">
			<div id="fakeupload1" class="fakeupload"></div>
			<input onchange="display_game()" id="upload_files1" class="upload_files" type="file" size="76" name="upload_file"/>
		</div>
		<div class="upload_files2">
			<div id="fakeupload2" class="fakeupload"></div>
			<input onchange="display_picture()" id="upload_files2" class="upload_files2" type="file" size="76" name="upload_picture"/>
		</div>		
	<div class="bottom_box_input">
		<div class="bottom_box_input1">
			<input class="radio" type="radio" name="upload_type2" id="upload_type2" value="a" checked="checked"/> Both
			<input type="radio" name="upload_type2" id="upload_type2" value="b" /> Members
			<input type="radio" name="upload_type2" id="upload_type2" value="c" /> Admins
		</div>
		<div class="bottom_box_input3"><a href="javascript:uploadGames_form();"><img src="blank.gif" name="upload" class="upload_button"/></a>
			<input name="id" type="hidden" value="'.$id.'"/>
			<input name="type" type="hidden" value="'.$type.'"/>
		<input name="parse_var" type="hidden" value="game_creation"/></div>
	</div></form></div>';exit();
	}
//////////////////// UPLOADING END ////////////////////
///////////////////////////////////////////////////////
?>