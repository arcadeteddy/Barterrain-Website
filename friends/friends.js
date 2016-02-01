var PageChangerURL = "../scripts/page_changer.php";
function window_1(a,b)
	{$.post(PageChangerURL,{page:"friends_window_1",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".friends_window_1").toggleClass("selected_window");
		$(".search_list").addClass("hidden_filter_search");
		$(".search_invited_list").addClass("hidden_filter_search");
		$(".filter_list").removeClass("hidden_filter_search");
		$("#friends_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_2(a,b)
	{$.post(PageChangerURL,{page:"friends_window_2",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".friends_window_2").toggleClass("selected_window");
		$(".filter_list").addClass("hidden_filter_search");
		$(".search_list").addClass("hidden_filter_search");
		$(".search_invited_list").removeClass("hidden_filter_search");
		$("#friends_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_3(a,b)
	{$.post(PageChangerURL,{page:"friends_window_3",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".friends_window_3").toggleClass("selected_window");
		$(".filter_list").addClass("hidden_filter_search");
		$(".search_invited_list").addClass("hidden_filter_search");
		$(".search_list").removeClass("hidden_filter_search");
		$("#friends_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
	
// Filter People
$('#filter_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function filter_query(a,b)
	{$("div.full_page_loader").removeClass("full_page_loader_hidden");
	var filter_query_name = $('#filter_query_name');
	var filter_query_location = $('#filter_query_location');
	var filter_query_primary_school = $('#filter_query_primary_school');
	var filter_query_secondary_school = $('#filter_query_secondary_school');
	var filter_query_post_secondary = $('#filter_query_post_secondary');
	var filter_query_employer = $('#filter_query_employer');
	$.post("find_friends_content.php",{ids:a,id:b,filter_query_name:filter_query_name.val(),filter_query_location:filter_query_location.val(),filter_query_primary_school:filter_query_primary_school.val(),
	filter_query_secondary_school:filter_query_secondary_school.val(),filter_query_post_secondary:filter_query_post_secondary.val(),filter_query_employer:filter_query_employer.val()},function(data)
			{$("div.full_page_loader").addClass("full_page_loader_hidden");
			$('#bottom_find_friends').html(data).show();});
	}
	
// Search Family & Friends
$('#search_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function search_query(a,b)
	{$("div.full_page_loader").removeClass("full_page_loader_hidden");
	var search_query = $('#search_query');
	$.post("friends_list.php",{ids:a,id:b,search_query:search_query.val()},function(data)
			{$("div.full_page_loader").addClass("full_page_loader_hidden");
			$('#friends_list').html(data).show();});
	}
	
// Search Invited Family & Friends
$('#search_invited_form').submit(function(){$('input[type=image]', this).attr('disabled', 'disabled');});
function search_invited_query(a,b)
	{$("div.full_page_loader").removeClass("full_page_loader_hidden");
	var search_invited_query = $('#search_invited_query');
	$.post("invited_friends_list.php",{ids:a,id:b,search_invited_query:search_invited_query.val()},function(data)
			{$("div.full_page_loader").addClass("full_page_loader_hidden");
			$('#invited_friends_list').html(data).show();});
	}
	
var thisRandNum = "<?php echo $thisRandNum; ?>";
var friendRequestURL = "../scripts/request_as_friend.php";
var DisplayArray = "../scripts/display_array.php";
function acceptFriendRequest (x) 
	{$.post(friendRequestURL,{request:"acceptFriend",requestID:x,thisWipit:thisRandNum},function(data)
		{$("#request"+x).html(data).show();});
	}
function rejectFriendRequest (x) 
	{$.post(friendRequestURL,{request:"rejectFriend",requestID:x,thisWipit:thisRandNum} ,function(data) 
		{$("#request"+x).html(data).show();});
	} 
function addAsFriend(a,b)
	{$.post(friendRequestURL,{request:"requestFriendship2",user_id:a,request_id:b,thisWipit:thisRandNum},function(data) 
		{$("#request"+b).html(data).show()});	
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
	
var DisplayItem = "../scripts/display_item.php";
var DisplayArray = "../scripts/display_array.php";

// Display Item	
function display_item(a,b,c,d,e)
	{display_box();
	$.post(DisplayItem,{ids:a,item_id:b,item_type:c,create_id:d,create_type:e},function(data) 
		{$("#display_div").html(data).show();});
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
	{var $sidebar = $("#friends_page_left "),
    $window = $(window),
    sidebartop = $("#friends_page_left").position().top;
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