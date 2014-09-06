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
	$filename = "starlings.xml";
	if(file_exists($filename)){
	
		// Open xml file and go through each entry
		$xml = new SimpleXMLElement(file_get_contents($filename));
		$num = $xml->count();


		echo 
      		"<table>
      		   	<tr>
					<th>Code</th>
					<th>Title</th>
	  		  		<th>Detail</th>
					<th>Priority</th>
					<th>Status</th>
      		   	</tr>";

		for($i=($num-1);$i>-1;$i--){
			echo "<tr>";//New line in table
			echo "<td>".$xml->entry[$i]->code."</td>";   
			echo "<td>".$xml->entry[$i]->title."</td>";   
	 		echo "<td>".$xml->entry[$i]->detail."</td>";    
	 		echo "<td>".$xml->entry[$i]->priority."</td>";
			echo "<td>".$xml->entry[$i]->status."</td>";
			echo "</tr>";				
		}
		echo "</table>";
	}	
?>
   </body>
</html>
