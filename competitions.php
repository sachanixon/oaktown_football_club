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
   
   
   ini_set('display_errors','0'); 
    $message = "";
    $db_server = "localhost";
    $db_username = "e0867928_LTanner";
    $db_password = "oaktownfootballclub";
    $db_database = "e0867928_Oaktown_Football_Club";

    $conn = new PDO("mysql:host=$db_server;dbname=$db_database", $db_username, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$weeksQuery = "
		SELECT 
		f.fixture_id
        ,w.week_id 
		,w.week_number 
		,w.week_date
		,t1.image as 'homeimage'
        ,t2.image as 'awayimage'
        ,t1.team_name AS 'home'
		,t2.team_name AS 'away' 
		,f.home_score
		,f.away_score 
	FROM Fixture f 
	   INNER JOIN Team t1
	       ON t1.team_id = f.home_team_id
	   LEFT JOIN Team t2
	       ON t2.team_id = f.away_team_id 
	   JOIN Week w
	       ON f.week_id = w.week_id
	";

	$weeks = $conn->query($weeksQuery);

	if (!$_GET['week']){ $GLOBALS['message'] = "please select a week!";
            }
            else
            {
    if (isset($_GET['week'])) //select fields
    {
       $weekQuery = "{$weeksQuery} WHERE w.week_id = :weeks_id";
	   $week = $conn->prepare($weekQuery);
	   $week->execute(['weeks_id' => $_GET['week']]);
	   $selectedWeek = $week->fetchAll(PDO::FETCH_ASSOC);		
    }
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
    		<title>Competitions</title>
    	</head>
    	<body>
    		<head>
    			<title>Oaktown Football Club</title>
    			<meta charset="utf-8">
    			<link rel="stylesheet" type="text/css" href="css/style.css">
    			<link rel="stylesheet" type="text/css" href="css/competitions.css">
    			<meta name="viewport" content="width=device-width, initial-scale=1.0">
    		</head>
      		
      		<body> <!--image for Background-->
    			<div id="white_box"><!--White Box-->
    	  			<div class="container"> <!--container in white box-->
    					<header class="header">
    						<img src="images/logo.png" alt="football logo">
        					<h1>Oaktown Football Club</h1>
        				</header>
    					<nav ><!--Navigation Bar linking to index competition contact-->
    		  				<ul>
    							<li><a href="index.html">Home</a></li>
    							<li><a class="active"> Competitions</a></li>
    							<li><a href="contact.html">Contact</a></li>
    							<li><a href="login.php">Login</a></li>
    		  				</ul>
    					</nav>
    					<div class="row">
        		  			<br/>
        		  			<br/>
        		  			<section>
        						<div class="col-12">
        			  				<h2>Competitions</h2>
        			  				<p><strong>Choose the week's game fixture:</strong></p>
        			  				<br/>
        			  				
        			  				<form action="competitions.php"  method="get">
        	  	   	   					<label>Select a Week from Dropdown Menu </br></br>
                                        <select name="week"><!--dropdown menu-->
        	   								
        	   								<option value="">(Make a Selection)
        	   								</option>
        	   								<?php foreach($weeks->fetchAll() as $week): ?> 
        									   <option value="<?php echo $week['week_id']; ?>">
        										  <?php echo $week['week_number']; ?>
        									   </option>
        	   								<?php endforeach; ?>	   				
        	   							</select>
        	   							</label>
                                        <input type="submit" value="select">	
        			   				
                                    </form>
        				 			<br/>
        
        				 			<table><!--table content-->
        								<tr>
										<caption><td colspan=7><?php echo $message; ?></td></caption> <!-- Error Messages -->
										</tr>
        								<tr>
        									<th colspan="7"> Fixture Results</th>
        								</tr>
        								<tr>
        									<th colspan="7"><?php echo $selectedWeek[0]['week_number']; ?></th>
        								</tr>
        								<tr>
        									<th> Fixture Date </th>
        									<th>logo</th>
        									<th> Home </th>				
        									<th> Home Score </th>				
        									<th>logo</th>
        									<th> Away </th>
        									<th> Away Score </th>
        								</tr>
        							<?php
                                        foreach($selectedWeek as $s)
                                        {
                                            $team_idhomezero =$s['homeimage'];
                                            $team_idawayzero =$s['awayimage'];
                                            echo'<tr>' . '<td>' . $s['week_date'] . '</td>' . '<td>' . '<img src="data:image/png;base64,' . base64_encode($team_idhomezero).' "alt="'.$s['home'].'"."  " class="responsive" />' . '</td>' . '<td>' . $s['home'] . '</td>'  . '<td>' . $s['home_score'] . '</td>' .'<td>' . '<img src="data:image/png;base64,'.base64_encode($team_idawayzero).'"alt="'.$s['away'].'"." " class="responsive"/>' . '</td>'.'<td>' . $s['away'] . '</td>'. '<td>' . $s['away_score'] . '</td>'.'</tr>';
                                        }
                                    ?>
                                 
                                    
        							</table>
        			  				<br/>
        						</div>
        		  			</section>
        		  			<br/>
        		  			<footer class="col-12">
        						<p>Copyright 2019 <a href="contact.html">Contact Us</a>
        						</p>  
        		  			</footer>
    					</div>
    	  			</div>
    			</div>
    		</body>
    	</body>
	</html>
