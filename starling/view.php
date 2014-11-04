<html>
   <head>
      <title>View Starlings</title>
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
	

	// SUBMIT
	//
	if( isset($_GET['submit'])){
		if( isset($_POST['title']) 	and
			isset($_POST['detail']) and
			isset($_POST['priority']) ){

			// Look for new number
			$filename = "starlings.xml";
			$end = "</starlings>";
			while(1){
				if(file_exists($filename)){
					// Open xml	
					$xml = new SimpleXMLElement(file_get_contents($filename));
					// Find next code
					$num = $xml->count();
					$code = 0;
					for($i=0;$i<$num;$i++){
						$test = intval($xml->entry[$i]->code);
						if($code == $test){
							$code = $test + 1;
						}
					}
					// Add new entry
					$entry = $xml->addChild('entry');
					$entry->addChild("code",$code);
					$entry->addChild("title",$_POST['title']);
					$entry->addChild("detail",$_POST['detail']);
					$entry->addChild("priority",$_POST['priority']);
					$entry->addChild("status","open");
					$entry->addChild("created",gmdate('d-m-Y'));
					$output = $xml->asXML();
					// Use DomDoc to format
					$doc = new DOMDocument();
					$doc->preserveWhiteSpace = false;
					$doc->formatOutput = true;
					$doc->loadXML($output);
					$output =  $doc->saveXML();
					// Save as xml file
					file_put_contents($filename,$output);
					break;		
				}else{
					$file = fopen($filename,"wb");
					$entry = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<starlings>\n</starlings>";
					fwrite($file,$entry);
					fclose($file);
				}
			}
		}else{
		echo '	
			<form id="starling" name="starling" method="post" action="">
			Submit Starling<br>
				
			<label for="title">Title </label><br>
			<input  type="title" name="title" maxlength="50" size="50"><br>
			<label for="detail">Detail</label><br>
			<textarea  name="detail" maxlength="1000" cols="45" rows="6"></textarea><br>
			<label for="priority">Priority</label>
			<input  type="radio" name="priority" value="high"> 		High	
			<input  type="radio" name="priority" value="medium"> 	Medium
			<input  type="radio" name="priority" value="low">	 	Low<br>
			<input type="submit" value="Submit"><br>	
  		</form>';

		}
	}else{
		// CLOSE
		//
		if( isset($_GET['close'])){
			$code = $_GET['close'];
			$xml = new SimpleXMLElement(file_get_contents($filename));
			$num = $xml->count();
			for($i=0;$i<$num;$i++){
				$test = $xml->entry[$i]->code;
				if($test == $code){
					$xml->entry[$i]->status = "closed";
					break;
				}
			}
			$output = $xml->asXML();
			// Use DomDoc to format
			$doc = new DOMDocument();
			$doc->preserveWhiteSpace = false;
			$doc->formatOutput = true;
			$doc->loadXML($output);
			$output =  $doc->saveXML();
			file_put_contents($filename, $output);

			$Message .= "Closed ".$code." <br>";

			echo $Message;	
		}else{
			// REOPEN
			//
			if( isset($_GET['reopen'])){
				$code = $_GET['reopen'];
				$xml = new SimpleXMLElement(file_get_contents($filename));
				$num = $xml->count();
				for($i=0;$i<$num;$i++){
					$test = $xml->entry[$i]->code;
					if($test == $code){
						$xml->entry[$i]->status = "open";
						break;
					}
				}
					//		echo $out;
				$output = $xml->asXML();
				// Use DomDoc to format
				$doc = new DOMDocument();
				$doc->preserveWhiteSpace = false;
				$doc->formatOutput = true;
				$doc->loadXML($output);
				$output =  $doc->saveXML();
				file_put_contents($filename, $output);
			
				
				$Message .= "Reopened ".$code." <br>";

				echo $Message;
			}else{
				// EDIT
				//
				if( isset($_GET['edit'])){
					if(isset($_POST['detail']) and isset($_POST['code'])){
						$code = $_POST['code']; 
						$detail = $_POST['detail']; 
						$filename = "starlings.xml";
						if(file_exists($filename)){
							// Open xml	
							$xml = new SimpleXMLElement(file_get_contents($filename));
							// Find next code
							$num = $xml->count();
							for($i=0;$i<$num;$i++){
								$test = $xml->entry[$i]->code;
								if($code == $test){
									$xml->entry[$i]->detail = $detail;	
									break;
								}
							}
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
					}else{		
						$code = $_GET['edit'];
						if(file_exists($filename)){
							// Open xml	
							$xml = new SimpleXMLElement(file_get_contents($filename));
							// Find next code
							$num = $xml->count();
							for($i=0;$i<$num;$i++){
								$test = $xml->entry[$i]->code;
								if($code == $test){
									$detail = $xml->entry[$i]->detail;
									$title = $xml->entry[$i]->title;	
									break;
								}
							}
						}	
						echo '
							<form id="starling" name="starling" method="post" action="">
							Edit Starling '.$code.'	<br>
							Title: '.$title.'<br>
							Detail: '.$detail.'	<br>
							<label for="detail">New Detail</label><br>
							<textarea  name="detail" maxlength="1000" cols="45" rows="6"></textarea><br>
							<input type="hidden" name="code" value="'.$code.'"> <br>
							<input type="submit" value="Submit">   	<br>
							</form>';
					}
				}else{
					echo "<a href='http://www.ajrobinson.org/starling/view.php?submit' target='_blank'>Submit New Starling</a><p>";
				}

			}
		}
	}






	// THE TABLE
	//
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
					<th>Change Status</th>	
					<th>Edit</th>	
				</tr>";

		for($i=($num-1);$i>-1;$i--){
			
			// New row with colour depedent on status
			if($xml->entry[$i]->status == "open"){
				echo '<tr bgcolor="#FFCC33">';
			}else{
				echo '<tr bgcolor="#FF3333">';
			}
			
			echo "<td>".$xml->entry[$i]->code."</td>";   
			echo "<td>".$xml->entry[$i]->title."</td>";   
	 		echo "<td>".$xml->entry[$i]->detail."</td>";    
	 		echo "<td>".$xml->entry[$i]->priority."</td>";
			echo "<td>".$xml->entry[$i]->status."</td>";
			if($xml->entry[$i]->status == "open"){
				echo "<td><a href='http://www.ajrobinson.org/starling/view.php?close=".$xml->entry[$i]->code."' target='_blank'>Close</a></td>";
			}else{
				echo "<td><a href='http://www.ajrobinson.org/starling/view.php?reopen=".$xml->entry[$i]->code."' target='_blank'>Reopen</a></td>";
			}
			echo "<td><a href='http://www.ajrobinson.org/starling/view.php?edit=".$xml->entry[$i]->code."' target='_blank'>Edit</a></td>";
			echo "</tr>";				
		}
		echo "</table>";
	}	
?>
   </body>
</html>
