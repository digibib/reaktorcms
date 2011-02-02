<?php
/**
 * In order for any user of the Reaktor site to be able to easily browse interesting artworks, preferrably with active content, 
 * dynamic lists are provided. This template displays a list of links to artworks which last received comments. It's actually
 * a container, it calles another template with the correct paramters to print the list. To use this template:
 * 
 * include_component("artwork","latestCommented");
 * 
 * It isn't mandatory, but the following parameters can be passed when including the component:
 * $lokalreaktor: Limit the list to only use comments given to articles in this lokalreaktor 
 * $subreaktor  : Limit the list to only use comments given to articles in this subreaktor
 * 
 * The controller passes the following information:
 * $latest_commented : An array of comments
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

include_partial ('artwork/listPresentation', array('artworks'         => $latestCommented,
                                                   'lokalreaktor'     => ((isset($lokalreaktor) ? $lokalreaktor : '')),
                                                   'subreaktor'       => ((isset($subreaktor) ? $subreaktor : '')),
                                                   'feed_description' => __('latest commented'),
                                                   'feed_slug'        => 'latest_commented'));

?>