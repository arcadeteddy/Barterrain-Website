function window_1(a,b)
	{$.post(PageChangerURL,{page:"settings_window_1",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".settings_window_1").toggleClass("selected_window");
		$(".planet_pic").addClass("hide_pic");
		$(".profile_pic").removeClass("hide_pic");
		$("#settings_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_2(a,b)
	{$.post(PageChangerURL,{page:"settings_window_2",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".settings_window_2").toggleClass("selected_window");
		$(".planet_pic").addClass("hide_pic");
		$(".profile_pic").removeClass("hide_pic");
		$("#settings_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_3(a,b)
	{$.post(PageChangerURL,{page:"settings_window_3",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".settings_window_3").toggleClass("selected_window");
		$(".profile_pic").addClass("hide_pic");
		$(".planet_pic").removeClass("hide_pic");
		$("#settings_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_4(a,b)
	{$.post(PageChangerURL,{page:"settings_window_4",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".settings_window_4").toggleClass("selected_window");
		$(".planet_pic").addClass("hide_pic");
		$(".profile_pic").removeClass("hide_pic");
		$("#settings_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_5(a,b)
	{$.post(PageChangerURL,{page:"settings_window_5",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".settings_window_5").toggleClass("selected_window");
		$(".planet_pic").addClass("hide_pic");
		$(".profile_pic").removeClass("hide_pic");
		$("#settings_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
function window_6(a,b)
	{$.post(PageChangerURL,{page:"settings_window_6",ids:a,id:b},function(data) 
		{$(".side_button").removeClass("selected_window");
		$(".settings_window_6").toggleClass("selected_window");
		$(".planet_pic").addClass("hide_pic");
		$(".profile_pic").removeClass("hide_pic");
		$("#settings_page_right").html(data).show();
		$('html,body').scrollTop(0);});
	}
	
$(document).ready(function () 
	{var $sidebar = $("#settings_page_left "),
    $window = $(window),
    sidebartop = $("#settings_page_left").position().top;
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