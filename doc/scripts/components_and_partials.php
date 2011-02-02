<?php
/**
 * Script to extract all comments from templates. The comments are written to html-files, 
 * one for each of the following: partials, components and the rest of the templates.
 * The html-files are included in the documention file ReaktorSystemDoc.odt . 
 */

/**  
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */ 

//CONSTANTS
define('REAKTOR_ROOT', '/opt/reaktor');
define('REAKTOR_APPLICATION_ROOT', REAKTOR_ROOT.'/apps/reaktor');
define('MODULE_ROOT', '/apps/reaktor/modules');
define('DOC_ROOT', REAKTOR_ROOT.'/doc');
define('MODULE_ROOT_PATH', REAKTOR_ROOT.MODULE_ROOT);
define('TEMPLATE_ROOT', '/templates');

/**
 * Extract from the comment block of a file.
 *
 * @param string $file Name of file to extract comments from
 * 
 */
function getCommentBlock($file, $format)
{ 
  try
  {
    $fh = fopen($file, 'r');
  } 
  catch(Exception $e)
  {
    return '';
  }
  if($fh)
  {
    $comment_start = 0;
    $comment_block = '';    
  
    while (true)
    {
      $line = fgets($fh);
      if ($line == null)break; 
      
      if(!$comment_start) //Check for comment start tag, and flip comment_start to true if found 
      { 
        preg_match('|(/\*)+|', $line, $php_comment);
        
        $comment_start = $php_comment ? true : false;
        
      }
      else //Comment start was found extract comment
      {
        //look for comment end tag 
        preg_match('|(\*/)+|', $line, $php_end);
        
        preg_match('/PHP Version 5/i', $line, $comment_end);
        if($php_end||$comment_end)
        {
          break;
        }
        else //php end tag not found check what the line actually contains
        {
          $php_comment    = trim(substr($line, strpos($line, '*')+1));        
          $comment_block .= $php_comment;
          
          //Don't add empty lines
          if(!empty($php_comment))
          {
            $comment_block .= $format == 'html'? '<br />' : '\n';
          }
          
        }
      }   
    }
    //Close the template
    fclose($fh);
  }
  return trim($comment_block);    
}

/**
 * Get comments from components
 *
 * @return void
 */
function getComponentComments($format = 'html')
{
  //Get all components 
  exec("grep -nir 'function execute' /opt/reaktor/apps/reaktor |grep -v svn|grep -i components", $path_to_component);
  
  $components = array();
  if($format == 'html')
  {
    echo '<h2>Components</h2>';
  }
  
  foreach($path_to_component as $key => $value)
  {
    //get name of module component is in
    preg_match('|modules/([^/]*)/|', $value, $module_path);
    preg_match('@^(?:modules/)?([^/]+)@i', $module_path[0], $module);
  
    //get component template
    preg_match('@(execute)+([^(]*)@', $value, $function_name);
    
    //get name of component template 
    $function_name_stripped    = $function_name[2];
    $function_name_stripped[0] = strtolower($function_name_stripped[0]);
    $template                  = '_'.$function_name_stripped.'.php';
    
    //Open template
    $template_file             = MODULE_ROOT_PATH.'/'.$module[1].TEMPLATE_ROOT.'/'.$template;
    
    $comment = getCommentBlock($template_file, $format);
    //Save non empty commentblocks
    if(!empty($comment))
    {
      $components[$module[1]][$template]= $comment; 
      
      //Print to file if requested
      if($format == 'html')
      {
          echo '<h3>'.$module[1].': '.$template.':</h3><br />';       
          echo $components[$module[1]][$template].'<br />';
      }  
    }
  }
  return $components;
}

/**
 * Get comments from components
 *
 * @return void
 */
function getPartialComments($format = 'html')
{
  //First we get all components (we need them to eliminate all component templates ) 
  $components = getComponentComments('nodisplay');  
  echo 'find '.MODULE_ROOT_PATH.' -name _*|grep -v svn';
  exec('find '.MODULE_ROOT_PATH.' -name _*|grep -v svn', $templates);

  //Print header
  if($format == 'html')
  {
    echo '<h2>Partials</h2>';
  }
  
  //Extract template name and the module it's in
  $partials = array();
  foreach ($templates as $key => $value)
  {
    //get module name template is in
    preg_match('|modules/([^/]*)/|', $value, $module_name);  
    preg_match('@^(?:modules/)?([^/]+)@i', $module_name[0], $module);
   
    //get template
    preg_match('/_(.*)$/', $value, $template);
    if(!isset($components[$module[1]][$template[0]]))
    {
      $comment = getCommentBlock($value, $format);
      if(!empty($comment))
      {
        $partials[$module[1]][$template[0]] = $comment;
  
        //Print if requested
        if($format == 'html')
        {
          echo '<h3>'.$module[1].': '.$template[0].':</h3>';       
          echo $partials[$module[1]][$template[0]].'<br />';
        }
      }  
    }    
  }
  
  return $partials;
}

/**
 * Get comments from templates
 *
 * @return void
 */
function getTemplateComments($format = 'html')
{
  exec('find '.REAKTOR_APPLICATION_ROOT.' -name *Success.php|grep -vi .svn', $template_paths);
  
  //Print header
  if($format == 'html')
  {
    echo '<h2>Templates</h2>';
  }
  
  //Extract template name and the module it's in
  $templates = array();
  foreach ($template_paths as $key => $value)
  {
    //get module name template is in
    preg_match('|modules/([^/]*)/|', $value, $module_name);  
    preg_match('@^(?:modules/)?([^/]+)@i', $module_name[0], $module);
   
    //get template
    preg_match('|[^/]*Success.php|', $value, $template_name);   
    
    //'Get comments'
    $comment = getCommentBlock($value, $format);
    if(!empty($comment))
    {
      $templates[$module[1]][$template_name[0]] = $comment;
  
      //Print if requested
      if($format == 'html')
      {
        echo '<h3>'.$module[1].': '.$template_name[0].':</h3>';       
        echo $templates[$module[1]][$template_name[0]].'<br />';
      }  
    }
            
  }
  return $templates;
}

function getLayoutTemplateComments($format = 'html')
{
  exec('find '.REAKTOR_APPLICATION_ROOT.'/templates/_*.php|grep -vi .svn', $template_paths);
  
  //Print header
  if($format == 'html')
  {
    echo '<h2>Layout Templates</h2>';
  }
  
  //Extract template name and the module it's in
  $templates = array();
  foreach ($template_paths as $key => $value)
  {
    //get template name
    preg_match_all('/\/_([^.]*).php/i', $value, $result);
    
    $template_name = $result[1][0];
    //'Get comments'
    $comment = getCommentBlock($value, $format);
    if(!empty($comment))
    {
      $templates[$module[1]][$template_name] = $comment;
  
      //Print if requested
      if($format == 'html')
      {
        echo '<h3> Layout template: '.$template_name.':</h3>';       
        echo $templates[$module[1]][$template_name].'<br />';
      }  
    }      
  }
  return $templates;
  
}

//Get components and write to file
ob_start();
getComponentComments();
$output = ob_get_clean();
//print $output;
file_put_contents(DOC_ROOT.'/components.html', $output);


//Get partials and write to file
ob_start();
getPartialComments();
$output = ob_get_clean();
//echo $output;
file_put_contents(DOC_ROOT.'/partials.html', $output);

//Get templates and write to file
ob_start();
getTemplateComments();
$output = ob_get_clean();
//echo $output;
file_put_contents(DOC_ROOT.'/templates.html', $output);

//Get layout templates and write to file
ob_start();
getLayoutTemplateComments();
$output = ob_get_clean();
//echo $output;
file_put_contents(DOC_ROOT.'/layouttemplates.html', $output);




?>