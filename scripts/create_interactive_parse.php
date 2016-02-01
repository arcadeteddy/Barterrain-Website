<?php
ob_start();
session_start();
include_once "../config.php";
$ids = $_SESSION['ids'];
$file_location = $_SESSION['file_location'];
if ($file_location == "planet") {$header_location = "../planet/planet.php";}
else {$header_location = "../planet/planet.php";}

if((!isset($_SESSION['id']))AND(!isset($_SESSION['ids'])))
	{header("Location: http://www.barterrain.com/settings/logout.php");exit();}

// Section for ALBUM CREATION
if (isset($_POST['parse_var']))
{if ($_POST['parse_var'] == "album_creation")
	{$id=$_POST['id'];
	$member_album_active=$_POST['upload_images'];
	$typex=$_POST['type'];
	$typex_s=substr($typex, 0, -1);
	$upload_images=$_POST['upload_images'];
	if (($upload_images=="a")OR ($upload_images=="b"))
		{$album_name=$_POST['upload_name'];
		$album_description=$_POST['upload_field'];
		$type=$_POST['upload_type2'];
		$album_name=htmlspecialchars($album_name);
		$album_description=htmlspecialchars($album_description);
		$album_name=mysql_real_escape_string($album_name);
		$album_description=mysql_real_escape_string($album_description);
		/*$prevent_double_post1=mysql_query("SELECT id FROM albums WHERE user_id='$ids' AND upload_date between subtime(UTC_TIMESTAMP(),'0:1:0') and UTC_TIMESTAMP()");
		$numRows_prevent1=mysql_num_rows($prevent_double_post1);
		$prevent_double_post2=mysql_query("SELECT id FROM albums WHERE user_id='$ids' AND DATE(upload_date) = DATE(UTC_TIMESTAMP()) LIMIT 10");
		$numRows_prevent2=mysql_num_rows($prevent_double_post2);
		if($numRows_prevent1>0)
			{$error_message='<br/>Please wait 1 minute between each upload.<br/><br/>';}
		else if($numRows_prevent2>10)
			{$error_message='<br/>Please only upload 10 albums per day.<br/><br/>';}*/
		if(empty($album_name))
			{$error_message="Album requires a name. <br/>Please enter an album name!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
		else if(!$_FILES['upload_files']['tmp_name'][0])
			{$error_message="Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
		else
			{mysql_query("INSERT INTO ".$typex."_albums (user_page_id,user_post_id,upload_date,album_name,album_description,album_type,member_album_active) 
						VALUES ('$id','$ids',UTC_TIMESTAMP(),'$album_name','$album_description','$type','$member_album_active')");
			$album_id=mysql_insert_id();
			mkdir("../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_".mysql_insert_id());	
			mkdir("../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".mysql_insert_id());
			for ($x=0;$x<count($_FILES['upload_files']['name']);$x++)
				{$fileName =$_FILES['upload_files']['name'][$x];
				$fileTmpLoc =$_FILES['upload_files']['tmp_name'][$x];
				$fileType =$_FILES['upload_files']['type'][$x];
				$fileSize =$_FILES['upload_files']['size'][$x];
				$fileError =$_FILES['upload_files']['error'][$x];
				$fileName=preg_replace('#[^a-z.0-9_]#i','',$fileName);
				list($width, $height) = getimagesize($_FILES["upload_files"]['tmp_name'][$x]);
				$exploded_name=explode(".",$fileName); // Explodes the name into array.
				//  $fileName=time().rand().'.'.$file_ext;
				$file_ext=end($exploded_name); // Targeting first part of array.
				
			if(!$fileTmpLoc)
				{$error_message="Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
			else if ($fileSize > 10485760) // 10MB
				{$error_message = "Image Size Too Large!<br/><br/>";
				unlink ($fileTmpLoc);header("location: ".$header_location."?error_message=".$error_message);exit();}
			else if (!preg_match("/\.(gif|jpg|jpeg|png)$/i", $fileName))
				{$error_message = "Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";
				unlink ($fileTmpLoc);header("location: ".$header_location."?error_message=".$error_message);exit();}
			else if ($fileError ==1)
				{$error_message = "Error Occured! Please Try Again Later.<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
			else {$success_message="";
				mysql_query("INSERT INTO ".$typex."_images (user_page_id,user_post_id,album_id,upload_date,image_type,ext) VALUES ('$id','$ids','$album_id',UTC_TIMESTAMP(),'$type','$file_ext')");
				$image_id=mysql_insert_id();
		
				$mysql_image_array = mysql_query("SELECT image_array FROM ".$typex."_albums WHERE id='$album_id' LIMIT 1");
				while ($row=mysql_fetch_array($mysql_image_array))
					{$image_array = $row['image_array'];}
				$imageArray = explode(",",$image_array);
				if(in_array($image_id, $imageArray))
					{$success_message = "";header("location: ".$header_location."");exit();}
				if ($image_array !== "")
					{$image_array = "$image_array,$image_id";}
				else {$image_array = "$image_id";}
				$UpdateArray = mysql_query("UPDATE ".$typex."_albums SET image_array='$image_array' WHERE id='$album_id'") or die (mysql_error());
		
				$newname= $typex_s."_album_".$album_id."_pic_".$image_id.".".$file_ext."";
				$newname_thumb= $typex_s."_album_".$album_id."_thumb_".$image_id.".jpg";
				$newname_cover= $typex_s."_album_".$album_id."_cover.jpg";
				$newname_cover2= $typex_s."_album_".$album_id."_cover2.jpg";
				$place_files = move_uploaded_file ($fileTmpLoc, "../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_".$album_id."/".$newname);
				include_once "../scripts/image_functions.php";
				// Picture Thumb
				$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_".$album_id."/".$newname;
				$resized_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_thumb;
				if($width>=$height)
					{$wmax=8686;$hmax=215;}
				else if($width<=$height)
					{$wmax=215;$hmax=8686;}
				img_resize($target_file,$resized_file,$wmax,$hmax,$file_ext);
				$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_thumb;
				$thumbnail="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_thumb;
					$wthumb=215;$hthumb=215;
				thumb_img_resize($target_file,$thumbnail,$wthumb,$hthumb,$file_ext);}
				}
			$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_thumb;
			$thumbnail="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_cover2;
				$wthumb=215;$hthumb=138;
			thumb_img_resize($target_file,$thumbnail,$wthumb,$hthumb,$file_ext);
			$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_thumb;
			$thumbnail="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_cover;
				$wthumb=215;$hthumb=215;
			thumb_img_resize($target_file,$thumbnail,$wthumb,$hthumb,$file_ext);
			}
		}
		
	else if (($upload_images!=="a")OR($upload_images!=="b"))
		{$image_array2="";
		$album_id=$_POST['upload_images'];
		$type=$_POST['upload_type2'];
		$images_count=count($_FILES['upload_files']['name']);
		/*$prevent_double_post1=mysql_query("SELECT id FROM images_walls WHERE user_id='$ids' AND upload_date between subtime(UTC_TIMESTAMP(),'0:1:0') and UTC_TIMESTAMP()");
		$numRows_prevent1=mysql_num_rows($prevent_double_post1);
		if($numRows_prevent1>0)
			{$error_message='<br/>Please wait 1 minute between each upload.<br/><br/>';}*/
		if(!$_FILES['upload_files']['tmp_name'][0])
			{$error_message="Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
		else
			{for ($x=0;$x<$images_count;$x++)
				{$mysql_image_array = mysql_query("SELECT id,image_array,album_name FROM ".$typex."_albums WHERE id='$album_id' LIMIT 1");
				$numRows = mysql_num_rows($mysql_image_array);
				if (empty($album_id))
					{$error_message = "Album requires a name. <br/>Please enter an album name!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
				else if ($numRows < 1)
					{$error_message = "Album no longer exists. <br/>Please try another album!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
				$fileName =$_FILES['upload_files']['name'][$x];
				$fileTmpLoc =$_FILES['upload_files']['tmp_name'][$x];
				$fileType =$_FILES['upload_files']['type'][$x];
				$fileSize =$_FILES['upload_files']['size'][$x];
				$fileError =$_FILES['upload_files']['error'][$x];
				list($width, $height) = getimagesize($_FILES["upload_files"]['tmp_name'][$x]);
				$fileName=preg_replace('#[^a-z.0-9_]#i','',$fileName);
				$exploded_name=explode(".",$fileName); // Explodes the name into array.
				//  $fileName=time().rand().'.'.$file_ext;
				$file_ext=end($exploded_name); // Targeting first part of array.
				
			if(!$fileTmpLoc)
				{$error_message="Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
			else if ($fileSize > 10485760) // 10MB
				{$error_message = "Image Size Too Large!<br/><br/>";
				unlink ($fileTmpLoc);header("location: ".$header_location."?error_message=".$error_message);exit();}
			else if (!preg_match("/\.(gif|jpg|jpeg|png)$/i", $fileName))
				{$error_message = "Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";
				unlink ($fileTmpLoc);header("location: ".$header_location."?error_message=".$error_message);exit();}
			else if ($fileError ==1)
				{$error_message = "Error Occured! Please Try Again Later.<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
			else{$image_array="";
				$success_message="";
				mysql_query("INSERT INTO ".$typex."_images (user_page_id,user_post_id,album_id,upload_date,image_type,ext) VALUES ('$id','$ids','$album_id',UTC_TIMESTAMP(),'$type','$file_ext')");
				$image_id=mysql_insert_id();
				while ($row=mysql_fetch_array($mysql_image_array))
					{$image_array = $row['image_array'];
					$album_name = $row['album_name'];}
				$imageArray = explode(",",$image_array);
				if(in_array($image_id, $imageArray))
					{$success_message = "";header("location: ".$header_location."");exit();}
				if ($image_array!="")
					{$image_array="$image_array,$image_id";}
				else {$image_array="$image_id";}
				if ($image_array2!="")
					{$image_array2="$image_array2,$image_id";}
				else {$image_array2="$image_id";}
				$UpdateArray = mysql_query("UPDATE ".$typex."_albums SET image_array='$image_array' WHERE id='$album_id'") or die (mysql_error());
		
				$newname= $typex_s."_album_".$album_id."_pic_".$image_id.".".$file_ext."";
				$newname_thumb= $typex_s."_album_".$album_id."_thumb_".$image_id.".jpg";
				$newname_cover= $typex_s."_album_".$album_id."_cover.jpg";
				$newname_cover2= $typex_s."_album_".$album_id."_cover2.jpg";
				$place_files = move_uploaded_file ($fileTmpLoc, "../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_".$album_id."/".$newname);
				include_once "../scripts/image_functions.php";
				// Picture Thumb
				$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_".$album_id."/".$newname;
				$resized_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_thumb;
				if($width>=$height)
					{$wmax=8686;$hmax=215;}
				else if($width<=$height)
					{$wmax=215;$hmax=8686;}
				img_resize($target_file,$resized_file,$wmax,$hmax,$file_ext);
				$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_thumb;
				$thumbnail="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_thumb;
					$wthumb=215;$hthumb=215;
				thumb_img_resize($target_file,$thumbnail,$wthumb,$hthumb,$file_ext);}
				}
			$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_thumb;
			$thumbnail="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_cover2;
				$wthumb=215;$hthumb=138;
			thumb_img_resize($target_file,$thumbnail,$wthumb,$hthumb,$file_ext);
			$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_thumb;
			$thumbnail="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_cover;
				$wthumb=215;$hthumb=215;
			thumb_img_resize($target_file,$thumbnail,$wthumb,$hthumb,$file_ext);
			$mysql_last=mysql_query("SELECT id, upload_date, album_id, images FROM ".$typex."_images_walls WHERE user_post_id='$ids' AND album_id='$album_id' AND upload_date>DATE_SUB(UTC_TIMESTAMP(),INTERVAL 72 HOUR) ORDER BY upload_date DESC LIMIT 1");
			$numRows=mysql_num_rows($mysql_last);
		
			if($numRows>0)
				{while ($row=mysql_fetch_array($mysql_last))
					{$images_walls_id=$row['id'];
					$album_id_last=$row['album_id'];
					$images_array_last=$row['images'];}
				if ($images_array_last!=""){$images_array_last="$images_array_last,$image_array2";}
				else {$images_array_last="$image_array2";}
				mysql_query("UPDATE ".$typex."_images_walls SET images='$images_array_last',upload_date=UTC_TIMESTAMP(),union_type='images_walls' WHERE id='$images_walls_id' AND album_id='$album_id'");}
			else {mysql_query("INSERT INTO ".$typex."_images_walls (user_page_id,user_post_id,album_id,album_name,upload_date,images,images_wall_type) 
							VALUES ('$id','$ids','$album_id','$album_name',UTC_TIMESTAMP(),'$image_array2','$type')");}
			}
		}
	header("location: ".$header_location."?id=".$id);exit();}
	
// Gif Creation
if ($_POST['parse_var'] == "gif_creation")
	{$id=$_POST['id'];
	$member_album_active=$_POST['member_album_active'];
	$typex=$_POST['type'];
	$typex_s=substr($typex, 0, -1);
	$upload_images=$_POST['upload_images'];
	if (($upload_images=="a")OR($upload_images=="b"))
		{$album_name=$_POST['upload_name'];
		$album_description=$_POST['upload_field'];
		$type=$_POST['upload_type2'];
		$speed=$_POST['speed'];
		$album_name=htmlspecialchars($album_name);
		$album_description=htmlspecialchars($album_description);
		$album_name=mysql_real_escape_string($album_name);
		$album_description=mysql_real_escape_string($album_description);
		/*$prevent_double_post1=mysql_query("SELECT id FROM albums WHERE user_id='$ids' AND upload_date between subtime(UTC_TIMESTAMP(),'0:1:0') and UTC_TIMESTAMP()");
		$numRows_prevent1=mysql_num_rows($prevent_double_post1);
		$prevent_double_post2=mysql_query("SELECT id FROM albums WHERE user_id='$ids' AND DATE(upload_date) = DATE(UTC_TIMESTAMP()) LIMIT 10");
		$numRows_prevent2=mysql_num_rows($prevent_double_post2);
		if($numRows_prevent1>0)
			{$error_message='<br/>Please wait 1 minute between each upload.<br/><br/>';}
		else if($numRows_prevent2>10)
			{$error_message='<br/>Please only upload 10 albums per day.<br/><br/>';}*/
		if(empty($album_name))
			{$error_message="Album requires a name. <br/>Please enter an album name!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
		else if((!$_FILES['upload_files1']['tmp_name'])OR(!$_FILES['upload_files2']['tmp_name'])OR(!$_FILES['upload_files3']['tmp_name']))
			{$error_message="Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
		else
			{mysql_query("INSERT INTO ".$typex."_albums (user_page_id,user_post_id,upload_date,album_name,album_description,album_type,member_album_active) 
						VALUES ('$id','$ids',UTC_TIMESTAMP(),'$album_name','$album_description','$type','$member_album_active')");
			$album_id=mysql_insert_id();
			mkdir("../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_".mysql_insert_id());	
			mkdir("../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".mysql_insert_id());		
			include_once ("../scripts/image_functions.php");
			include_once("../scripts/GIFEncoder.class.php");
			for ($x=1;$x<=20;$x++)
				{if(!isset($_FILES['upload_files'.$x]['tmp_name']))
					{$error_message="Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";}
				else if(!preg_match("/\.(gif|jpg|jpeg|png)$/i", $_FILES['upload_files'.$x]['name']))
					{$error_message="Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";}
				else
				{$fileName =$_FILES['upload_files'.$x]['name'];
				$fileTmpLoc =$_FILES['upload_files'.$x]['tmp_name'];
				$fileType =$_FILES['upload_files'.$x]['type'];
				$fileSize =$_FILES['upload_files'.$x]['size'];
				$fileError =$_FILES['upload_files'.$x]['error'];
				$fileName=preg_replace('#[^a-z.0-9_]#i','',$fileName);
				list($width, $height) = getimagesize($fileTmpLoc);
				$exploded_name=explode(".",$fileName); // Explodes the name into array.
				//  $fileName=time().rand().'.'.$file_ext;
				$file_ext=end($exploded_name); // Targeting first part of array.
				
				if ($fileSize > 10485760) // 10MB
					{$error_message = "Image Size Too Large!<br/><br/>";
					unlink ($fileTmpLoc);header("location: ".$header_location."?error_message=".$error_message);exit();}
				else if ($fileError ==1)
					{$error_message = "Error Occured! Please Try Again Later.<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
				else {$newname= "tmp_".$x.".".$file_ext;
					$newname2= "tmp_".$x.".png";
					$place_files=move_uploaded_file($fileTmpLoc, "../".$typex_s."_files/".$typex_s."$id/tmp_folder/".$newname);
				// Picture Picture
					$target_file="../".$typex_s."_files/".$typex_s."$id/tmp_folder/".$newname;
					$resized_file="../".$typex_s."_files/".$typex_s."$id/tmp_folder/".$newname;
					if($width>=$height)
						{$wmax=8686;$hmax=800;}
					else if($width<=$height)
						{$wmax=800;$hmax=8686;}
					img_resize($target_file,$resized_file,$wmax,$hmax,$file_ext);
					$target_file="../".$typex_s."_files/".$typex_s."$id/tmp_folder/".$newname;
					$thumbnail="../".$typex_s."_files/".$typex_s."$id/tmp_folder/".$newname;
					if($width>=$height)
						{$wthumb=800;$hthumb=800;}
					else if($width<=$height)
						{$wthumb=800;$hthumb=800;}
					thumb_img_resize($target_file,$thumbnail,$wthumb,$hthumb,$file_ext);
					
				// Convert to PNG
					$target_file="../".$typex_s."_files/".$typex_s."$id/tmp_folder/".$newname;
					$newcopy="../".$typex_s."_files/".$typex_s."$id/tmp_folder/".$newname2;
					convert_to_png($target_file,$newcopy,$file_ext);
					
					$image=imagecreatefrompng("../".$typex_s."_files/".$typex_s."$id/tmp_folder/".$newname2);
					ob_start();
					imagegif($image);
					$frames[]=ob_get_contents();
					$framed[]=$speed; // Delay in the animation.
					ob_end_clean();
					}
				}}
			mysql_query("INSERT INTO ".$typex."_images (user_page_id,user_post_id,album_id,upload_date,image_type,ext) VALUES ('$id','$ids','$album_id',UTC_TIMESTAMP(),'$type','gif')");
			$image_id=mysql_insert_id();
			$mysql_image_array = mysql_query("SELECT id,image_array,album_name FROM ".$typex."_albums WHERE id='$album_id' LIMIT 1");
			while ($row=mysql_fetch_array($mysql_image_array))
				{$image_array = $row['image_array'];}
				
			$newname= $typex_s."_album_".$album_id."_pic_".$image_id.".gif";
			$newname2= $typex_s."_album_".$album_id."_thumb_".$image_id.".gif";
			$newname_thumb= $typex_s."_album_".$album_id."_thumb_".$image_id.".jpg";
			$newname_cover= $typex_s."_album_".$album_id."_cover.jpg";
			$newname_cover2= $typex_s."_album_".$album_id."_cover2.jpg";				
			
			$gif = new GIFEncoder($frames,$framed,0,2,0,0,0,'bin');
			$fp = fopen('../'.$typex_s.'_files/'.$typex_s.''.$id.'/'.$typex_s.'_album_'.$album_id.'/'.$newname, 'w');
			fwrite($fp, $gif->GetAnimation());
			fclose($fp);
			
		// Picture Thumb
			$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_".$album_id."/".$newname;
			$resized_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname2;
			if($width>=$height)
				{$wmax=8686;$hmax=215;}
			else if($width<=$height)
				{$wmax=215;$hmax=8686;}
			img_resize($target_file,$resized_file,$wmax,$hmax,'gif');
			$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname2;
			$thumbnail="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_thumb;
			$wthumb=215;$hthumb=215;
			thumb_img_resize2($target_file,$thumbnail,$wthumb,$hthumb,'gif');
			$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_thumb;
			$thumbnail="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_cover2;
				$wthumb=215;$hthumb=138;
			thumb_img_resize2($target_file,$thumbnail,$wthumb,$hthumb,'jpg');
			$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_thumb;
			$thumbnail="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_cover;
				$wthumb=215;$hthumb=215;
			thumb_img_resize2($target_file,$thumbnail,$wthumb,$hthumb,'jpg');
			
			$UpdateArray = mysql_query("UPDATE ".$typex."_albums SET image_array='$image_id' WHERE id='$album_id'") or die (mysql_error());
			}
		}		
	else if (($upload_images!=="a")OR($upload_images!=="b"))
		{$image_array2="";
		$album_id=$_POST['upload_images'];
		$type=$_POST['upload_type2'];
		$speed=$_POST['speed'];
		/*$prevent_double_post1=mysql_query("SELECT id FROM images_walls WHERE user_id='$ids' AND upload_date between subtime(UTC_TIMESTAMP(),'0:1:0') and UTC_TIMESTAMP()");
		$numRows_prevent1=mysql_num_rows($prevent_double_post1);
		if($numRows_prevent1>0)
			{$error_message='<br/>Please wait 1 minute between each upload.<br/><br/>';}*/
		if((!$_FILES['upload_files1']['tmp_name'])OR(!$_FILES['upload_files2']['tmp_name'])OR(!$_FILES['upload_files3']['tmp_name']))
			{$error_message="Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
		else{include_once ("../scripts/image_functions.php");
			include_once("../scripts/GIFEncoder.class.php");
			$mysql_image_array = mysql_query("SELECT id,image_array,album_name FROM ".$typex."_albums WHERE id='$album_id' LIMIT 1");
			$numRows = mysql_num_rows($mysql_image_array);
			if (empty($album_id))
				{$error_message="Album requires a name. <br/>Please enter an album name!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
			else if ($numRows < 1)
				{$error_message = "Album no longer exists. <br/>Please try another album!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
			else {for ($x=1;$x<=20;$x++)
				{if(!isset($_FILES['upload_files'.$x]['tmp_name']))
					{$error_message="Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";}
				else if(!preg_match("/\.(gif|jpg|jpeg|png)$/i", $_FILES['upload_files'.$x]['name']))
					{$error_message="Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";}
				else{$fileName =$_FILES['upload_files'.$x]['name'];
						$fileTmpLoc =$_FILES['upload_files'.$x]['tmp_name'];
						$fileType =$_FILES['upload_files'.$x]['type'];
						$fileSize =$_FILES['upload_files'.$x]['size'];
						$fileError =$_FILES['upload_files'.$x]['error'];
						list($width, $height) = getimagesize($fileTmpLoc);
						$fileName=preg_replace('#[^a-z.0-9_]#i','',$fileName);
						$exploded_name=explode(".",$fileName); // Explodes the name into array.
						//  $fileName=time().rand().'.'.$file_ext;
						$file_ext=end($exploded_name); // Targeting first part of array.
					
						if ($fileSize > 10485760) // 10MB
							{$error_message = "Image Size Too Large!<br/><br/>";
							unlink ($fileTmpLoc);header("location: ".$header_location."?error_message=".$error_message);exit();}
						else if ($fileError ==1)
							{$error_message = "Error Occured! Please Try Again Later.<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
						else {$newname= "tmp_".$x.".".$file_ext;
							$newname2= "tmp_".$x.".png";
							$place_files=move_uploaded_file($fileTmpLoc, "../".$typex_s."_files/".$typex_s."$id/tmp_folder/".$newname);
						// Picture Picture
							$target_file="../".$typex_s."_files/".$typex_s."$id/tmp_folder/".$newname;
							$resized_file="../".$typex_s."_files/".$typex_s."$id/tmp_folder/".$newname;
							if($width>=$height)
								{$wmax=8686;$hmax=680;}
							else if($width<=$height)
								{$wmax=680;$hmax=8686;}
							img_resize($target_file,$resized_file,$wmax,$hmax,$file_ext);
							$target_file="../".$typex_s."_files/".$typex_s."$id/tmp_folder/".$newname;
							$thumbnail="../".$typex_s."_files/".$typex_s."$id/tmp_folder/".$newname;
							if($width>=$height)
								{$wthumb=680;$hthumb=680;}
							else if($width<=$height)
								{$wthumb=680;$hthumb=680;}
							thumb_img_resize($target_file,$thumbnail,$wthumb,$hthumb,$file_ext);
					
						// Convert to PNG
							$target_file="../".$typex_s."_files/".$typex_s."$id/tmp_folder/".$newname;
							$newcopy="../".$typex_s."_files/".$typex_s."$id/tmp_folder/".$newname2;
							convert_to_png($target_file,$newcopy,$file_ext);
					
							$image=imagecreatefrompng("../".$typex_s."_files/".$typex_s."$id/tmp_folder/".$newname2);
							ob_start();
							imagegif($image);
							$frames[]=ob_get_contents();
							$framed[]=$speed; // Delay in the animation.
							ob_end_clean();
							}
						}
					}
				mysql_query("INSERT INTO ".$typex."_images (user_page_id,user_post_id,album_id,upload_date,image_type,ext) VALUES ('$id','$ids','$album_id',UTC_TIMESTAMP(),'$type','gif')");
				$image_id=mysql_insert_id();
				$mysql_image_array = mysql_query("SELECT id,image_array,album_name FROM ".$typex."_albums WHERE id='$album_id' LIMIT 1");
				while ($row=mysql_fetch_array($mysql_image_array))
					{$image_array = $row['image_array'];
					$album_name = $row['album_name'];}
				$imageArray = explode(",",$image_array);
				if(in_array($image_id, $imageArray))
					{$success_message = "";header("location: ".$header_location."");exit();}
				if ($image_array!="")
					{$image_array="$image_array,$image_id";}
				else {$image_array="$image_id";}
				if ($image_array2!="")
					{$image_array2="$image_array2,$image_id";}
				else {$image_array2="$image_id";}
				
				$newname= $typex_s."_album_".$album_id."_pic_".$image_id.".gif";
				$newname2= $typex_s."_album_".$album_id."_thumb_".$image_id.".gif";
				$newname_thumb= $typex_s."_album_".$album_id."_thumb_".$image_id.".jpg";
				$newname_cover= $typex_s."_album_".$album_id."_cover.jpg";
				$newname_cover2= $typex_s."_album_".$album_id."_cover2.jpg";				
			
				$gif = new GIFEncoder($frames,$framed,0,2,0,0,0,'bin');
				$fp = fopen('../'.$typex_s.'_files/'.$typex_s.''.$id.'/'.$typex_s.'_album_'.$album_id.'/'.$newname.'', 'w');
				fwrite($fp, $gif->GetAnimation());
				fclose($fp);

				// Picture Thumb
				$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_".$album_id."/".$newname;
				$resized_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname2;
				if($width>=$height)
					{$wmax=8686;$hmax=215;}
				else if($width<=$height)
					{$wmax=215;$hmax=8686;}
				img_resize($target_file,$resized_file,$wmax,$hmax,'gif');
				$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname2;
				$thumbnail="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_thumb;
				$wthumb=215;$hthumb=215;
				thumb_img_resize2($target_file,$thumbnail,$wthumb,$hthumb,'gif');
				$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_thumb;
				$thumbnail="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_cover2;
					$wthumb=215;$hthumb=138;
				thumb_img_resize2($target_file,$thumbnail,$wthumb,$hthumb,'jpg');
				$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_thumb;
				$thumbnail="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_album_thumbs_".$album_id."/".$newname_cover;
					$wthumb=215;$hthumb=215;
				thumb_img_resize2($target_file,$thumbnail,$wthumb,$hthumb,'jpg');
				
				$UpdateArray = mysql_query("UPDATE ".$typex."_albums SET image_array='$image_array' WHERE id='$album_id'") or die (mysql_error());	
				$mysql_last=mysql_query("SELECT id, upload_date, album_id, images FROM ".$typex."_images_walls WHERE user_post_id='$ids' AND album_id='$album_id' AND upload_date>DATE_SUB(UTC_TIMESTAMP(),INTERVAL 72 HOUR) ORDER BY upload_date DESC LIMIT 1");
				$numRows=mysql_num_rows($mysql_last);
				if($numRows>0)
					{while ($row=mysql_fetch_array($mysql_last))
						{$images_walls_id=$row['id'];
						$album_id_last=$row['album_id'];
						$images_array_last=$row['images'];}
					if ($images_array_last!=""){$images_array_last="$images_array_last,$image_array2";}
					else {$images_array_last="$image_array2";}
					mysql_query("UPDATE ".$typex."_images_walls SET images='$images_array_last',upload_date=UTC_TIMESTAMP(),union_type='images_walls' WHERE id='$images_walls_id' AND album_id='$album_id'");}
				else {mysql_query("INSERT INTO ".$typex."_images_walls (user_page_id,user_post_id,album_id,album_name,upload_date,images,images_wall_type) 
									VALUES ('$id','$ids','$album_id','$album_name',UTC_TIMESTAMP(),'$image_array2','$type')");}
				}
			}
		}
	header("location: ".$header_location."?id=".$id);exit();}
	
// Section for Video Upload
if ($_POST['parse_var'] == "video_creation")
{if ($_FILES['upload_file']['name'])
	{$id=$_POST['id'];
	$video_name=$_POST['upload_name'];
	$video_description=$_POST['upload_field'];
	$type=$_POST['upload_type2'];
	$typex=$_POST['type'];
	$typex_s=substr($typex, 0, -1);
	$video_name=htmlspecialchars($video_name);
	$video_description=htmlspecialchars($video_description);
	$video_name=mysql_real_escape_string($video_name);
	$video_description=mysql_real_escape_string($video_description);
	$prevent_double_post1=mysql_query("SELECT id FROM ".$typex."_videos WHERE user_post_id='$ids' AND upload_date between subtime(UTC_TIMESTAMP(),'0:1:0') and UTC_TIMESTAMP()");
	$numRows_prevent1=mysql_num_rows($prevent_double_post1);
	$prevent_double_post2=mysql_query("SELECT id FROM ".$typex."_videos WHERE user_post_id='$ids' AND DATE(upload_date) = DATE(UTC_TIMESTAMP()) LIMIT 10");
	$numRows_prevent2=mysql_num_rows($prevent_double_post2);
	if($numRows_prevent1>0)
		{$error_message='Please wait one minute between each video upload!<br/><br/>';header("location: ".$header_location."?error_message=".$error_message);exit();}
	else if (empty($video_name))
		{$error_message='Video requires a name. <br/>Please enter a video name!<br/><br/>';header("location: ".$header_location."?error_message=".$error_message);exit();}
	else{
		
	$fileName =$_FILES['upload_file']['name'];
	$fileTmpLoc =$_FILES['upload_file']['tmp_name'];
	$fileType =$_FILES['upload_file']['type'];
	$fileSize =$_FILES['upload_file']['size'];
	$fileError =$_FILES['upload_file']['error'];
	$fileName=preg_replace('#[^a-z.0-9_]#i','',$fileName);
	$exploded_name=explode(".",$fileName); // Explodes the name into array.
	$file_ext=end($exploded_name); // Targeting first part of array.
	
	$pictureName =$_FILES['upload_picture']['name'];
	$pictureTmpLoc =$_FILES['upload_picture']['tmp_name'];
	$pictureType =$_FILES['upload_picture']['type'];
	$pictureSize =$_FILES['upload_picture']['size'];
	$pictureError =$_FILES['upload_picture']['error'];
	$pictureName=preg_replace('#[^a-z.0-9_]#i','',$pictureName);
	$exploded_name=explode(".",$pictureName); // Explodes the name into array.
	$picture_ext=end($exploded_name); // Targeting first part of array.
	
	if(!$fileTmpLoc)
		{$error_message = "Select videos with the accepted format. <br/>Please only upload MP4 videos!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
	else if(!$pictureTmpLoc)
		{$error_message = "Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
	else if ($fileSize > 104857600) // 100MB
		{$error_message = "Video Size Too Large!<br/><br/>";
		unlink ($fileTmpLoc);header("location: ".$header_location."?error_message=".$error_message);exit();}
	else if ($pictureSize > 10485760) // 10MB
		{$error_message = "Image Size Too Large!<br/><br/>";
		unlink ($pictureTmpLoc);header("location: ".$header_location."?error_message=".$error_message);exit();}
	else if (!preg_match("/\.(mp4)$/i", $_FILES['upload_file']['name']))
		{$error_message = "Select videos with the accepted format. <br/>Please upload only MP4 games!<br/><br/>";
		unlink ($fileTmpLoc);header("location: ".$header_location."?error_message=".$error_message);exit();}
	else if (!preg_match("/\.(gif|jpg|jpeg|png)$/i", $pictureName))
		{$error_message = "Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";
		unlink ($pictureTmpLoc);header("location: ".$header_location."?error_message=".$error_message);exit();}
	else if ($fileError ==1)
		{$error_message = "Error Occured! Please Try Again Later.<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
	else if ($pictureError ==1)
		{$error_message = "Error Occured! Please Try Again Later.<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
	else
		{mysql_query("INSERT INTO ".$typex."_videos (user_page_id,user_post_id,upload_date,video_name,video_description,video_type,ext) VALUES ('$id','$ids',UTC_TIMESTAMP(),'$video_name','$video_description','$type','$file_ext')");
		$video_id=mysql_insert_id();
		mkdir("../".$typex_s."_files/".$typex_s."$id/".$typex_s."_video_".mysql_insert_id(), 0755);	
		move_uploaded_file($fileTmpLoc,"../".$typex_s."_files/".$typex_s."$id/".$typex_s."_video_$video_id/".$typex_s."_video_".$video_id.".".$file_ext);
		
		$newname_cover= $typex_s."_video_".$video_id."_cover.jpg";
		$place_files = move_uploaded_file ($pictureTmpLoc, "../".$typex_s."_files/".$typex_s."$id/".$typex_s."_video_".$video_id."/".$newname_cover);
		include_once "../scripts/image_functions.php";
		// Cover Picture
		$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_video_".$video_id."/".$newname_cover;
		$resized_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_video_".$video_id."/".$newname_cover;
		$wmax=215;
		$hmax=8686;
		img_resize($target_file,$resized_file,$wmax,$hmax,$picture_ext);
		$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_video_".$video_id."/".$newname_cover;
		$thumbnail="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_video_".$video_id."/".$newname_cover;
		$wthumb=215;
		$hthumb=138;
		thumb_img_resize($target_file,$thumbnail,$wthumb,$hthumb,$picture_ext);}
		}
	}
	else {$error_message = "Select videos with the accepted format. <br/>Please only upload MP4 videos!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
	
	header("location: ".$header_location."?id=".$id);exit();}
	
// Section for Game Upload
if ($_POST['parse_var'] == "game_creation")
{if ((preg_match("/\.(swf)$/i", $_FILES['upload_file']['name']))AND(preg_match("/\.(gif|jpg|jpeg|png)$/i", $_FILES['upload_picture']['name'])))
	{$id=$_POST['id'];
	$typex=$_POST['type'];
	$typex_s=substr($typex, 0, -1);
	$game_name=$_POST['upload_name'];
	$game_description=$_POST['upload_field'];
	$categories=$_POST['categories'];
	$type=$_POST['upload_type2'];
	$game_name=htmlspecialchars($game_name);
	$game_description=htmlspecialchars($game_description);
	$game_name=mysql_real_escape_string($game_name);
	$game_description=mysql_real_escape_string($game_description);
	$prevent_double_post1=mysql_query("SELECT id FROM ".$typex."_games WHERE user_post_id='$ids' AND upload_date between subtime(UTC_TIMESTAMP(),'0:1:0') and UTC_TIMESTAMP()");
	$numRows_prevent1=mysql_num_rows($prevent_double_post1);
	$prevent_double_post2=mysql_query("SELECT id FROM ".$typex."_games WHERE user_post_id='$ids' AND DATE(upload_date) = DATE(UTC_TIMESTAMP()) LIMIT 10");
	$numRows_prevent2=mysql_num_rows($prevent_double_post2);
	if($numRows_prevent1>0)
		{$error_message='Please wait one minute between each game upload!<br/><br/>';header("location: ".$header_location."?error_message=".$error_message);exit();}
	else if (empty($game_name))
		{$error_message='Game requires a name. <br/>Please enter a game name!<br/><br/>';header("location: ".$header_location."?error_message=".$error_message);exit();}
	else{
		
	$fileName =$_FILES['upload_file']['name'];
	$fileTmpLoc =$_FILES['upload_file']['tmp_name'];$error_message = $fileTmpLoc;
	$fileType =$_FILES['upload_file']['type'];
	$fileSize =$_FILES['upload_file']['size'];
	$fileError =$_FILES['upload_file']['error'];
	$fileName=preg_replace('#[^a-z.0-9_]#i','',$fileName);
	$exploded_name=explode(".",$fileName); // Explodes the name into array.
	$file_ext=end($exploded_name); // Targeting first part of array.
	
	$pictureName =$_FILES['upload_picture']['name'];
	$pictureTmpLoc =$_FILES['upload_picture']['tmp_name'];
	$pictureType =$_FILES['upload_picture']['type'];
	$pictureSize =$_FILES['upload_picture']['size'];
	$pictureError =$_FILES['upload_picture']['error'];
	$pictureName=preg_replace('#[^a-z.0-9_]#i','',$pictureName);
	$exploded_name=explode(".",$pictureName); // Explodes the name into array.
	$picture_ext=end($exploded_name); // Targeting first part of array.
	
	if(!$fileTmpLoc)
		{$error_message = "Select games with the accepted format. <br/>Please upload only SWF games!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
	else if(!$pictureTmpLoc)
		{$error_message = "Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
	else if ($fileSize > 20971520) // 20MB
		{$error_message = "Game Size Too Large!<br/><br/>";
		unlink ($fileTmpLoc);header("location: ".$header_location."?error_message=".$error_message);exit();}
	else if ($pictureSize > 10485760) // 10MB
		{$error_message = "Image Size Too Large!<br/><br/>";
		unlink ($pictureTmpLoc);header("location: ".$header_location."?error_message=".$error_message);exit();}
	else if (!preg_match("/\.(swf)$/i", $_FILES['upload_file']['name']))
		{$error_message = "Select games with the accepted format. <br/>Please upload only SWF games!<br/><br/>";
		unlink ($fileTmpLoc);header("location: ".$header_location."?error_message=".$error_message);exit();}
	else if (!preg_match("/\.(gif|jpg|jpeg|png)$/i", $pictureName))
		{$error_message = "Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";
		unlink ($pictureTmpLoc);header("location: ".$header_location."?error_message=".$error_message);exit();}
	else if ($fileError ==1)
		{$error_message = "Error Occured! Please Try Again Later.<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
	else if ($pictureError ==1)
		{$error_message = "Error Occured! Please Try Again Later.<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
	else
		{mysql_query("INSERT INTO ".$typex."_games (user_page_id,user_post_id,upload_date,game_name,game_description,categories,game_type,ext) VALUES ('$id','$ids',UTC_TIMESTAMP(),'$game_name','$game_description','$categories','$type','$file_ext')");
		$game_id=mysql_insert_id();
		mkdir("../".$typex_s."_files/".$typex_s."$id/".$typex_s."_game_".mysql_insert_id());
		move_uploaded_file($fileTmpLoc,"../".$typex_s."_files/".$typex_s."$id/".$typex_s."_game_".$game_id."/".$typex_s."_game_".$game_id.".swf");
		
		$newname_cover= $typex_s."_game_".$game_id."_cover.jpg";
		$place_files = move_uploaded_file ($pictureTmpLoc, "../".$typex_s."_files/".$typex_s."$id/".$typex_s."_game_".$game_id."/".$newname_cover);
		include_once "../scripts/image_functions.php";
		// Cover Picture
		$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_game_".$game_id."/".$newname_cover;
		$resized_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_game_".$game_id."/".$newname_cover;
		$wmax=215;
		$hmax=8686;
		img_resize($target_file,$resized_file,$wmax,$hmax,$picture_ext);
		$target_file="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_game_".$game_id."/".$newname_cover;
		$thumbnail="../".$typex_s."_files/".$typex_s."$id/".$typex_s."_game_".$game_id."/".$newname_cover;
		$wthumb=215;
		$hthumb=138;
		thumb_img_resize($target_file,$thumbnail,$wthumb,$hthumb,$picture_ext);}
			}
		}
	else {$error_message = "Select games with the accepted format. <br/>Please only upload SWF videos!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
	
	header("location: ".$header_location."?id=".$id);exit();}
	
//////////////////////////////
//////////// PLANET //////////
//////////////////////////////

if ($_POST['parse_var']=="create_planet")
	{$create_id=$_POST['id'];
	$link_create_type=$_POST['create_type2'];
	$typex=$_POST['type'];
	$typex_s=substr($typex, 0, -1);
	$planet_id=$_POST['new_create'];
	if($planet_id=="planets") {
	$planet_name=$_POST['create_name'];
	$planet_description=$_POST['create_description'];
	$type=$_POST['create_type'];
	$categories=$_POST['categories'];
	$planet_name=htmlspecialchars($planet_name);
	$planet_description=htmlspecialchars($planet_description);
	$planet_name=mysql_real_escape_string($planet_name);
	$planet_description=mysql_real_escape_string($planet_description);
	
	if (empty($planet_name))
		{$error_message='Planet requires a name. <br/>Please enter a planet name!<br/><br/>';header("location: ".$header_location."?error_message=".$error_message);exit();}
	else{mysql_query("INSERT INTO planets (user_id,create_date,planet_name,planet_description,categories,member_array,creator_array,planet_type) VALUES ('$ids',UTC_TIMESTAMP(),'$planet_name','$planet_description','$categories','$ids','$ids','$type')");
		$planet_id=mysql_insert_id();
		mkdir("../planet_files/planet$planet_id");	
		mkdir("../planet_files/planet$planet_id/tmp_folder");			
		$mysql = mysql_query("SELECT planets_array FROM members WHERE id='$ids' LIMIT 1") or die ("Sorry, we have a system error!");
		while ($row=mysql_fetch_array($mysql))
			{$planets_array=$row['planets_array'];}
			$planetArray = explode(",",$planets_array);
		if(in_array($planet_id, $planetArray))
			{$success_message = "";header("location: ".$header_location."");exit();}
		if ($planets_array != ""){$planets_array = "$planets_array,$planet_id";}
		else {$planets_array = "$planet_id";}
		$UpdateArray = mysql_query("UPDATE members SET planets_array = '$planets_array' WHERE id='$ids'") or die (mysql_error());
		
		$fileName =$_FILES['planet_picture']['name'];
		$fileTmpLoc =$_FILES['planet_picture']['tmp_name'];
		$fileType =$_FILES['planet_picture']['type'];
		$fileSize =$_FILES['planet_picture']['size'];
		$fileError =$_FILES['planet_picture']['error'];
		$fileName=preg_replace('#[^a-z.0-9_]#i','',$fileName);
		$exploded_name=explode(".",$fileName); // Explodes the name into array.
	//  $fileName=time().rand().'.'.$file_ext;
		$file_ext=end($exploded_name); // Targeting first part of array.
		if(!$fileTmpLoc)
			{$error_message = "Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
		else if ($fileSize > 10485760) // 10MB
			{$error_message = "Image Size Too Large!<br/><br/>";
			unlink ($fileTmpLoc);header("location: ".$header_location."?error_message=".$error_message);exit();}
		else if (!preg_match("/\.(gif|jpg|jpeg|png)$/i", $fileName))
			{$error_message = "Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!<br/><br/>";
			unlink ($fileTmpLoc);header("location: ".$header_location."?error_message=".$error_message);exit();}
		else if ($fileError ==1)
			{$error_message = "Error Occured! Please Try Again Later.<br/><br/>";header("location: ".$header_location."?error_message=".$error_message);exit();}
		else
		{$newname= "planet_picture.jpg";
		$newname_thumb= "planet_thumb.jpg";
		$newname_cover= "planet_cover.jpg";
		$place_files = move_uploaded_file ($fileTmpLoc, "../planet_files/planet$planet_id/".$newname);
		include_once "../scripts/image_functions.php";
		// Picture
		$target_file="../planet_files/planet$planet_id/$newname";
		$resized_file="../planet_files/planet$planet_id/$newname";
		$wmax=260;
		$hmax=8686;
		img_resize($target_file,$resized_file,$wmax,$hmax,$file_ext);
		// Planet Cover
		$target_file="../planet_files/planet$planet_id/$newname";
		$resized_file="../planet_files/planet$planet_id/$newname_cover";
		$wmax=170;
		$hmax=8686;
		img_resize($target_file,$resized_file,$wmax,$hmax,$file_ext);
		$target_file="../planet_files/planet$planet_id/$newname_cover";
		$thumbnail="../planet_files/planet$planet_id/$newname_cover";
		$wthumb=170;
		$hthumb=170;
		thumb_img_resize($target_file,$thumbnail,$wthumb,$hthumb,$file_ext);
		// Planet Thumb
		$target_file="../planet_files/planet$planet_id/$newname_cover";
		$resized_file="../planet_files/planet$planet_id/$newname_thumb";
		$wmax=75;
		$hmax=75;
		img_resize($target_file,$resized_file,$wmax,$hmax,$file_ext);}
		/* JPEG Thumb
		if (strtolower($file_ext)!=="jpg")
			{$target_file="../user_files/user$ids/$newname";
			$thumbnail="../user_files/user$ids/$newname_thumb";
			convert_to_jpg($target_file,$thumbnail,$file_ext);}*/
		}}
		
	$mysql_create_array_1 = mysql_query("SELECT ".$typex."_array AS create_array FROM planets WHERE id='$planet_id' LIMIT 1");
	$mysql_create_array_2 = mysql_query("SELECT planets_array AS create_array FROM ".$typex." WHERE id='$create_id' LIMIT 1");
	while ($row=mysql_fetch_array($mysql_create_array_1))
		{$create_array_1 = $row['create_array'];}
	while ($row=mysql_fetch_array($mysql_create_array_2))
		{$create_array_2 = $row['create_array'];}
	$createArray1 = explode(",",$create_array_1);
	$createArray2 = explode(",",$create_array_2);
	
	if(in_array($create_id, $createArray1))
		{header("location: ../planet/".$typex_s.".php?id=".$create_id);exit();}
	if(in_array($planet_id, $createArray2))
		{header("location: ../planet/".$typex_s.".php?id=".$create_id);exit();}
	if ($create_array_1 != "")
		{$create_array_1 = "$create_array_1,$create_id";}
	else {$create_array_1 = "$create_id";}
	if ($create_array_2 != "")
		{$create_array_2 = "$create_array_2,$planet_id";}
	else {$create_array_2 = "$planet_id";}
	
	$UpdateArray1 = mysql_query("UPDATE planets SET ".$typex."_array = '$create_array_1' WHERE id='$planet_id'") or die (mysql_error());
	$UpdateArray2 = mysql_query("UPDATE ".$typex." SET planets_array = '$create_array_2' WHERE id='$create_id'") or die (mysql_error());
	mysql_query("INSERT INTO link_creates (user_post_id,user_page_id,planet_id,create_type,link_create_date,link_create_type) VALUES ('$ids','$create_id','$planet_id','$typex',UTC_TIMESTAMP(),'$link_create_type')") ;	
	
	header("location: ../planet/planet.php?id=".$planet_id);exit();}
}
header("location: ".$header_location."?id=".$create_id);exit();
ob_flush();
?>