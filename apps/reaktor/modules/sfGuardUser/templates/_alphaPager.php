<?php
/**
 * Alphabetical pager for displaying tags
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

$first = true;
?>

<div id="alphapager">
<?php

  $letters = range('A', 'Z');
  
  foreach($letters as $letter)
  {
    if($first != true)
    {
      echo ' | ';
    }
    $first = false;
    if($letter == $thisPage)
    {
      echo $letter;
    }
    else
    {
      echo reaktor_link_to($letter, '@userlist?startingwith='.$letter);
    }
  }

?>
</div>
