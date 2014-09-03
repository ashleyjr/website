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

		if( isset($_POST['title']) 	and
			isset($_POST['detail']) and
			isset($_POST['priority']) ){
				echo "<h3>Thanks for your Starling!</h3>";

			// Look for new number
			$code = 0;
			while(1){
				$filename = $code.".sta";
				if(!file_exists($filename)){
					break;
				}
				$code = $code + 1;
			}

			// Write new alert folder	
			$file = fopen($filename,"wb");
			$message = 	"number=".$code."\n";
			$message .= "title=".$_POST['title']."\n";	
			$message .= "detail=".$_POST['detail']."\n";	
			$message .= "prioity=".$_POST['priority']."\n";			
			fwrite($file,$message);
			fclose($file);
			
			echo nl2br($message);	
			//// Send email	
			//$To = 'ashley181291@gmail.com';
			//$Subject = 'Comment';
			//$Headers = "From: ajrobinson.org \r\n";
			//mail($To, $Subject, $Message, $Headers);
		}else{
			echo $form;
		}
	?>


   </body>
</html>
