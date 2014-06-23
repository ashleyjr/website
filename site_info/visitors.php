<html>
   <head>
      <title>visitors</title>
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
            table{
               border-style: solid;  
               background-color:#FFFFFF;
               border-width:1px;
               width:100%;
               border-collapse:collapse; 
            }
            th,td{
               border-style: solid;  
               border-width:1px;
               color:#8F590D;
            }
      </style>
   </head>

   <body>      
   		<?php
      		//Get data out of database
      		//Values
      		$host = "ajrobinson.db.11129888.hostedresource.com";
      		$username = "ajrobinson";
      		$password = "Tompson@1";
      		$db_name = "ajrobinson";
      		$tbl_name = "visits";
      		//Connect
      		$con = mysqli_connect($host,$username,$password,$db_name);
      		//Read data backwards
      		$result = mysqli_query($con,"SELECT * FROM ".$tbl_name." ORDER BY PID DESC");
	  		
	  		//Display a set number of rows
      		$rows = mysqli_num_rows($result);


      		//Take care of stuff from URL
      		$jump = $_GET["jump"];
      		$length = $_GET["length"];
	  		  
  
	  		echo "<h2> Visitors</h2>";
			

			echo "Backwards from entry ".($rows-$jump)." for ".$length." entries. <br>";		
			//Setup table	
	  		$end = $jump + $length;
			if($end > $rows) $end = $rows;	  
	  
			// User options
			$user = "";
			if($jump != 0){
				$temp = $jump - $length; 
				if($temp < 0) $temp = 0;
				$user .= "[<a href=visitors.php?jump=".$temp."&length=".$length." target=content>Later</a>]  ";	
			}
			if($end != $rows){
				$temp = $jump + $length;
				$user .= "[<a href=visitors.php?jump=".$temp."&length=".$length." target=content>Earlier</a>]";	
			}
			$user .= "<br>";
			$temp = $length / 2;
			if($temp < 1) $temp = 1;	
			$user .= "[<a href=visitors.php?jump=".$jump."&length=".$temp." target=content>Shorter</a>]";	
			$temp = $length * 2;
			if($temp > $rows) $temp = $rows;	
			$user .= "[<a href=visitors.php?jump=".$jump."&length=".$temp." target=content>Longer</a>]";	
		
			echo $user;	
		

			// Table header
			echo 
      		"<table>
      		   	<tr>
      		      	<th>Visitor</th>
      		      	<th style='width:75px'>Date</th>
	  		  		<th style='width:75px'>Time(GMT)</th>
	  		  		<th style='width:150px'>IP Address</th>
      		      	<th style='width:300px'>Referer</th>
      		      	<th style='width:300px'>Browser</th>
      		   	</tr>";
		
			//Display table	
     		for($i = 0;$i < $end;$i++){
     		   	$row = mysqli_fetch_array($result);       // Get every row
     		   	if($i >= $jump){         // Display only some
     		   	   	echo "<tr>";//New line in table
     		   	   	echo "<td>".$row['PID']."</td>";                                     //TODO: This is shit 
     		   	   	echo "<td>".$row['DATE']."</td>";   
	 		   	 	echo "<td>".$row['TIME']."</td>";    
	 		   	 	echo "<td>".$row['IP_ADDRESS']."</td>";
     		   	   	//list of active stuff
     		   	   	$active[0] = '/</';
     		   	   	$active[1] = '/</';
     		   	   	//remove active stuff
     		   	   	echo "<td>".preg_replace($active,'',$row['REFERER'])."</td>";
     		   	   	echo "<td>".preg_replace($active,'',$row['USER_AGENT'])."</td>";  
     		   	   	echo "</tr>"; 
     		  	}	
     		}
     		mysqli_close($con);
     		echo "</table>";
			// options again
			echo $user;	
   		?> 
   </body>
</html>
