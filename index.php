<?php
   echo "
   <html>
      <head>
      <title>Ashley J. Robinson</title>
         <frameset cols='165,*' frameborder='0' border='0' framespacing='0'>
         <frameset rows='*'>
            <frame name='menu' src='menu.php' marginheight='0' marginwidth='0' scrolling='auto' noresize>
            </frameset>
   ";
   //Use this to redirect if different page is required
   switch($_GET["page"]){
      case "bio":     
         $page="bio.php";  
         break;
      case "courses": 
         $page="education/courses.php";   
         break;
      default:       
         $page="home.php";
         break;
   }
   echo "
         <frame name='content' src=".$page." marginheight='0' marginwidth='0' scrolling='auto' noresize>
          <noframes>
            <p>Personal website of Ashley J. Robinson</p>
         </noframes>
         </frameset>
      </head>
      <body>
      </body>
   </html>
   ";

   //Database for customer count

   //Values
   $host = "";
   $username = "a";
   $password = "";
   $db_name = "ajrobinson";
   $tbl_name = "visits";
   //Create if necessary
   $con = mysqli_connect($host,$username,$password);
   //Create database
   $sql="CREATE DATABASE IF NOT EXISTS ".$db_name;
   mysqli_query($con,$sql);
   $con = mysqli_connect($host,$username,$password,$db_name);//connect to new or old
   //Create table
   $sql="CREATE TABLE IF NOT EXISTS ".$tbl_name."
      (
         PID INT NOT NULL AUTO_INCREMENT, 
         PRIMARY KEY(PID),
         TIME CHAR(19),
         IP_ADDRESS CHAR(15),
         REFERER CHAR(100),
         USER_AGENT CHAR(100)
      )";
   mysqli_query($con,$sql);
   //Add visit info
   $sql="
      INSERT INTO ".$tbl_name."
      (
         TIME,
         IP_ADDRESS,
         REFERER,
         USER_AGENT
      ) 
      VALUES 
      ( 
         '".date('Y-m-d H:i:s')."',
         '".$_SERVER['REMOTE_ADDR']."', 
         '".$_SERVER['HTTP_REFERER']."',
         '".$_SERVER['HTTP_USER_AGENT']."'
      )";
   mysqli_query($con,$sql);
   mysqli_close($con);


   // This emails me the info too

	$To = 'ashley181291@gmail.com';
	$Subject = 'ajrobinson.org';
	$Message = 'This example demonstrates how you can send plain text email with PHP';
	$Headers = "From: ajrobinson.org \r\n";
	mail($To, $Subject, $Message, $Headers);

		
?>

