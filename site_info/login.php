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

				// My own content
				echo "Welcome Ashley";



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
	</body>

</html>
