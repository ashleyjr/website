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
		include("../pChart/pData.class"); 
		include("../pChart/pChart.class"); 


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

		// Send reminder
		
		$To = 'ashley181291@gmail.com';
		$Subject = $title;

		$Message =  '<html><body><center>';
		$Message .= "<u><h2>".$title."</h2></u>";
		$Message .= "<h2>Today: $today</h2>";
		$Message .= '<img src="http://www.ajrobinson.org/site_info/';
		$Message .= $file;
		$Message .= '">';
		$Message .= '</center></body></html>';
		

		$Headers = "From: ajrobinson.org \r\n";
		$Headers .= "MIME-Version: 1.0\r\n";
		$Headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		mail($To, $Subject, $Message, $Headers);

		echo $Message;
	?>	
</html>
