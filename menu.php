<html dir="rtl">
	<div dir="ltr">
	</div>
	<head>
      <title>menu</title>
      <style type="text/css">
         body {
	            font-family:Times New Roman;
            	font-size:13pt;
            	margin:10px;
               background-color:#FFD9A3;
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
      <h2>Menu</h2>
		 <ul>
            <li><a href="home.php" target="content">Home</a>
            <li><a href="bio/bio.php" target="content">Bio</a>
			<li><a href="calender.php" target="content">Calender</a>
			<li><a href="AshleyRobinsonCV.pdf" target="_blank">CV</a> 
         </ul>

      <h4>Projects</h4>
         <ul>
			<li><a href="AudioSpectrumAnalyser" target="_blank">ASA</a>
			<li><a href="DebugSerial" target="_blank">DebugSerial</a>

         </ul>

      <h4>Education</h4>
         <ul>
            <li><a href="education/courses.php" target="content">Courses</a>
            <li><a href="education/projects.php" target="content">Projects</a>
            <li><a href="education/ukesf.php" target="content">Scholarship</a>
         </ul>

      <h4>Work Experience</h4>
         <ul>
            <li><a href="work_experience/csr.php" target="content">CSR</a>
            <li><a href="work_experience/sainsburys.php" target="content">Sainsbury's</a>
            <li><a href="work_experience/mjrobinson.php" target="content">M.J.Robinson</a>
         </ul>

      <h4>Other Interests</h4>
		 <ul>
			<li><a href="other_interests/vehicles.php" target="content">Cars and Bikes</a>
            <li><a href="other_interests/films.php" target="content">Films</a>
            <li><a href="other_interests/music.php" target="content">Music</a>
            <li><a href="other_interests/outdoors.php" target="content">Outdoors</a>
         </ul>

	  <h4>Site info</h4>    
		
         <ul>
			<li><a href="site_info/login.php" target="content">Login</a>
			<?php
               // Defaults
               $start = 0;
               $length = 100;
               echo "<li><a href=site_info/visitors.php?start=".$start."&length=".$length." target=content>Visitors</a>";//List item and variable link
            ?>   
			<li><a href="site_info/updates.php" target="content">Updates</a>
		</ul>   
 	</body>
</html>
