<html>
   <head>
      <title>Starling Info</title>
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
	//This scripts allows you to associate more data wih each starling but is not tied to the main tracking
	// Suppoort for tracking links and general time based comments
	if(isset($_GET['code'])){
		$code = $_GET['code'];

		// Create the file if it does not exist	
		$filename = $code.".xml";
		if(!file_exists($filename)){	
			// Make xml file
			$file = fopen($filename,"wb");
			$entry = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<i".$code.">\n</i".$code.">\n";
			fwrite($file,$entry);
			fclose($file);
		}
		
		// Print data the can't be change from starlings
		$starlings = "starlings.xml";	
		if(file_exists($starlings)){
			$xml = new SimpleXMLElement(file_get_contents($starlings));
			$num = $xml->count();
			echo "<table>";
			for($i=($num-1);$i>-1;$i--){
				if($xml->entry[$i]->code == $code){
					echo "<tr><th>Title</th><td>".$xml->entry[$i]->title."</td>";   
					echo "<tr><th>Detail</th><td>".stripslashes($xml->entry[$i]->detail)."</td>";    
					echo "<tr><th>Murmation</th><td>".$xml->entry[$i]->murmation."</td>";
					echo "<tr><th>Created</th><td>".$xml->entry[$i]->created."</td>";
				}
			}
			echo "</table>";
		}

		echo "<br><a href=\"view.php?user=ashleyjr\">Back to main list</a><br><br>";

		// Add new updates
		echo '
			<form id="starling" name="starling" method="post" action="">
			
			<label for="info">Info</label><br>		                
			<textarea  name="info" maxlength="1000" cols="50" rows="6"></textarea><br>
		
			<label for="url">URL</label><br>		                
			<textarea  name="url" maxlength="1000" cols="100" rows="2"></textarea><br>
				
			
			<input type="submit" value="Submit">   	<br>							 
			</form>';
	
		if(isset($_POST['info']) and isset($_POST['url'])){	
			$xml = new SimpleXMLElement(file_get_contents($filename));
			// Find next code
			
			$num = $xml->count();
		
			$xml->entry[$num]->code = $num+1;	
			$xml->entry[$num]->info = $_POST['info'];	
                   	$xml->entry[$num]->url = $_POST['url'];
			$xml->entry[$num]->date = gmdate("m/d/Y g:i:s A", time()-($ms));;
			// Add new entry
			$output = $xml->asXML();
			// Use DomDoc to format
			$doc = new DOMDocument();
			$doc->preserveWhiteSpace = false;
			$doc->formatOutput = true;
			$doc->loadXML($output);
			$output =  $doc->saveXML();
			// Save as xml file
			file_put_contents($filename,$output);
                  
	
		}
		
		

		// Print table of updates
		$xml = new SimpleXMLElement(file_get_contents($filename));
			// Find next code
			
		$num = $xml->count();
	
		echo "<table>";	
		for($i=($num-1);$i>-1;$i--){
			echo "<tr>";
			echo "<td>".$xml->entry[$i]->date."</td>";	
			echo "<td>".$xml->entry[$i]->info."</td>";
			echo "<td><a href=\"".$xml->entry[$i]->url."\" target=\"_blank\">".$xml->entry[$i]->url."</a></td>";		
		}		
		echo "</table>";
      

	}		
?>
