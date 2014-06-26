<?php
	if (isset($_GET["ip"]) and $_GET["machine"])
	{
		// Ask geo location
		$geo = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_GET["ip"]));

		// Make a txt submission
		$info .= "\r\nMachine:     ".$_GET["machine"]; 
		$info .= "\r\nDate:        ".gmdate('Y-m-d');
		$info .= "\r\nTime:        ".gmdate('H:i:s');
		$info .= "\r\nSubmitted:   ".$_GET["ip"];
		$info .= "\r\nFound:       ".$_SERVER['REMOTE_ADDR'];		
		$info .= "\r\nCity:        ".(string)$geo["geoplugin_city"];
		$info .= "\r\nRegion:      ".(string)$geo["geoplugin_region"];
		$info .= "\r\nCountry:     ".(string)$geo["geoplugin_countryName"];
		$info .= "\r\nContinent:   ".(string)$geo["geoplugin_continentCode"];
		$info .= "\r\nLatitude:    ".(string)$geo["geoplugin_latitude"];
		$info .= "\r\nLongitude:   ".(string)$geo["geoplugin_longitude"];
		
		file_put_contents("ip.txt", $info);
		echo $info;
	}
	else
	{
		echo "Submission failed";
		echo '<meta http-equiv="refresh" content="0;URL=index.php" />';
	}
?>
