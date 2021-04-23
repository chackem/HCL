<?php

     function generate_files_tables()
     {
          $file = fopen('/home/chackem/Desktop/files.contents.tables.csv', 'r');
          while (($line = fgetcsv($file)) !== FALSE)
          {
               echo "<tr>" . PHP_EOL;
               echo      "<th width='10%'>Filename</th>" . PHP_EOL;
               echo      "<th width='5%'>Core</th>" . PHP_EOL;
               echo      "<th width='5%'>Classes</th>" . PHP_EOL;
               echo      "<th width='5%'>Dependent</th>" . PHP_EOL;
               echo      "<th width='5%'>Data</th>" . PHP_EOL;
               echo      "<th width='5%'>Contrib</th>" . PHP_EOL;
               echo      "<th width='5%'>Gzipped Size</th>" . PHP_EOL;
               echo      "<th width='10'>MD5 sum</th>" . PHP_EOL;
               echo "</tr>" . PHP_EOL;

          }
          fclose($file);
     }

generate_files_tables();


?>