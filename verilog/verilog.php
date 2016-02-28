<html>
	<head>
      <title>bio</title> 
      <?php
         if(isset($_GET['file'])){  
            echo '<style type="text/css">
               body {
	               margin:30px;
                  background-color:#221a0f;
                  color:#d6baad;
               } 
               .hljs-comment,
               .hljs-quote {
                   color: #d6baad;
               }
               .hljs-variable,
                  .hljs-template-variable,
                  .hljs-tag,
                  .hljs-name,
                  .hljs-selector-id,
                  .hljs-selector-class,
                  .hljs-regexp,
                  .hljs-meta {
                      color: #dc3958;
               }
               .hljs-number,
                  .hljs-built_in,
                  .hljs-builtin-name,
                  .hljs-literal,
                  .hljs-type,
                  .hljs-params,
                  .hljs-deletion,
                  .hljs-link {
                      color: #f79a32;
               }
               .hljs-title,
                  .hljs-section,
                  .hljs-attribute {
                      color: #f06431;
               }
               .hljs-string,
                  .hljs-symbol,
                  .hljs-bullet,
                  .hljs-addition {
                      color: #889b4a;
               }
               .hljs-keyword,
                  .hljs-selector-tag,
                  .hljs-function {
                      color: #98676a;
               }
               .hljs {
                   display: block;
                    overflow-x: auto;
                    background: #221a0f;
                     color: #d3af86;
                     padding: 0.5em;
               }
               .hljs-emphasis {
                   font-style: italic;
               }
               .hljs-strong {
                   font-weight: bold;
               } 
            </style>';
            $loc = 'https://raw.githubusercontent.com/ashleyjr/Verilog/master/'.$_GET['file']; 
            $file =  file_get_contents($loc);
            echo "<pre><code class='verilog'>".$file."</code></pre>";
         }else{
            echo '
               <style type="text/css">
                  body {
	                  font-family: monospace;
	                  margin:30px;
                     background-color:#221a0f;
                     color:#d6baad;
                  }
			         a:link 
         	      {
                     COLOR: #d6baad;
                  }
			         a:visited 
         	      {
         	         COLOR: #d6baad;
         	      }
         	      a:hover 
         	      {
         	         COLOR: #d6baad;
         	      }
         	      a:active 
         	      {
         	         COLOR: #d6baad;
         	      }
                  img{
                     width: auto; /* you can use % */
                     height: 250px;
                  }
               </style>
                  ';
            echo "<h2>Verilog Repo</h2>";
            $list = file_get_contents('https://raw.githubusercontent.com/ashleyjr/Verilog/master/list.txt');
            echo "<ul>";
            foreach(preg_split("/((\r?\n)|(\r\n?))/", $list) as $line){
               if (strpos($line, '.v') !== false) {
                  echo "<li><a href='verilog.php?file=".$line."'>".$line."</a><br>";
               } 
            }
            echo "</ul>";
         } 
      ?> 
   </head>
   <body>
      <script src="highlight.pack.js"></script>
      <script>hljs.initHighlightingOnLoad();</script>
   </body>

</html>
