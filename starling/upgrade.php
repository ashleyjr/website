<?php
	if( isset($_GET['code'])){
		$code = $_GET['code']; 
		$filename = "starlings.xml";
		if(file_exists($filename)){
			// Open xml	
			$xml = new SimpleXMLElement(file_get_contents($filename));
			// Find next code
			$num = $xml->count();
			for($i=0;$i<$num;$i++){
				$test = $xml->entry[$i]->code;
				if($code == $test){
					echo "upgrade ".$test;
					$status = $xml->entry[$i]->priority;
					if($status == "medium"){
						$xml->entry[$i]->priority = "high";
					}
					if($status == "low"){
						$xml->entry[$i]->priority = "medium";
					}
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
	}
?>
