<html>
   <head>
      <title>home</title>
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
               height: 300px;
			}


			
      </style>
   </head>
   <body>
	<center>

		<?php	
			if(isset($_POST['detail']) and isset($_POST['code'])){
				echo "DONE";
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
				if( isset($_GET['code'])){
					$code = $_GET['code']; 
					echo '								
						<form id="starling" name="starling" method="post" action="">
							<table width="600px" align="cemter">
		
							<tr>
								<th><h1>Edit Starling '.$code.'</h1></th>
						
							</tr>	

							<tr>
								<th><h1> </h1></th>
							</tr>		
							<tr>
							  	<th><h2><label for="detail">Detail</label></h2></th>
							</tr>
							<tr>
							  	<th><textarea  name="detail" maxlength="1000" cols="45" rows="6"></textarea></th>
							</tr>


							<tr>
								<th><h1> <input type="hidden" name="code" value="'.$code.'"> </h1></th>
							</tr>		
							<tr>
							 	<th><input type="submit" value="Submit"></th>   	
							</tr>
	
							</table>
  						</form>';
				}
			}
		?>
	</center>
   </body>
</html>

