<?php
ob_start();
if (isset($_SESSION['color']))
	{$color=$_SESSION['color'];}
else {$color="blue";}

include_once "../scripts/check_login.php";
ob_flush();
?>

<script src="../profile/profile.js" type="text/javascript" async></script>

<body>
<div class="margin"></div>
<div class="points_sub_body" id="points_sub_body">
	<div class="bottom_point_transactions">
		<?php $mysql_union = mysql_query("(SELECT * FROM point_transactions WHERE (plus_id='$ids' OR minus_id='$ids') AND delete_transaction='1' AND create_type='profile') 
					UNION ALL(SELECT * FROM point_transactions_comments WHERE (plus_id='$ids' OR minus_id='$ids') AND delete_transaction='1' AND create_type='profile')
					ORDER BY transaction_date DESC LIMIT 1");
		$numRows_top_bottom=mysql_num_rows($mysql_union);
		if ($numRows_top_bottom>0)
			{echo "<div class='bar_wrap'>
					<div class='points_bars'><img src='blank.gif' width='1px' height='1px' class='transactions_lists'/><span class='heading_list'>Transactions</span></div>
       				<div class='plus_minus_bars'><span class='heading_list_pm'>&#8722; &#5528;</span></div>
        			<div class='plus_minus_bars'><span class='heading_list_pm'>+ &#5528;</span></div>
					</div>";} ?>
                    
        <div id="bottom_profile_transactions">
			<?php include "profile_transactions_content.php"; ?>
        </div>
		
        <?php if ($numRows_top_bottom>0) {echo "<div class='transactions_bars_end'></div>";}
		else {echo "<div class='nothing'><span class='nothing'>No Point Transactions</span></div>";} ?>
	</div>
	<div id="bottom_box">
		<div class="expand_bottom_point_transactions" id="expand_bottom_point_transactions">
			<center><span class="expand_bottom_point_transactions">&#9660;</span></center>
		</div>
		<div class="expand_bottom_point_transactions" id="load_content_scroll" style="display:none;">
			<center><img class="loader" src="barterrain_points_images/loader_light_<?php echo $color;?>.gif" width="220px" height="19px"></center>
		</div>
	</div>
</div>
</body>