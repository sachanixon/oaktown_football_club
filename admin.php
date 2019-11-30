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



session_start();

ini_set('display_errors', '0');
   
if(isset($_SESSION["Name"])) // does session variable name exist?  
{  
echo "<h6>Login Successful</h6>";    
}  
else  
{  
header("Location: login.php");  // if not redirect user to index.php web page
}  
?>  

<?php
	 $db_server = "localhost";
	 $db_username = "e0867928_LTanner";
  	 $db_password = "oaktownfootballclub";
	 $team_name = "";
	 $team_id = "";
     $week_id = ""; 
     $home = "";
	 $away ="";
     $home_score = "";
	 $away_score = "";
	 $message = "";
	 $fixture_message = ""; 
	 $submit_message = "";
	 $name = "";
	 $image = "";
	 $team_id_image = "";
	 $fixture_id = "";
	 $message_score = "";
   
   
    if (isset($_POST['get_team']))
    {
        getteam($_POST['team_id']);
    }
        
        function getteam($team_id) 
        {
        try {
            $conn = new PDO("mysql:host=" . $GLOBALS['db_servername'] . ";
            dbname=e0867928_Oaktown_Football_Club", $GLOBALS['db_username'], $GLOBALS['db_password']);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
            if (!$_POST['team_id']){$GLOBALS['message'] = "<font color=red>The ID entered is blank please enter ID!</font>";
			} 
            else 
            {
            $statement = $conn->query ("SELECT team_id, team_name, name FROM Team WHERE team_id=" . $team_id);
                
			$result = $statement->fetch();		 	
					
		 	if ($result == null) { // id doesn't exist
         	$GLOBALS['message'] = "<font color=red>The ID entered is not valid try again!</font>";
         	}
         	else
         	{
         	
         	    
         	$GLOBALS['message'] = "<font color=green>The ID is ok scroll down to see results!</font>";
			$GLOBALS['team_id'] = $result[0];
			$GLOBALS['team_name'] = $result[1];
			$GLOBALS['name'] = $result[2];
            }
            }
        }
        catch(PDOException $e) { echo "An error occured: " . $e->getMessage();
        }
	$conn= null;
	}
?>



<?php   

    if (isset($_POST['insert_team']))
    {
    	insertteam();
    }
        
    function insertteam()
    {
        try {
      		$conn = new PDO("mysql:host=" . $GLOBALS['db_servername'] . ";
            dbname=e0867928_Oaktown_Football_Club", $GLOBALS['db_username'], $GLOBALS['db_password']);

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			$statement = $conn->prepare("INSERT INTO Team (team_name) VALUES (:team_name)");
			$statement->bindValue(":team_name", $_POST['team_name']);
			$result = $statement->execute();
				
			if ($result)
			{
                $last_id = $conn->lastInsertId();
				    
			    $GLOBALS['message'] = "<font color=green>New record created successfully. Last inserted ID is: </font>" . $last_id;
				}
				else
				{
				$GLOBALS['message'] = "<font color=red>Sorry new team has not been inserted</font>";
				}
            }
		catch(PDOException $e)
		{
		    echo "A problem occurred:" . $e->getMessage();
		}
	$conn = null;
    }
?>




<?php   

    if (isset($_POST['update_team']))
    {
        updateteam($_POST["team_id"]);
    }
        
    function updateteam($team_id)
    {
        try {
      		$conn = new PDO("mysql:host=" . $GLOBALS['db_servername'] . ";dbname=e0867928_Oaktown_Football_Club", $GLOBALS['db_username'],
      		$GLOBALS['db_password']);

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							
			$statement = $conn->prepare("UPDATE Team SET team_name=:team_name WHERE team_id=" . $team_id);
			$statement->bindValue(":team_name", $_POST['team_name']);
			$result = $statement->execute();
				
			if ($result)
			{
			$GLOBALS['message'] = "<font color=green>Team record was updated</font>";
			}
			else
			{
			$GLOBALS['message'] = "<font color=red>Team record was not updated</font>";
			}
		}
		catch(PDOException $e)
		{
			echo "A problem occurred:" . $e->getMessage();
		}
	$conn = null;
    }
?>




<?php   

    if (isset($_POST['delete_team']))
    {
        deleteteam($_POST["team_id"]);
    }
        
    function deleteteam($team_id)
    {
        try {
      		$conn = new PDO("mysql:host=" . $GLOBALS['db_servername'] . ";dbname=e0867928_Oaktown_Football_Club",
      		$GLOBALS['db_username'], $GLOBALS['db_password']);

			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			$statement = $conn->prepare("DELETE FROM Team WHERE team_id=" . $team_id);
			$result = $statement->execute();
			if ($result)
			{
			$GLOBALS['message'] = "<font color=green>Team record was deleted successfully</font>";
			}
			else
			{
			$GLOBALS['message'] = "<font color=red>Team record was not deleted</font>";
			}
		}
		catch(PDOException $e)
		{
            echo "A problem occurred:" . $e->getMessage();
		}
	$conn = null;
    }
?>








<?php
    if (isset($_POST["upload"]))
    {
        updateimage($_POST["team_id_image"]);
    }

    function updateimage($team_id_image)
    {
        try {
            $conn = new PDO("mysql:host=" . $GLOBALS['db_servername'] . ";dbname=e0867928_Oaktown_Football_Club",
            $GLOBALS['db_username'], $GLOBALS['db_password']);
        
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
            $file = file_get_contents($_FILES["image"]["tmp_name"]); // get image file
        

            if(!isset($file)) { // file hasn't been selected
            $GLOBALS['submit_message'] = "<font color=red>Please select a file to upload</font>";
            } 
            else 
            {
                $check = getimagesize($_FILES["image"]["tmp_name"]); //check if image type file
                $mime = addslashes($_FILES["image"]["type"]);
                $name = addslashes($_FILES["image"]["name"]);
                if ($check)
            {
                $statement = $conn->prepare("UPDATE Team SET image= :image, name= :name, mime= :mime WHERE . Team . team_id= $team_id_image");
				
                $statement->bindParam(":image",$file);
                $statement->bindParam(":name", $name);
                $statement->bindParam(":mime", $mime);
				
                $result = $statement->execute();
            }
			if ($result)
			{
                $GLOBALS['message'] = "<font color=green>Team record was updated</font>";
			}
			else
			{
			    $GLOBALS['message'] = "<font color=red>Team record was not updated</font>";
			}
            }      
        }
    catch(PDOException $e)
    {
        echo "A problem occured: " . $e->getMessage();
    }
    $conn = null;
    }
?>




<?php	

    $conn = new PDO("mysql:host=" . $GLOBALS['db_servername'] . ";dbname=e0867928_Oaktown_Football_Club",
    $GLOBALS['db_username'], $GLOBALS['db_password']);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$weeksQuery = "
		SELECT 
		f.fixture_id
        ,w.week_id 
		,w.week_number 
		,w.week_date
        ,t1.team_id AS 'homeid'
		,t2.team_id AS 'awayid'
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
    	       ON f.week_id = w.week_id";

	$weeks = $conn->query($weeksQuery);

	if (isset($_GET['week'])) //select fields
	{    
       $weekQuery = "{$weeksQuery} WHERE w.week_id = :weeks_id";
	   $week = $conn->prepare($weekQuery);
	   $week->execute(['weeks_id' => $_GET['week']]);
	   $selectedWeek = $week->fetchAll(PDO::FETCH_ASSOC);		
    }   
?>




<?php   

    if (isset($_POST['get_fixture']))
    {
        updateteamscore($_POST["fixture_id"]);
    }

    function updateteamscore($fixture_id)
    {    
        try{
            $conn = new PDO("mysql:host=" . $GLOBALS['db_servername'] . ";dbname=e0867928_Oaktown_Football_Club",
            $GLOBALS['db_username'], $GLOBALS['db_password']);
        
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            if (!$_POST['fixture_id']){$GLOBALS['message'] = "The fixture ID entered is blank please enter fixture ID!";
            }
            else
            {
							
			$statement = $conn->prepare("UPDATE Fixture SET home_score=:home_score, away_score= :away_score WHERE fixture_id=" . $fixture_id);
			$statement->bindValue(":home_score", $_POST['home_score']);
			$statement->bindValue(":away_score", $_POST['away_score']);
			$result = $statement->execute();
				
			if ($result)
			    {
			    $GLOBALS['message'] = "<font color=green>Team record was updated</font>";
			    }
			    else
                {
                $GLOBALS['message'] = "<font color=red>Team record was not updated</font>";
                }
            }
		}
	catch(PDOException $e)
	{
        echo "A problem occurred:" . $e->getMessage();
	}
	   $conn = null;
	}
?>


<!--Form from here-->

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

	   		<title>Admin Page</title>	
			<link rel="stylesheet" type="text/css" href="css/style.css">
			<link rel="stylesheet" type="text/css" href="css/competitions.css"> 
			<meta charaset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
			
			<style>
    			.responsive {
    				max-width: 70%;
    				height: auto;
    			}
    			
    		</style>
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
  		</head>
  			<body><!--image for Background-->
			
				<div id="white_box"><!--White Box-->
		  			<div class="container"> <!--container in white box-->
						<header class="header">
							<img src="images/logo.png" alt="football logo">
							<td><h1>Oaktown Football Club</h1></td>
							<div>
							<table>
							<tr>
								<td ><?php echo '<h2> Welcome - '.$_SESSION["Name"].'</h2>';?></td> 
							</tr>
							<tr>
	    					<td ><?php echo '<h2><a href="logout.php"> Logout </a></h2>';?></td>
	    				</tr>
	    					</table>
	    					</div>
						</header>
						<nav>

			  				<ul> <!--Navigation Bar linking to index competition contact-->
								<li><a href="index.html">Home</a></li>
								<li><a href="competitions.php"> Competitions</a></li>
								<li><a href="contact.html">Contact</a></li>
								<li><a class="active">Admin</a></li>
			  				</ul>
						</nav>
						<div class="row">
			  				<section>
									<div>
									<table>
									<tr>
									<th colspan=5><?php echo $message; ?></th> <!-- Messages -->
									</tr>
									</table>
									</div>
									
													
										<div>
		        			  			<h3>Fixtures</h3> <!-- fixture update -->
		        			  			
		        			  			<p><strong>Choose the week's game fixture you want to update:</strong></p>  
		        			  			<form action="admin.php"  method="get">
		        	  	   	   				<select name="week"><!--dropdown menu-->
		        	   							<option value="1" selected="week 1">(select a week)</option>
		        	   							<?php foreach($weeks->fetchAll() as $week): ?> 
		        								<option value="<?php echo $week['week_id']; ?>">
		        									<?php echo $week['week_number']; ?>
		        								</option>
		        	   							<?php endforeach; ?>	   				
		        	   						</select>
		        	   						<input type="submit" value="select">	
		        			   			</form>
		        			   			</div>
		        				 		

		        				 		<div>
		            				 		<br/> 
		            				 		    
		            				 		<table><!--table content for fixture-->
		                						
		                						<tr>
		                							<th colspan=5> Fixture Results</th>
		                						</tr>
		                						<tr>
		                							<th colspan=5><?php echo $selectedWeek[0]['week_number']; ?></th>
		                						</tr>
		                						<tr>
		                							<th> Fixture id </th>       									
		                							<th> Home </th>				
		                							<th> Home Score </th>				       								
		                							<th> Away </th>
		                							<th> Away Score </th>
		                						<?php
		                						if ($selectedWeek){
		                                        foreach($selectedWeek as $s)
		                                        {

		                                            echo'<tr>' . '<td>' . $s['fixture_id'] . '</td>'  . '<td>' . $s['home'] . '</td>'  . '<td>' . $s['home_score'] . '</td>' .'<td>' . $s['away'] . '</td>'. '<td>' . $s['away_score'] . '</td>'.'</tr>';
		                                        }
		                						}
		                                    ?>
		                					
		            						</table>
		            			  			<br/>
		        						</div>
		        						

		        						<div>      						
		        							<form method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		        								<table>
		        									<tr>
		        										<th colspan=5> Fixture Score Updater</th>
		        									</tr>
		        									<tr>
														<td colspan=5> Enter Fixture ID to update team score record (see table above): </td>
													</tr>
													<tr>
														<td><input type="text" name="fixture_id" placeholder="fixture ID" value="<?php echo $fixture_id;?>"></td>
														<td><input type="submit" name="get_fixture" value="update"></td>
													</tr>
													<tr>
														<td><input type="text" name="home_score" placeholder="Home Score" ></td>
														<td><input type="text" name="away_score" placeholder="Away Score" ></td>
													</tr>
												</table>
		        							 
		        						</div>
		        						
		        						<div>
		        							
									
												<table> <!--table content for Teams-->
													<tr>
														<th colspan=5> Teams</th>
													</tr>
													<tr>
														<td colspan=5> Enter Team ID to show team record 1-8 </td>
													</tr>
													<tr>
														<td colspan=5><input type="text" name="team_id" placeholder="Team ID" value="<?php echo $team_id;?>"></td>
													</tr>
													<tr>												
														<td colspan=5><input type="submit" name="get_team" value="Show Team"></td>
													</tr>
													<tr>
														<td colspan=5> <input type="text" name="team_name" placeholder="Team Name" value="<?php echo $team_name;?>"></td>
												    </tr>
												    
												    <tr>
														<td colspan=5> To insert a new team select "new" then enter the new teams name and select "insert"</td>
												    </tr> 
													<tr >
														<td colspan=1><input type="submit" name="new_team" value="new"></td>
														<td colspan=1><input type="submit" name="insert_team" value="insert"></td>
													</tr>
													<tr><td colspan=5>You can save changes to team name by selecting "update". Scratch a team by selecting "delete"</td>
												    </tr>											
													<tr >
														<td colspan=1><input type="submit" name="update_team" value="update"></td>
														<td colspan=1><input type="submit" name="delete_team" value="delete"></td>
													</tr>
													
												    	<th colspan=5>Teams Logo</th>
											    	<tr>
														<td colspan=5> To add a new logo to team enter the Team ID then select the image file then "submit"</td>
												    </tr>

											    	<tr>
											    	
												       <td colspan=5><?php 
												       if ($name){
												           echo "<img src=getimage.php?id=$team_id>";}
												           else 
												           {
												           echo "<img src='images/profile.png' alt='profile'>";
												           }
											
												           ?></td>									      
													</tr>
													<tr>
														<th colspan=5>Update Team Mascot</th> <!--table content for Team Mascot-->
													</tr>
													<tr>
														<td colspan=5><input type="file" name="image"></td>
													</tr>
													<tr>
														<td colspan=5>Enter team id to add the image to </td>
													</tr>
													<tr>
													 	<td colspan=5><input type="text" name="team_id_image" placeholder="Team ID" value="<?php echo $team_id;?>"></td>
													</tr>
													<tr>
														<td colspan=5><input type="submit" name="upload"></td>
													</tr>																			
												</table>
										
											</form>	      						
	        						<footer class="col-12">
								<p>Copyright 2019 <a href="contact.html">Contact Us</a></p>  
		  					</footer>
	        						</div>
	        					</div>
	        					
	        				</section>
        					
					
						</div>
					</div>
				</div>
			</body>
		</html>












