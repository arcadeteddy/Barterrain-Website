// Side
function window_1(a,b)
	{$.post(PageChangerURL,{page:"profile_window_1",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".profile_window_1").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".profile_page_middle_right").removeClass("hide_div");
		$(".profile_page_middle_left").removeClass("expand");
		$("#profile_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_2(a,b)
	{$.post(PageChangerURL,{page:"profile_window_2",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".profile_window_2").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".profile_page_middle_right").removeClass("hide_div");
		$(".profile_page_middle_left").removeClass("expand");
		$("#profile_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_3(a,b)
	{$.post(PageChangerURL,{page:"profile_window_3",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".profile_window_3").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".profile_page_middle_right").removeClass("hide_div");
		$(".profile_page_middle_left").removeClass("expand");
		$("#profile_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_4(a,b)
	{$.post(PageChangerURL,{page:"profile_window_4",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".profile_window_4").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".profile_page_middle_right").removeClass("hide_div");
		$(".profile_page_middle_left").removeClass("expand");
		$("#profile_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_5(a,b)
	{$.post(PageChangerURL,{page:"profile_window_5",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".profile_window_5").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".profile_page_middle_right").removeClass("hide_div");
		$(".profile_page_middle_left").removeClass("expand");
		$("#profile_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_6(a,b)
	{$.post(PageChangerURL,{page:"profile_window_6",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".profile_window_6").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".profile_page_middle_right").removeClass("hide_div");
		$(".profile_page_middle_left").removeClass("expand");
		$("#profile_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_7(a,b)
	{$.post(PageChangerURL,{page:"profile_window_7",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".profile_window_7").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".profile_page_middle_right").removeClass("hide_div");
		$(".profile_page_middle_left").removeClass("expand");
		$("#profile_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_8(a,b)
	{$.post(PageChangerURL,{page:"profile_window_8",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".profile_window_8").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".profile_page_middle_right").removeClass("hide_div");
		$(".profile_page_middle_left").removeClass("expand");
		$("#profile_page_middle_left").html(data).show();
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
	
// Album Opener
function album_opener(a,b,c)
	{$.post(PageChangerURL,{page:"album_opener",ids:a,id:b,album_id:c},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".profile_window_3").toggleClass("selected_window");
		$(".profile_page_middle_right").addClass("hide_div");
		$(".white_background_full2").addClass("hide_div");
		$(".profile_page_middle_left").addClass("expand");
		$("#profile_page_middle_left").html(data).show();
		$("html,body").scrollTop(0);});
	}
// Video Opener
function video_opener(a,b,c)
	{$.post(PageChangerURL,{page:"video_opener",ids:a,id:b,video_id:c},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".profile_window_3").toggleClass("selected_window");
		$(".white_background_full2").addClass("hide_div");
		$(".profile_page_middle_right").addClass("hide_div");
		$(".profile_page_middle_left").addClass("expand");
		$("#profile_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
// Game Opener
function game_opener(a,b,c)
	{$.post(PageChangerURL,{page:"game_opener",ids:a,id:b,game_id:c},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".profile_window_3").toggleClass("selected_window");
		$(".white_background_full2").addClass("hide_div");
		$(".profile_page_middle_right").addClass("hide_div");
		$(".profile_page_middle_left").addClass("expand");
		$("#profile_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
	
if (numRows_force_album>0)
		{onload = album_opener(ids,id,force_album);}
if (numRows_force_video>0)
		{onload = video_opener(ids,id,force_video);}
if (numRows_force_game>0)
		{onload = game_opener(ids,id,force_game);}