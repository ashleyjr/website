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
               height: 250px;
            }
      </style>
   </head>
   <body>



	<h1>Ashley J. Robinson</h1>

	
	
	<img src="images/mugshot.jpg" alt="images/mugshot.jpg" target="_blank"><br>
	
	
	<h3> Hot Links </h3>
	<ul>
		<li><a href="AshleyRobinson.pdf" target="_blank">CV</a>
		<li><a href="AudioSpectrumAnalyser" target="content">AudioSpectrumAnalyser</a>
		<li><a href="DebugSerial" target="_blank">DebugSerial</a>
		<li><a href="education/projects/quadcopter/Quadcopter_AJR.pdf" target="_blank">Small Swarm Quadcopter</a>  
    </ul>

	
   <h3>Contact Details</h3>
      <p>
      Mobile: 07554162860</br>
      E-mail: <a href="mailto:ashley181291@gmail.com?Subject=Hi%20Ash">ashley181291@gmail.com</a></br>
      Check my <a href="calender.php" target="content">Calender</a>
      </p>



    <!-- <h3>Random site sample</h3> 
      <?php
         // -- Get a random image --
         //Make sure it's a jpg
         $image = '';
         $files = glob('images/*.*');
         while(substr($image, -4) != '.jpg'){
            $file = array_rand($files);
            $image = $files[$file];
         }
         echo '<img src="'.$image.'" alt="'.$image.'" target="_blank"><br>';
         //replace the jpg with dat for the caption and print it 
         $file = str_replace(".jpg",".dat",$image);
         if(file_exists($file)){
            $file_handle = fopen($file, "r");
            while (!feof($file_handle)) {
               $line = fgets($file_handle);
               echo $line;
            }
            fclose($file_handle);
         }
	?>
	-->

   <!-- <h3>Updates</h3>
      <table 
         border="1"
         style="
         background-color:#FFFFFF;
         border:1px  #8F590D;
         width:100%;
         border-collapse:collapse;"
      >
      <tr>
         <th style="white-space: nowrap">Date</th>
         <th style="white-space: nowrap">Area</th>
         <th style="white-space: nowrap">Status</th>
         <th>Details</th>
      </tr>
	


      <?php
         // -- Read in update from a file --
         // Get all files in updates folder
         $folder = 'updates/';
         $file_type = '.dat';
         $files = array_reverse(glob($folder.'*.*'));
         foreach($files as &$file){
            //Make sure they are the right files
            if(substr($file, -4) == $file_type){
               $temp = str_replace($folder,"",$file);
               $temp = str_replace($file_type,"",$temp);
               //Put the date in
               $year = substr($temp,0,-8);
               $month = substr($temp,4,-6);
               $day = substr($temp,6,-4);
               echo '<tr>';
               echo '<td style="white-space: nowrap">'.$day.'/'.$month.'/'.$year.'</td>';
               //Put in the area
               switch(substr($temp,9,-2)){
                  case "p":     
                     $area ="Project";  
                     break;
                  case "w": 
                     $area="Website";   
                     break;
                  default:       
                     $area="";
                     break;
               }
               echo '<td style="white-space: nowrap">'.$area.'</td>';
               //Put in the status
               switch(substr($temp,-1)){
                  case "i":     
                     $status="In progress";  
                     break;
                  case "f": 
                     $status="Finished";   
                     break;
                  default:       
                     $status="";
                     break;
               }
               echo '<td style="white-space: nowrap">'.$status.'</td>';
               echo '<td>';  
               //Print the contents of the file
               $file_handle = fopen($file, "r");
               while (!feof($file_handle)) {
                  $line = fgets($file_handle);
                  echo $line;
               }
               fclose($file_handle);
               echo '</td>'; 
               echo '</tr>';
            }
         } 
      ?> 
	-->

   </table>
   </body>
</html>
