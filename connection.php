<?php
$db_server = "localhost";
$db_username = "e0867928_LTanner";
$db_password = "oaktownfootballclub";
$db_database = "e0867928_Oaktown_Football_Club";

$db = new PDO("mysql:host=$db_server;dbname=$db_database", $db_username, $db_password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>