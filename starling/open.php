<?php
	$filename = "starlings.xml";
	if( isset($_GET['code'])){
		$code = $_GET['code'];
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

		$Message = '<html><body><center>';
		$Message .= "<h3>Starling ".$code." opened</h3>";
		$Message .= "<a href='http://www.ajrobinson.org/starling/close.php?code=".$code."'>Close</a>";
		$Message .= "<br><br>	<a href='http://www.ajrobinson.org/starling/submit.php'>Submit New Starling</a>";
		$Message .= '</center></body></html>';
		echo $Message;
	}
?>
