<?php
/**
 * In Reaktor some objects like f.ex artwork can be commented/discussed. This template provides a list, and a 
 * possibility to add comments to that list.
 * 
 * Example of usage:
 * include_partial('artwork/displayComments', array('object' => $artwork->getBaseObject(), 'namespace' => 'frontend')
 * 
 * Parameters passed:
 * $object    - The object to attach comments to
 * $namespace - Which namespace the comments belong to (administrator|frontend)
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
 ?>

<div id="commentlist">
  <?php include_component('sfComment', 'commentList', array(
    'object'    => $object, 
    'namespace' => $namespace, 
    'adminlist' => $adminlist))?>  
  <?php if ($sf_user->hasCredential('postnewcomments')): ?>
    <a name="_newcomment"></a>
    <div id="comment_new">
    <?php include_component('sfComment', 'commentForm', array(
      'object'    => $object, 
      'namespace' => $namespace,
      'adminlist' => $adminlist)) ?>
    </div>
  <?php endif; ?>
</div>