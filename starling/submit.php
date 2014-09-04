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



	<?php 
		$form = '
				<h3>Submit Starling</h3>
					<form id="starling" name="starling" method="post" action="">
						<table width="450px">
							</tr>
							<tr>
								<td valign="top">
							  		<label for="title">Title </label>
								</td>
							 	<td valign="top">
							  		<input  type="title" name="title" maxlength="50" size="30">
								 </td>
							</tr>
							 
							<tr>
							 	<td valign="top">
							  		<label for="detail">Detail</label>
							 	</td>
							 	<td valign="top">
							  		<textarea  name="detail" maxlength="1000" cols="25" rows="6"></textarea>
							 	</td>
							</tr>

							<tr>
								<td valign="top">
							  		<label for="priority">Priority</label>
								</td>
							 	<td valign="top">
									<input  type="radio" name="priority" value="high"> 		High<br>
									<input  type="radio" name="priority" value="medium"> 	Medium<br>
									<input  type="radio" name="priority" value="low">	 	Low<br>
								</td>	
							</tr>
								
								
							<tr>
							 	<td colspan="2" style="text-align:left">
							 		<input type="submit" value="Submit">   
							 	</td>
							</tr>
						</table>
  					</form>';


		function endsWith($haystack, $needle)
		{
		    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
		}

		if( isset($_POST['title']) 	and
			isset($_POST['detail']) and
			isset($_POST['priority']) ){

			// Look for new number
			$filename = "starlings.xml";
			$end = "</starlings>";
			while(1){
				if(file_exists($filename)){
					$file = file_get_contents($filename);
					if(endsWith($file, $end)){

						$p = xml_parser_create();
						xml_parse_into_struct($p, $file, $values, $tags);
						xml_parser_free($p);
						$code = 0;
						foreach($tags['CODE'] as $entry){
							$test = intval($values[$entry]['value']);
							if($test == $code){
								$code = $test + 1;
							}
						}	
		
							
						$info  = 	"\t<entry>\n";
						$info .= 	"\t\t<code>".$code."</code>\n";
						$info .= 	"\t\t<title>".$_POST['title']."</title>\n";
						$info .= 	"\t\t<detail>".$_POST['detail']."</detail>\n";	
						$info .= 	"\t\t<priority>".$_POST['priority']."</priority>\n";
						$info .= 	"\t\t<created>".gmdate('d-m-Y')."</created>\n";				
						$info .= 	"\t</entry>\n";	

						$new = substr_replace($file, $info, (strlen($file)-strlen($end)), 0);	
						file_put_contents($filename, $new);	
					}
					break;		
				}else{
					$file = fopen($filename,"wb");
					$entry = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<starlings>\n</starlings>";
					fwrite($file,$entry);
					fclose($file);
				}
			}
			echo $form;
			echo "<h3>Thanks for your Starling!</h3>";
		}else{
			echo $form;
		}
	?>


   </body>
</html>
