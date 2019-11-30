<?php

		
require_once('/home/e0867928/public_html/owa/owa_php.php');
		
$owa = new owa_php();
// Set the site id you want to track
$owa->setSiteId('f5518f9298552a5a92c65a92433296e5');
// Uncomment the next line to set your page title
//$owa->setPageTitle('somepagetitle');
// Set other page properties
//$owa->setProperty('foo', 'bar');
$owa->trackPageView();

ini_set('display_errors', '0'); 
   if (isset($_POST["Login"]))
   {
      checkLogin($_POST["Name"], $_POST["Password"]);
   }
   function checkLogin($Username, $Password)
   {
       $db_server = "localhost";
       $db_username = "e0867928_LTanner";
	   $db_password = "oaktownfootballclub";
	   $db_database = "e0867928_Oaktown_Football_Club";

       try {
           $conn = new PDO("mysql:host=$db_server;dbname=$db_database", $db_username, $db_password);
	       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           $statement = $conn->query("SELECT * FROM User WHERE Username='" . $Username . "' AND PASSWORD='" . $Password . "'");
           
           $result = $statement->fetch();
           if ($result == null) { // customer id and password doesn't match
           echo '<script type="text/javascript">alert("The ID or password entered is not valid. Please enter a valid username and password");</script>';
           }
           else
           {
           session_start(); // start the session
           $_SESSION['Name']=$Username;
           header("location: admin.php"); // redirect user to admin.php web page
           }
       }
       catch(PDOException $e)
       {
       echo "Sorry an error occured: " . $e->getMessage();
       }
       $conn = null;
       }

?>




<!DOCTYPE html>
	<html lang="en">
      	<head>
          <!-- Global site tag (gtag.js) - Google Analytics -->
          <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151807485-1"></script>
          <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-151807485-1');
          </script>

<!-- Start Open Web Analytics Tracker -->
<script type="text/javascript">
//<![CDATA[
var owa_baseUrl = 'https://e0867928sachanixon.myitoc.com.au/owa/';
var owa_cmds = owa_cmds || [];
owa_cmds.push(['setSiteId', 'f5518f9298552a5a92c65a92433296e5']);
owa_cmds.push(['trackPageView']);
owa_cmds.push(['trackClicks']);

(function() {
	var _owa = document.createElement('script'); _owa.type = 'text/javascript'; _owa.async = true;
	owa_baseUrl = ('https:' == document.location.protocol ? window.owa_baseSecUrl || owa_baseUrl.replace(/http:/, 'https:') : owa_baseUrl );
	_owa.src = owa_baseUrl + 'modules/base/js/owa.tracker-combined-min.js';
	var _owa_s = document.getElementsByTagName('script')[0]; _owa_s.parentNode.insertBefore(_owa, _owa_s);
}());
//]]>
</script>
<!-- End Open Web Analytics Code -->
        	<meta charaset="UTF-8", name="viewport"
        content="width=device-width, initial-scale=1">
        <style>
          .responsive {
            max-width: 100%;
            height: auto;
          }
        </style>
          <title>Login Page</title>
       		
        	<link rel="stylesheet" type="text/css" href="css/style.css">
        	<link rel="stylesheet" type="text/css" href="css/competitions.css">
        	<meta name="viewport" content="width=device-width, initial-scale=1.0">
      	</head>
      	<body><!--image for Background-->
        	<div id="white_box"><!--White Box-->
          	<div class="container"> <!--container in white box-->
            <header class="header">
            	<img src="images/logo.png" alt="football logo">
            	<h1>Oaktown Football Club</h1>
            </header>
            <!--Navigation Bar linking to index competition contact-->
            <nav>
        		<ul>
        			<li><a href="index.html">Home</a></li>
              <li><a href="competitions.php">Competitions</a></li>
              <li><a href="contact.html">Contact</a></li>
               <li><a class="active">Login</a></li> <!--Login Link-->
                </ul>
            </nav>
    		<header>
            	<table>
              		<tr>
                 		<h1>Login</h1>
              		</tr>
            	</table>
          	</header>
            <div class="row_small">
    			<section>
    				<div>         			
    					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
             				<table>
    	            			<tr>
    	               				<td><h2>Username:</h2></td>
    	               				<td><input type="text" name="Name"></td>
    	            			</tr>
    	            			<tr>
    	               				<td><h2>Password:</h2></td>
    	               				<td><input type="password" name="Password"></td>
    	            			</tr>
    	            			<tr>
    	               				<td colspan="2"><input type="submit" name="Login" value="Login"></td>
    	            			</tr>
             				</table>
             	</form>
             	<footer class="col-12">
            		<p>Copyright 2019 <a href="contact.html">Contact Us</a></p>  
            	</footer>
             </div>
  			</section>
        </div>
<br />
<br />
<br />

           
    	</body>
	</html>