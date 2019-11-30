<?php
ini_set('display_errors', '0'); 
	$db_server = "localhost";
	$db_username = "e0867928_LTanner";
	$db_password = "oaktownfootballclub";

	$conn = new PDO("mysql:host=" . $GLOBALS['db_servername'] . ";dbname=e0867928_Oaktown_Football_Club", $GLOBALS['db_username'], $GLOBALS['db_password']);

	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	$id=addslashes($_REQUEST['id']);

// select the image 
	$image = $conn->query("SELECT * FROM Team WHERE team_id=". $id);

	$row = $image->fetch(PDO::FETCH_ASSOC);


	header("Content-type:image/png");

	echo $row['image'];
?>