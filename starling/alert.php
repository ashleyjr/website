<?php
	$filename = "starlings.xml";
	if(file_exists($filename)){
		$file = file_get_contents($filename);

		$p = xml_parser_create();
		xml_parse_into_struct($p, $file, $values, $tags);
		xml_parser_free($p);
		
		//var_dump($tags);

		$open = False;
		foreach($values as $value){

			//print_r($value);
			if($value["tag"] == "ENTRY"){
				//echo "entry ".$value["type"];
				if($value["type"]  == "open"){
					$open = True;

					$title = "";
					$detail = "";
					$code = "";
					$status = "";
					$priority = "";
				}
		
				if($value["type"]  == "close"){
					$open = False;
					echo $status;
					if($status == "open"){
						// Send reminder
						$To = 'ashley181291@gmail.com';
						$Subject = $title;

						$Message = '<html><body><center>';
						$Message .= "<u><h2>".$title."</h2></u>";
						$Message .= "<h3>".$detail."</h3>";
						$Message .= "Priority: ".$priority;
						$Message .= "<br>Starling Code: ".$code;
						$Message .= "<br><br>	<a href='http://www.ajrobinson.org/starling/upgrade.php' target='_blank'>Upgrade</a>";
						$Message .= "   		<a href='http://www.ajrobinson.org/starling/downgrade.php' target='_blank'>Downgrade</a>";
						$Message .= "   		<a href='http://www.ajrobinson.org/starling/close.php?code=".$code."' target='_blank'>Close</a>";
						$Message .= "<br><br>	<a href='http://www.ajrobinson.org/starling/submit.php' target='_blank'>Submit New Starling</a>";
						$Message .= '</center></body></html>';
						

						$Headers = "From: ajrobinson.org \r\n";
						$Headers .= "MIME-Version: 1.0\r\n";
						$Headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

						echo $Message;
						mail($To, $Subject, $Message, $Headers);
					}	
				}	
			}
			if($open){
				if($value["tag"] == "CODE"){
					$code = $value["value"];	
				}
				if($value["tag"] == "STATUS"){
					$status = $value["value"];
				}
				if($value["tag"] == "TITLE"){
					$title = $value["value"];
				}
				if($value["tag"] == "DETAIL"){
					$detail = $value["value"];
				}
				if($value["tag"] == "PRIORITY"){
					$priority = $value["value"];
				}

			}
			//var_dump($open);
			//echo "<br>";
		}
	}
?>
