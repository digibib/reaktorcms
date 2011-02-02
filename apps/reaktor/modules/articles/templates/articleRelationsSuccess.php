<?php 
/**
 * The reaktor site's main functionality is uploading artworks, but also providing useful articles for
 * the regular users and staff. These articles can sometimes cover the same topic, and this template 
 * provide a way of relating articles to each other and displays a list of articles that have been 
 * related to each other
 * 
 * This is really just a component, but we need to validate the form, which is why this dummy template
 * is needed. 
 * 
 * The controller passes the following information:
 * 
 * $article - An article object
 */
?>

<?php  include_component('articles', 'articleRelations', array('article' => $article)) ?>