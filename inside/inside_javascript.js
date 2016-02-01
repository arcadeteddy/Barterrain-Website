function daily_points1(a,b)
	{$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(interactivePoints,{daily_points1:"daily_points1",id:a,ids:b,file_location:file_location},function(data) 
		{$("#daily_points1").html(data).show();
		$("#point_reload").load('../scripts/point_reload.php');
		$("div.full_page_loader").addClass("full_page_loader_hidden");});}
function daily_points2(a,b)
	{$("div.full_page_loader").removeClass("full_page_loader_hidden");
	$.post(interactivePoints,{daily_points2:"daily_points2",id:a,ids:b,file_location:file_location},function(data) 
		{$("#daily_points2").html(data).show();
		$("#point_reload").load('../scripts/point_reload.php');
		$("div.full_page_loader").addClass("full_page_loader_hidden");});}