<?php
ob_start();
$id = $_SESSION['ids'];
$ids = $_SESSION['ids'];

$items_per_page=20;
include_once "../scripts/check_login.php";
ob_flush();
?>

<script type="text/javascript">
var items_per_page = "<?php echo $items_per_page; ?>";
</script>

<body>
<font>

<div id="planets_games_list">
<?php // Games
include_once "planets_games_list.php";
?></div>

</font>
</body>