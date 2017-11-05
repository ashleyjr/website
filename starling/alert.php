<?php

	unlink('backup.zip');	
    	$zipname = 'backup.zip';
    	$zip = new ZipArchive;
    	$zip->open($zipname, ZipArchive::CREATE);
    	if ($handle = opendir('.')) {
    	  while (false !== ($entry = readdir($handle))) {
    	    if ($entry != "." && $entry != ".." && !strstr($entry,'.php')) {
    	        $zip->addFile($entry);
    	    }
    	  }
    	  closedir($handle);
    	}

    	$zip->close();


		
	// The file
	$filename = "backup.zip";

	// Send a backup
	$file_size = filesize($filename);
	$handle = fopen($filename, "r");
	$content = fread($handle, $file_size);
	fclose($handle);
	$content = chunk_split(base64_encode($content));
	$uid = md5(uniqid(time()));
	$name = basename($filename);
	
	$header = "From: ajrobinson.org <ajrobinson.org>\r\n";
	$header .= "Reply-To: ".$replyto."\r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
	
	$message  = "Content-type:text/plain; charset=iso-8859-1\r\n";
	$message .= "--".$uid."Backup\r\nContent-Transfer-Encoding: 7bit\r\n\r\n";
	
	$message .= "\r\n\r\n";   //$msg contains the plain text body of the email
	
	$message .= "--".$uid."\r\n";
	$message .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
	$message .= "Content-Transfer-Encoding: base64\r\n";
	$message .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
	$message .= $content."\r\n\r\n";
	$message .= "--".$uid."--\r\n";
	
	if (mail("ashley181291@gmail.com", "Backup",$message, $header)){
		echo "SENT!";	
	}else{
		echo "ERROR...not sent.";	  	
	}	

	

	
	// The file
	$filename = "starlings.xml";
			
	// Send the notofications
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
               // Data over a month has random +/- 1 day
               if($murmation > 672){
                  $murmation = $murmation + rand(-24,24);
               }

               // Data over a week has random +/- 1 hour
               if($murmation > 168){
                  $murmation = $murmation + rand(-1,1);
               } 

               // Decrement
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
