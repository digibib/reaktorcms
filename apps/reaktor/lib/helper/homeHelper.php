<?php
/**
 * Home page helper
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wiknene <olepw@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

  /**
   * Show score using images. 
   * Make sure we cannot display more then the maximum score set in the config
   * files. Note that changing the max score could break the styling.  
   *
   * @param integer $score 
   * @return string html for displaying imagescores
   */
  function showScore($score)
  {
    $buf   = "";
    $max_score = sfConfig::get('app_artwork_max_score', 6);
    
    $score = $score > $max_score ? $max_score : $score;
    

    // Whole numbers (0-9)
    $full = $score % 10;

    if ($full > 0)
    {
      $buf = str_repeat(mkscore("propellhel.gif"), $full);
    }
    // Max score, no need to continue
    if ($full == $max_score)
    {
      return $buf;
    }

    // OK. Now we have done the full images, time to figure out how many 1/3rds 
    // we have
    $left = $score - $full;
    
    if ($left > 0.84)
    {
      $buf .= mkscore("propellhel.gif");
    }
    elseif ($left > 0.5)
    {
      $buf .= mkscore("propell2.gif");
    }
    elseif ($left > 0.16)
    {
      $buf .= mkscore("propell1.gif");
    }

    // Append empty images if needed
    if ($score < $max_score)
    {
      $buf .= str_repeat(mkscore("propellgraa.gif"), $max_score-ceil($score));
    }
    
    return $buf;
  }

  /**
   * Little helper to print score images
   * 
   * @param mixed $img 
   * @return string
   */
  function mkscore($img)
  {
    return '<div class="image_single_score">' . image_tag($img) . '</div>';
  }

  
  /**
   * Show score using images.This function pads with gray images
   *
   * @param integer $score 
   * @return string html for displaying imagescores
   */
/*  function showScorePadded($score)
  {
    $buf       = "";
    $max_score = sfConfig::get('app_artwork_max_score', 6);
    $score     = $score>$max_score ? $max_score : $score;
    $buf      .= '<ul class="star-rating" style="width: 120px;"><li id="current_rating" class="current-rating" style="width: '.($score*20).'px;"></li>';
    $buf      .= '</ul>';
    return $buf;
  }
  */
  
  function showScorePadded($score)
  {
    $buf   = "";
    $max_score = sfConfig::get('app_artwork_max_score', 6);
    
    $score = $score > $max_score ? $max_score : $score;
    
    $buf .= '<ul class="star-rating-non-interactive">';
    for ($i = $score ; $i > 0 ; $i--)
    {
      $buf .= '<li class="current-rating">';
      switch (true)
      {
      	case ($i > 0.84):
      		$buf .= image_tag('reaktor_full_blue.gif');
      		break; 
        case ($i > 0.5):
          $buf .= image_tag('reaktor_bottom_grey.gif');
          break; 
        case ($i > 0.16):
          $buf .= image_tag('reaktor_bottom_right_grey.gif');
          break; 
        default:
          $buf .= image_tag('reaktor_grey.gif');
      }
      $max_score--;
      //$buf .= $i==0.5?image_tag("propellhalv.gif", array()):image_tag("propellhel.gif", array());
      $buf .= '</li>';    
    }
    while ($max_score > 0)
    {
      $buf .= '<li class="current-rating">';
      $buf .= image_tag('reaktor_grey.gif');
      $buf .= '</li>';
      $max_score--;    
    }
    
    $buf .= '</ul>';
    
    return $buf;
  	
  }
?>
