<?php
/**
 * One of the important ways of achieving a dynamic site, includes having lists like these
 * which are continously updated. This component template lists a reaktors latest
 * approved artworks. To include this 
 * component, see the example below:
 * 
 *  include_component('artwork','lastArtworks', array(
 *   'image'         => 'mini',
 *   'limit'         => 6, 
 *   'subreaktor'    => $subreaktor, 
 *   'lokalreaktor'  => $lokalreaktor,
 *   'random'        => true,    
 *   'exclude_first' => 1))
 * 
 * None of these parameters are required. The default limit is retrieved from configuration,
 * exclude_first will exclude the n latest artworks from the list (say you've displayed the 
 * latest artwork as a thumbnail on top of the page, and you want a list of smaller thumbnails
 * on a different part of the page, you don't want the latest artwork to be displayed again, so 
 * exclude_first = 1). If $image (thumb|subreaktorthumb|mini) isn't passed then text is 
 * used. $subreaktor and $lokalreaktor are only needed if they should display something 
 * from a different reaktor than the site belongs to. For instance, on the frontpage of 
 * groruddalenreaktor, you might want to show a list of the most popular reaktors in foto:
 * 
 * include_component('artwork', 'lastArtworks', array('subreaktor' => 'foto')
 * 
 * The information passed from the controller are the following:
 * - $last : If not passed from a lokalreaktor: An array of artwork objects
 * - $last : If passed from a lokalreaktor: An array with:
 *                                          'last' => an array of artworks, 
 *                                          'subreaktor' = the subreaktor object for the subreaktor it was passed from
 * 
 * The image type "subreaktorthumb" and "subreaktorlist" can only be called from a lokalreaktor 
 * frontpage. This is used when this list is called more than once on the same page, to make sure 
 * the same image doesn't appear more than once.
 * 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 */


include_partial ('artwork/listPresentation', array('image'            => $image, 
				                                           'artworks'         => $last,
				                                           'tags'             => $tags,
				                                           'lokalreaktor'     => $lokalreaktor,
				                                           'subreaktor'       => $subreaktor,
				                                           'feed_description' => $feed_description,
				                                           'feed_slug'        => $feed_slug,
                                                   'show_username'    => isset($show_username) ? $show_username : false,
                                                   ));
 ?>
