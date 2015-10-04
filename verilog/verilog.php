<html>
	
	<head>
      <title>bio</title>
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
    <?php

         if(isset($_GET['file'])){ 
            $loc = 'https://raw.githubusercontent.com/ashleyjr/Verilog/master/'.$_GET['file'];
            $file =  file_get_contents($loc);
            echo nl2br($file);
         }else{
            $list = file_get_contents('https://raw.githubusercontent.com/ashleyjr/Verilog/master/list.txt');
            echo "test";
            foreach(preg_split("/((\r?\n)|(\r\n?))/", $list) as $line){
               echo "<a href='verilog.php?file=".$line."'>".$line."</a><br>";
            } 
         }
        
       # $lines = file('https://raw.githubusercontent.com/ashleyjr/Verilog/master/list.txt', FILE_IGNORE_NEW_LINES);

       # 
       # foreach($lines as $line){
       #     echo nl2br(file_get_contents('https://raw.githubusercontent.com/ashleyjr/Verilog/master/'. $line ));
       # }


    ?>
   </body>

</html>
