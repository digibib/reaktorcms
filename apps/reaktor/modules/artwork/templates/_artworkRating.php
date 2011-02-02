<?php

/**
 * Rating partial
 * Do not add html newlines (echo everything) as this breaks the tooltip when used in mouseover
 *
 *
 * This partial takes the following arguments:
 *   - $artwork *required* - The artwork to retrieve rating info about
 *   - $login   [optional] - Print the login note, if user is not logged in
 *   - $noedit  [optional] - Do not make it rateable
 *
 * $sf_user is automatically populated by Symfony
 *  
 * PHP version 5
 * 
 * @author    Ole-Petter Wikene <olepw@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
 
?>
<?php

$login = isset($login) ? $login : true;
$noedit = isset($noedit) ? $noedit : true;

use_helper('home', 'sfRating');

echo '<h4 style="float: left;">'.__("Rating:").'</h4>';

if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->getId() != $artwork->getUserId() && $noedit && $sf_user->hasCredential('rateartwork')):
  echo sf_rater($artwork->getBaseObject());
else:
  echo showScorePadded($artwork->getAverageRating());
endif;

