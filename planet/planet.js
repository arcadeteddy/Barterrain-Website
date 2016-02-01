var CreateOptionsURL = "../scripts/create_interactive_options.php";
var interactiveURL = "../scripts/create_interactive_changer.php";
var interactive = "../scripts/create_interactive_box.php";
var commentURL = "../scripts/create_comment_box.php";
var url = "../scripts/create_interactive_box.php";

// Top Right Options Menu
//$(document).ready(function() 
//	{$(".right_inside2_button").click(function(e) 
//		{e.preventDefault();
//       $("fieldset#right_inside2_menu").toggle();
//		$(".right_inside2_button").toggleClass("right_inside2_open");});
//		$("fieldset#right_inside2_menu").mouseup(function() 
//			{return false});
//      $(document).mouseup(function(e)
//			{if($(e.target).parent("a.right_inside2_button").length==0)
//				{$(".right_inside2_button").removeClass("right_inside2_open");
//				$("fieldset#right_inside2_menu").hide();}
//           });            
//	});
	
$(document).ready(function() 
	{$(".right_inside_button").click(function(e) 
		{e.preventDefault();
        $("fieldset#right_inside_menu").toggle();
		$(".right_inside_button").toggleClass("right_inside_open");});
		$("fieldset#right_inside_menu").mouseup(function() 
			{return false});
        $(document).mouseup(function(e)
			{if($(e.target).parent("a.right_inside_button").length==0)
				{$(".right_inside_button").removeClass("right_inside_open");
				$("fieldset#right_inside_menu").hide();}
            });            
	});
	
function albums_list(a,b,c)
	{$.post("planet_albums_list.php?page="+a,{x:a,id:b,ids:c,cacheBuster:cacheBuster},function(data) 
		{$("#albums_list").html(data).show()});	
	}
function games_list(a,b,c)
	{$.post("planet_games_list.php?page="+a,{x:a,id:b,ids:c,cacheBuster:cacheBuster},function(data) 
		{$("#games_list").html(data).show()});	
	}
function videos_list(a,b,c)
	{$.post("planet_videos_list.php?page="+a,{x:a,id:b,ids:c,cacheBuster:cacheBuster},function(data) 
		{$("#videos_list").html(data).show()});	
	}
	
// Top Right Options
function JoinCreate(a,b,c)
	{$.post(CreateOptionsURL,{request:"JoinCreate",ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("body").html(data).show()});
	}
function LeaveCreate(a,b,c)
	{$.post(CreateOptionsURL,{request:"LeaveCreate",ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("body").html(data).show()});
	}
function LeaveCreate2(a,b,c)
	{$.post(CreateOptionsURL,{request:"LeaveCreate2",id:id,ids:ids,member_id:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("#members_list").html(data).show()});
	}
function BlockCreate(a,b,c)
	{$.post(CreateOptionsURL,{request:"BlockCreate",ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("#top_result_div").html(data).show()});	
	}
function UnblockCreate(a,b,c)
	{$.post(CreateOptionsURL,{request:"UnblockCreate",ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("#top_result_div").html(data).show()});	
	}
function ReportCreate(a,b,c)
	{$.post(CreateOptionsURL,{request:"ReportCreate",ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("#top_result_div").html(data).show()});
	}
function UnreportCreate(a,b,c)
	{$.post(CreateOptionsURL,{request:"UnreportCreate",ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("#top_result_div").html(data).show()});
	}
function RequestCreator(a,b,c)
	{$.post(CreateOptionsURL,{request:"RequestCreator",ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("#top_result_div").html(data).show()});
	}
function RequestAdmin(a,b,c)
	{$.post(CreateOptionsURL,{request:"RequestAdmin",ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("#top_result_div").html(data).show()});
	}
function LeaveCreator(a,b,c)
	{$.post(CreateOptionsURL,{request:"LeaveCreator",ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("body").html(data).show()});
	}
function LeaveAdmin(a,b,c)
	{$.post(CreateOptionsURL,{request:"LeaveAdmin",ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("body").html(data).show()});
	}
function LeaveCreator2(a,b,c)
	{$.post(CreateOptionsURL,{request:"LeaveCreator2",id:id,ids:ids,member_id:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("#creators_list").html(data).show()});
	}
function LeaveAdmin2(a,b,c)
	{$.post(CreateOptionsURL,{request:"LeaveAdmin2",id:id,ids:ids,member_id:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("#admins_list").html(data).show()});
	}
function DeleteCreate(a,b,c)
	{$.post(CreateOptionsURL,{request:"DeleteCreate",ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{location.href = "index.php";});
	}

////////////// LIKE/LOVE CIRCLE //////////////
function Like_circle(a,b,c)
	{$.post(like_loveURL,{like_love:"Like_circle",id:id,ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("#information_circle_"+c+b).html(data).show()});	
	}
function Love_circle(a,b,c)
	{$.post(like_loveURL,{like_love:"Love_circle",id:id,ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("#information_circle_"+c+b).html(data).show()});	
	}
function unlikeLike_circle(a,b,c)
	{$.post(like_loveURL,{like_love:"unlikeLike_circle",id:id,ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("#information_circle_"+c+b).html(data).show()});
	}
function unloveLove_circle(a,b,c)
	{$.post(like_loveURL,{like_love:"unloveLove_circle",id:id,ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("#information_circle_"+c+b).html(data).show()});
	}

////////////// LIKE/LOVE create //////////////
function Like_create(a,b,c)
	{$.post(like_loveURL,{like_love:"Like_create",user_id:a,ids:b,create_id:c,type:type,thisWipit:thisRandNum},function(data) 
		{$("#create_ll_"+c).html(data).show()});	
	}
function Love_create(a,b,c)
	{$.post(like_loveURL,{like_love:"Love_create",user_id:a,ids:b,create_id:c,type:type,thisWipit:thisRandNum},function(data) 
		{$("#create_ll_"+c).html(data).show()});	
	}
function unlikeLike_create(a,b,c)
	{$.post(like_loveURL,{like_love:"unlikeLike_create",user_id:a,ids:b,create_id:c,type:type,thisWipit:thisRandNum},function(data) 
		{$("#create_ll_"+c).html(data).show()});	
	}
function unloveLove_create(a,b,c)
	{$.post(like_loveURL,{like_love:"unloveLove_create",user_id:a,ids:b,create_id:c,type:type,thisWipit:thisRandNum},function(data) 
		{$("#create_ll_"+c).html(data).show()});	
	}
	
// Like/Love Folder
var like_loveURL = "../scripts/like_love.php";
function Like_folder(a,b,c,d)
	{$.post(like_loveURL,{like_love:"create_Like_folder",id:a,ids:b,item_id:c,item_type:d,type:type,thisWipit:thisRandNum},function(data) 
		{$("#like_love_"+d+c).html(data).show()});	
	}
function Love_folder(a,b,c,d)
	{$.post(like_loveURL,{like_love:"create_Love_folder",id:a,ids:b,item_id:c,item_type:d,type:type,thisWipit:thisRandNum},function(data) 
		{$("#like_love_"+d+c).html(data).show()});	
	}
function unlikeLike_folder(a,b,c,d)
	{$.post(like_loveURL,{like_love:"create_unlikeLike_folder",id:a,ids:b,item_id:c,item_type:d,type:type,thisWipit:thisRandNum},function(data) 
		{$("#like_love_"+d+c).html(data).show()});
	}
function unloveLove_folder(a,b,c,d)
	{$.post(like_loveURL,{like_love:"create_unloveLove_folder",id:a,ids:b,item_id:c,item_type:d,type:type,thisWipit:thisRandNum},function(data) 
		{$("#like_love_"+d+c).html(data).show()});
	}

////////////// TOP BOXES //////////////
function post()
	{$("#interactive_error").html('').show();
		$(".top_boxes").removeClass("selected_box");
		$(".top_box1").toggleClass("selected_box");
		$("#bottom_half_box").hide();
		$(".bottom_half_box_hide").hide();
		$("#bottom_half_box_post").show();
	}
function upload_media()
	{$("#interactive_error").html('').show();
		$(".top_boxes").removeClass("selected_box");
		$(".top_box2").toggleClass("selected_box");
		$("#bottom_half_box").hide();
		$(".bottom_half_box_hide").hide();
		$("#bottom_half_box_media").show();
	}
function create_circles()
	{$("#interactive_error").html('').show();
		$(".top_boxes").removeClass("selected_box");
		$(".top_box3").toggleClass("selected_box");
		$("#bottom_half_box").html(data).show();
	}
function note()
	{$("#interactive_error").html('').show();
		$(".top_boxes").removeClass("selected_box");
		$(".top_box4").toggleClass("selected_box");
		$("#bottom_half_box").hide();
		$(".bottom_half_box_hide").hide();
		$("#bottom_half_box_note").show();
	}
function planet()
	{$("#interactive_error").html('').show();
		$(".top_boxes").removeClass("selected_box");
		$(".top_box5").toggleClass("selected_box");
		$("#bottom_half_box").hide();
		$(".bottom_half_box_hide").hide();
		$("#bottom_half_box_planet").show();
	}
	
// IMAGES
function image_post()
	{$("#interactive_error").html('').show();
		$(".image_top_boxes").removeClass("selected_box");
		$(".image_top_box").toggleClass("selected_box");
		$(".images_bottom_posts").addClass("selected_box");
		$("#image_bottom_half_box").html(data).show();
	}
	
////////////// UPLOADING //////////////
function UploadImages()
	{$.post(interactiveURL,{ids:ids,id:id,type:type,interactive:"images"},function(data) 
		{$("#bottom_half_box").html(data).show();
		$("#bottom_half_box").show();
		$(".bottom_half_box_hide").hide();});}
function UploadGifs()
	{$.post(interactiveURL,{ids:ids,id:id,type:type,interactive:"gifs"},function(data) 
		{$("#bottom_half_box").html(data).show();
		$("#bottom_half_box").show();
		$(".bottom_half_box_hide").hide();});}
function UploadVideos()
	{$.post(interactiveURL,{ids:ids,id:id,type:type,interactive:"videos"},function(data) 
		{$("#bottom_half_box").html(data).show();
		$("#bottom_half_box").show();
		$(".bottom_half_box_hide").hide();});}
function UploadGames()
	{$.post(interactiveURL,{ids:ids,id:id,type:type,interactive:"games"},function(data) 
		{$("#bottom_half_box").html(data).show();
		$("#bottom_half_box").show();
		$(".bottom_half_box_hide").hide();});}
		
function add_remove_new_album()
	{var option = document.getElementById("upload_images").value;
	if (option=="a")
		{$.post(interactiveURL,{interactive:"add_new_album"},function(data) 
			{$("#remove_new_album").html(data).show();});}
	else if (option=="b")
		{$.post(interactiveURL,{interactive:"add_new_member_album"},function(data) 
			{$("#remove_new_album").html(data).show();});}
	else
		{$.post(interactiveURL,{interactive:"remove_new_album"},function(data) 
			{$("#remove_new_album").html(data).show();});}}
		
function uploadImages_form(a)
	{var exiting_album2=document.getElementById("upload_images");
	var existing_album=exiting_album2.options[exiting_album2.selectedIndex].value;
	if (existing_album=='a')
		{var name=document.getElementById('upload_name').value;}
	else if (existing_album=='b')
		{var name=document.getElementById('upload_name').value;}
	else {var name=document.getElementById('upload_images').value;}
	var pictures2=document.getElementById('upload_files').value;
	var pictures=pictures2.split('.').pop();
	if (name=='')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Album requires a name. <br/>Please enter an album name!</font><br/><br/>').show();}	
	else if (pictures.indexOf('jpg')!==-1 || pictures.indexOf('jpeg')!==-1 || pictures.indexOf('png')!==-1 || pictures.indexOf('gif')!==-1)
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		document.forms["uploadImages_form"].submit();}
	else {$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!</font><br/><br/>').show();}}

function uploadVideos_form()
	{var name=document.getElementById('upload_name').value;
	var video=document.getElementById('upload_files').value;
	var picture2=document.getElementById('upload_files2').value;
	var video=video.split('.').pop();
	var picture=picture2.split('.').pop();
	if (name=='')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Video requires a name. <br/>Please enter a video name!</font><br/><br/>').show();}	
	else if (video=='')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Select videos with the accepted format. <br/>Please only upload MP4 videos!</font><br/><br/>').show();}
	else if (video.indexOf('mp4')==-1)
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Select videos with the accepted format. <br/>Please only upload MP4 videos!</font><br/><br/>').show();}
	else if (picture.indexOf('jpg')!==-1 || picture.indexOf('jpeg')!==-1 || picture.indexOf('png')!==-1 || picture.indexOf('gif')!==-1)
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		document.forms["uploadVideos_form"].submit();}
	else {$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!</font><br/><br/>').show();}}

function uploadGifs_form()
	{var count=$('input:file[value!=""]').length;
	var exiting_album2=document.getElementById("upload_images");
	var existing_album=exiting_album2.options[exiting_album2.selectedIndex].value;
	if (existing_album=='a')
		{var name=document.getElementById('upload_name').value;}
	else if (existing_album=='b')
		{var name=document.getElementById('upload_name').value;}
	else {var name=document.getElementById('upload_images').value;}
	if (name=='')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Album requires a name. <br/>Please enter an album name!</font><br/><br/>').show();}	
	else {var picture2=document.getElementById('upload_files1').value;
			var picture4=document.getElementById('upload_files2').value;
			var picture6=document.getElementById('upload_files3').value;
			var picture=picture2.split('.').pop();
			var picture3=picture4.split('.').pop();
			var picture5=picture6.split('.').pop();
			if (picture.indexOf('jpg')!==-1 || picture.indexOf('jpeg')!==-1 || picture.indexOf('png')!==-1 || picture.indexOf('gif')!==-1)
				{if (picture3.indexOf('jpg')!==-1 || picture3.indexOf('jpeg')!==-1 || picture3.indexOf('png')!==-1 || picture3.indexOf('gif')!==-1)
					{if (picture5.indexOf('jpg')!==-1 || picture5.indexOf('jpeg')!==-1 || picture5.indexOf('png')!==-1 || picture5.indexOf('gif')!==-1)
						{$("div.full_page_loader").removeClass("full_page_loader_hidden");
						document.forms["uploadGifs_form"].submit();}
					else {$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Select pictures (>2) with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!</font><br/><br/>').show();}}
				else {$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Select pictures (>2) with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!</font><br/><br/>').show();}}
			else {$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Select pictures (>2) with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!</font><br/><br/>').show();}}}
	
function uploadGames_form()
	{var name=document.getElementById('upload_name').value;
	var game2=document.getElementById('upload_files1').value;
	var picture2=document.getElementById('upload_files2').value;
	var game=game2.split('.').pop();
	var picture=picture2.split('.').pop();
	if (name=='')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Game requires a name. <br/>Please enter a game name!</font><br/><br/>').show();}	
	else if (game.indexOf('swf')==-1)
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Select games with the accepted format. <br/>Please upload only SWF games!</font><br/><br/>').show();}	
	else if (picture.indexOf('jpg')!==-1 || picture.indexOf('jpeg')!==-1 || picture.indexOf('png')!==-1 || picture.indexOf('gif')!==-1)
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		document.forms["uploadGames_form"].submit();}
	else {$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Select pictures with the accepted formats. <br/>Please only upload JPG, PNG, or GIF pictures!</font><br/><br/>').show();}}
	
		
function add_remove_new_create()
	{var option = document.getElementById("new_create").value;
	if (option=="planets")
		{$.post(interactiveURL,{interactive:"add_new_planet"},function(data) 
			{$("#add_remove_new_create").html(data).show();});}
	else
		{$.post(interactiveURL,{interactive:"remove_new_create"},function(data) 
			{$("#add_remove_new_create").html(data).show();});}
	}
		
function planet_form()
	{var name=document.getElementById('create_name').value;
	if (name=='')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Planet requires a name. <br/>Please enter a planet name!</font><br/><br/>').show();}
	else{document.forms["planet_form"].submit();}}

////////////// POSTING //////////////
$('#post_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function post_form()
	{var post_field = $('#post_field');
	var post_type = $('#post_type:checked');
	if (post_field.val() == '')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Post field is empty. Please fill it in!</font><br/><br/>').show();}
	else
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$("#interactive_error").html('').show();
		$.post(url,{id:id,ids:ids,type:type,post:post_field.val(),post_type:post_type.val(),file_location:file_location,thisWipit:thisRandNum},function(data)
			{$('#bottom_wall').html(data).show();
			document.post_form.post_field.value='';
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}

////////////// NOTING //////////////
$('#note_form').submit(function(){$('input[type=note]', this).attr('disabled', 'disabled');});
function note_form()
	{var note_subject = $('#note_subject');
	var note_field = $('#note_field');
	var note_type = $('#note_type:checked');
	if (note_subject.val() == '')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Subject field is empty. Please fill it in!</font><br/><br/>').show();}
	else if (note_field.val() == '')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Note field is empty. Please fill it in!</font><br/><br/>').show();}
	else
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$("#interactive_error").html('').show();
		$.post(url,{id:id,ids:ids,type:type,subject:note_subject.val(),note:note_field.val(),note_type:note_type.val(),file_location:file_location,thisWipit:thisRandNum},function(data)
			{$('#bottom_wall').html(data).show();
			document.note_form.note_field.value='';
			document.note_form.note_subject.value='';
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
		
////////////// LIKE/LOVE WALL STUFF //////////////
function Like_item(a,b,c,d)
	{$.post(like_loveURL,{like_love:"create_Like_item",id:a,ids:b,item_id:c,item_type:d,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#like_love_"+d+c).html(data).show()});	
	}
function Love_item(a,b,c,d)
	{$.post(like_loveURL,{like_love:"create_Love_item",id:a,ids:b,item_id:c,item_type:d,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#like_love_"+d+c).html(data).show()});	
	}
function unlikeLike_item(a,b,c,d)
	{$.post(like_loveURL,{like_love:"create_unlikeLike_item",id:a,ids:b,item_id:c,item_type:d,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#like_love_"+d+c).html(data).show()});
	}
function unloveLove_item(a,b,c,d)
	{$.post(like_loveURL,{like_love:"create_unloveLove_item",id:a,ids:b,item_id:c,item_type:d,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#like_love_"+d+c).html(data).show()});
	}
	
////////////// TYPE CHANGER //////////////	
function type_change(a,b)
	{$.post(interactive,{interactive:"type_change",item_id:a,item_type:b,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#type_change_"+b+a).html(data).show();});}
////////////// MEMORY BOX //////////////
function memory_box(a,b)
	{$.post(interactive,{interactive:"memory_box",item_id:a,item_type:b,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#memory_box_"+b+a).html(data).show();});}
function memory_box2_posts(a,b,c)
	{$.post(interactive,{interactive:"memory_box_posts",id:id,item_id:a,item_type:b,ids:c,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#memory_box_"+b+a).html(data).show();});}
////////////// POINT WALL STUFF //////////////
function point1(a,b,c)
	{$.post(interactiveURL,{interactive:"point1",ids:a,item_id:b,item_type:c,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#point_"+c+b).html(data).show();});}
function point2(a,b,c)
	{$.post(url,{interactive:"point2",ids:a,item_id:b,item_type:c,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#point_"+c+b).html(data).show();
		$("#point_reload").load('../scripts/point_reload.php');});}
////////////// DELETING WALL STUFF //////////////
function delete_item1(a,b)
	{$.post(interactiveURL,{interactive:"delete_item1",item_id:a,item_type:b,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#delete_"+b+a).html(data).show();});}
function delete_item2(a,b)
	{$.post(url,{interactive:"delete_item2",item_id:a,item_type:b,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#item_box_"+b+a).html(data).show();});}
////////////// POSTS //////////////
function delete_post1(a)
	{$.post(interactiveURL,{interactive:"delete_post1",post_id:a,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#delete_posts"+a).html(data).show();});}
function delete_post2(a)
	{$.post(url,{interactive:"delete_post2",post_id:a,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#post_box"+a).html(data).show();});}
////////////// MEMBER POSTS //////////////
function delete_member_post1(a)
	{$.post(interactiveURL,{interactive:"delete_member_post1",post_id:a,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#delete_member_posts"+a).html(data).show();});}
function delete_member_post2(a)
	{$.post(url,{interactive:"delete_member_post2",post_id:a,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#member_post_box"+a).html(data).show();});}
	
////////////// LIKE/LOVE COMMENTS //////////////
function Like_comment(a,b,c,d)
	{$.post(like_loveURL,{like_love:"Like_comment",id:a,ids:b,comment_id:c,comment_type:d,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#like_love_comment_"+d+c).html(data).show()});	
	}
function Love_comment(a,b,c,d)
	{$.post(like_loveURL,{like_love:"Love_comment",id:a,ids:b,comment_id:c,comment_type:d,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#like_love_comment_"+d+c).html(data).show()});	
	}
function unlikeLike_comment(a,b,c,d)
	{$.post(like_loveURL,{like_love:"unlikeLike_comment",id:a,ids:b,comment_id:c,comment_type:d,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#like_love_comment_"+d+c).html(data).show()});
	}
function unloveLove_comment(a,b,c,d)
	{$.post(like_loveURL,{like_love:"unloveLove_comment",id:a,ids:b,comment_id:c,comment_type:d,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#like_love_comment_"+d+c).html(data).show()});
	}

////////////// EXPAND COMMENTS //////////////
function expand_comments(a,b)
	{$.post(commentURL,{interactive:"expand_comments",item_id:a,comment_type:b,id:id,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#comments_"+b+a).html(data).show()});}

////////////// COMMENT BOX //////////////
function comment(a,b)
	{$.post(commentURL,{interactive:"Comment",item_id:a,comment_type:b,id:id,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#comment_"+b+a).html(data).show()});	
	$("#comment_space_"+b+a).addClass("comment_space");}
	
////////////// COMMENTING //////////////
$('#comment_form').submit(function(){$('input[type=submit]', this).attr('disabled', 'disabled');});
function comment_form(a,b)
	{var comment_field = $('#comment_field'+a);
	if (comment_field.val() == '')
		{$("#top_result_div2").html('<font color="#dd4a4a" style="font:12px helvetica, sans-serif;">Comment field is empty. <br/>Please write something!</font><br/><br/>').show();}
	else
		{$.post(commentURL,{id:id,ids:ids,item_id:a,comment_type:b,the_comment:comment_field.val(),id:id,typex:type,thisWipit:thisRandNum},function(data)
			{$('#comments_'+b+a).html(data).show();
			document.comment_form.comment_field.value='';});
		}
	}
	
////////////// COMMENT POINT WALL STUFF //////////////
function comment_point1(a,b,c)
	{$.post(commentURL,{interactive:"comment_point1",ids:a,comment_id:b,comment_type:c,id:id,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#comment_point_"+c+b).html(data).show();});}
function comment_point2(a,b,c)
	{$.post(commentURL,{interactive:"comment_point2",ids:a,comment_id:b,comment_type:c,id:id,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#comment_point_"+c+b).html(data).show();
		$("#point_reload").load('../scripts/point_reload.php');});}
	
////////////// DELETING COMMENTS //////////////
function delete_comment1(a,b,c)
	{$.post(commentURL,{interactive:"delete_comment1",item_id:a,comment_id:b,comment_type:c,id:id,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#delete_comment_"+c+b).html(data).show();});}
function delete_comment2(a,b,c)
	{$.post(commentURL,{interactive:"delete_comment2",item_id:a,comment_id:b,comment_type:c,id:id,typex:type,thisWipit:thisRandNum},function(data) 
		{$("#comment_list_"+c+b).html(data).show();});}
	
function display_pictures()
	{var i=document.getElementById('upload_files').files.length;
	if (i>1){x="Pictures Selected ("+i+")";}
	else if (i=1){x="Picture Selected ("+i+")";}
		document.getElementById("fakeupload").innerHTML=x;}
		
function display_picture()
	{var a=document.getElementById('upload_files2').value;
    var b=a.replace("C:\\fakepath\\","");
		document.getElementById("fakeupload2").innerHTML=b;}
		
function display_picture_planet()
	{var a=document.getElementById('upload_files2_planet').value;
    var b=a.replace("C:\\fakepath\\","");
		document.getElementById("fakeupload2_planet").innerHTML=b;}
		
function display_game()
	{var a=document.getElementById('upload_files1').value;
    var b=a.replace("C:\\fakepath\\","");
		document.getElementById("fakeupload1").innerHTML=b;}
		
function display_video()
	{var a=document.getElementById('upload_files').value;
    var b=a.replace("C:\\fakepath\\","");
		document.getElementById("fakeupload").innerHTML=b;}
		
function display_gifs(number)
	{var x="";
	var a=document.getElementById('upload_files'+number).value;
    var b=a.replace("C:\\fakepath\\","");
		document.getElementById("fakeupload"+number).innerHTML=b;
	if (number==5)
		{$(".class").removeClass("upload_files2");
		$(".class").addClass("upload_files5");
		for (var numberx=6; numberx<11; numberx++)
			{if (numberx==10){var numberx2=2;}
			else {var numberx2=5;}
			var input='<input onchange="display_gifs('+numberx+')" name="upload_files'+numberx+'" id="upload_files'+numberx+'" class="upload_files" type="file" size="76" name="upload_picture"/>';
			var x=x+'<div id="fakeupload'+numberx+'" class="fakeupload"><font style="color:#696969;">'+numberx+'</font></div><div class="upload_files'+numberx2+' class">'+input+'</div>';}
		document.getElementById("gif_part_"+2).innerHTML=x;}
	if (number==10)
		{$(".class").removeClass("upload_files2");
		$(".class").addClass("upload_files5");
		for (var numberx=11; numberx<16; numberx++)
			{if (numberx==10){var numberx2=2;}
			else {var numberx2=5;}
			var input='<input onchange="display_gifs('+numberx+')" name="upload_files'+numberx+'" id="upload_files'+numberx+'" class="upload_files" type="file" size="76" name="upload_picture"/>';
			var x=x+'<div id="fakeupload'+numberx+'" class="fakeupload"><font style="color:#696969;">'+numberx+'</font></div><div class="upload_files'+numberx2+' class">'+input+'</div>';}
		document.getElementById("gif_part_"+3).innerHTML=x;}
	if (number==15)
		{$(".class").removeClass("upload_files2");
		$(".class").addClass("upload_files5");
		for (var numberx=16; numberx<21; numberx++)
			{if (numberx==10){var numberx2=2;}
			else {var numberx2=5;}
			var input='<input onchange="display_gifs('+numberx+')" name="upload_files'+numberx+'" id="upload_files'+numberx+'" class="upload_files" type="file" size="76" name="upload_picture"/>';
			var x=x+'<div id="fakeupload'+numberx+'" class="fakeupload"><font style="color:#696969;">'+numberx+'</font></div><div class="upload_files'+numberx2+' class">'+input+'</div>';}
		document.getElementById("gif_part_"+4).innerHTML=x;}
	}
		
function display_box() 
	{$(".display_button").click(function(e) 
		{$("fieldset#sub_button_friends").hide();
		$(".friends_button").removeClass("selected_button_bottom");
		e.preventDefault();
		$("fieldset#display_image_button").hide();
        $("fieldset#display_button").show();
		$(".body").addClass("darken");});
		$("fieldset#display_button").mouseup(function() 
			{return false});
        $(document).mouseup(function(e)
			{if($(e.target).parent("a.display_button").length==0)
				{$(".body").removeClass("darken");
				$("#display_div").html('<img class="full_page_loader_array" src="../barterrain_main_images/loader_full_'+color+'.gif" width="128px"/>');
				$("fieldset#display_button").hide();}
        });            
	}
	
function display_image_box() 
	{$(".display_image_button").click(function(e) 
		{$("fieldset#sub_button_friends").hide();
		$(".friends_button").removeClass("selected_button_bottom");
		e.preventDefault();
		$("fieldset#display_button").hide();
        $("fieldset#display_image_button").show();
		$(".body").addClass("darken");});
		$("fieldset#display_image_button").mouseup(function() 
			{return false});
        $(document).mouseup(function(e)
			{if($(e.target).parent("img.display_image_button").length==0)
				{$(".body").removeClass("darken");
				$("#display_image_div").html('<img class="full_page_loader_image" src="../barterrain_main_images/loader_full_'+color+'.gif" width="128px"/>');
				$("fieldset#display_image_button").hide();}
        });            
	}
		
var DisplayItem = "../scripts/display_item.php";
var DisplayImage = "../scripts/create_display_image.php";
var DisplayArray = "../scripts/display_array.php";

// Display Item	
function display_item(a,b,c,d,e)
	{display_box();
	$.post(DisplayItem,{ids:a,item_id:b,item_type:c,create_id:d,create_type:e,type:type},function(data) 
		{$("#display_div").html(data).show();});
	}
// Display Image	
function display_image(a,b,c)
	{display_image_box();
	$.post(DisplayImage,{display:"display_image",id:a,ids:b,image_id:c,type:type,color:color},function(data) 
		{$("#display_image_div").html(data).show();});
	}
// List Arrays
function display_mutual_FF(a,b,c)
	{display_box();
	$.post(DisplayArray,{display:"mutual_FF_array",id:a,ids:b,mutual_FF_array:c},function(data) 
		{$("#display_div").html(data).show();});
	}
// List Arrays
function display_planet_FF(a,b,c)
	{display_box();
	$.post(DisplayArray,{display:"planet_FF_array",id:a,ids:b,planet_FF_array:c},function(data) 
		{$("#display_div").html(data).show();});
	}
		
// List Arrays
function display_like_array(a,b,c,d)
	{display_box();
	$.post(DisplayArray,{display:"like_array",id:a,ids:b,item_id:c,item_type:d,type:type},function(data) 
		{$("#display_div").html(data).show();});
	}
function display_love_array(a,b,c,d)
	{display_box();
	$.post(DisplayArray,{display:"love_array",id:a,ids:b,item_id:c,item_type:d,type:type},function(data) 
		{$("#display_div").html(data).show();});
	}
function display_point_array(a,b,c,d)
	{display_box();
	$.post(DisplayArray,{display:"point_array",id:a,ids:b,item_id:c,item_type:d,type:type},function(data) 
		{$("#display_div").html(data).show();});
	}
function display_like_array_comment(a,b,c,d)
	{display_box();
	$.post(DisplayArray,{display:"like_array_comment",id:a,ids:b,item_id:c,item_type:d,type:type},function(data) 
		{$("#display_div").html(data).show();});
	}
function display_love_array_comment(a,b,c,d)
	{display_box();
	$.post(DisplayArray,{display:"love_array_comment",id:a,ids:b,item_id:c,item_type:d,type:type},function(data) 
		{$("#display_div").html(data).show();});
	}
function display_point_array_comment(a,b,c,d)
	{display_box();
	$.post(DisplayArray,{display:"point_array_comment",id:a,ids:b,item_id:c,item_type:d,type:type},function(data) 
		{$("#display_div").html(data).show();});
	}
	
$(document).ready(function () 
	{var $sidebar = $("#planet_page_left "),
    $window = $(window),
    sidebartop = $("#planet_page_left").position().top;
	$window.scroll(function() 
		{if ($window.height() > $sidebar.height()) 
			{$sidebar.removeClass('fixedBtm');
        	if($sidebar.offset().top <= $window.scrollTop() && sidebartop <= $window.scrollTop()) 
				{$sidebar.addClass('fixedTop');} 
			else {$sidebar.removeClass('fixedTop');}
			}
		else 
			{$sidebar.removeClass('fixedTop');
        	if ($window.height() + $window.scrollTop() > $sidebar.offset().top + $sidebar.height()+20) 
				{$sidebar.addClass('fixedBtm');}
       		if ($sidebar.offset().top < 0) 
				{$sidebar.removeClass('fixedBtm');}
    		}
    	}
	);});