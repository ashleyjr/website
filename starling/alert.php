<?php
	$filename = "starlings.xml";
	if(file_exists($filename)){
		
		$hour = gmdate("h");
		$hour = intval($hour)+1;

		// High every hour	
		$high = True;


		// Medium every two hours
		// low every four hours

		if($hour == 4 or $hour == 8 or $hour == 12 ){
			$medium = True;
			$low= True;
		}else{
			$medium = False;
			$low = False;
		}
		if(($hour == 2) or ($hour == 6) or ($hour == 10)){
			$medium = True;
		}


		// Open xml file and go through each entry
		$xml = new SimpleXMLElement(file_get_contents($filename));
		$num = count($xml);
		for($i=($num-1);$i>-1;$i--){
			if($xml->entry[$i]->status == "open"){
				// Priority check for send emails
				$priority = $xml->entry[$i]->priority;
				if(	(($priority == "high") and ($high == True)) or
					(($priority == "medium") and ($medium == True)) or
					(($priority == "low") and ($low == True)) ){
					// Make data nice
					$title = $xml->entry[$i]->title;
					$detail = $xml->entry[$i]->detail;
					$code = $xml->entry[$i]->code;


					// Send reminder
					$To = 'ashley181291@gmail.com';
					$Subject = $title;

					$Message = '<html><body><center>';
					$Message .= "<u><h2>".$title."</h2></u>";
					$Message .= "<h3>".$detail."</h3>";
					$Message .= "Priority: ".$priority;
					$Message .= "<br>Starling Code: ".$code;
					$Message .= "<br><br>	<a href='http://www.ajrobinson.org/starling/upgrade.php?code=".$code."' target='_blank'>Upgrade</a>";
					$Message .= "   		<a href='http://www.ajrobinson.org/starling/downgrade.php?code=".$code."' target='_blank'>Downgrade</a>";
					$Message .= "   		<a href='http://www.ajrobinson.org/starling/close.php?code=".$code."' target='_blank'>Close</a><p>";
				
					$Message .= "   		<a href='http://www.ajrobinson.org/starling/submit.php' target='_blank'>Submit New Starling</a><p>";

					$Message .= '</center></body></html>';

					$Headers = "From: ajrobinson.org \r\n";
					$Headers .= "MIME-Version: 1.0\r\n";
					$Headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

					echo $Message;
					mail($To, $Subject, $Message, $Headers);
				}	
			}	
		}
	}	
?>
