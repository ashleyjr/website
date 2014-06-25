<html>
   <head>
      <title>home</title>
      <style type="text/css">
         body {
	            font-family:Times New Roman;
	            font-size:13pt;
	            margin:30px;
               background-color:#FFFFFF;
               color:#8F590D;
            }
			a:link 
         	{
         	   COLOR: #8F590D;
         	}
         	a:visited
         	{
         	   COLOR: #8F590D;
         	}
         	a:hover 
         	{
         	   COLOR: #8F590D;
         	}
         	a:active 
         	{
         	   COLOR: #8F590D;
         	}
            img{
               width: auto; /* you can use % */
               height: 250px;
            }
      </style>
   </head>
   <body>



	<h1>Ashley J. Robinson</h1>

	
	
	<img src="bio/mugshot.jpg" alt="mugshot" target="_blank"><br>
	
	
	<h3> Hot Links </h3>
	<ul>
		<li><a href="AshleyRobinsonCV.pdf" target="_blank">CV</a>
		<li><a href="AudioSpectrumAnalyser" target="content">AudioSpectrumAnalyser</a>
		<li><a href="DebugSerial" target="_blank">DebugSerial</a>
		<li><a href="education/projects/quadcopter/Quadcopter_AJR.pdf" target="_blank">Small Swarm Quadcopter</a> 
		<li><a href="AshleyRobinsonUKESF.pdf" target="_blank">UKESF Scholar of the Year Report</a>  
    </ul>


	<?php 
		$form = '
			<h3>Comments</h3>
			<p>I am very interested in your opinion of the site. Layout, structure and content.</br></p>
			<form id="form1" name="form1" method="post" action="">
				<textarea name="comment" id="textarea" cols="45" rows="5"></textarea><br>
				Name (optional):   <input type="text" name="name" id="name"><br>
				Email (optional): <input type="text" name="email" id="email">
  				<input type="submit" name="button" id="button" value="Send" />
  			</form>';

		if( isset($_POST['comment']) ){
			if(strlen($_POST['comment']) === 0){
				echo $form;
			}else{
				// Check super globals 
				echo "<h3>Thanks for your comment!</h3>";
				$Message = "";
				if (strlen($_POST['name']) !== 0)		$Message .= "\n\rNAME: ".$_POST['name']."   \n\r";	
				if (strlen($_POST['email']) !== 0)		$Message .= "\n\rEMAIL: ".$_POST['email']."   \n\r";		
				if (strlen($_POST['comment']) !== 0)	$Message .= "\n\rCOMMENT: ".$_POST['comment']."   \n\r";	
				echo nl2br($Message);	
				// Send email	
				$To = 'ashley181291@gmail.com';
				$Subject = 'Comment';
				$Headers = "From: ajrobinson.org \r\n";
				mail($To, $Subject, $Message, $Headers);
			}
		}else{
			echo $form;
		}
	?>

	<h3>Contact Details</h3>
      <p>
      Mobile: 07554162860</br>
      E-mail: <a href="mailto:ashley181291@gmail.com?Subject=Hi%20Ash">ashley181291@gmail.com</a></br>
      Come find me? Check my <a href="calender.php" target="content">Calender</a>.
      </p>



   </table>
   </body>
</html>
