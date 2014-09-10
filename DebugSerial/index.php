<html>
	<head>
		<title>DebugSerial</title>
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
      </style>
    </head>
	<body>
		<center><h2>DebugSerial</h2></center>				  
		DebugSerial is tool for embedded programmers to verify their designs with a simple serial connection.
		Using only UART restricted to 8 bit frames with no parity bits makes setting up the connection simple.
		Allowing the user to define only the Baud rate.

		
		<ul>
			<li><a href="https://github.com/ashleyjr/DebugSerial/" target="_blank">Github Repository</a>
            <li><a href="DebugSerial.pdf" target="_blank">User Manual (pdf)</a>
		</ul>

		<h2>Hardware</h2>

		DebugSerial is written in python and designed operate cross-platform.
		The operating system must have access to a serial port in order to communicate with the embedded system.
		This can be a standard RS-232 port built, which is often built into older computers, but also emulated serial ports via USB exist.
		There are many solutions available for serial port emulation.
		<a href="http://www.ftdichip.com/Products/Cables/USBTTLSerial.htm" target="_blank">FTDI</a> offer many products and also supply the core conversion IC so it can be placed into your own design.

		<h2>Modes of operation</h2>
		

	</body>
</html>

