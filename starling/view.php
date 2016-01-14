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


   function xml2array ( $xmlObject, $out = array () )
   {
          foreach ( (array) $xmlObject as $index => $node )
                     $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

              return $out;
   }


   function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
      $sort_col = array();
      foreach ($arr as $key=> $row) {
         $sort_col[$key] = $row[$col];
      }
      array_multisort($sort_col, $dir, $arr);
   }
   
   
   function array_to_xml( $data, &$xml_data ) {
      foreach( $data as $key => $value ) {
      if( is_array($value) ) {
      if( is_numeric($key) ){
      $key = 'item'.$key; //dealing with <0/>..<n/> issues
      }
      $subnode = $xml_data->addChild($key);
      array_to_xml($value, $subnode);
      } else {
      $xml_data->addChild("$key",htmlspecialchars("$value"));
      }
      }
      }
      
	function post_unwrap($input) {
    		$new = htmlspecialchars($input);
		$new = utf8_encode($new);
		return $new;
	}
	

	$filename = "starlings.xml";




   $form =    '	
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

   $user = "ashley181291";
   
   if($_GET['user'] == $user){




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

         echo $form; 
      }else{
		   echo $form;         
      }
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
					
					      
					                <input type="hidden" name="code" value="'.$code.'"> <br>
					      
					                <input type="submit" value="Submit">   	<br>
							 
					                </form>';
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



      // Sort by title if flag
      if( isset($_GET['sort'])){
         $msg = array();
         $msg_count = $xml->count();
         
         for ($x=0;$x<$msg_count;$x++){
            $msg[$x]['code'] = (string)$xml->entry[$x]->code;
            $msg[$x]['title'] = (string)$xml->entry[$x]->title;
            $msg[$x]['detail'] = (string)$xml->entry[$x]->detail;
            $msg[$x]['murmation'] = (string)$xml->entry[$x]->murmation;
            $msg[$x]['status'] = (string)$xml->entry[$x]->status;
            $msg[$x]['created'] = (string)$xml->entry[$x]->created;

         } 
         $code = array();
         foreach ($msg as $key => $row) {
            $code[$key] = $row['code'];
            $title[$key] = $row['title'];
            $detail[$key] = $row['detail'];
            $murmation[$key] = $row['murmation'];
            $status[$key] = $row['status'];
            $created[$key] = $row['created'];
         }

         $title_lowercase = array_map('strtolower', $title); 
         array_multisort(
            //change $titl to any variable created by "foreach"
            $title_lowercase, SORT_DESC, SORT_STRING,
            $msg); 

         for ($x=0;$x<$msg_count;$x++){
            $xml->entry[$x]->code =  $msg[$x]['code'];
            $xml->entry[$x]->title =  $msg[$x]['title'];
            $xml->entry[$x]->detail =  $msg[$x]['detail'];
            $xml->entry[$x]->murmation =  $msg[$x]['murmation'];
            $xml->entry[$x]->status =  $msg[$x]['status'];
            $xml->entry[$x]->created =  $msg[$x]['created'];

         }
      }
      

      // Sort by murmation if flag
      if( isset($_GET['sort_m'])){
         $msg = array();
         $msg_count = $xml->count();
         
         for ($x=0;$x<$msg_count;$x++){
            $msg[$x]['code'] = (string)$xml->entry[$x]->code;
            $msg[$x]['title'] = (string)$xml->entry[$x]->title;
            $msg[$x]['detail'] = (string)$xml->entry[$x]->detail;
            $msg[$x]['murmation'] = (string)$xml->entry[$x]->murmation;
            $msg[$x]['status'] = (string)$xml->entry[$x]->status;
            $msg[$x]['created'] = (string)$xml->entry[$x]->created;

         } 
         $code = array();
         foreach ($msg as $key => $row) {
            $code[$key] = $row['code'];
            $title[$key] = $row['title'];
            $detail[$key] = $row['detail'];
            $murm[$key] = $row['murmation'];
            $status[$key] = $row['status'];
            $created[$key] = $row['created'];
         }

         $murm_lowercase = array_map('strtolower', $murm); 
         array_multisort(
         //change $titl to any variable created by "foreach"
         $murm_lowercase, SORT_DESC, SORT_NUMERIC,$msg); 

         for ($x=0;$x<$msg_count;$x++){
            $xml->entry[$x]->code =  $msg[$x]['code'];
            $xml->entry[$x]->title =  $msg[$x]['title'];
            $xml->entry[$x]->detail =  $msg[$x]['detail'];
            $xml->entry[$x]->murmation =  $msg[$x]['murmation'];
            $xml->entry[$x]->status =  $msg[$x]['status'];
            $xml->entry[$x]->created =  $msg[$x]['created'];

         }
      }
      
      
      if(!isset($_GET['see_closed']) && !isset($_GET['submit']) && !isset($_GET['sort_m'])  && !isset($_GET['sort'])){
         echo "<a href='view.php?user=".$user."&submit'                  >Submit</a><p>";
         echo "<a href='view.php?user=".$user."&see_closed'              >Show Closed</a><p>"; 
         echo "<a href='view.php?user=".$user."&sort'                    >Sort by Title</a><p>";
      }
      if(isset($_GET['see_closed']) && !isset($_GET['submit']) && !isset($_GET['sort_m'])  && !isset($_GET['sort'])){
         echo "<a href='view.php?user=".$user."&see_closed&submit'       >Submit</a><p>";
         echo "<a href='view.php?user=".$user."'                         >Hide Closed</a><p>";
         echo "<a href='view.php?user=".$user."&see_closed&sort'         >Sort by Title</a><p>";
      }
      if(!isset($_GET['see_closed']) && isset($_GET['submit'])&& !isset($_GET['sort_m']) && !isset($_GET['sort'])){
         echo "<a href='view.php?user=".$user."'                         >Hide Form</a><p>";
         echo "<a href='view.php?user=".$user."&submit&see_closed'       >Show Closed</a><p>"; 
         echo "<a href='view.php?user=".$user."&submit&sort'             >Sort by Title</a><p>";
      }
      if(!isset($_GET['see_closed']) && !isset($_GET['submit']) && isset($_GET['sort'])){
         echo "<a href='view.php?user=".$user."&submit&sort'             >Submit</a><p>";
         echo "<a href='view.php?user=".$user."&see_closed&sort'         >Show Closed</a><p>"; 
         echo "<a href='view.php?user=".$user."&sort_m'                  >Sort by Murmation</a><p>";
      }
      if(!isset($_GET['see_closed']) && isset($_GET['submit']) && isset($_GET['sort'])){
         echo "<a href='view.php?user=".$user."&sort'                    >Hide Form</a><p>";
         echo "<a href='view.php?user=".$user."&see_closed&submit&sort'  >Show Closed</a><p>"; 
         echo "<a href='view.php?user=".$user."&submit&sort_m'           >Sort by Murmation</a><p>";
      }
      if(isset($_GET['see_closed']) && !isset($_GET['submit']) && isset($_GET['sort'])){
         echo "<a href='view.php?user=".$user."&see_closed&submit&sort'  >Submit</a><p>";
         echo "<a href='view.php?user=".$user."&sort'                    >Hide Closed</a><p>"; 
         echo "<a href='view.php?user=".$user."&see_closed&sort_m'       >Sort by Murmation</a><p>";
      }
      if(isset($_GET['see_closed']) && isset($_GET['submit']) && !isset($_GET['sort_m']) && !isset($_GET['sort'])){
         echo "<a href='view.php?user=".$user."&see_closed'              >Hide Form</a><p>";
         echo "<a href='view.php?user=".$user."&submit'                  >Hide Closed</a><p>"; 
         echo "<a href='view.php?user=".$user."&see_closed&submit&sort'  >Sort by Title</a><p>";
      }
      if(isset($_GET['see_closed']) && isset($_GET['submit']) && isset($_GET['sort'])){
         echo "<a href='view.php?user=".$user."&see_closed&sort'         >Hide Form</a><p>";
         echo "<a href='view.php?user=".$user."&submit&sort'             >Hide Closed</a><p>"; 
         echo "<a href='view.php?user=".$user."&see_closed&submit&sort_m'>Sort by Murmation</a><p>";
      } 
      if(!isset($_GET['see_closed']) && !isset($_GET['submit']) && !isset($_GET['sort']) && isset($_GET['sort_m'])){
         echo "<a href='view.php?user=".$user."&submit&sort_m'             >Submit</a><p>";
         echo "<a href='view.php?user=".$user."&see_closed&sort_m'         >Show Closed</a><p>"; 
         echo "<a href='view.php?user=".$user."'                        >Sort by Code</a><p>";
      }
      if(!isset($_GET['see_closed']) && isset($_GET['submit']) && !isset($_GET['sort']) && isset($_GET['sort_m'])){
         echo "<a href='view.php?user=".$user."&sort_m'                    >Hide Form</a><p>";
         echo "<a href='view.php?user=".$user."&see_closed&submit&sort_m'  >Show Closed</a><p>"; 
         echo "<a href='view.php?user=".$user."&submit'           >Sort by Code</a><p>";
      }
      if(isset($_GET['see_closed']) && !isset($_GET['submit']) && !isset($_GET['sort'])  && isset($_GET['sort_m'])){
         echo "<a href='view.php?user=".$user."&see_closed&submit&sort_m'  >Submit</a><p>";
         echo "<a href='view.php?user=".$user."&sort_m'                    >Hide Closed</a><p>"; 
         echo "<a href='view.php?user=".$user."&see_closed'       >Sort by Code</a><p>";
      } 
      if(isset($_GET['see_closed']) && isset($_GET['submit']) && !isset($_GET['sort'])  && isset($_GET['sort_m'])){
         echo "<a href='view.php?user=".$user."&see_closed&sort_m'         >Hide Form</a><p>";
         echo "<a href='view.php?user=".$user."&submit&sort_m'             >Hide Closed</a><p>"; 
         echo "<a href='view.php?user=".$user."&see_closed&submit'>Sort by Code</a><p>";
      } 
    
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
               <th>+D</th>   
               <th>+W</th>
               <th>+M</th>
               </tr>";

      $odd_even = true;
      for($i=($num-1);$i>-1;$i--){
         
         $link = false;
         $file = $xml->entry[$i]->code.".xml";
         if(file_exists($file)){
            $info = file_get_contents($file);
            //echo $info;
            if(strstr($info,"<url>")){
               $link = true;
            }
         }

         $change_str = "<td><a href='view.php?user=".$user;
         if(isset($_GET['see_closed'])){
            $change_str = $change_str."&see_closed";  
         }   
         if(isset($_GET['sort'])){
            $change_str = $change_str."&sort";  
         }
         if(isset($_GET['sort_m'])){
            $change_str = $change_str."&sort_m";  
         }  

         if( isset($_GET['see_closed'])){
            // New row with colour depedent on status
			   if($xml->entry[$i]->status == "open"){
			   	echo '<tr bgcolor="#FFCC33">';
			   }else{
			   	echo '<tr bgcolor="#FF6666">';
			   }
			   
            echo "<td><a href='info.php?user=".$user."&code=".$xml->entry[$i]->code."'>".$xml->entry[$i]->code."</a>";
            if($link){
               echo "(link)";
            }
            echo "</td>";   
            echo "<td>".$xml->entry[$i]->title."</td>";   
	 		   echo "<td>".stripslashes($xml->entry[$i]->detail)."</td>";    
	 		   echo "<td>".($xml->entry[$i]->murmation)."</a></td>";

            if($xml->entry[$i]->status == "open"){
               echo $change_str."&close=".$xml->entry[$i]->code."'>Close</a></td>";
            }else{	
               echo $change_str."&reopen=".$xml->entry[$i]->code."'>Reopen</a></td>";
            }
            
            
            echo "<td><a href='view.php?user=".$user."&see_closed&edit=".$xml->entry[$i]->code."'>Edit</a></td>";
            
            $state = "view.php?user=".$user."&see_closed"; 
            if(isset($_GET['submit'])){
               $state = $state."&submit";
            }  
            if(isset($_GET['sort'])){
               $state = $state."&sort";
            }
            if(isset($_GET['sort_m'])){
                  $state = $state."&sort_m";
               }

            echo "<td><a href='".$state."&murmation=".(($xml->entry[$i]->murmation) + 24)."&code=".$xml->entry[$i]->code."'>+</a></td>";
            echo "<td><a href='".$state."&murmation=".(($xml->entry[$i]->murmation) + 168)."&code=".$xml->entry[$i]->code."'>+</a></td>";
            echo "<td><a href='".$state."&murmation=".(($xml->entry[$i]->murmation) + 672)."&code=".$xml->entry[$i]->code."'>+</a></td>";
 
            
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
               echo "<td><a href='info.php?user=".$user."&code=".$xml->entry[$i]->code."'>".$xml->entry[$i]->code."</a>";
               if($link){
                  echo "(link)";
               }
               echo "</td>";   
               echo "<td>".$xml->entry[$i]->title."</td>";   
	 		      echo "<td>".stripslashes($xml->entry[$i]->detail)."</td>";    
	 		      echo "<td>".($xml->entry[$i]->murmation)." </a></td>";
    
		
			      echo $change_str."&close=".$xml->entry[$i]->code."'>Close</a></td>";

                  
			      echo "<td><a href='view.php?user=".$user."&edit=".$xml->entry[$i]->code."'>Edit</a></td>";
               

               $state = "view.php?user=".$user; 
               if(isset($_GET['submit'])){
                  $state = $state."&submit";
               }  
               if(isset($_GET['sort'])){
                  $state = $state."&sort";
               }
               if(isset($_GET['sort_m'])){
                  $state = $state."&sort_m";
               }
               echo "<td><a href='".$state."&murmation=".(($xml->entry[$i]->murmation) + 24)."&code=".$xml->entry[$i]->code."'>+</a></td>";
               echo "<td><a href='".$state."&murmation=".(($xml->entry[$i]->murmation) + 168)."&code=".$xml->entry[$i]->code."'>+</a></td>";
               echo "<td><a href='".$state."&murmation=".(($xml->entry[$i]->murmation) + 672)."&code=".$xml->entry[$i]->code."'>+</a></td>";
 

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
