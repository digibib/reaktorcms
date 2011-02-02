<?php
/**
 * This template is used to change the order and filter images on a user's portfoliopage. The controller
 * passes the following information:
 * 
 * $userid : The id of the user who owns the portfolio page
 * $orderby: What to order/filter by (title, date, rating or format)
 * $user   : sfGuardUser object, (used to set title of page)
 *
 * PHP version 5
 *
 * @author    Russell Flynn <russ@linpro.no>
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */ 

reaktor::setReaktorTitle(__('Latest artwork from %username%', array("%username%" => $user))); 

?>

<?php include_component('artwork','lastArtworksFromUser',array(
       'id' => $userid,
       'portfolio' => true,
       'user' => $user,
       'orderBy' => $orderBy,
)) ?>
