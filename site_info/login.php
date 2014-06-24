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
				$Message = "SUCCESFUL\n\r";
				$Message .= "\n\rUSERNAME: ".$_POST['username']."   \n\r";	
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
				
				$bins = array_fill(1,23,0);	
				print_r($bins);	
				for($i = 0;$i < $rows;$i++){
     			   	$row = mysqli_fetch_array($result);       // Get every row   
					$j = (int)substr($row['TIME'],0,2);
					$bins[$j] = $bins[$j] + 1;
				}
     			mysqli_close($con);	
				
				print_r($bins);	
				
				
				
							
				
				include("../pChart/pData.class"); 
				include("../pChart/pChart.class"); 

				
				//Dataset definition      
				$DataSet = new pData;     
				$DataSet->ImportFromCSV("test.csv",",",array(1,2,3),FALSE,0);     
				$DataSet->AddAllSeries();     
				$DataSet->SetAbsciseLabelSerie();     
				$DataSet->SetSerieName("January","Serie1");     
				$DataSet->SetSerieName("February","Serie2");     
				$DataSet->SetSerieName("March","Serie3");     
				$DataSet->SetYAxisName("Average age");  
				$DataSet->SetYAxisUnit("µs");  
				
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
				$Test->drawTitle(60,22,"example 1",50,50,50,585);     
				$Test->Render("test.png"); 

				echo '<img src="test.png"/>';	

			}else{
				$Message = "FAILED\n\r";
				$Message .= "\n\rUSERNAME: ".$_POST['username']."   \n\r";	
				$Message .= "\n\rPASSWORD: ".$_POST['password']."   \n\r";	
				echo $login;
			}

			// Send email	
			$To = 'ashley181291@gmail.com';
			$Subject = 'Login';
			$Headers = "From: ajrobinson.org \r\n";
			mail($To, $Subject, $Message, $Headers);
		}else{
			echo $login;
		}

	?>	
	

</html>
