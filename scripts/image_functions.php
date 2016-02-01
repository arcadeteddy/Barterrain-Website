<?php
// Profile Picture
function img_resize($target,$newcopy,$w,$h,$ext)
{list($w_orig,$h_orig)=getimagesize($target);
$scale_ratio = $w_orig/$h_orig;
if (($w/$h)>$scale_ratio)
	{$w=$h*$scale_ratio;}
else
	{$h=$w/$scale_ratio;}
$img="";
if ($ext=="gif"||$ext=="GIF")
	{$img=imagecreatefromgif($target);}
else if ($ext=="png"||$ext=="PNG")
	{$img=imagecreatefrompng($target);}
else if ($ext=="jpg"||$ext=="JPG"||$ext=="jpeg"||$ext=="JPEG")
	{$img=imagecreatefromjpeg($target);}
$tci=imagecreatetruecolor($w,$h);
imagecopyresampled($tci,$img,0,0,0,0,$w,$h,$w_orig,$h_orig);
if ($ext=="gif")
	{imagegif($tci,$newcopy);}
else if ($ext=="png")
	{imagepng($tci,$newcopy);}
else if (($ext=="jpg")OR($ext=="jpeg"))
	{imagejpeg($tci,$newcopy,80);}
}

// GIF Thumbnail
function thumb_img_resize2($target,$newcopy,$w,$h,$ext)
{list($w_orig,$h_orig)=getimagesize($target);
$src_x=($w_orig/2)-($w/2);
$src_y=($h_orig/2)-($h/2);
$ext=strtolower($ext);
$img="";
if ($ext=="jpg"||$ext=="JPG"||$ext=="jpeg"||$ext=="JPEG")
	{$img=imagecreatefromjpeg($target);}
else if ($ext=="gif"||$ext=="GIF")
	{$img=imagecreatefromgif($target);}
else if ($ext=="png"||$ext=="PNG")
	{$img=imagecreatefrompng($target);}
$tci=imagecreatetruecolor($w,$h);
imagecopyresampled($tci,$img,0,0,$src_x,$src_y,$w,$h,$w,$h);
imagejpeg($tci,$newcopy,8);
}

// Profile Thumbnail
function thumb_img_resize($target,$newcopy,$w,$h,$ext)
{list($w_orig,$h_orig)=getimagesize($target);
$src_x=($w_orig/2)-($w/2);
$src_y=($h_orig/2)-($h/2);
$ext=strtolower($ext);
$img="";
if ($ext=="gif"||$ext=="GIF")
	{$img=imagecreatefromgif($target);}
else if ($ext=="png"||$ext=="PNG")
	{$img=imagecreatefrompng($target);}
else
	{$img=imagecreatefromjpeg($target);}
$tci=imagecreatetruecolor($w,$h);
imagecopyresampled($tci,$img,0,0,$src_x,$src_y,$w,$h,$w,$h);
if ($ext=="gif")
	{imagegif($tci,$newcopy);}
else if ($ext=="png")
	{imagepng($tci,$newcopy);}
else if (($ext=="jpg")OR($ext=="jpeg"))
	{imagejpeg($tci,$newcopy,80);}
}

// Convert to JPG
function convert_to_jpg($target,$newcopy,$ext)
{list($w_orig,$h_orig)=getimagesize($target);
$ext=strtolower($ext);
$img="";
if ($ext=="gif"||$ext=="GIF")
	{$img=imagecreatefromgif($target);}
else if ($ext=="png"||$ext=="PNG")
	{$img=imagecreatefrompng($target);}
$tci=imagecreatetruecolor($w_orig,$h_orig);
imagecopyresampled($tci,$img,0,0,0,0,$w_orig,$h_orig,$w_orig,$h_orig);
imagejpeg($tci,$newcopy,80);
}

// Convert to PNG
function convert_to_png($target,$newcopy,$ext)
{list($w_orig,$h_orig)=getimagesize($target);
$ext=strtolower($ext);
$img="";
if ($ext=="jpg"||$ext=="JPG"||$ext=="jpeg"||$ext=="JPEG")
	{$img=imagecreatefromjpeg($target);}
else if ($ext=="gif"||$ext=="GIF")
	{$img=imagecreatefromgif($target);}
else if ($ext=="png"||$ext=="PNG")
	{$img=imagecreatefrompng($target);}
$tci=imagecreatetruecolor($w_orig,$h_orig);
imagecopyresampled($tci,$img,0,0,0,0,$w_orig,$h_orig,$w_orig,$h_orig);
imagepng($tci,$newcopy,8);
}
?>