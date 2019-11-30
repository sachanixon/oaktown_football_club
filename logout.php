<?php	
session_start();

ini_set('display_errors', '0'); 

unset($_SESSION['Name']);
 
if(session_destroy())
{
header("Location: index.html");
}
?>