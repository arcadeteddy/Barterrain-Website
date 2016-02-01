<?php
header("Content-Type: text/html; charset=utf-8");
?>
<?
$random_number=rand(1,8);
if ($random_number=="1") {$color='blue';}
else if ($random_number=="2") {$color='green';}
else if ($random_number=="3") {$color='yellow';}
else if ($random_number=="4") {$color='orange';}
else if ($random_number=="5") {$color='red';}
else if ($random_number=="6") {$color='purple';}
else if ($random_number=="7") {$color='brown';}
else if ($random_number=="8") {$color='black';}
?>

<html>

<head>
<link rel="stylesheet" href="barterrain_banner.php" media="screen">
<link rel="stylesheet" href="barterrain_outside.php" media="screen"/>
</head>

<body class="browser_body">
<font>

<?php include_once "outside_banner.php"; ?>

<div class="side_colors_left_2"></div>

<div class="barterrain_browser_background">
	<div class="barterrain_outside content">
    	<div id="outside_pages_browser">
        <div class="outside_pages_browser">
        <table class="browser_table" cellpadding="0" cellspacing="0">
        <tr class="browser_td"><td class="browser_top_left"></td><td class="browser_top_bottom" colspan="4"></td><td class="browser_top_right"></td></tr>
        <tr class="browser_td">
    		<td class="browser_left_right"></td>
            <td class="browser_td" style="padding-top:10px;padding-bottom:20px;width:auto;" colSpan="4">
            	<span class="browser">Sorry, Internet Explorer Is Not Supported.<br/>Please Try One Of The Following Browsers!</span>
            </td>
            <td class="browser_left_right"></td>
        </tr>
        <tr>
        	<td class="browser_left_right"></td>
            <td class="browser_td"><a href="https://www.google.com/chrome/" class="chrome_browser"></a></td>
            <td class="browser_td"><a href="http://www.mozilla.org/firefox/" class="firefox_browser"></a></td>
            <td class="browser_td"><a href="http://www.opera.com/"  class="opera_browser"></a></td>
            <td class="browser_td"><a href="http://support.apple.com/downloads/#safari" class="safari_browser"></a></td>
            <td class="browser_left_right"></td>
        </tr>
        <tr>
        	<td class="browser_left_right"></td>
            <td class="browser_td" style="padding-top:20px;padding-bottom:10px;"><span class="browser">Google<br/>Chrome</span></td>
            <td class="browser_td" style="padding-top:20px;padding-bottom:10px;"><span class="browser">Mozilla<br/>Firefox</span></td>
            <td class="browser_td" style="padding-top:20px;padding-bottom:10px;"><span class="browser">Opera<br/>Software</span></td>
            <td class="browser_td" style="padding-top:20px;padding-bottom:10px;"><span class="browser">Apple<br/>Safari</span></td>
            <td class="browser_left_right"></td>
        </tr>
            <tr class="browser_td"><td class="browser_bottom_left"></td><td class="browser_top_bottom" colspan="4"></td><td class="browser_bottom_right"></td></tr>
        </table>
        </div>
        </div>
	</div>
</div>

<div class="side_colors_right_2"></div>
</font>
</body>

</html>