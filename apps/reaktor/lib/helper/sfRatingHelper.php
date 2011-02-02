<?php
/*
 * This file is part of the sfPropelActAsRatableBehaviorPlugin
 * 
 * @author Nicolas Perriault <nperriault@gmail.com>
 */
sfLoader::loadHelpers(array('Javascript', 'Tag', 'I18N'));

$response = sfContext::getInstance()->getResponse();

$css = 'sf_rating';
$response->addStylesheet($css, '', array("media" => "all"));

$js = 'prototype';
$response->addJavascript($js);

/**
 * Return the HTML code for a unordered list showing rating stars
 * 
 * @param  BaseObject  $object  Propel object instance
 * @param  array       $options        Array of HTML options to apply on the HTML list
 * @throws sfPropelActAsRatableException
 * @return string
 **/
function sf_rater($object, $options = array())
{
  if (is_null($object))
  {
    sfLogger::getInstance()->debug('A NULL object cannot be rated');
  }
  
  if (!isset($options['star-width']))
  {
    $star_width = sfConfig::get('app_rating_star_width', 25);  
  }
  else
  {
    $star_width = $options['star-width'];
    unset($options['star-width']);
  }
  
  try
  {
    $max_rating = $object->getMaxRating();
    $actual_rating = $object->getRating();
    $bar_width = floor($actual_rating) * $star_width;
    $rest = ($actual_rating - floor($actual_rating));
    
    $options = _parse_attributes($options);
    if (!isset($options['class']))
    {
      $options = array_merge($options, array('class' => 'star-rating'));
    }
    if (!isset($options['style']) or !preg_match('/width:/i', $options['style']))
    {
      $full_bar_width = $max_rating * $star_width;
      $options = array_merge($options, 
                             array('style' => 'width:'.$full_bar_width.'px'));
    }
    
    if ($object instanceof sfOutputEscaperObjectDecorator)
    {
      $object_class = get_class($object->getRawValue());
    }
    else
    {
      $object_class = get_class($object);
    }
    $object_id = $object->getReferenceKey();
    $token = sfPropelActAsRatableBehaviorToolkit::addTokenToSession($object_class, $object_id);
    
    $msg_domid = sprintf('rating_message_%s', $token) ;
    $bar_domid = sprintf('current_rating_%s', $token) ;
    
    if( $rest > 0.84 ) //Rest is enough to fill three reaktor blades = a whole reaktor blade
    {
      $bar_width += (1 * $star_width); 
      $list_content  = '  <li class="current-rating" id="'.$bar_domid.'" style="width:'.$bar_width.'px;">';
    }
    else //Rest eqals 0, 1 or 2 reaktor blades
    {
      $list_content  = '  <li class="current-rating" id="'.$bar_domid.'" style="width:'.$bar_width.'px;">';
      if ( $rest > 0.16 && $rest <= 0.5 ) //Rest equals one blade
      {
      	$list_content .= '  <li class="current-rating-1" id="current-rating-1" style="width:'.($bar_width+20).'px; display: block;"></li>';
      	$list_content .= '  <li class="current-rating-2" id="current-rating-2" style="width:'.($bar_width+20).'px; display: none;"></li>';
      }
      else if ( $rest > 0.5 && $rest <= 0.84) //Rest equals two blades
      {
      	$list_content .= '  <li class="current-rating-1" id="current-rating-1" style="width:'.($bar_width+20).'px; display: none;"></li>';
      	$list_content .= '  <li class="current-rating-2" id="current-rating-2" style="width:'.($bar_width+20).'px; display: block;"></li>';
      }
    }

    $list_content .= '  <li class="current-rating-2" id="current-rating-1" style="width:'.($bar_width+20).'px; display: none;">';
    $list_content .= __('Currently rated %rating% star(s) on %max_rating%', array('%rating%' => $object->getRating(), '%max_rating%' => $max_rating));
    $list_content .= '  </li>';
    
    for ($i=1; $i <= $max_rating; $i++)
    {
      $label = __('Rate it %number_of_stars% stars', array('%number_of_stars%' => $i));
      $list_content .= 
        '  <li>'.link_to_remote($label, 
          array('url'      => sprintf('sfRating/rate?token=%s&rating=%d&star_width=%d', 
                                      $token, 
                                      $i,
                                      $star_width),
                'update'   => $msg_domid,
                'script'   => true,
                'complete' => visual_effect('appear', $msg_domid).
                              visual_effect('highlight', $msg_domid)), 
          array('class'    => 'r'.$i.'stars',
                'title'    => $label)).'</li>';
    }
    
    return content_tag('ul', $list_content, $options).
           content_tag('div', __('Click the symbols to vote'), array('id' => $msg_domid, 'class' => 'clearboth'));
  }
  catch (Exception $e)
  {
    sfLogger::getInstance()->err('Exception catched from sf_rater helper: '.$e->getMessage());
  }
}
