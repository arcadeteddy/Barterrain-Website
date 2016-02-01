var interactiveURL = "../scripts/interactive_changer.php";
var interactive = "../scripts/interactive_box.php";
var commentURL = "../scripts/comment_box.php";
var url = "../scripts/interactive_box.php";
var like_loveURL = "../scripts/like_love.php";

// Side
var PageChangerURL = "../scripts/page_changer.php";
function window_1(a,b)
	{$.post(PageChangerURL,{page:"inside_window_1",ids:a,id:b},function(data) 
		{$(".side_hidden_div").addClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".inside_window_1").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".inside_page_middle_right").removeClass("hide_div");
		$(".inside_page_middle_left").removeClass("expand");
		$("#inside_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_2(a,b)
	{$.post(PageChangerURL,{page:"inside_window_2",ids:a,id:b},function(data) 
		{$(".side_hidden_div").addClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".inside_window_2").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".inside_page_middle_right").removeClass("hide_div");
		$(".inside_page_middle_left").removeClass("expand");
		$("#inside_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_3(a,b)
	{$.post(PageChangerURL,{page:"inside_window_3",ids:a,id:b},function(data) 
		{$(".side_hidden_div").addClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".inside_window_3").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".inside_page_middle_right").removeClass("hide_div");
		$(".inside_page_middle_left").removeClass("expand");
		$("#inside_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_4(a,b)
	{$.post(PageChangerURL,{page:"inside_window_4",ids:a,id:b},function(data) 
		{$(".side_hidden_div").addClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".inside_window_4").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".inside_page_middle_right").removeClass("hide_div");
		$(".inside_page_middle_left").removeClass("expand");
		$("#inside_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_5(a,b)
	{$.post(PageChangerURL,{page:"inside_window_5",ids:a,id:b},function(data) 
		{$(".side_hidden_div").addClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".inside_window_5").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".inside_page_middle_right").removeClass("hide_div");
		$(".inside_page_middle_left").removeClass("expand");
		$("#inside_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_6(a,b)
	{$.post(PageChangerURL,{page:"inside_window_6",ids:a,id:b},function(data) 
		{$(".side_hidden_div").addClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".inside_window_6").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".inside_page_middle_right").removeClass("hide_div");
		$(".inside_page_middle_left").removeClass("expand");
		$("#inside_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_7(a,b)
	{$.post(PageChangerURL,{page:"inside_window_7",ids:a,id:b},function(data) 
		{$(".side_hidden_div").addClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".inside_window_7").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".inside_page_middle_right").removeClass("hide_div");
		$(".inside_page_middle_left").removeClass("expand");
		$("#inside_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_8(a,b)
	{$.post(PageChangerURL,{page:"inside_window_8",ids:a,id:b},function(data) 
		{$(".side_button_tabs").removeClass("selected_window");
		$(".side_hidden_div").addClass("hide_div");
		$(".planets_side").removeClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".inside_window_8").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".inside_page_middle_right").removeClass("hide_div");
		$(".inside_page_middle_left").removeClass("expand");
		$("#inside_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_9(a,b)
	{$.post(PageChangerURL,{page:"inside_window_9",ids:a,id:b},function(data) 
		{$(".side_button_tabs").removeClass("selected_window");
		$(".side_hidden_div").addClass("hide_div");
		$(".family_side").removeClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".inside_window_9").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".inside_page_middle_right").removeClass("hide_div");
		$(".inside_page_middle_left").removeClass("expand");
		$("#inside_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_10(a,b)
	{$.post(PageChangerURL,{page:"inside_window_10",ids:a,id:b},function(data) 
		{$(".side_button_tabs").removeClass("selected_window");
		$(".side_hidden_div").addClass("hide_div");
		$(".subscriptions_side").removeClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".inside_window_10").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".inside_page_middle_right").removeClass("hide_div");
		$(".inside_page_middle_left").removeClass("expand");
		$("#inside_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
	
function planets_changer(a,b,c)
	{$.post(PageChangerURL,{page:"planets_changer",ids:a,id:b,planets_id:c},function(data) 
		{$(".side_button_tabs").removeClass("selected_window");
		$(".planet_window_"+c).toggleClass("selected_window");
		$(".inside_page_middle_right").removeClass("hide_div");
		$(".inside_page_middle_left").removeClass("expand");
		$("#inside_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function subscriptions_changer(a,b,c)
	{$.post(PageChangerURL,{page:"subscriptions_changer",ids:a,id:b,subscriptions_id:c},function(data) 
		{$(".side_button_tabs").removeClass("selected_window");
		$(".subscription_window_"+c).toggleClass("selected_window");
		$(".inside_page_middle_right").removeClass("hide_div");
		$(".inside_page_middle_left").removeClass("expand");
		$("#inside_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function family_changer(a,b,c)
	{$.post(PageChangerURL,{page:"family_changer",ids:a,id:b,family_id:c},function(data) 
		{$(".side_button_tabs").removeClass("selected_window");
		$(".family_window_"+c).toggleClass("selected_window");
		$(".inside_page_middle_right").removeClass("hide_div");
		$(".inside_page_middle_left").removeClass("expand");
		$("#inside_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
	
// Friends Options Menu
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

// Friends Options
var friendRequestURL = "../scripts/request_as_friend.php";
function addAsFriend(a,b)
	{$.post(friendRequestURL,{request:"requestFriendship",user_id:a,request_id:b,thisWipit:thisRandNum},function(data) 
		{$("#top_result_div").html(data).show()});	
	}
function addAsFriend2(a,b)
	{$.post(friendRequestURL,{request:"requestFriendship2",user_id:a,request_id:b,thisWipit:thisRandNum},function(data) 
		{$("#request"+b).html(data).show()});	
	}
function removeAsFriend(a,b)
	{$.post(friendRequestURL,{request:"removeFriendship",user_id:a,request_id:b,thisWipit:thisRandNum},function(data) 
		{$("body").html(data).show()});	
	}
function FriendstoFamily(a,b)
	{$.post(friendRequestURL,{request:"FriendstoFamily",ids:a,id:b,thisWipit:thisRandNum},function(data) 
		{$("#top_result_div").html(data).show()});	
	}
function FamilytoFriends(a,b)
	{$.post(friendRequestURL,{request:"FamilytoFriends",ids:a,id:b,thisWipit:thisRandNum},function(data) 
		{$("#top_result_div").html(data).show()});	
	}
function blockUser(a,b)
	{$.post(friendRequestURL,{request:"blockUser",ids:a,id:b,thisWipit:thisRandNum},function(data) 
		{$("#top_result_div").html(data).show()});	
	}
function unblockUser(a,b)
	{$.post(friendRequestURL,{request:"unblockUser",ids:a,id:b,thisWipit:thisRandNum},function(data) 
		{$("#top_result_div").html(data).show()});	
	}
function subscribeUser(a,b)
	{$.post(friendRequestURL,{request:"subscribeUser",ids:a,id:b,thisWipit:thisRandNum},function(data) 
		{$("#top_result_div").html(data).show()});	
	}
function unsubscribeUser(a,b)
	{$.post(friendRequestURL,{request:"unsubscribeUser",ids:a,id:b,thisWipit:thisRandNum},function(data) 
		{$("#top_result_div").html(data).show()});	
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
function points()
	{$("#interactive_error").html('').show();
		$(".top_boxes").removeClass("selected_box");
		$(".top_box6").toggleClass("selected_box");
		$("#bottom_half_box").hide();
		$(".bottom_half_box_hide").hide();
		$("#bottom_half_box_points").show();
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
	{$.post(interactiveURL,{ids:ids,interactive:"images"},function(data) 
		{$("#bottom_half_box").html(data).show();
		$("#bottom_half_box").show();
		$(".bottom_half_box_hide").hide();});}
function UploadGifs()
	{$.post(interactiveURL,{ids:ids,interactive:"gifs"},function(data) 
		{$("#bottom_half_box").html(data).show();
		$("#bottom_half_box").show();
		$(".bottom_half_box_hide").hide();});}
function UploadVideos()
	{$.post(interactiveURL,{ids:ids,interactive:"videos"},function(data) 
		{$("#bottom_half_box").html(data).show();
		$("#bottom_half_box").show();
		$(".bottom_half_box_hide").hide();});}
function UploadGames()
	{$.post(interactiveURL,{ids:ids,interactive:"games"},function(data) 
		{$("#bottom_half_box").html(data).show();
		$("#bottom_half_box").show();
		$(".bottom_half_box_hide").hide();});}
		
////////////// POINTS //////////////
function PointsAdvertise()
	{$.post(interactiveURL,{ids:ids,interactive:"points_advertise"},function(data) 
		{$("#bottom_half_box").html(data).show();
		$("#bottom_half_box").show();
		$(".bottom_half_box_hide").hide();});}
function PointsBC()
	{$.post(interactiveURL,{ids:ids,interactive:"points_bc"},function(data) 
		{$("#bottom_half_box").html(data).show();
		$("#bottom_half_box").show();
		$(".bottom_half_box_hide").hide();});}
function PointsReveal()
	{$.post(interactiveURL,{ids:ids,interactive:"points_reveal"},function(data) 
		{$("#bottom_half_box").html(data).show();
		$("#bottom_half_box").show();
		$(".bottom_half_box_hide").hide();});}
function PointsTT()
	{$.post(interactiveURL,{ids:ids,interactive:"points_tt"},function(data) 
		{$("#bottom_half_box").html(data).show();
		$("#bottom_half_box").show();
		$(".bottom_half_box_hide").hide();});}
		
function add_remove_new_album()
	{var option = document.getElementById("upload_images").value;
	if (option=="")
		{$.post(interactiveURL,{interactive:"add_new_album"},function(data) 
			{$("#remove_new_album").html(data).show();});}
	else
		{$.post(interactiveURL,{interactive:"remove_new_album"},function(data) 
			{$("#remove_new_album").html(data).show();});}}
		
function uploadImages_form(a)
	{var exiting_album2=document.getElementById("upload_images");
	var existing_album=exiting_album2.options[exiting_album2.selectedIndex].value;
	if (existing_album=='')
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
	var video=video.split('.').pop();
	if (name=='')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Video requires a name. <br/>Please enter a video name!</font><br/><br/>').show();}	
	else if (video=='')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Select videos with the accepted format. <br/>Please only upload MP4 videos!</font><br/><br/>').show();}
	else if (video.indexOf('mp4')!==-1)
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		document.forms["uploadVideos_form"].submit();}
	else {$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Select videos with the accepted format. <br/>Please only upload MP4 videos!</font><br/><br/>').show();}
	}

function uploadGifs_form()
	{var count=$('input:file[value!=""]').length;
	var exiting_album2=document.getElementById("upload_images");
	var existing_album=exiting_album2.options[exiting_album2.selectedIndex].value;
	if (existing_album=='')
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
		
function planet_form()
	{var name=document.getElementById('create_name').value;
	if (name=='')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Planet requires a name. <br/>Please enter a planet name!</font><br/><br/>').show();}
	else
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		document.forms["planet_form"].submit();}}

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
		$.post(url,{id:id,ids:ids,post:post_field.val(),type:post_type.val(),file_location:file_location,thisWipit:thisRandNum},function(data)
			{$('#bottom_news').html(data).show();
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
	var url = "../scripts/interactive_box.php";
	if (note_subject.val() == '')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Subject field is empty. Please fill it in!</font><br/><br/>').show();}
	else if (note_field.val() == '')
		{$("#interactive_error").html('<font class="color" style="font:12px helvetica, sans-serif;">Note field is empty. Please fill it in!</font><br/><br/>').show();}
	else
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$("#interactive_error").html('').show();
		$.post(url,{id:id,subject:note_subject.val(),note2:note_field.val(),type:note_type.val(),file_location:file_location,thisWipit:thisRandNum},function(data)
			{$('#bottom_news').html(data).show();
			document.note_form.note_field.value='';
			document.note_form.note_subject.value='';
			$("div.full_page_loader").addClass("full_page_loader_hidden");});
		}
	}
	
////////////// LIKE/LOVE POSTING //////////////
function Like_post(a,b,c,d)
	{$.post(like_loveURL,{like_love:"Like_post",id:a,ids:b,post_id:c,item_type:d,thisWipit:thisRandNum},function(data) 
		{$("#like_love_"+d+c).html(data).show()});	
	}
function Love_post(a,b,c,d)
	{$.post(like_loveURL,{like_love:"Love_post",id:a,ids:b,post_id:c,item_type:d,thisWipit:thisRandNum},function(data) 
		{$("#like_love_"+d+c).html(data).show()});	
	}
function unlikeLike_post(a,b,c,d)
	{$.post(like_loveURL,{like_love:"unlikeLike_post",id:a,ids:b,post_id:c,item_type:d,thisWipit:thisRandNum},function(data) 
		{$("#like_love_"+d+c).html(data).show()});
	}
function unloveLove_post(a,b,c,d)
	{$.post(like_loveURL,{like_love:"unloveLove_post",id:a,ids:b,post_id:c,item_type:d,thisWipit:thisRandNum},function(data) 
		{$("#like_love_"+d+c).html(data).show()});
	}
	
////////////// POSTS //////////////
function delete_post1(a,b)
	{$.post(interactiveURL,{interactive:"delete_post1",post_id:a,item_type:b,thisWipit:thisRandNum},function(data) 
		{$("#delete_"+b+a).html(data).show();});}
function delete_post2(a,b)
	{$.post(url,{interactive:"delete_post2",post_id:a,item_type:b,thisWipit:thisRandNum},function(data) 
		{$("#box_"+b+a).html(data).show();});}
////////////// TYPE CHANGER //////////////	
function type_change(a,b)
	{$.post(interactive,{interactive:"type_change",item_id:a,item_type:b,thisWipit:thisRandNum},function(data) 
		{$("#type_change_"+b+a).html(data).show();});}
		
////////////// LIKE/LOVE news STUFF //////////////
function Like_item(a,b,c,d)
	{$.post(like_loveURL,{like_love:"Like_item",id:a,ids:b,item_id:c,item_type:d,thisWipit:thisRandNum},function(data) 
		{$("#like_love_"+d+c).html(data).show()});	
	}
function Love_item(a,b,c,d)
	{$.post(like_loveURL,{like_love:"Love_item",id:a,ids:b,item_id:c,item_type:d,thisWipit:thisRandNum},function(data) 
		{$("#like_love_"+d+c).html(data).show()});	
	}
function unlikeLike_item(a,b,c,d)
	{$.post(like_loveURL,{like_love:"unlikeLike_item",id:a,ids:b,item_id:c,item_type:d,thisWipit:thisRandNum},function(data) 
		{$("#like_love_"+d+c).html(data).show()});
	}
function unloveLove_item(a,b,c,d)
	{$.post(like_loveURL,{like_love:"unloveLove_item",id:a,ids:b,item_id:c,item_type:d,thisWipit:thisRandNum},function(data) 
		{$("#like_love_"+d+c).html(data).show()});
	}
	
////////////// MEMORY BOX //////////////
function memory_box(a,b)
	{$.post(interactive,{interactive:"memory_box",item_id:a,item_type:b,thisWipit:thisRandNum},function(data) 
		{$("#memory_box_"+b+a).html(data).show();});}
function memory_box2_posts(a,b,c)
	{$.post(interactive,{interactive:"memory_box_posts",id:id,item_id:a,item_type:b,ids:c,thisWipit:thisRandNum},function(data) 
		{$("#memory_box_"+b+a).html(data).show();});}
////////////// POINT news STUFF //////////////
function point1(a,b,c)
	{$.post(interactiveURL,{interactive:"point1",ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("#point_"+c+b).html(data).show();});}
function point2(a,b,c)
	{$.post(url,{interactive:"point2",ids:a,item_id:b,item_type:c,thisWipit:thisRandNum},function(data) 
		{$("#point_"+c+b).html(data).show();
		$("#point_reload").load('../scripts/point_reload.php');});}
////////////// DELETING news STUFF //////////////
function delete_item1(a,b)
	{$.post(interactiveURL,{interactive:"delete_item1",item_id:a,item_type:b,thisWipit:thisRandNum},function(data) 
		{$("#delete_"+b+a).html(data).show();});}
function delete_item2(a,b)
	{$.post(url,{interactive:"delete_item2",item_id:a,item_type:b,thisWipit:thisRandNum},function(data) 
		{$("#item_box_"+b+a).html(data).show();});}
	
////////////// LIKE/LOVE COMMENTS //////////////
function Like_comment(a,b,c,d)
	{$.post(like_loveURL,{like_love:"Like_comment",id:a,ids:b,comment_id:c,comment_type:d,thisWipit:thisRandNum},function(data) 
		{$("#like_love_comment_"+d+c).html(data).show()});	
	}
function Love_comment(a,b,c,d)
	{$.post(like_loveURL,{like_love:"Love_comment",id:a,ids:b,comment_id:c,comment_type:d,thisWipit:thisRandNum},function(data) 
		{$("#like_love_comment_"+d+c).html(data).show()});	
	}
function unlikeLike_comment(a,b,c,d)
	{$.post(like_loveURL,{like_love:"unlikeLike_comment",id:a,ids:b,comment_id:c,comment_type:d,thisWipit:thisRandNum},function(data) 
		{$("#like_love_comment_"+d+c).html(data).show()});
	}
function unloveLove_comment(a,b,c,d)
	{$.post(like_loveURL,{like_love:"unloveLove_comment",id:a,ids:b,comment_id:c,comment_type:d,thisWipit:thisRandNum},function(data) 
		{$("#like_love_comment_"+d+c).html(data).show()});
	}
	
var type = "planets";
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

////////////// EXPAND COMMENTS //////////////
function expand_comments(a,b)
	{$.post(commentURL,{interactive:"expand_comments",item_id:a,comment_type:b,thisWipit:thisRandNum},function(data) 
		{$("#comments_"+b+a).html(data).show()});}

////////////// COMMENT BOX //////////////
function comment(a,b)
	{$.post(commentURL,{interactive:"Comment",item_id:a,comment_type:b,thisWipit:thisRandNum},function(data) 
		{$("#comment_"+b+a).html(data).show()});	
	$("#comment_space_"+b+a).addClass("comment_space");}
	
////////////// COMMENTING //////////////
$('#comment_form').submit(function(){$('input[type=submit]', this).attr('disabled', 'disabled');});
function comment_form(a,b)
	{var comment_field = $('#comment_field'+a);
	if (comment_field.val() == '')
		{$("#top_result_div2").html('<font color="#dd4a4a" style="font:12px helvetica, sans-serif;">Comment field is empty. <br/>Please write something!</font><br/><br/>').show();}
	else
		{$.post(commentURL,{id:id,ids:ids,item_id:a,comment_type:b,the_comment:comment_field.val(),thisWipit:thisRandNum},function(data)
			{$('#comments_'+b+a).html(data).show();
			document.comment_form.comment_field.value='';});
		}
	}
	
////////////// CREATE EXPAND COMMENTS //////////////
function create_expand_comments(a,b,c,d)
	{$.post(create_commentURL,{interactive:"expand_comments",item_id:a,comment_type:b,typex:c,id:d,thisWipit:thisRandNum},function(data) 
		{$("#comments_"+b+a).html(data).show()});}

////////////// CREATE COMMENT BOX //////////////
function create_comment(a,b,c,d)
	{$.post(create_commentURL,{interactive:"Comment",item_id:a,comment_type:b,typex:c,id:d,thisWipit:thisRandNum},function(data) 
		{$("#comment_"+b+a).html(data).show()});	
	$("#comment_space_"+b+a).addClass("comment_space");}
	
////////////// CREATE COMMENTING //////////////
$('#comment_form').submit(function(){$('input[type=submit]', this).attr('disabled', 'disabled');});
function create_comment_form(a,b,c,d)
	{var comment_field = $('#comment_field'+a);
	if (comment_field.val() == '')
		{$("#top_result_div2").html('<font color="#dd4a4a" style="font:12px helvetica, sans-serif;">Comment field is empty. <br/>Please write something!</font><br/><br/>').show();}
	else
		{$.post(create_commentURL,{id:id,ids:ids,item_id:a,comment_type:b,typex:c,id:d,the_comment:comment_field.val(),thisWipit:thisRandNum},function(data)
			{$('#comments_'+b+a).html(data).show();
			document.create_comment_form.comment_field.value='';});
		}
	}
	
////////////// COMMENT POINT news STUFF //////////////
function comment_point1(a,b,c)
	{$.post(commentURL,{interactive:"comment_point1",ids:a,comment_id:b,comment_type:c,thisWipit:thisRandNum},function(data) 
		{$("#comment_point_"+c+b).html(data).show();});}
function comment_point2(a,b,c)
	{$.post(commentURL,{interactive:"comment_point2",ids:a,comment_id:b,comment_type:c,thisWipit:thisRandNum},function(data) 
		{$("#comment_point_"+c+b).html(data).show();
		$("#point_reload").load('../scripts/point_reload.php');});}
	
////////////// DELETING COMMENTS //////////////
function delete_comment1(a,b,c)
	{$.post(commentURL,{interactive:"delete_comment1",item_id:a,comment_id:b,comment_type:c,thisWipit:thisRandNum},function(data) 
		{$("#delete_comment_"+c+b).html(data).show();});}
function delete_comment2(a,b,c)
	{$.post(commentURL,{interactive:"delete_comment2",item_id:a,comment_id:b,comment_type:c,thisWipit:thisRandNum},function(data) 
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
var DisplayImage = "../scripts/display_image.php";
var DisplayArray = "../scripts/display_array.php";

// Display Item	
function display_item(a,b,c,d,e)
	{display_box();
	$.post(DisplayItem,{ids:a,item_id:b,item_type:c,create_id:d,create_type:e},function(data) 
		{$("#display_div").html(data).show();});
	}
// Display Image	
function display_image(a,b,c)
	{display_image_box();
	$.post(DisplayImage,{display:"display_image",id:a,ids:b,image_id:c,color:color},function(data) 
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
	$.post(DisplayArray,{display:"like_array",id:a,ids:b,item_id:c,item_type:d},function(data) 
		{$("#display_div").html(data).show();});
	}
function display_love_array(a,b,c,d)
	{display_box();
	$.post(DisplayArray,{display:"love_array",id:a,ids:b,item_id:c,item_type:d},function(data) 
		{$("#display_div").html(data).show();});
	}
function display_point_array(a,b,c,d)
	{display_box();
	$.post(DisplayArray,{display:"point_array",id:a,ids:b,item_id:c,item_type:d},function(data) 
		{$("#display_div").html(data).show();});
	}
function display_like_array_comment(a,b,c,d)
	{display_box();
	$.post(DisplayArray,{display:"like_array_comment",id:a,ids:b,item_id:c,item_type:d},function(data) 
		{$("#display_div").html(data).show();});
	}
function display_love_array_comment(a,b,c,d)
	{display_box();
	$.post(DisplayArray,{display:"love_array_comment",id:a,ids:b,item_id:c,item_type:d},function(data) 
		{$("#display_div").html(data).show();});
	}
function display_point_array_comment(a,b,c,d)
	{display_box();
	$.post(DisplayArray,{display:"point_array_comment",id:a,ids:b,item_id:c,item_type:d},function(data) 
		{$("#display_div").html(data).show();});
	}
	
$(document).ready(function () 
	{var $sidebar = $("#inside_page_left "),
    $window = $(window),
    sidebartop = $("#inside_page_left").position().top;
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
	
$(function()
	{var right_side = $('#search_page_right_daily_points');
    var right_sidePosTop = right_side.offset().top;
    var win = $(window);
    win.scroll(function(e)
		{var scrollTop = win.scrollTop();
        if (scrollTop >= right_sidePosTop-32)
			{right_side.css({position:'fixed',top:'0px',marginTop:'32px'});}
		else if (right_side.css('position') === 'fixed')
			{right_side.css({position:'',top:'0px',marginTop:'0px'});}
    });
});