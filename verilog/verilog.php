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
        $homepage = file_get_contents('https://raw.githubusercontent.com/ashleyjr/Verilog/master/fir_filter/fir_filter.v');
        echo $homepage;
    ?>
   </body>

</html>
