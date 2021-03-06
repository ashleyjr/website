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

   function saveXML($xml,$filename){                                                                                 // Format and save xml
      $output = $xml->asXML();
		$doc = new DOMDocument();                                                                                      // Use DomDoc to format
		$doc->preserveWhiteSpace = false;
		$doc->formatOutput = true;
		$doc->loadXML($output);
		$output =  $doc->saveXML();
		file_put_contents($filename,$output);                                                                          // Save xml file 
   }

   function hoursToDate($hours){
      return gmdate("Y-m-d", $hours);
   }

   // XML file
   $filename = "starlings.xml";
   
   // Username required in url
   $user = "ashley181291";

   // Form builder
   $form =    '	
			   <form id="starling" name="starling" method="post" action="" enctype="application/x-www-form-urlencoded">
				Submit Starling<br>	
				<label for="title">Title </label><br>
            <input list="title" name="title">
               <datalist id="title">';
               if(file_exists($filename)){	                                                                        // 10 recent entries to fill drop down
                  $xml = new SimpleXMLElement(stripslashes(file_get_contents($filename)));                           // Open the xml file and go through for entries
                  $msg = array();
                  $msg_count = $xml->count();
                  for ($x=$msg_count;$x>$msg_count-11;$x--){                                                         // Add entries to html
                     $form .='<option value="'.(string)$xml->entry[$x]->title.'">'; 
                     if($x == 0) break;  
                  } 
               }
   $form .= '</datalist><br>
            <label for="detail">Detail</label><br>
				<textarea  name="detail" maxlength="1000" cols="45" rows="6"></textarea><br>
				<label for="murmation">Murmation</label><br>	
            			<input  type="radio" name="murmation" value="0">                        0 
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
                     <br> 
                     <input type="submit" value="Submit"><br>	
  			</form>';

   if($_GET['user'] != $user){                                                                                       // Basic username in url
      echo "Access denied";
   }else{
	   if( isset($_GET['submit'])){                                                                                   // ------------------------ SUBMIT
		   if(   isset($_POST['title']      ) 	and
			      isset($_POST['detail']     )  and
			      isset($_POST['murmation']) ){    
			   if(file_exists($filename) == False){                                                                     // If file does not exist then create
               $file = fopen($filename,"wb");
			   	$entry = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<starlings>\n</starlings>";
			   	fwrite($file,$entry);
			   	fclose($file);
            }
            $xml = new SimpleXMLElement(stripslashes(file_get_contents($filename)));                                 // Open up the file to look for new number
			   $num = $xml->count();                                                                                    // Number of entrie in database
			   $code = 0;
			   for($i=0;$i<$num;$i++){
			   	$test = intval($xml->entry[$i]->code);
			   	if($code == $test){
			   		$code = $test + 1;
			   	}
			   }
			   $entry = $xml->addChild('entry');                                                                        // Build the entry
			   $entry->addChild("code",$code);
			   $entry->addChild("title",utf8_encode(htmlspecialchars(($_POST['title']))));
			   $entry->addChild("detail",utf8_encode(htmlspecialchars(($_POST['detail']))));
			   $entry->addChild("murmation",utf8_encode(htmlspecialchars(($_POST['murmation']))));
			   $entry->addChild("status","open");
			   $entry->addChild("created",gmdate('d-m-Y'));
            saveXML($xml,$filename);
         }else{
            if( isset($_GET['close'])){                                                                                 // -------------------------------- CLOSE                                                                            
			      $code = $_GET['close'];
			      $xml = new SimpleXMLElement(stripslashes(file_get_contents($filename)));
			      $num = $xml->count();
			      for($i=0;$i<$num;$i++){
				      $test = $xml->entry[$i]->code;
				      if($test == $code){
				   	   $xml->entry[$i]->status = "closed";                                                                // Set the code to "Closed"
				   	   break;
			      	}
               }
               saveXML($xml,$filename);
            }
         }      
         echo $form;  
         if(   isset($_GET['murmation'])  and 
               isset($_GET['code'])       ){
            $code = $_GET['code']; 
            $murmation = $_GET['murmation']; 
			   $filename = "starlings.xml";
			   if(file_exists($filename)){
			   	$xml = new SimpleXMLElement(stripslashes(file_get_contents($filename)));
			   	$num = $xml->count();                                                                                 // Find next code
			   	for($i=0;$i<$num;$i++){
			   		$test = $xml->entry[$i]->code;
			   		if($code == $test){	
                     $xml->entry[$i]->murmation = $murmation;
                     break;
			   		}
			   	}
               saveXML($xml,$filename);
            }
         }           
	   }else{
		   if( isset($_GET['close'])){                                                                                 // -------------------------------- CLOSE                                                                            
			   $code = $_GET['close'];
			   $xml = new SimpleXMLElement(stripslashes(file_get_contents($filename)));
			   $num = $xml->count();
			   for($i=0;$i<$num;$i++){
				   $test = $xml->entry[$i]->code;
				   if($test == $code){
					   $xml->entry[$i]->status = "closed";                                                                // Set the code to "Closed"
					   break;
			   	}
            }
            saveXML($xml,$filename);
         }else{
			   if( isset($_GET['reopen'])){                                                                             // ----------------------------------REOPEN
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
               saveXML($xml,$filename);
     		   }else{
				   if( isset($_GET['edit'])){                                                                            // ---------------------------------- EDIT
                  if(   isset($_POST['detail'])    and 
                        isset($_POST['murmation']) and 
                        isset($_POST['code'])      ){
                     $code = utf8_encode(htmlspecialchars(($_POST['code']))); 
				         $murmation = utf8_encode(htmlspecialchars($_POST['murmation']));
				   		$detail = utf8_encode(htmlspecialchars(($_POST['detail']))); 
				   		$filename = "starlings.xml";
				   		if(file_exists($filename)){
				   			$xml = new SimpleXMLElement(stripslashes(file_get_contents($filename)));
				   			$num = $xml->count();
				   			for($i=0;$i<$num;$i++){
				   				$test = $xml->entry[$i]->code;
				   				if($code == $test){
                              $old = (string)$xml->entry[$i]->detail;
                              $xml->entry[$i]->detail = $detail;	
                              $xml->entry[$i]->murmation = $murmation;
                              break;
				   				}
                        }
                        saveXML($xml,$filename);
		                  $name = $code.".xml";                                                                        // Create the info file if it does not exist	
		                  if(!file_exists($name)){	
		                  	$file = fopen($name,"wb");
		                  	$entry = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<i".$code.">\n</i".$code.">\n";
		                  	fwrite($file,$entry);
		                  	fclose($file);
		                  }
                        $xml = new SimpleXMLElement(file_get_contents($name));                                       // Add change to info log 
			               $num = $xml->count();
			               $xml->entry[$num]->code = $num+1;	
			               $xml->entry[$num]->info = "DETAIL EDIT<br>Old: ".$old."<br>New: ".$detail;	
                        $xml->entry[$num]->url = "";
			               $xml->entry[$num]->date = gmdate("m/d/Y g:i:s A", time()-($ms));;
                        saveXML($xml,$name);                     
                     }
				   	}else{		
				   		$code = $_GET['edit'];
				   		if(file_exists($filename)){                                                                     // Get the existing info from the file
				   			$xml = new SimpleXMLElement(stripslashes(file_get_contents($filename)));
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
                        <input  type="radio" name="murmation" value="0">                        0    
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
                  if(isset($_GET['murmation']) and isset($_GET['code'])){                                               // ------------------------------ MURMATION
                     $code = $_GET['code']; 
                     $murmation = $_GET['murmation']; 
					   	$filename = "starlings.xml";
					   	if(file_exists($filename)){	
					   		$xml = new SimpleXMLElement(stripslashes(file_get_contents($filename)));
					   		$num = $xml->count();
					   		for($i=0;$i<$num;$i++){
					   			$test = $xml->entry[$i]->code;
					   			if($code == $test){	
                              $xml->entry[$i]->murmation = $murmation;
                              break;
					   			}
                        }
                        saveXML($xml,$filename);                                      
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
            $tit[$key] = $row['title'];
            $detail[$key] = $row['detail'];
            $murmation[$key] = $row['murmation'];
            $status[$key] = $row['status'];
            $created[$key] = $row['created'];
         }

         $title_lowercase = array_map('strtolower', $tit); 
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
      

      if(isset($_GET['edit']) && !isset($_POST['detail'])){     
         if(!isset($_GET['see_closed']) && !isset($_GET['submit']) && !isset($_GET['sort_m'])  && !isset($_GET['sort'])){
            echo "<a href='view.php?user=".$user."'                  >Hide Form</a> &nbsp;    ";
            echo "<a href='view.php?user=".$user."&see_closed&edit=".$_GET['edit']."'              >Show Closed</a> &nbsp;   "; 
            echo "<a href='view.php?user=".$user."&sort&edit=".$_GET['edit']."'                    >Sort by Title</a><p>";
         }
         if(isset($_GET['see_closed']) && !isset($_GET['submit']) && !isset($_GET['sort_m'])  && !isset($_GET['sort'])){
            echo "<a href='view.php?user=".$user."&see_closed'       >Hide Form</a>   &nbsp; ";
            echo "<a href='view.php?user=".$user."&edit=".$_GET['edit']."'                         >Hide Closed</a> &nbsp;   ";
            echo "<a href='view.php?user=".$user."&see_closed&sort&edit=".$_GET['edit']."'         >Sort by Title</a><p>";
         }
         if(!isset($_GET['see_closed']) && isset($_GET['submit'])&& !isset($_GET['sort_m']) && !isset($_GET['sort'])){
            echo "<a href='view.php?user=".$user."'                         >Hide FormHide Form</a>   &nbsp;  ";
            echo "<a href='view.php?user=".$user."&submit&see_closed&edit=".$_GET['edit']."'       >Show Closed</a> &nbsp;   "; 
            echo "<a href='view.php?user=".$user."&submit&sort&edit=".$_GET['edit']."'             >Sort by Title</a><p>";
         }
         if(!isset($_GET['see_closed']) && !isset($_GET['submit']) && isset($_GET['sort'])){
            echo "<a href='view.php?user=".$user."&sort'             >Hide Form</a>   &nbsp; ";
            echo "<a href='view.php?user=".$user."&see_closed&sort&edit=".$_GET['edit']."'         >Show Closed</a>  &nbsp;  "; 
            echo "<a href='view.php?user=".$user."&sort_m&edit=".$_GET['edit']."'                  >Sort by Murmation</a><p>";
         }
         if(!isset($_GET['see_closed']) && isset($_GET['submit']) && isset($_GET['sort'])){
            echo "<a href='view.php?user=".$user."&sort'                    >Hide Form</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."&see_closed&submit&sort&edit=".$_GET['edit']."'  >Show Closed</a>  &nbsp;  "; 
            echo "<a href='view.php?user=".$user."&submit&sort_m&edit=".$_GET['edit']."'           >Sort by Murmation</a><p>";
         }
         if(isset($_GET['see_closed']) && !isset($_GET['submit']) && isset($_GET['sort'])){
            echo "<a href='view.php?user=".$user."&see_closed&sort'  >Hide Form</a>   &nbsp; ";
            echo "<a href='view.php?user=".$user."&sort&edit=".$_GET['edit']."'                    >Hide Closed</a> &nbsp;   "; 
            echo "<a href='view.php?user=".$user."&see_closed&sort_m&edit=".$_GET['edit']."'       >Sort by Murmation</a><p>";
         }
         if(isset($_GET['see_closed']) && isset($_GET['submit']) && !isset($_GET['sort_m']) && !isset($_GET['sort'])){
            echo "<a href='view.php?user=".$user."&see_closed'              >Hide FormHide Form</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."&submit&edit=".$_GET['edit']."'                  >Hide Closed</a> &nbsp;   "; 
            echo "<a href='view.php?user=".$user."&see_closed&submit&sort&edit=".$_GET['edit']."'  >Sort by Title</a><p>";
         }
         if(isset($_GET['see_closed']) && isset($_GET['submit']) && isset($_GET['sort'])){
            echo "<a href='view.php?user=".$user."&see_closed&sort'         >Hide Form</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."&submit&sort&edit=".$_GET['edit']."'             >Hide Closed</a>  &nbsp;  "; 
            echo "<a href='view.php?user=".$user."&see_closed&submit&sort_m&edit=".$_GET['edit']."'>Sort by Murmation</a><p>";
         } 
         if(!isset($_GET['see_closed']) && !isset($_GET['submit']) && !isset($_GET['sort']) && isset($_GET['sort_m'])){
            echo "<a href='view.php?user=".$user."&sort_m'             >Hide Form</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."&see_closed&sort_m&edit=".$_GET['edit']."'         >Show Closed</a> &nbsp;   "; 
            echo "<a href='view.php?user=".$user."&edit=".$_GET['edit']."'                        >Sort by Code</a><p>";
         }
         if(!isset($_GET['see_closed']) && isset($_GET['submit']) && !isset($_GET['sort']) && isset($_GET['sort_m'])){
            echo "<a href='view.php?user=".$user."&sort_m'                    >Hide Form</a>   &nbsp; ";
            echo "<a href='view.php?user=".$user."&see_closed&submit&sort_m&edit=".$_GET['edit']."'  >Show Closed</a> &nbsp;   "; 
            echo "<a href='view.php?user=".$user."&submit&edit=".$_GET['edit']."'           >Sort by Code</a>    ";
         }
         if(isset($_GET['see_closed']) && !isset($_GET['submit']) && !isset($_GET['sort'])  && isset($_GET['sort_m'])){
            echo "<a href='view.php?user=".$user."&see_closed&sort_m'  >Hide Form</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."&sort_m&edit=".$_GET['edit']."'                    >Hide Closed</a> &nbsp;   "; 
            echo "<a href='view.php?user=".$user."&see_closed&edit=".$_GET['edit']."'       >Sort by Code</a><p>";
         } 
         if(isset($_GET['see_closed']) && isset($_GET['submit']) && !isset($_GET['sort'])  && isset($_GET['sort_m'])){
            echo "<a href='view.php?user=".$user."&see_closed&sort_m'         >Hide Form</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."&submit&sort_m&edit=".$_GET['edit']."'             >Hide Closed</a> &nbsp;   "; 
            echo "<a href='view.php?user=".$user."&see_closed&submit&edit=".$_GET['edit']."'>Sort by Code</a><p>";
         }
      }else{ 
         if(!isset($_GET['see_closed']) && !isset($_GET['submit']) && !isset($_GET['sort_m'])  && !isset($_GET['sort'])){
            echo "<a href='view.php?user=".$user."&submit'                  >Submit</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."&see_closed'              >Show Closed</a>  &nbsp;  "; 
            echo "<a href='view.php?user=".$user."&sort'                    >Sort by Title</a><p>";
         }
         if(isset($_GET['see_closed']) && !isset($_GET['submit']) && !isset($_GET['sort_m'])  && !isset($_GET['sort'])){
            echo "<a href='view.php?user=".$user."&see_closed&submit'       >Submit</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."'                         >Hide Closed</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."&see_closed&sort'         >Sort by Title</a><p>";
         }
         if(!isset($_GET['see_closed']) && isset($_GET['submit'])&& !isset($_GET['sort_m']) && !isset($_GET['sort'])){
            echo "<a href='view.php?user=".$user."'                         >Hide Form</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."&submit&see_closed'       >Show Closed</a>  &nbsp;  "; 
            echo "<a href='view.php?user=".$user."&submit&sort'             >Sort by Title</a><p>";
         }
         if(!isset($_GET['see_closed']) && !isset($_GET['submit']) && isset($_GET['sort'])){
            echo "<a href='view.php?user=".$user."&submit&sort'             >Submit</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."&see_closed&sort'         >Show Closed</a>  &nbsp;  "; 
            echo "<a href='view.php?user=".$user."&sort_m'                  >Sort by Murmation</a><p>";
         }
         if(!isset($_GET['see_closed']) && isset($_GET['submit']) && isset($_GET['sort'])){
            echo "<a href='view.php?user=".$user."&sort'                    >Hide Form</a> &nbsp;   ";
            echo "<a href='view.php?user=".$user."&see_closed&submit&sort'  >Show Closed</a>  &nbsp;  "; 
            echo "<a href='view.php?user=".$user."&submit&sort_m'           >Sort by Murmation</a><p>";
         }
         if(isset($_GET['see_closed']) && !isset($_GET['submit']) && isset($_GET['sort'])){
            echo "<a href='view.php?user=".$user."&see_closed&submit&sort'  >Submit</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."&sort'                    >Hide Closed</a>  &nbsp;  "; 
            echo "<a href='view.php?user=".$user."&see_closed&sort_m'       >Sort by Murmation</a><p>";
         }
         if(isset($_GET['see_closed']) && isset($_GET['submit']) && !isset($_GET['sort_m']) && !isset($_GET['sort'])){
            echo "<a href='view.php?user=".$user."&see_closed'              >Hide Form</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."&submit'                  >Hide Closed</a>   &nbsp; "; 
            echo "<a href='view.php?user=".$user."&see_closed&submit&sort'  >Sort by Title</a><p>";
         }
         if(isset($_GET['see_closed']) && isset($_GET['submit']) && isset($_GET['sort'])){
            echo "<a href='view.php?user=".$user."&see_closed&sort'         >Hide Form</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."&submit&sort'             >Hide Closed</a>  &nbsp;  "; 
            echo "<a href='view.php?user=".$user."&see_closed&submit&sort_m'>Sort by Murmation</a><p>";
         } 
         if(!isset($_GET['see_closed']) && !isset($_GET['submit']) && !isset($_GET['sort']) && isset($_GET['sort_m'])){
            echo "<a href='view.php?user=".$user."&submit&sort_m'             >Submit</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."&see_closed&sort_m'         >Show Closed</a>  &nbsp;  "; 
            echo "<a href='view.php?user=".$user."'                        >Sort by Code</a><p>";
         }
         if(!isset($_GET['see_closed']) && isset($_GET['submit']) && !isset($_GET['sort']) && isset($_GET['sort_m'])){
            echo "<a href='view.php?user=".$user."&sort_m'                    >Hide Form</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."&see_closed&submit&sort_m'  >Show Closed</a>  &nbsp;  "; 
            echo "<a href='view.php?user=".$user."&submit'           >Sort by Code</a><p>";
         }
         if(isset($_GET['see_closed']) && !isset($_GET['submit']) && !isset($_GET['sort'])  && isset($_GET['sort_m'])){
            echo "<a href='view.php?user=".$user."&see_closed&submit&sort_m'  >Submit</a>    ";
            echo "<a href='view.php?user=".$user."&sort_m'                    >Hide Closed</a>    "; 
            echo "<a href='view.php?user=".$user."&see_closed'       >Sort by Code</a><p>";
         } 
         if(isset($_GET['see_closed']) && isset($_GET['submit']) && !isset($_GET['sort'])  && isset($_GET['sort_m'])){
            echo "<a href='view.php?user=".$user."&see_closed&sort_m'         >Hide Form</a>  &nbsp;  ";
            echo "<a href='view.php?user=".$user."&submit&sort_m'             >Hide Closed</a>  &nbsp;  "; 
            echo "<a href='view.php?user=".$user."&see_closed&submit'>Sort by Code</a><p>";
         } 
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
               <th>+Y</th>
               <th>Expires</th>
               </tr>";

      $odd_even = true;
      for($i=($num-1);$i>-1;$i--){

   
         $file = $xml->entry[$i]->code.".xml";
         if(file_exists($file)){
            $info = file_get_contents($file);
            //echo $info;
            $code_add = "";
            if(strstr($info,"<url>")){ 
               $code_add .= "(link)";
            }else{
               if(strstr($info,"<info>")){
                  $code_add .= "(info)";
               }
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
			   
            echo "<td><a href='info.php?user=".$user."&code=".$xml->entry[$i]->code; 
            if(isset($_GET['sort'])){
               echo "&sort";
            }
            if(isset($_GET['sort_m'])){
               echo "&sort_m";
            }
            if(isset($_GET['see_closed'])){
               echo "&see_closed";
            }
            echo "'>".$xml->entry[$i]->code."</a>";


            echo $code_add;
                        
            echo "</td>";   
            echo "<td>".$xml->entry[$i]->title."</td>";   
	 		   echo "<td>".stripslashes($xml->entry[$i]->detail)."</td>";    
	 		   echo "<td>".($xml->entry[$i]->murmation)."</a></td>";

            if($xml->entry[$i]->status == "open"){
               echo $change_str."&close=".$xml->entry[$i]->code." 'id=\"c".$xml->entry[$i]->code."\" onclick='getScroll(\"c".$xml->entry[$i]->code."\")'>Close</a></td>";
            }else{	
               echo $change_str."&reopen=".$xml->entry[$i]->code." 'id=\"r".$xml->entry[$i]->code."\" onclick='getScroll(\"r".$xml->entry[$i]->code."\")'>Reopen</a></td>";
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
            
            echo "<td><a id=\"d".$xml->entry[$i]->code."\" onclick='getScroll(\"d".$xml->entry[$i]->code."\")' href='".$state."&murmation=".(($xml->entry[$i]->murmation) + 24)."&code=".$xml->entry[$i]->code."'>+D</a></td>";
            echo "<td><a id=\"w".$xml->entry[$i]->code."\" onclick='getScroll(\"w".$xml->entry[$i]->code."\")' href='".$state."&murmation=".(($xml->entry[$i]->murmation) + 168)."&code=".$xml->entry[$i]->code."'>+W</a></td>";
            echo "<td><a id=\"m".$xml->entry[$i]->code."\" onclick='getScroll(\"m".$xml->entry[$i]->code."\")' href='".$state."&murmation=".(($xml->entry[$i]->murmation) + 672)."&code=".$xml->entry[$i]->code."'>+M</a></td>"; 
            echo "<td><a id=\"m".$xml->entry[$i]->code."\" onclick='getScroll(\"m".$xml->entry[$i]->code."\")' href='".$state."&murmation=".(($xml->entry[$i]->murmation) + 8760)."&code=".$xml->entry[$i]->code."'>+Y</a></td>"; 
            
            $expires = time() + ($xml->entry[$i]->murmation*3600);
            echo "<td>".hoursToDate($expires)."</td>"; 

            echo "</tr>";				
         }else{
            if($xml->entry[$i]->status == "open"){ 
               if($xml->entry[$i]->murmation < 25){ 
                  if($xml->entry[$i]->murmation == 0){    
                     echo '<tr bgcolor="#FF6666">'; 
                  }else{
                     echo '<tr bgcolor="#FFFF00">'; 
                  }
               }else{
                  // Single bit state machine
			         if($odd_even){
                     $odd_even = false;
                     echo '<tr bgcolor="#FFD9A3">';
			         }else{
                     $odd_even = true;
                     echo '<tr bgcolor="#FFFFFF">';
			         }
               }
               echo "<td><a href='info.php?user=".$user."&code=".$xml->entry[$i]->code; 
               if(isset($_GET['sort'])){
                  echo "&sort";
               }
               if(isset($_GET['sort_m'])){
                  echo "&sort_m";
               }
               if(isset($_GET['see_closed'])){
                  echo "&see_closed";
               }
               echo "'>".$xml->entry[$i]->code."</a>";
               
               
               echo $code_add; 
               
               echo "</td>";   
               echo "<td>".$xml->entry[$i]->title."</td>";   
	 		      echo "<td>".stripslashes($xml->entry[$i]->detail)."</td>";    
	 		      echo "<td>".($xml->entry[$i]->murmation)." </a></td>";
    

               if(isset($_GET['submit'])){
                  echo $change_str."&submit&close=".$xml->entry[$i]->code." 'id=\"c".$xml->entry[$i]->code."\" onclick='getScroll(\"c".$xml->entry[$i]->code."\")'>Close</a></td>";
               }else{
                  echo $change_str."&close=".$xml->entry[$i]->code." 'id=\"c".$xml->entry[$i]->code."\" onclick='getScroll(\"c".$xml->entry[$i]->code."\")'>Close</a></td>";
               }
                  
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

               echo "<td><a id=\"d".$xml->entry[$i]->code."\" onclick='getScroll(\"d".$xml->entry[$i]->code."\")' href='".$state."&murmation=".(($xml->entry[$i]->murmation) + 24)."&code=".$xml->entry[$i]->code."'>+D</a></td>";
               echo "<td><a id=\"w".$xml->entry[$i]->code."\" onclick='getScroll(\"w".$xml->entry[$i]->code."\")' href='".$state."&murmation=".(($xml->entry[$i]->murmation) + 168)."&code=".$xml->entry[$i]->code."'>+W</a></td>";
               echo "<td><a id=\"m".$xml->entry[$i]->code."\" onclick='getScroll(\"m".$xml->entry[$i]->code."\")' href='".$state."&murmation=".(($xml->entry[$i]->murmation) + 672)."&code=".$xml->entry[$i]->code."'>+M</a></td>"; 
               echo "<td><a id=\"m".$xml->entry[$i]->code."\" onclick='getScroll(\"m".$xml->entry[$i]->code."\")' href='".$state."&murmation=".(($xml->entry[$i]->murmation) + 8760)."&code=".$xml->entry[$i]->code."'>+Y</a></td>"; 
               
                
               $expires = time() + ($xml->entry[$i]->murmation*3600);
               echo "<td>".hoursToDate($expires)."</td>"; 
            

               echo "</tr>";				
           }
         }
		}
		echo "</table>";
	}

	}	
?>


      <script>
         function getScroll(id) {
            document.getElementById(id).href += "&scroll=" + window.pageYOffset;
         }
         var search = window.location.search,matches;
         // if query string exists
         if (search) {
            // find scroll parameter in query string
            matches = /scroll=(\d+)/.exec(search);
            // jump to the scroll position if scroll parameter exists
            if (matches) {
               window.scrollTo(0, matches[1]);
            }
         }
      </script>
      
   </body>
</html>
