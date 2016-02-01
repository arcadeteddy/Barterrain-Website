// Side
function window_1(a,b)
	{$.post(PageChangerURL,{page:"planet_window_1",ids:a,id:b},function(data) 
		{$(".side_hidden_div").addClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".planet_window_1").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".planet_page_middle_right").removeClass("hide_div");
		$(".planet_page_middle_left").removeClass("expand");
		$("#planet_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_2(a,b)
	{$.post(PageChangerURL,{page:"planet_window_2",ids:a,id:b},function(data) 
		{$(".side_hidden_div").addClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".planet_window_2").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".planet_page_middle_right").removeClass("hide_div");
		$(".planet_page_middle_left").removeClass("expand");
		$("#planet_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_3(a,b)
	{$.post(PageChangerURL,{page:"planet_window_3",ids:a,id:b},function(data) 
		{$(".side_hidden_div").addClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".planet_window_3").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".planet_page_middle_right").removeClass("hide_div");
		$(".planet_page_middle_left").removeClass("expand");
		$("#planet_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_4(a,b)
	{$.post(PageChangerURL,{page:"planet_window_4",ids:a,id:b},function(data) 
		{$(".side_hidden_div").addClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".planet_window_4").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".planet_page_middle_right").removeClass("hide_div");
		$(".planet_page_middle_left").removeClass("expand");
		$("#planet_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_5(a,b)
	{$.post(PageChangerURL,{page:"planet_window_5",ids:a,id:b},function(data) 
		{$(".side_hidden_div").addClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".planet_window_5").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".planet_page_middle_right").removeClass("hide_div");
		$(".planet_page_middle_left").removeClass("expand");
		$("#planet_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_6(a,b)
	{$.post(PageChangerURL,{page:"planet_window_6",ids:a,id:b},function(data) 
		{$(".side_hidden_div").addClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".planet_window_6").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".planet_page_middle_right").removeClass("hide_div");
		$(".planet_page_middle_left").removeClass("expand");
		$("#planet_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_7(a,b)
	{$.post(PageChangerURL,{page:"planet_window_7",ids:a,id:b},function(data) 
		{$(".side_hidden_div").addClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".planet_window_7").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".planet_page_middle_right").removeClass("hide_div");
		$(".planet_page_middle_left").removeClass("expand");
		$("#planet_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_8(a,b)
	{$.post(PageChangerURL,{page:"planet_window_8",ids:a,id:b},function(data) 
		{$(".side_hidden_div").addClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".planet_window_8").toggleClass("selected_window");
		$(".white_background_full2").removeClass("hide_div");
		$(".planet_page_middle_right").removeClass("hide_div");
		$(".planet_page_middle_left").removeClass("expand");
		$("#planet_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
	
function album_opener(a,b,c)
	{$.post(PageChangerURL,{page:"planet_album_opener",ids:a,id:b,album_id:c},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".planet_window_3").toggleClass("selected_window");
		$(".planet_page_middle_right").addClass("hide_div");
		$(".white_background_full2").addClass("hide_div");
		$(".planet_page_middle_left").addClass("expand");
		$("#planet_page_middle_left").html(data).show();
		$("html,body").scrollTop(0);});
	}
	
// video opener
function video_opener(a,b,c)
	{$.post(PageChangerURL,{page:"planet_video_opener",ids:a,id:b,video_id:c},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".planet_window_3").toggleClass("selected_window");
		$(".white_background_full2").addClass("hide_div");
		$(".planet_page_middle_right").addClass("hide_div");
		$(".planet_page_middle_left").addClass("expand");
		$("#planet_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}

// Game opener
function game_opener(a,b,c)
	{$.post(PageChangerURL,{page:"planet_game_opener",ids:a,id:b,game_id:c},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".planet_window_3").toggleClass("selected_window");
		$(".white_background_full2").addClass("hide_div");
		$(".planet_page_middle_right").addClass("hide_div");
		$(".planet_page_middle_left").addClass("expand");
		$("#planet_page_middle_left").html(data).show();
		$('html,body').scrollTop(0);});
	}
	
if (numRows_force_album>0)
		{onload = album_opener(ids,id,force_album);}
if (numRows_force_video>0)
		{onload = video_opener(ids,id,force_video);}
if (numRows_force_game>0)
		{onload = game_opener(ids,id,force_game);}