<?php
/**
 * Component for showing intelligent tags that are related in some way to a tagged object
 * - $tags : The tags with which to base the relations (for example a set of tags from an artwork)
 * 
 * The above variable is used by the component action to generate related tags and display a tag cloud.
 *  
 * PHP version 5
 * 
 * @author    Daniel Andre Eikeland <dae@linpro.no>
 * @author    Russ Flynn <russ@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */


use_helper('cloud');

echo tag_cloud($cloud_tags, '@findtags?tag=', array('class' => 'tag-cloud-right'), __('Related tags'));
?>