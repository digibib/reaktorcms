<?php
/**
 * Helpers for accessing hidden content
 * 
 * Content (images, video clips etc) are stored outside the web root
 * This function returns the correct path to use for a particular file
 * in the database, based on the id of the file.
 *
 * PHP Version 5
 *
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 *
 */

/**
 * Get the correct link to stored content, based on the file ID
 *
 * @param int|artworkFile $item     The file ID or object of the file/artwork (required)
 * @param string          $type     "thumb" or "original" (default is "normal")
 * @param boolean         $relative Whether to return a relative URL or not
 * 
 * @return string the generated path to file (e.g. /content/1/myimage.jpg)
 */
function contentPath($item, $type = "normal", $relative = false, $randomize = false)
{
  if (is_numeric($item))
  {
    try
    {
      $selectedFile = new artworkFile($item);
    }
    catch (Exception $e)
    {
        return "";
    }  
  }
  elseif ($item instanceof genericArtwork)
  {
    $selectedFile = $item->getFirstFile();
  }
  else
  {
    $selectedFile = $item;
  }
  
  if ($selectedFile instanceof artworkFile)
  {
    $filename = $selectedFile->getFilename();
    $file_id  = $selectedFile->getId();  
  }
  else
  {
    return "";
  }
  $ext='';
  $routing_rule = '@content_server';
  sfLoader::loadHelpers('string');
  switch ($type)
  {
    case "thumb":
      $routing_rule = '@content_thumb';
      $filename=getThumbNameFromFile($filename);
      break;
    case "original":
      $routing_rule = '@content_original';
      break;
    case "mini":
      $filename=getThumbNameFromFile($filename);
      $routing_rule = '@content_mini';
      break;
    case "":
    case "normal":
      // routing rule already set for this case
      break;
    default:
      return "";
      break;
  }

  if ($relative)
  {
    return "$routing_rule?id=$file_id&filename=$filename";
  }
  else
  {
    $retval = url_for("$routing_rule?id=$file_id&filename=$filename");
    if ($randomize)
    {
      $retval .= "?id" . rand();
    }
    return $retval;
  }
}

/**
 * Show mini thumbnail with mouseover tooltip
 *
 * @param genericArtwork $object      The Artwork object
 * @param boolean        $nomouseover True to hide mouseover
 */
function showMiniThumb($object, $nomouseover = false, $nolink = false, $relative = true)
{
  if (!$object instanceof genericArtwork )
  {
     return "";
  }
  
  sfLoader::loadHelpers(array('Partial'));
  
  return get_partial("contentServer/showMini", array("artwork" => $object, "nomouseover" => $nomouseover, "nolink" => $nolink, "relative" => $relative));
}

/**
 * This function calculates how long time it is since a given time
 *
 * @param time 	Time
 */
function timeToAgo($time)
{
	$timestamp = strtotime($time);
	$now = time();
	$diff = $now - $timestamp;
	if ($diff > 31536000)
	{
		return ((int) ($diff / 31536000)) . " " . __('year(s) ago');
	}
	if ($diff > 84600)
	{
		return ((int) ($diff / 84600)) ." " . __('day(s) ago');
	}
	if ($diff > 3600)
	{
		return ((int) ($diff / 3600)) . " " . __('hour(s) ago');
	}
	if ($diff > 60)
	{
		return ((int) ($diff / 60)) . " " . __('minute(s) ago');
	} else
	{
		return $diff . " " . __('second(s) ago');
	}
}

/**
 * Return the collection type for a specified artwork
 * Placed here to make translation easier, since I don't want to create another i18n table...
 * Can also return the type as text if second param is false - partly written here so the translation helpers
 * will find them and add them to the translation batch too.
 *
 * @param genericArtwork|string $artwork         The artwork object we are querying or the type if known
 * @param boolean               $collectionValue Whether to return collection name, or false if you want the content type
 * @param boolean               $upper           Whether to uppercase the first letter of the response
 * 
 * @return string the translated collection type
 */
function collectionType($artwork, $collectionValue = true, $upper = false)
{
  if (is_object($artwork))
  {
    $type = $artwork->getArtworkType(); 
  }
  else
  {
    $type = $artwork;
  }
  
  switch($type)
  {
    case "image": //image
      $result = array (__("gallery"), __("image"));
      break;
    case "audio": //audio
      $result = array (__("playlist"), __("audio"));
      break;
    case "text": //text
      $result = array (__("collection"), __("text"));
      break;
    case "video": //video
      $result = array (__("playlist"), __("video"));
      break;
    case "pdf": //pdf
      $result = array (__("collection"), __("pdf"));
      break;
    case "flash_animation": //Flash animation
      $result = array(__("collection"), __("flash animation"));
      break;
    default:
      return "";
      break;
  }
  if ($collectionValue)
  {
    return $upper ? ucfirst($result[0]) : $result[0];
  }
  else
  {
    return $upper ? ucfirst($result[1]) : $result[1];
  }
}
