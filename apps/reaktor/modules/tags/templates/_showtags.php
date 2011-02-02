<?php
/**
 * Basic tag cloud, used on home page
 * 
 * No parameters required, this partial will automatically generate a list of all tags used by the site with correct
 * filtering based on subreaktors.
 * 
 * You can pass the option 'cloud_type' to this partial to make it display a nice tag cloud instead
 * of the one with numbers in it:
 * 
 * $cloud_type: 'pretty' (no counts) or 'fugly' (with counts)
 * 
 * The size of the tag cloud can be controlled by altering the following values in app.yml
 * ~ home / max_tag_length : This is the total number of characters that the tag cloud can consume
 * ~ home / max_tags       : This is the number of tags that should be shown (up to the limit set in max_tag_length)
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wiknene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('cloud');

  //$cloud_type = (isset($cloud_type)) ? $cloud_type : sfConfig::get('app_tagging_cloud_type');
  
  /*switch ($cloud_type)
  {
  	case 'pretty':*/
	  	echo tag_cloud(TagPeer::getPopulars(null, array('notmodel' => 'Article')), '@findtags?tag=', 
	  	               array('class' => 'tag-cloud-right'),
	  	               __('Popular tags'));
		/*  break;
  	default:
		  echo tag_cloud_with_count(TagPeer::getPopularTagsWithCount(sfConfig::get("app_home_max_tags", 20), 
		                                                             sfConfig::get("app_home_max_tag_length", 500)
                                ), '@findtags?tag=', 
		                            array('class' => 'tag-cloud-right'), 
		                            __('Popular tags'));
		  break;
  }*/

?>