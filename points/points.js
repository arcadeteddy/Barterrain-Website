function display_box() 
	{$(".display_button").click(function(e) 
		{e.preventDefault();
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
		{e.preventDefault();
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
	{var $sidebar = $("#points_page_left "),
    $window = $(window),
    sidebartop = $("#points_page_left").position().top;
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