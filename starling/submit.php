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


	

					<form id="starling" name="starling" method="post" action="">
						
						<table width="600px" align="cemter">
							
								
							<tr>
								<th><h1>Submit Starling</h1></th>
							</tr>

							<tr>				
							  	<th><h2><label for="title">Title </label></h2></th>
							</tr>


							<tr>
							 
							  	<th><input  type="title" name="title" maxlength="50" size="30"></th>
							
							</tr>


							<tr>
							  		<th><h2><label for="detail">Detail</label></h2></th>
							</tr>



							<tr>
							 
							  		<th><textarea  name="detail" maxlength="1000" cols="25" rows="6"></textarea></th>
							 
							</tr>


							<tr>
							
							  		<th><h2><label for="priority">Priority</label></h2></th>

							
							</tr>
							

							<tr>								
									<th><input  type="radio" name="priority" value="high"> 		High<br></th>
							</tr>

							<tr>
									<th><input  type="radio" name="priority" value="medium"> 	Medium<br></th>
							</tr>

							<tr>
									<th><input  type="radio" name="priority" value="low">	 	Low<br></th>
							
							</tr>


								
							<tr>
					
							 		<th><input type="submit" value="Submit"></th>   
							
							</tr>

		<?php 

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
			echo '<tr>
					
				<th><h3>Thanks for your Starling!</h3></th>
				
					</tr>';
		}
?>

			</table>
  		</form>

	</center>
   </body>
</html>
