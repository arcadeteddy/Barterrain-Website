// Points
$(document).ready(function() 
	{$(".points_button").click(function(e) 
		{e.preventDefault();
        $("fieldset#sub_button_points").toggle();
		$(".body").addClass("darken");
		$(".points_button").toggleClass("selected_button_bottom");});
		$("fieldset#sub_button_points").mouseup(function() 
			{return false});
        $(document).mouseup(function(e)
			{if($(e.target).parent("div.points_button").length==0)
				{$(".points_button").removeClass("selected_button_bottom");
				$(".body").removeClass("darken");
				$("fieldset#sub_button_points").hide();}
            });            
	});

// Friends
$(document).ready(function() 
	{$(".friends_button").click(function(e) 
		{e.preventDefault();
        $("fieldset#sub_button_friends").toggle();
		$(".body").addClass("darken");
		$(".friends_button").toggleClass("selected_button_bottom");});
		$("fieldset#sub_button_friends").mouseup(function() 
			{return false});
        $(document).mouseup(function(e)
			{if($(e.target).parent("a.friends_button").length==0)
				{$(".friends_button").removeClass("selected_button_bottom");
				$(".body").removeClass("darken");
				$("fieldset#sub_button_friends").hide();}
            });            
	});

// Friend Requests
function banner_acceptFriendRequest(x) 
	{$.post(friendRequestURL_banner,{request:"acceptFriend",requestID:x,thisWipit:thisRandNum},function(data)
		{$("#banner_request"+x).html(data).show();});
	}
function banner_rejectFriendRequest(x) 
	{$.post(friendRequestURL_banner,{request:"rejectFriend",requestID:x,thisWipit:thisRandNum} ,function(data) 
		{$("#banner_request"+x).html(data).show();});
	} 
	
// Planet Requests
function acceptcreatorRequest (x) 
	{$.post(CreateOptionsURL,{request:"acceptcreator",requestID:x,typex:typex,thisWipit:thisRandNum},function(data)
		{$("#banner_creator_request"+x).html(data).show();});
	}
function rejectcreatorRequest (x) 
	{$.post(CreateOptionsURL,{request:"rejectcreator",requestID:x,typex:typex,thisWipit:thisRandNum} ,function(data) 
		{$("#banner_creator_request"+x).html(data).show();});
	} 
function acceptadminRequest (x) 
	{$.post(CreateOptionsURL,{request:"acceptadmin",requestID:x,typex:typex,thisWipit:thisRandNum},function(data)
		{$("#banner_admin_request"+x).html(data).show();});
	}
function rejectadminRequest (x) 
	{$.post(CreateOptionsURL,{request:"rejectadmin",requestID:x,typex:typex,thisWipit:thisRandNum} ,function(data) 
		{$("#banner_admin_request"+x).html(data).show();});
	} 
	
// Settings
$(document).ready(function() 
	{$(".settings_button").click(function(e) 
		{e.preventDefault();
        $("fieldset#sub_button_settings").toggle();
		$(".body").addClass("darken");
		$(".settings_button").toggleClass("selected_button_bottom");});
		$("fieldset#sub_button_settings").mouseup(function() 
			{return false});
        $(document).mouseup(function(e)
			{if($(e.target).parent("a.settings_button").length==0)
				{$(".settings_button").removeClass("selected_button_bottom");
				$(".body").removeClass("darken");
				$("fieldset#sub_button_settings").hide();}
            });            
	});
	
// Back to Top Button
$(document).ready(function() {
$(function(){$(window).scroll(function() 
	{if($(this).scrollTop() > 0) 
		{$('#back_top_img').fadeIn();} 
	else {$('#back_top_img').fadeOut();}});
	$('#back_top').click(function() 
		{$('body,html').animate({scrollTop:0},800);return false;});	
});});

function banner_display_box() 
	{$(".display_button").click(function(e) 
		{$("fieldset#sub_button_friends").hide();
		$(".friends_button").removeClass("selected_button_bottom");
		$("fieldset#sub_button_points").hide();
		$(".points_button").removeClass("selected_button_bottom");
		e.preventDefault();
		$("fieldset#display_image_button").hide();
        $("fieldset#display_button").show();
		$(".body").addClass("darken");});
		$("fieldset#display_button").mouseup(function() 
			{return false});
        $(document).mouseup(function(e)
			{if($(e.target).parent("a.display_button").length==0)
				{$(".body").removeClass("darken");
				$("#display_div").html('<img class="full_page_loader_array" src="http://www.barterrain.com/barterrain_main_images/loader_full_'+color+'.gif" width="128px"/>');
				$("fieldset#display_button").hide();}
        });    
	}
function banner_display_image_box() 
	{$(".display_image_button").click(function(e) 
		{$("fieldset#sub_button_friends").hide();
		$(".friends_button").removeClass("selected_button_bottom");
		$("fieldset#sub_button_points").hide();
		$(".points_button").removeClass("selected_button_bottom");
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
	
// Display Item	
function banner_display_item(a,b,c,d,e)
	{banner_display_box();
	$.post(DisplayItem,{ids:a,item_id:b,item_type:c,create_id:d,create_type:e},function(data) 
		{$("#display_div").html(data).show();});
	}
// Display Image	
function banner_display_image(a,b,c)
	{banner_display_image_box();
	$.post(DisplayImage,{display:"display_image",id:a,ids:b,image_id:c,color:color},function(data) 
		{$("#display_image_div").html(data).show();});
	}	
// List Arrays
function display_mutual_FF(a,b,c)
	{display_box();
	$.post(DisplayArray,{display:"mutual_FF_array",id:a,ids:b,mutual_FF_array:c},function(data) 
		{$("#display_div").html(data).show();});
	}

function search_box_query()
	{$("div.full_page_loader").removeClass("full_page_loader_hidden");
	var search_box_query = $('#search_box_query').val();
	location.href = '../search/search.php?search='+search_box_query;}