<html>
   <head>
      <title>Courses</title>
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
      </style>
   </head>

   <body>

	<?php

		$login = '
			<h2>Login</h2>
			<form id="form1" name="form1" method="post" action="">
				Username:  <input type="text" name="username" id="name"><br>
				Password: <input type="password" name="password" id="password"><br>
  				<input type="submit" name="button" id="button" value="Login" />
  			</form>
		';
		if( isset($_POST['password']) and isset($_POST['username'])  ){
			if( ($_POST['password'] === "Tompson1") and ($_POST['username'] === "ashley")){
				
				echo "<h1>IP Submissions </h1>";
					
				$info = file_get_contents("../ip.txt");	
				echo nl2br($info);

                $info = file_get_contents("../pi.log");    
				echo nl2br($info);
                
                $info = file_get_contents("../pi1.log");    
				echo nl2br($info);

				echo "<h1>Visiting Times</h1>";
				
				include("../pChart/pData.class"); 
				include("../pChart/pChart.class"); 


				//////////////
				// DO ALL
				/////////////
					
      			// Values
      			$host = "ajrobinson.db.11129888.hostedresource.com";
      			$username = "ajrobinson";
      			$password = "Tompson@1";
      			$db_name = "ajrobinson";
      			$tbl_name = "visits";
      			// Connect
      			$con = mysqli_connect($host,$username,$password,$db_name);
      			// Read data backwards
      			$result = mysqli_query($con,"SELECT * FROM ".$tbl_name." ORDER BY PID DESC");
	  			// Number of rows
      			$rows = mysqli_num_rows($result);	
				
	
				// Calculate bins	
				$bins = array_fill(0,24,0);		
				for($i = 0;$i < $rows;$i++){
     			   	$row = mysqli_fetch_array($result);       // Get every row   
					$j = (int)substr($row['TIME'],0,2);
					$bins[$j] = $bins[$j] + 1;
				}
	
				mysqli_close($con);	
				
							
				$file = "all.png";			
				if (file_exists($file)) {
				    unlink($file);
				}
				
				
				//Dataset definition      
				$DataSet = new pData;     
				$DataSet->AddPoint($bins,"Serie1");
				//$DataSet->ImportFromCSV("test.csv",",",array(1,2,3),FALSE,0);     
				$DataSet->AddAllSeries();     
				$DataSet->SetAbsciseLabelSerie();          
				$DataSet->SetYAxisName("Visitors");   
				
				// Initialise the graph     
				$Test = new pChart(700,230);     
				$Test->setFontProperties("../pChart/tahoma.ttf",8);     
				$Test->setGraphArea(70,30,680,200);     
				$Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);     
				$Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);     
				$Test->drawGraphArea(255,255,255,TRUE);  
				$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2);     
				$Test->drawGrid(4,TRUE,230,230,230,50);  
				
				// Draw the 0 line     
				$Test->setFontProperties("../pChart/tahoma.ttf",6);     
				$Test->drawTreshold(0,143,55,72,TRUE,TRUE);     
				
				// Draw the line graph  
				$Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());     
				$Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);     
				
				// Finish the graph     
				$Test->setFontProperties("../pChart/tahoma.ttf",8);     
				$Test->drawLegend(75,35,$DataSet->GetDataDescription(),255,255,255);     
				$Test->setFontProperties("../pChart/tahoma.ttf",10);     
				$Test->drawTitle(60,22,"Site Visitors",50,50,50,585);     
				$Test->Render($file); 

				echo "<h2>Total visits: $rows</h2>";
				echo '<img src="';
				echo $file;
				echo '"/>';


				/////////////////
				// Daily 
				///////////////

				// Values
      			$host = "ajrobinson.db.11129888.hostedresource.com";
      			$username = "ajrobinson";
      			$password = "Tompson@1";
      			$db_name = "ajrobinson";
      			$tbl_name = "visits";
      			// Connect
      			$con = mysqli_connect($host,$username,$password,$db_name);
      			// Read data backwards
      			$result = mysqli_query($con,"SELECT * FROM ".$tbl_name." ORDER BY PID DESC");
	  			// Number of rows
      			$rows = mysqli_num_rows($result);	
				
	
				// Calculate bins
				$today = 0;	
				$bins_1 = array_fill(0,24,0);		
				for($i = 0;$i < $rows;$i++){
     			   	$row = mysqli_fetch_array($result);       // Get every row   
					if($row['DATE'] != gmdate('d-m-Y') ){
						break;
					}	
					$j = (int)substr($row['TIME'],0,2);
					$bins_1[$j] = $bins_1[$j] + 1;
					$today = $today + 1;
				}
	
				mysqli_close($con);	
				
							
				$file = "today.png";			
				if (file_exists($file)) {
				    unlink($file);
				}
							
				//Dataset definition      
				$Data = new pData;     
				$Data->AddPoint($bins_1,"Serie2");
				$Data->AddAllSeries();     
				$Data->SetAbsciseLabelSerie();      
				$Data->SetYAxisName("Visitors");   
				
				// Initialise the graph     
				$Test1 = new pChart(700,230);     
				$Test1->setFontProperties("../pChart/tahoma.ttf",8);     
				$Test1->setGraphArea(70,30,680,200);     
				$Test1->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);     
				$Test1->drawRoundedRectangle(5,5,695,225,5,230,230,230);     
				$Test1->drawGraphArea(255,255,255,TRUE);  
				$Test1->drawScale($Data->GetData(),$Data->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2);     
				$Test1->drawGrid(4,TRUE,230,230,230,50);  
				
				// Draw the 0 line     
				$Test1->setFontProperties("../pChart/tahoma.ttf",6);     
				$Test1->drawTreshold(0,143,55,72,TRUE,TRUE);     
				
				// Draw the line graph  
				$Test1->drawLineGraph($Data->GetData(),$Data->GetDataDescription());     
				$Test1->drawPlotGraph($Data->GetData(),$Data->GetDataDescription(),3,2,255,255,255);     
				
				// Finish the graph     
				$Test1->setFontProperties("../pChart/tahoma.ttf",8);     
				$Test1->drawLegend(75,35,$Data->GetDataDescription(),255,255,255);     
				$Test1->setFontProperties("../pChart/tahoma.ttf",10);     
				$Test1->drawTitle(60,22,"Site Visitors",50,50,50,585);     
				$Test1->Render($file); 

				echo "<h2>Today: $today</h2>";
				echo '<img src="';
				echo $file;
				echo '"/>';
				


					

			}else{
				$Message = "FAILED\n\r";
				$Message .= "\n\rUSERNAME: ".$_POST['username']."   \n\r";	
				$Message .= "\n\rPASSWORD: ".$_POST['password']."   \n\r";	
				echo $login;
				// Send email	
				$To = 'ashley181291@gmail.com';
				$Subject = 'Login';
				$Headers = "From: ajrobinson.org \r\n";
				mail($To, $Subject, $Message, $Headers);
			}
		}else{
			echo $login;
		}

	?>	
	

</html>
