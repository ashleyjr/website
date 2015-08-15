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
	
	function post_unwrap($input) {
    		$new = htmlspecialchars($input);
		$new = utf8_encode($new);
		return $new;
	}
	

	$filename = "starlings.xml";
	

	if($_GET['user'] == "ashleyjr"){

	
	// SUBMIT
	//
	if( isset($_GET['submit'])){
		if( isset($_POST['title']) 	and
			isset($_POST['detail']) and
			isset($_POST['murmation']) ){

			   // Look for new number
			   $filename = "starlings.xml";
			   $end = "</starlings>";
			   while(1){
			   	if(file_exists($filename)){
			   		// Open xml	
			   		$xml = new SimpleXMLElement(stripslashes(file_get_contents($filename)));
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
			   		$entry->addChild("title",post_unwrap($_POST['title']));
			   		$entry->addChild("detail",post_unwrap($_POST['detail']));
			   		$entry->addChild("murmation",post_unwrap($_POST['murmation']));
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
			
            if(isset($_GET['see_closed'])){ 
               echo "<a href='view.php?user=ashleyjr&see_closed'>View Closed</a><p>";
            }else{
                echo "<a href='view.php?user=ashleyjr&submit'>Submit New Starling</a><p>";
            }
      	
            echo "<a href='view.php?user=ashleyjr&see_closed'>View Closed</a><p>";
         
      }else{
		   echo '	
			<form id="starling" name="starling" method="post" action="" enctype="application/x-www-form-urlencoded">
				Submit Starling<br>
					
				<label for="title">Title </label><br>
				<input  type="title" name="title" maxlength="50" size="50"><br>
				<label for="detail">Detail</label><br>
				<textarea  name="detail" maxlength="1000" cols="45" rows="6"></textarea><br>
				<label for="murmation">Murmation</label><br>	
            			<input  type="radio" name="murmation" value="1">                        1    
                     <input  type="radio" name="murmation" value="6">                        6
                     <input  type="radio" name="murmation" value="12">                       12 
                     <input  type="radio" name="murmation" value="24">                       24 
            			<input  type="radio" name="murmation" value="48">                       2d  
            			<input  type="radio" name="murmation" value="72">                       3d
            			<input  type="radio" name="murmation" value="96">                       4d 
                     <input  type="radio" name="murmation" value="120">                      5d
                     <input  type="radio" name="murmation" value="148">                      6d
                     <input  type="radio" name="murmation" value="172" checked="checked">    1w
                     <input  type="radio" name="murmation" value="336">                      2w
                     <input  type="radio" name="murmation" value="504">                      3w
                     <input  type="radio" name="murmation" value="672">                      1m
                     <br>
				<input type="submit" value="Submit"><br>	
  			</form>';
         
 
            if(isset($_GET['see_closed'])){ 
		echo "<a href='view.php?user=ashleyjr&see_closed'>Hide Form</a><p>";
                echo "<a href='view.php?user=ashleyjr&submit'>Hide Closed</a><p>"; 
            }else{
		echo "<a href='view.php?user=ashleyjr'>Hide Form</a><p>"; 
                echo "<a href='view.php?user=ashleyjr&submit&see_closed'>View Closed</a><p>";
            }

		}
	}else{
		// CLOSE
		//
		if( isset($_GET['close'])){
			$code = $_GET['close'];
			$xml = new SimpleXMLElement(stripslashes(file_get_contents($filename)));
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

			echo "<a href='view.php?user=ashleyjr&submit'>Submit New Starling</a><p>";

            if(isset($_GET['see_closed'])){ 
                echo "<a href='view.php?user=ashleyjr'>Hide Closed</a><p>"; 
            }else{
                echo "<a href='view.php?user=ashleyjr&see_closed'>View Closed</a><p>";
            }
      }else{
			// REOPEN
			//
			if( isset($_GET['reopen'])){
				$code = $_GET['reopen'];
				$xml = new SimpleXMLElement(stripslashes(file_get_contents($filename)));
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
            
            if(isset($_GET['see_closed'])){ 
               echo "<a href='view.php?user=ashleyjr&submit&see_closed'>Submit New Starling</a><p>";
               echo "<a href='view.php?user=ashleyjr'>Hide Closed</a><p>"; 
            }else{
               echo "<a href='view.php?user=ashleyjr&submit'>Submit New Starling</a><p>";
               echo "<a href='view.php?user=ashleyjr&see_closed'>View Closed</a><p>";
            }

     		}else{
				// EDIT
				//
				if( isset($_GET['edit'])){
					if(isset($_POST['detail']) and isset($_POST['murmation']) and isset($_POST['code'])){
                  				$code = post_unwrap($_POST['code']); 
				                  $murmation = post_unwrap($_POST['murmation']);
						$detail = post_unwrap($_POST['detail']); 
						$filename = "starlings.xml";
						if(file_exists($filename)){
							// Open xml	
							$xml = new SimpleXMLElement(stripslashes(file_get_contents($filename)));
							// Find next code
							$num = $xml->count();
							for($i=0;$i<$num;$i++){
								$test = $xml->entry[$i]->code;
								if($code == $test){
									$xml->entry[$i]->detail = $detail;	
                           $xml->entry[$i]->murmation = $murmation;
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
                  
                     if(isset($_GET['see_closed'])){ 
                        echo "<a href='view.php?user=ashleyjr&submit&see_closed'>Submit New Starling</a><p>";
                        echo "<a href='view.php?user=ashleyjr'>Hide Closed</a><p>"; 
                    }else{
                        echo "<a href='view.php?user=ashleyjr&submit'>Submit New Starling</a><p>";
                        echo "<a href='view.php?user=ashleyjr&see_closed'>View Closed</a><p>";
                    }
  
                  }
					}else{		
						$code = $_GET['edit'];
						if(file_exists($filename)){
							// Open xml	
							$xml = new SimpleXMLElement(stripslashes(file_get_contents($filename)));
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
					                <textarea  name="detail" maxlength="1000" cols="45" rows="6">'.$detail.'</textarea><br>
					                <label for="murmation">Murmation</label><br>
							               <input  type="radio" name="murmation" value="1"> 		1	
							               <input  type="radio" name="murmation" value="2"> 	    2
							               <input  type="radio" name="murmation" value="4">	    4  
					                   <input  type="radio" name="murmation" value="6">        6  
					                   <input  type="radio" name="murmation" value="12">        12  
					                   <input  type="radio" name="murmation" value="24">        24 
					                   <input  type="radio" name="murmation" value="48">        48  
					                   <input  type="radio" name="murmation" value="72">        72
					                   <input  type="radio" name="murmation" value="96" checked>        96 
					                   <br>
					
					      
					                <input type="hidden" name="code" value="'.$code.'"> <br>
					      
					                <input type="submit" value="Submit">   	<br>
							 
					                </form>';
      
						echo "<br><a href='view.php?user=ashleyjr&submit'>Submit New Starling</a><p>";
                  
                  if(isset($_GET['see_closed'])){ 
                     echo "<a href='view.php?user=ashleyjr&edit=".$code."'>Hide Closed</a><p>"; 
                  }else{
                     echo "<a href='view.php?user=ashleyjr&see_closed&edit=".$code."'>View Closed</a><p>";
                  }
					}
            }else{
               // Murmation
               //
               if(isset($_GET['murmation']) and isset($_GET['code'])){
                  $code = $_GET['code']; 
                  $murmation = $_GET['murmation']; 
						$filename = "starlings.xml";
						if(file_exists($filename)){
							// Open xml	
							$xml = new SimpleXMLElement(stripslashes(file_get_contents($filename)));
							// Find next code
							$num = $xml->count();
							for($i=0;$i<$num;$i++){
								$test = $xml->entry[$i]->code;
								if($code == $test){	
                           $xml->entry[$i]->murmation = $murmation;
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
                  
                     if(isset($_GET['see_closed'])){ 
                        echo "murmation<a href='view.php?user=ashleyjr&submit&see_closed'>Submit New Starling</a><p>";
                        echo "<a href='view.php?user=ashleyjr'>Hide Closed</a><p>"; 
                    }else{
                        echo "<a href='view.php?user=ashleyjr&submit'>Submit New Starling</a><p>";
                        echo "<a href='view.php?user=ashleyjr&see_closed'>View Closed</a><p>";
                    }
  
                  } 
               }else{
                     // Default
                     // 
                     if(isset($_GET['see_closed'])){ 
                        echo "<a href='view.php?user=ashleyjr&submit&see_closed'>Submit New Starling</a><p>";
                        echo "<a href='view.php?user=ashleyjr'>Hide Closed</a><p>"; 
                     }else{
                        echo "<a href='view.php?user=ashleyjr&submit'>Submit New Starling</a><p>";
                        echo "<a href='view.php?user=ashleyjr&see_closed'>View Closed</a><p>";
                     }
               }
            }
			}
		}
	}






	// THE TABLE
	//
	if(file_exists($filename)){
	
		// Open xml file and go through each entry
		$xml = new SimpleXMLElement(stripslashes(file_get_contents($filename)));
		$num = $xml->count();

			

		echo 
      		"<table>
      		   	<tr>
					<th>Code</th>
					<th>Title</th>
	  		  		<th>Detail</th>
					<th>Murmation</th>
               <th>Change</th>	
               <th>Edit</th>
               <th>+1</th>   
               <th>+24</th>
               <th>+1w</th>
               </tr>";

      $odd_even = true;
		for($i=($num-1);$i>-1;$i--){
			
         if( isset($_GET['see_closed'])){
            // New row with colour depedent on status
			   if($xml->entry[$i]->status == "open"){
			   	echo '<tr bgcolor="#FFCC33">';
			   }else{
			   	echo '<tr bgcolor="#FF6666">';
			   }
			   
			   echo "<td>".$xml->entry[$i]->code."</td>";   
			   echo "<td>".$xml->entry[$i]->title."</td>";   
	 		   echo "<td>".stripslashes($xml->entry[$i]->detail)."</td>";    
	 		   echo "<td>".($xml->entry[$i]->murmation)."</a></td>";

            if($xml->entry[$i]->status == "open"){
			      if(isset($_GET['see_closed'])){ 
                  echo "<td><a href='view.php?user=ashleyjr&see_closed&close=".$xml->entry[$i]->code."'>Close</a></td>"; 
               }else{ 
                  echo "<td><a href='view.php?user=ashleyjr&close=".$xml->entry[$i]->code."'>Close</a></td>";

               }
            }else{
			   	echo "<td><a href='view.php?user=ashleyjr&see_closed&reopen=".$xml->entry[$i]->code."'>Reopen</a></td>";
			   }
            
            
            if(isset($_GET['see_closed'])){ 
               echo "<td><a href='view.php?user=ashleyjr&see_closed&edit=".$xml->entry[$i]->code."'>Edit</a></td>"; 
            }else{ 
                  echo "<td><a href='view.php?user=ashleyjr&edit=".$xml->entry[$i]->code."'>Edit</a></td>";
            } 


            echo "<td><a href='view.php?user=ashleyjr&see_closed&murmation=".(($xml->entry[$i]->murmation) + 1)."&code=".$xml->entry[$i]->code."'>+1</a></td>";
            echo "<td><a href='view.php?user=ashleyjr&see_closed&murmation=".(($xml->entry[$i]->murmation) + 24)."&code=".$xml->entry[$i]->code."'>+24</a></td>";
            echo "<td><a href='view.php?user=ashleyjr&see_closed&murmation=".(($xml->entry[$i]->murmation) + 168)."&code=".$xml->entry[$i]->code."'>+1w</a></td>";
 
            
            echo "</tr>";				
         }else{
            if($xml->entry[$i]->status == "open"){ 
               // Single bit state machine
			      if($odd_even){
                  $odd_even = false;
                  echo '<tr bgcolor="#FFD9A3">';
			      }else{
                  $odd_even = true;
                  echo '<tr bgcolor="#FFFFFF">';
			      }
			      echo "<td><a href='info.php?user=ashleyjr&code=".$xml->entry[$i]->code."'>".$xml->entry[$i]->code."</a></td>";   
			      echo "<td>".$xml->entry[$i]->title."</td>";   
	 		      echo "<td>".stripslashes($xml->entry[$i]->detail)."</td>";    
	 		      echo "<td>".($xml->entry[$i]->murmation)." </a></td>";
    
		
			      echo "<td><a href='view.php?user=ashleyjr&close=".$xml->entry[$i]->code."'>Close</a></td>";
		
			      echo "<td><a href='view.php?user=ashleyjr&edit=".$xml->entry[$i]->code."'>Edit</a></td>";
               
               
               echo "<td><a href='view.php?user=ashleyjr&murmation=".(($xml->entry[$i]->murmation) + 1)."&code=".$xml->entry[$i]->code."'>+1</a></td>";
               echo "<td><a href='view.php?user=ashleyjr&murmation=".(($xml->entry[$i]->murmation) + 24)."&code=".$xml->entry[$i]->code."'>+24</a></td>";
               echo "<td><a href='view.php?user=ashleyjr&murmation=".(($xml->entry[$i]->murmation) + 168)."&code=".$xml->entry[$i]->code."'>+1w</a></td>";
 

               echo "</tr>";				
           }
         }
		}
		echo "</table>";
	}

	}else{
		echo "Access denied";
	}	
?>
   </body>
</html>
