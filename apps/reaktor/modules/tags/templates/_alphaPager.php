<?php
/**
 * Alphabetical pager for tag lists
 * 
 * This partial when included in a template provides a convenient list of links based on an array of letters.
 * Required parameters are detailed below:
 * - $letters  : The array of letters (typically A to Å for example) which should be included in the menu
 * - $thisPage : The current page letter (will print directly without a link)
 * 
 * The partial will check the request parameters to see if we are looking just at unapproved tags and adjust the
 * links accordingly.              
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
  $first = true;
  foreach($letters as $letter)
  {
// Make sure taht the tag has name
  if ($letter == '')
   continue;

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
      if ($sf_params->get("unapproved"))
      {
        echo link_to($letter, '@taglist_unapproved?page='.$letter);
      }
      else
      {
        echo link_to($letter, '@taglist?page='.$letter);
      }
    }
  }
  if ($sf_params->get("page") == "ALL")
  {
    echo " | ".__("ALL");
  }
  elseif (!$sf_params->get("unapproved"))
  {
    echo " | ".link_to(__("ALL"), "@taglist?page=ALL");
  }
  else
  {
    echo " | ".link_to(__("ALL"), "@taglist_unapproved?page=ALL");
  }
  ?>
</div>