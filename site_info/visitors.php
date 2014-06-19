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
      $length = $_GET["length"];
      $start = $_GET["start"];


      //Take care of end
      $limit = $start + $length;
      if($limit > $rows){
         $limit = $rows;
      }

      //Tell user how many visits they are looking at
      $begin = $rows - $start;
      if($begin > $rows){
         $begin = $rows;
      }
      $end = $begin - $length;
      if($end > $begin){
         $end = 0;
      }
      if($end < 0){
         $end = 0;
      }
      echo "<h2> Visitors ".$begin." to ".$end."</h2>";

      //Setup table
      echo 
      "<table>
         <tr>
            <th>Vistor</th>
            <th style='width:150px'>Date/Time</th>
            <th>IP Address</th>
            <th>Referer</th>
            <th>Browser</th>
         </tr>";


      //Display table
      for($i = $rows;$i > 0;$i--){
         $row = mysqli_fetch_array($result);       // Get every row
         if(($i <= $begin)&&($i >= $end)){         // Display only some
            echo "<tr>";//New line in table
            echo "<td>".$row['PID']."</td>";                                     //TODO: This is shit 
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


      // User options
      echo "<br>View section...<br><br>";
      $start = 0;
      for($i = $rows;$i > 1;$i = $i - $length){
         $next = $i-$length;
         if($next < 0){
            $next = 0;
         }
         echo "[<a href=visitors.php?start=".$start."&length=".$length." target=content>".$i."..".$next."</a>]   <br>";
         $start = $start + $length;
      }

      echo "<br>View more/less...<br><br>";
      for($i=1;$i<$rows;$i=$i+$i){
         echo "[<a href=visitors.php?start=0&length=".$i." target=content>".$i." rows</a>]   <br>";
      }

   ?> 
   </body>
</html>
