<span id="counter">10</span>]
<script type="text/javascript">
var id = "<?php echo $id; ?>";
var ids = "<?php echo $ids; ?>";
var password_delete_account = "<?php echo $password_delete_account_mixed; ?>";
var InteractiveSetting = "../settings/setting_forms.php";

function countdown() 
	{var i = document.getElementById('counter');
    if (parseInt(i.innerHTML)<=1) 
		{$("div.full_page_loader").removeClass("full_page_loader_hidden");
		$.post(InteractiveSetting,{action:"delete_account",ids:ids,id:id,password_delete_account:password_delete_account},function(data) 
			{location.href = 'logout.php';
			$("div.full_page_loader").addClass("full_page_loader_hidden");});}
    i.innerHTML = parseInt(i.innerHTML)-1;
	}
setInterval(function(){ countdown(); },1000);
</script>