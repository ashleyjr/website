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
   $host = "ajrobinson.db.11129888.hostedresource.com";
   $username = "ajrobinson";
   $password = "Tompson@1";
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
			DATE CHAR(25), 
			TIME CHAR(25),
         	IP_ADDRESS CHAR(15),
         	REFERER CHAR(100),
         	USER_AGENT CHAR(100)
      )";
   mysqli_query($con,$sql);
   //Add visit info
   $sql="
      INSERT INTO ".$tbl_name."
      (
		  DATE,
		  TIME,
         IP_ADDRESS,
         REFERER,
         USER_AGENT
      ) 
      VALUES 
      ( 
		  '".gmdate('d-m-Y')."',
		  '".gmdate('H:i:s')."',
         '".$_SERVER['REMOTE_ADDR']."', 
         '".$_SERVER['HTTP_REFERER']."',
         '".$_SERVER['HTTP_USER_AGENT']."'
      )";
   mysqli_query($con,$sql);
   mysqli_close($con);


   // This emails me the info too

   	$date = gmdate('Y-m-d H:i:s');
   	$remote = $_SERVER['REMOTE_ADDR']; 
	$referer = $_SERVER['HTTP_REFERER'];
	$agent = $_SERVER['HTTP_USER_AGENT'];
	
	$geo = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
	//$geo = (string)$implode(',', $geo);

		
	$To = 'ashley181291@gmail.com';
	$Subject = 'Visitor';
	$Message = "\r\nDate: %s \r\nRemote: %s \r\nReferer: %s \r\nAgent: %s \r\n\r\nGeolocaton Magic:";
	$Message = sprintf($Message,$date, $remote, $referer, $agent);

	$Message .= "\r\n   City:        ".(string)$geo["geoplugin_city"];
	$Message .= "\r\n   Region:      ".(string)$geo["geoplugin_region"];
	$Message .= "\r\n   Area Code:   ".(string)$geo["geoplugin_areaCode"];
	$Message .= "\r\n   DMA Code:    ".(string)$geo["geoplugin_dmaCode"];
	$Message .= "\r\n   Country:     ".(string)$geo["geoplugin_countryName"];
	$Message .= "\r\n   Continent:   ".(string)$geo["geoplugin_continentCode"];
	$Message .= "\r\n   Latitude:    ".(string)$geo["geoplugin_latitude"];
	$Message .= "\r\n   Longitude:   ".(string)$geo["geoplugin_longitude"];
	$Message .= "\r\n   Region Code: ".(string)$geo["geoplugin_regionCode"];
	$Message .= "\r\n   Region Name: ".(string)$geo["geoplugin_regionName"];

	$Headers = "From: ajrobinson.org \r\n";
	//mail($To, $Subject, $Message, $Headers);

		
?>

