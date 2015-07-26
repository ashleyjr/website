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
               height: 200px;
            }
      </style>
   </head>

   <body>


	   <h2>CORDIC Architecture in System Verilog</h2>
      <img src="cordic_output.jpg" alt="Output" target="_blank">  
      <p>
         CORDIC stands for COordinate Rotation DIgital Computer and this task was to implement the equation below using this architecture.
         Restricted to 16-bit parallel input/output I chose to internal cast the value as 32-bit as to improve the accuracy of any calculations then cast back to a 16-bit output.
         An interesting challenge as I have never used System Verilog for trigonometric function before.
         A part from the maths the system is relatively simple and is pipelined using two separate blocks to compute the entire equation. 
      </p>
      <p>
         Find a zip file of code <a href="code.zip" target="_blank">here</a> as no report was submitted only an automated testbench was used to mark the design; for which I received 96%. 
      </p>





   </body>
</html>
