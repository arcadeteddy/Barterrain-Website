// Side Bars
function window_1(a,b)
	{$.post(PageChangerURL,{page:"planets_window_1",ids:a,id:b},function(data) 
		{$(".side_button_tabs").removeClass("selected_window");
		$(".side_hidden_div").addClass("hide_div");
		$(".popular_recent_side").removeClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".planets_window_1").toggleClass("selected_window");
		$("#planets_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_2(a,b)
	{$.post(PageChangerURL,{page:"planets_window_2",ids:a,id:b},function(data) 
		{$(".side_button_tabs").removeClass("selected_window");
		$(".side_hidden_div").addClass("hide_div");
		$(".popular_side").removeClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".planets_window_2").toggleClass("selected_window");
		$("#planets_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_3(a,b)
	{$.post(PageChangerURL,{page:"planets_window_3",ids:a,id:b},function(data) 
		{$(".side_button_tabs").removeClass("selected_window");
		$(".side_hidden_div").addClass("hide_div");
		$(".recent_side").removeClass("hide_div");
		$(".side_button").removeClass("selected_window");
		$(".planets_window_3").toggleClass("selected_window");
		$("#planets_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_11(a,b)
	{$.post(PageChangerURL,{page:"planets_window_11",ids:a,id:b},function(data) 
		{$(".extra_side_button").removeClass("selected_window");
		$(".planets_window_11").toggleClass("selected_window");
		$("#planets_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_12(a,b)
	{$.post(PageChangerURL,{page:"planets_window_12",ids:a,id:b},function(data) 
		{$(".extra_side_button").removeClass("selected_window");
		$(".planets_window_12").toggleClass("selected_window");
		$("#planets_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_13(a,b)
	{$.post(PageChangerURL,{page:"planets_window_13",ids:a,id:b},function(data) 
		{$(".extra_side_button").removeClass("selected_window");
		$(".planets_window_13").toggleClass("selected_window");
		$("#planets_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_14(a,b)
	{$.post(PageChangerURL,{page:"planets_window_14",ids:a,id:b},function(data) 
		{$(".extra_side_button").removeClass("selected_window");
		$(".planets_window_14").toggleClass("selected_window");
		$("#planets_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_21(a,b)
	{$.post(PageChangerURL,{page:"planets_window_21",ids:a,id:b},function(data) 
		{$(".extra_side_button").removeClass("selected_window");
		$(".planets_window_21").toggleClass("selected_window");
		$("#planets_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_22(a,b)
	{$.post(PageChangerURL,{page:"planets_window_22",ids:a,id:b},function(data) 
		{$(".extra_side_button").removeClass("selected_window");
		$(".planets_window_22").toggleClass("selected_window");
		$("#planets_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_23(a,b)
	{$.post(PageChangerURL,{page:"planets_window_23",ids:a,id:b},function(data) 
		{$(".extra_side_button").removeClass("selected_window");
		$(".planets_window_23").toggleClass("selected_window");
		$("#planets_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_24(a,b)
	{$.post(PageChangerURL,{page:"planets_window_24",ids:a,id:b},function(data) 
		{$(".extra_side_button").removeClass("selected_window");
		$(".planets_window_24").toggleClass("selected_window");
		$("#planets_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_31(a,b)
	{$.post(PageChangerURL,{page:"planets_window_31",ids:a,id:b},function(data) 
		{$(".extra_side_button").removeClass("selected_window");
		$(".planets_window_31").toggleClass("selected_window");
		$("#planets_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_32(a,b)
	{$.post(PageChangerURL,{page:"planets_window_32",ids:a,id:b},function(data) 
		{$(".extra_side_button").removeClass("selected_window");
		$(".planets_window_32").toggleClass("selected_window");
		$("#planets_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_33(a,b)
	{$.post(PageChangerURL,{page:"planets_window_33",ids:a,id:b},function(data) 
		{$(".extra_side_button").removeClass("selected_window");
		$(".planets_window_33").toggleClass("selected_window");
		$("#planets_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_34(a,b)
	{$.post(PageChangerURL,{page:"planets_window_34",ids:a,id:b},function(data) 
		{$(".extra_side_button").removeClass("selected_window");
		$(".planets_window_34").toggleClass("selected_window");
		$("#planets_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
	
function planets_planets_list(a,b,c)
	{$.post("planets_planets_list.php?page="+a,{x:a,id:b,ids:c,items_per_page:items_per_page,cacheBuster:cacheBuster},function(data) 
		{$("#planets_planets_list").html(data).show()});	
	}
function planets_albums_list(a,b,c)
	{$.post("planets_albums_list.php?page="+a,{x:a,id:b,ids:c,items_per_page:items_per_page,cacheBuster:cacheBuster},function(data) 
		{$("#planets_albums_list").html(data).show()});	
	}
function planets_games_list(a,b,c)  
	{$.post("planets_games_list.php?page="+a,{x:a,id:b,ids:c,items_per_page:items_per_page,cacheBuster:cacheBuster},function(data) 
		{$("#planets_games_list").html(data).show()});	
	}	
function planets_videos_list(a,b,c)
	{$.post("planets_videos_list.php?page="+a,{x:a,id:b,ids:c,items_per_page:items_per_page,cacheBuster:cacheBuster},function(data) 
		{$("#planets_videos_list").html(data).show()});	
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
	
$(document).ready(function () 
	{var $sidebar = $("#planets_page_left "),
    $window = $(window),
    sidebartop = $("#planets_page_left").position().top;
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