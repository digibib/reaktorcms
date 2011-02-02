<?php
/**
 * One of the important ways of achieving a dynamic site, includes having lists like these
 * which are continously updated. This component template list a reaktors most popular 
 * approved artworks. They can be displayed both in text and image format. To include this 
 * component, see the example below:
 * 
 *  include_component('artwork','listReaktorsPopularArtworks', array(
 *   'image'      =>   'thumb',
 *   'limit'      =>   1, 
 *   'subreaktor' =>   $subreaktor, 
 *   'lokalreaktor' => $lokalreaktor))
 * 
 * None of these parameters are needed. The default limit is retrived from configuration, 
 * if $image isn't passed then text is used. $subreaktor and lokal reaktor are only needed if they should display something
 * from a different reaktor than the site belongs to. For instance, on the frontpage of groruddalenreaktor, you might want to show
 * a list of the most popular reaktors in foto:
 * 
 * include_component('artwork', 'listReaktorsPopularArtworks', array('subreaktor' => 'foto')
 * 
 * The information passed from the controller are the following:
 * - $artworks : An array of artwork objects
 * 
 */

/** 
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * 
 */
use_helper('home');

include_partial ('artwork/listPresentation', array('artworks'         => $artworks,
                                                   'image'            => $image,
                                                   'tags'             => $text_or_artwork,
                                                   'lokalreaktor'     => ((isset($lokalreaktor) ? $lokalreaktor : '')),
                                                   'subreaktor'       => ((isset($subreaktor) ? $subreaktor : '')),
                                                   'feed_description' => $feed_description,
                                                   'feed_slug'        => $feed_slug,
                                                   'show_username'    => isset($show_username) ? $show_username : false,
                                                   ));
?>
