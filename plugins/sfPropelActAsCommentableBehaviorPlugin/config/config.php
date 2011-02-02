<?php
/*
 * This file is part of the sfPropelActAsCommentableBehavior package.
 * 
 * (c) 2007 Xavier Lacot <xavier@lacot.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
if (in_array('sfComment', sfConfig::get('sf_enabled_modules', array())))
{
  $r = sfRouting::getInstance();
  $r->prependRoute('sf_comment_authenticated', '/sfComment/authenticated_comment', array('module' => 'sfComment', 'action' => 'authenticatedComment'));
  $r->prependRoute('sf_comment_anonymous', '/sfComment/anonymous_comment', array('module' => 'sfComment', 'action' => 'anonymousComment'));
}

sfPropelBehavior::registerMethods('sfPropelActAsCommentableBehavior', array (
  array (
    'sfPropelActAsCommentableBehavior',
    'addComment'
  ),
  array (
    'sfPropelActAsCommentableBehavior',
    'clearComments'
  ),
  array (
    'sfPropelActAsCommentableBehavior',
    'getComments'
  ),
  array (
    'sfPropelActAsCommentableBehavior',
    'getNbComments'
  ),
  array (
    'sfPropelActAsCommentableBehavior',
    'removeComment'
  )
));