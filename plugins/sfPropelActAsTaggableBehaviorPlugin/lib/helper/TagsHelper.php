<?php
/*
 * This file is part of the sfPropelActAsTaggableBehavior package.
 * 
 * (c) 2007 Xavier Lacot <xavier@lacot.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

function tag_cloud($tags, $route, $options = array(), $title = '')
{
	$result = '';
  if ($title != '')
  {
    $result .= '<div class="tag_cloud_header"><h2>' . $title . '</h2></div>';
  }

  if(count($tags) > 0)
  {
    $emphasizers_begin = array(-2 => '<small><small>', 
                               -1 => '<small>', 
                                0 => '', 
                                1 => '<big>', 
                                2 => '<big><big>');
    $emphasizers_end = array(-2 => '</small></small>', 
                             -1 => '</small>', 
                              0 => '', 
                              1 => '</big>', 
                              2 => '</big></big>');

    $class = isset($options['class']) ? $options['class'] : 'tag-cloud';
    $result .= '<ul class="'.$class.'">';

    foreach ($tags as $name => $count)
    {
      $link = reaktor_link_to($name,
                      $route.$name, 
                      array('rel' => 'tag'));

      $result .= '
                  <li>'.$emphasizers_begin[$count].$link.$emphasizers_end[$count].'</li>';
    }

    $result .= '</ul>';
  }

  return $result;
}

function tag_list($tags, $route, $options = array())
{
  $result = '';

  if (count($tags) > 0)
  {
    $class = isset($options['class']) ? $options['class'] : 'tags-list';
    $result = '<ul class="'.$class.'">';

    foreach ($tags as $tag)
    {
      $link = link_to($tag,
                      $route.$tag, 
                      array('rel' => 'tag'));

      $result .= '
                  <li>'.$link.'</li>';
    }

    $result .= '</ul>';
  }

  return $result;
}

function related_tag_cloud($tags, $route, $tag, $options = array())
{
  $result = '';

  if(count($tags) > 0)
  {
    if (is_array($tag))
    {
      $tag = implode(',', $tag);
    }

    $emphasizers_begin = array(-2 => '<small><small>', 
                               -1 => '<small>', 
                                0 => '', 
                                1 => '<big>', 
                                2 => '<big><big>');
    $emphasizers_end = array(-2 => '</small></small>', 
                             -1 => '</small>', 
                              0 => '', 
                              1 => '</big>', 
                              2 => '</big></big>');

    $add = isset($options['add']) ? $options['add'] : '(+)';
    $class = isset($options['class']) ? $options['class'] : 'tag-cloud';
    $result = '<ul class="'.$class.'">';

    foreach ($tags as $name => $count)
    {
      $link = link_to($name,
                      $route.$name, 
                      array('rel' => 'tag'));
      $related_link = link_to($add,
                              $route.$tag.','.$name);

      $result .= '
                  <li>'.$emphasizers_begin[$count]
                  .$link.'&nbsp;'
                  .$related_link.$emphasizers_end[$count]
                  .'</li>';
    }

    $result .= '</ul>';
  }

  return $result;
}