<?php
/**
 * fake_button
 * 
 * @param mixed $text        The "button" text
 * @param mixed $link        See link_to() $link
 * @param array $options     Passed through remote_function()
 * @return string
 */
function fake_button($text, $link = "#", $options = array(),$enabled = true)
{
  if ($enabled)
  {
  	$class = "fakebutton";
  }
  else
  {
  	$class = "fakebutton_disabled";
  }
  if (is_string($link))
  {
    echo '<div class="'.$class.'">', fake_link_to($text, $link, $options,$enabled), '</div>';
  }
  elseif (is_array($link))
  {
    return fake_button_function($text, remote_function($link) . '; return false;', $options, "#", $class,$enabled);
  }
}

/**
 * fake_button_function 
 * 
 * @param string $text          The "button" text
 * @param string $function      Raw JavaScript code
 * @param array  $options       See link_to() $options
 * @param string $id            The ID/name to scroll down to
 * @return string
 */
function fake_button_function($text, $function, $options = array(), $id = "#", $class = "fakebutton",$enabled=true)
{
	$options["onclick"] = $function;
  echo '<div class="'.$class.'">', fake_link_to($text, $id, $options,$enabled), '</div>';
}

function fake_link_to($text, $link = "#", $options = array(),$enabled=true)
{
    if (!$enabled)
      return $text;
	if ($link[0] != "#")
  {
    return link_to($text, $link, $options);
  }

  $attributes = array();
  if (!isset($options["href"]))
  {
    $options["href"] = $link;
  }
  foreach($options as $key => $value)
  {
    $attributes[] = $key. '="' .$value. '"';
  }
  return "<a " . join(" ", $attributes) . ">$text</a>";
  
}

