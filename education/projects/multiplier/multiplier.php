<html>
   <head>
      <title>projects</title>
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

  	<h2>System Verilog Design of a Sequential Multiplier</h2>
      <img src="multiplier.jpg" alt="Output" target="_blank"> 
      <p>
         The first time I wrote a design which was synthesised and tested on hardware. 
         Using a MachXO development board (Lattice semiconductor) I constructed a 'shift and add' multiplier.
         This trades off execution time for design size by putting numbers into registers and shifting to give a multiplication of two.
         These are then added to a running total (or not) to give multiplication but any possible number.
         4-bits is rather trivial but still an interesting topic which took me a while to grasp the motivation for the design.
      </p>
      <p>
         Find the report <a href="squential_multiplier.pdf" target="_blank">here</a> for which I received 70% and a zip file of code <a href="code.zip" target="_blank">here</a>. 
      </p> 


   </body>
</html>
