<html>
   <head>
      <title>menu</title>
      <style type="text/css">
         body {
	            font-family:Times New Roman;
            	font-size:13pt;
            	margin:10px;
               background-color:#000000;
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
      </style>
   </head>

   <body>
      <h2>Menu</h2>
         <ul>
            <li><a href="home.php" target="content">Home</a>
            <li><a href="bio.php" target="content">Bio</a>
            <li><a href="calender.php" target="content">Calender</a>
         </ul>

      <h4>Electronics</h4>
         <ul>
            <li><a href="electronics/projects.php" target="content">Projects</a>
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
            <li><a href="work_experience/sainsburys.php" target="content">Sainsburys</a>
            <li><a href="work_experience/mjrobinson.php" target="content">M.J.Robinson</a>
         </ul>

      <h4>Other Interests</h4>
         <ul>
            <li><a href="other_interests/films.php" target="content">Films</a>
            <li><a href="other_interests/music.php" target="content">Music</a>
            <li><a href="other_interests/outdoors.php" target="content">Outdoors</a>
         </ul>

      <h4>Site info</h4>     
         <ul>
               <?php
               // Defaults
               $start = 0;
               $length = 100;
               echo "<li><a href=site_info/visitors.php?start=".$start."&length=".$length." target=content>Visitors</a>";//List item and variable link
            ?>   
         </ul> 
   </body>
</html>
