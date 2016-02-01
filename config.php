<?php
$db_host="localhost";
$db_username="root";
$db_pass="random123";
$db_name="teddy888_barterrain";

@mysql_connect("$db_host", "$db_username", "$db_pass") or die ("Could Not Connect To Host!");
@mysql_select_db("$db_name") or die ("Could Not Connect To Database!");
?>