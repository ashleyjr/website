<?php
	$filename = "starlings.xml";
	if(file_exists($filename)){
		// Open xml file and go through each entry
		$xml = new SimpleXMLElement(file_get_contents($filename));
		$num = count($xml);
		for($i=($num-1);$i>-1;$i--){
			if($xml->entry[$i]->status == "open"){
				// Priority check for send emails
				$murmation = $xml->entry[$i]->murmation;
                if($murmation == 0){
					// Make data nice
					$title = $xml->entry[$i]->title;
					$detail = $xml->entry[$i]->detail;
					$code = $xml->entry[$i]->code;


					// Send reminder
					$To = 'ashley181291@gmail.com';
					$Subject = $title;

					$Message = '<html><body><center>';
					$Message .= "<u><h2>".$title."</h2></u><p>";
					$Message .= "<h3>".$detail."</h3><p>";
					$Message .= "<br>Starling Code: ".$code;
					$Message .= "<br><a href='http://www.ajrobinson.org/starling/view.php' target='_blank'>View Starling</a><p>";

					$Message .= '</center></body></html>';

					$Headers = "From: ajrobinson.org \r\n";
					$Headers .= "MIME-Version: 1.0\r\n";
					$Headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

					echo $Message;
					mail($To, $Subject, $Message, $Headers);
				}else{
    			    $murmation = $murmation - 1;
                    $xml->entry[$i]->murmation = $murmation;
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
			}	
		}
	}	
?>
