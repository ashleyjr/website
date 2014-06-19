<html>
   <head>
      <title>projects</title>
      <style type="text/css">
         body {
	            font-family:Times New Roman;
	            font-size:13pt;
	            margin:30px;
               background-color:#222222;
               color:#008000;
            }
            a:link 
            {
               COLOR: #008000;
            }
            a:visited 
            {
               COLOR: #008000;
            }
            a:hover 
            {
               COLOR: #008000;
            }
            a:active 
            {
               COLOR: #008000;
            }
            img{
               width: auto; /* you can use % */
               height: 200px;
            }
      </style>
   </head>

   <body>
      <h2>Projects</h2>
      A collection of the more interesting projects from my academic career.
      I made the change to <a href="http://www.latex-project.org/" target="_blank">LaTeX</a> in late 2012. 
      <table 
         border="1"
         style="
         background-color:#222222;
         border:1px  #008000;
         width:50%;
         border-collapse:collapse;"
      >
      <tr>
         <th>Date</th>
         <th>Title</th>
         <th>View</th>
         <th>Associated module</th>
      </tr>
      <tr>
         <td>
            05/2013 
         </td>
         <td style="white-space: nowrap">
            A small scale quadcopter for robotic swarm development 
         </td>
         <td>
            [<a href="#quadcopter" target="content">view</a>] 
         </td>
         <td style="white-space: nowrap">
            COMP3020: Part III project {Dissertation}
         </td>
      </tr>
      <tr>
         <td>
            05/2013 
         </td>
         <td style="white-space: nowrap">
            Arrhythmia: A machine learning exercise 
         </td>
         <td>
            [<a href="#arrhythmia" target="content">view</a>] 
         </td>
         <td style="white-space: nowrap">
            COMP3008: Machine learning
         </td>
      </tr>
      <tr>
         <td>
            01/2013             
         </td>
         <td style="white-space: nowrap">
            CORDIC architecture in system verilog 
         </td>
         <td>
            [<a href="#cordic" target="content">view</a>]          
         </td>
         <td style="white-space: nowrap">
            ELEC3017: Digital system design            
         </td>
      </tr>
      <tr>
         <td>
            12/2012             
         </td>
         <td style="white-space: nowrap">
            Image contour extraction 
         </td>
         <td>
            [<a href="#ice" target="content">view</a>]          
         </td>
         <td style="white-space: nowrap">
            COMP3032: Intelligent algorithms
         </td>
      </tr>
      <tr>
         <td>
            04/2012           
         </td>
         <td style="white-space: nowrap">
            Robot football 
         </td>
         <td>
            [<a href="#robot" target="content">view</a>]          
         </td>
         <td style="white-space: nowrap">
            ELEC2032: Electronic design
         </td>
      </tr>
      <tr>
         <td>
            11/2011             
         </td>
         <td style="white-space: nowrap">
            System verilog design of a sequential multiplier 
         </td>
         <td>
            [<a href="#verilog" target="content">view</a>]          
         </td>
         <td style="white-space: nowrap">
            ELEC2032: Electronic design
         </td>
      </tr>
      <tr>
         <td>
            07/2011             
         </td>
         <td style="white-space: nowrap">
            Analogue design 
         </td>
         <td>
            [<a href="#analogue" target="content">view</a>]          
         </td>
         <td style="white-space: nowrap">
            ELEC2032: Electronic design
         </td>
      </tr>
   </table>





   <a id="quadcopter"></a>
   <h2>A small scale quadcopter for robotic swarm development</h2>
      <img src="../images/copter_bottom.jpg" alt="Bottom" target="_blank"><img src="../images/copter_top.jpg" alt="Bottom" target="_blank">  
      <p>
         My third year project (equivalent of a dissertation). 
         I specified the project details myself while watching awesome quadcopter swarm video of the summer of 2012.
         I began design work in October with a lot of construction starting at the beginning of 2013.
      </p>
      <p>
         Find the report <a href="projects/quadcopter/a_small_scale_quadcopter_platform_for_robotic_swarm_development.pdf" target="_blank">here</a> (80MB) for which I received 74%.
      </p>






   <a id="arrhythmia"></a>
   <h2>Arrhythmia: A machine learning exercise</h2>
      <img src="../images/test.jpg" alt="Test" target="_blank">  
      <p>
         Given a data set of patients (<a href="http://archive.ics.uci.edu/ml/datasets/Arrhythmia" target="_blank">UCI Machine Learning Repository</a>) the task was to use machine learning techniques achieve classification.
         I chose to use k-means clustering a simple approach to the task. 
         I found this very hard but also very interesting. 
      </p>
      <p>
         Find the report <a href="projects/arrhythmia/arrhythmia.pdf" target="_blank">here</a> for which I received 70% and a zip file of code <a href="projects/arrhythmia/code.zip" target="_blank">here</a>. 
      </p>





   <a id="cordic"></a>
   <h2>CORDIC Architecture in System Verilog</h2>
      <img src="../images/cordic_output.jpg" alt="Output" target="_blank">  
      <p>
         CORDIC stands for COordinate Rotation DIgital Computer and this task was to implement the equation below using this architecture.
         Restricted to 16-bit parallel input/output I chose to internal cast the value as 32-bit as to improve the accuracy of any calculations then cast back to a 16-bit output.
         An interesting challenge as I have never used System Verilog for trigonometric function before.
         A part from the maths the system is relatively simple and is pipelined using two separate blocks to compute the entire equation. 
      </p>
      <p>
         Find a zip file of code <a href="projects/cordic/code.zip" target="_blank">here</a> as no report was submitted only an automated testbench was used to mark the design; for which I received 96%. 
      </p>





   <a id="ice"></a>
   <h2>Image contour extraction</h2>
      <img src="../images/tongue.jpg" alt="Tongue" target="_blank"><img src="../images/mountains.jpg" alt="Mountains" target="_blank">  
      <p>
         This was a piece of coursework submitted for an module called 'Intelligent Algorithms'.
         A significant milestone for any of my software work.
         My biggest project in <a href="http://www.mathworks.co.uk/products/matlab/" target="_blank">MATLAB</a> and the first time I had really coded intelligently.
         The task was to extract the contour of a tongue from an x-ray.
         This involved setting a search space grid and computing energy expenditure when moving from one side to the other. 
      </p>
      <p>
         Find the report <a href="projects/image_contour_extraction/ajr_ice.pdf" target="_blank">here</a> for which I recieved 84% and a zip file of code <a href="projects/image_contour_extraction/code.zip" target="_blank">here</a>.
      </p>







   <a id="robot"></a>
   <h2>Robot football</h2>
      <img src="../images/krab.jpg" alt="Finished" target="_blank"><img src="../images/neat.jpg" alt="Finished" target="_blank"><img src="../images/finished.jpg" alt="Finished" target="_blank"> 
      <p>
         This was a great project I took part in with a group of six.
         The task was to build a robot to compete in a game of football with other robots built to the specification by other teams.
         We spent a lot of time in the lab building as everything had to fit on to a base provided.
         On top of the base we placed three layers of tri-pad board to house all the circuitry.
         The football and playing field used different types colours of light as to provide information.
         The end product looked very cool but, like every other team, failed to play a game of football.
         The task was very hard but I learnt a lot about team/project management and electronics construction.
         Unfortunately the report remains lost.
      </p>




   <a id="verilog"></a>
   <h2>System Verilog Design of a Sequential Multiplier</h2>
      <img src="../images/multiplier.jpg" alt="Output" target="_blank"> 
      <p>
         The first time I wrote a design which was synthesised and tested on hardware. 
         Using a MachXO development board (Lattice semiconductor) I constructed a 'shift and add' multiplier.
         This trades off execution time for design size by putting numbers into registers and shifting to give a multiplication of two.
         These are then added to a running total (or not) to give multiplication but any possible number.
         4-bits is rather trivial but still an interesting topic which took me a while to grasp the motivation for the design.
      </p>
      <p>
         Find the report <a href="projects/multiplier/squential_multiplier.pdf" target="_blank">here</a> for which I received 70% and a zip file of code <a href="projects/multiplier/code.zip" target="_blank">here</a>. 
      </p>




   <a id="analogue"></a>
   <h2>Analogue Design</h2>
      <img src="../../images/circuit.jpg" alt="Finished" target="_blank">
      <p>
         This task was to build and test and analogue circuit.
         The brief specified the circuit design but we were asked to choose component values and discuss why these values work.
         Then test circuit which also evaluated our ability to measure and verify circuit functionality.
      </p>
      <p>
         Find the report <a href="projects/analogue/analogue_design.pdf" target="_blank">here</a> for which I received 72%. 
      </p>


   </body>
</html>
