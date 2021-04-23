<?php

define("HCL_RELEASE_VERSION", $argv[1]);

define("HCL_TRUNK_FULL_PATH",                                         "/opt/svn/hcl/trunk");

define("HCL_TRUNK_ART_FULL_PATH",                                     HCL_TRUNK_FULL_PATH . "/art"); 
define("HCL_TRUNK_DOC_FULL_PATH",                                     HCL_TRUNK_FULL_PATH . "/doc"); 
define("HCL_TRUNK_RELEASE_FULL_PATH",                                 HCL_TRUNK_FULL_PATH . "/release"); 

define("HCL_TRUNK_SRC_FULL_PATH",                                     HCL_TRUNK_FULL_PATH . "/src");
define("HCL_TRUNK_SRC_BASH_FULL_PATH",                                HCL_TRUNK_SRC_FULL_PATH . "/bash"); 
define("HCL_TRUNK_SRC_BEANSHELL_FULL_PATH",                           HCL_TRUNK_SRC_FULL_PATH . "/beanshell"); 

define("HCL_TRUNK_SRC_COMMON_FULL_PATH",                              HCL_TRUNK_SRC_FULL_PATH . "/common"); 
define("HCL_TRUNK_SRC_COMMON_CONTRIB_FULL_PATH",                      HCL_TRUNK_SRC_COMMON_FULL_PATH . "/contrib"); 
define("HCL_TRUNK_SRC_COMMON_DATA_FULL_PATH",                         HCL_TRUNK_SRC_COMMON_FULL_PATH . "/data"); 
define("HCL_TRUNK_SRC_COMMON_DATA_NON_DEFINES_FULL_PATH",             HCL_TRUNK_SRC_COMMON_DATA_FULL_PATH . "/non-defines");
define("HCL_TRUNK_SRC_COMMON_DATA_DEFINES_FULL_PATH",                 HCL_TRUNK_SRC_COMMON_DATA_FULL_PATH . "/defines"); 

 
define("HCL_TRUNK_SRC_JAVASCRIPT_FULL_PATH",                          HCL_TRUNK_SRC_FULL_PATH .               "/javascript"); 
define("HCL_TRUNK_SRC_JAVASCRIPT_CONTRIB_FULL_PATH",                  HCL_TRUNK_SRC_JAVASCRIPT_FULL_PATH .    "/contrib"); 
define("HCL_TRUNK_SRC_JAVASCRIPT_DOCUMENTATION_FULL_PATH",            HCL_TRUNK_SRC_JAVASCRIPT_FULL_PATH .    "/documentation"); 

define("HCL_TRUNK_SRC_JAVASCRIPT_JS_FULL_PATH",                       HCL_TRUNK_SRC_JAVASCRIPT_FULL_PATH .    "/js");

define("HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_FULL_PATH",                   HCL_TRUNK_SRC_JAVASCRIPT_FULL_PATH .         "/output");
define("HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_CONTRIB_FULL_PATH",           HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_FULL_PATH .  "/contrib"); 
define("HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_DATA_FULL_PATH",              HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_FULL_PATH .  "/data");  
define("HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_DOCUMENTATION_FULL_PATH",     HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_FULL_PATH .  "/doc");
define("HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_FINAL_FULL_PATH",             HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_FULL_PATH .  "/final");  

function process_javascript_src_files()
{
 
     $js_core_src                  = file_get_contents(HCL_TRUNK_SRC_JAVASCRIPT_JS_FULL_PATH . "/hcl.core.js");     
     $js_classes_src               = file_get_contents(HCL_TRUNK_SRC_JAVASCRIPT_JS_FULL_PATH . "/hcl.classes.js");
     $js_dependent_src             = file_get_contents(HCL_TRUNK_SRC_JAVASCRIPT_JS_FULL_PATH . "/hcl.dependent.js");
     $js_debug_src                 = file_get_contents(HCL_TRUNK_SRC_JAVASCRIPT_JS_FULL_PATH . "/hcl.debug.js");

     $js_core_doc                  = str_replace("|VERSION|", HCL_RELEASE_VERSION, $js_core_src);     
     
     file_put_contents(HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_FINAL_FULL_PATH . "/hcl.core.js",       $js_core_src);
     file_put_contents(HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_FINAL_FULL_PATH . "/hcl.classes.js",    $js_classes_src);
     file_put_contents(HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_FINAL_FULL_PATH . "/hcl.dependent.js",  $js_dependent_src);
     file_put_contents(HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_FINAL_FULL_PATH . "/hcl.debug.js",      $js_debug_src);     
     

     foreach(glob(HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_FINAL_FULL_PATH . "/*.js") as $file_full_path)
     {
          $gzipped_size = array();
          $return_value = 0;
          exec("gzip $file_full_path --stdout |  wc -c", $gzipped_size, $return_value);
          
          if($return_value == 0)
          {
               $gzipped_size = $gzipped_size[0];
          }
          
          file_put_contents(str_replace(".js", ".md5", $file_full_path), md5_file($file_full_path));
     }

     
     file_put_contents(HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_DOCUMENTATION_FULL_PATH . "/hcl.core.doc.js",  $js_core_doc);
     file_put_contents(HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_DOCUMENTATION_FULL_PATH . "/hcl.classes.doc.js",  $js_classes_doc);
     file_put_contents(HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_DOCUMENTATION_FULL_PATH . "/hcl.dependent.doc.js",  $js_dependent_doc);
     file_put_contents(HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_DOCUMENTATION_FULL_PATH . "/hcl.debug.doc.js",  $js_debug_doc);
          
     //file_put_contents(HCL_TRUNK_SRC_JAVASCRIPT_OUTPUT_DOCUMENTATION_FULL_PATH . "/js_doxygen.doc.js",  $js_doxygen_src);

}

function generate_file_feature_fields()
{
     print_r($table);
     
}


function process_javascript_data_files()
{
          
}


function process_javascript_contrib_files()
{

}

function process_javascript_min_files()
{
$hcl_core_composure_command = <<<EOT
     closure-compiler \
                         --emit_use_strict=false \
                         --compilation_level=WHITESPACE_ONLY \
                         --language_out ECMASCRIPT_2015 \
                         --rewrite_polyfills=false \
                         --js "/opt/svn/hcl/trunk/src/javascript/output/doc/hcl.core.doc.js" \
                         --js_output_file "/opt/svn/hcl/trunk/src/javascript/output/final/hcl.core.min.js"
EOT;

echo $hcl_core_composure_command . PHP_EOL;

exec($hcl_core_composure_command);

}

function process_javascript_min_gzip_files()
{

}

function process_php_data_files()
{

}

function process_php_unit_data_files()
{

}

generate_file_feature_fields();
process_javascript_src_files();
process_javascript_min_files();

?>

