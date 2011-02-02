<?php 
/**
 * In Reaktor some objects like f.ex artwork can be commented/discussed. This template lists either all comments 
 * within a namespace for an objecttype, or it displays the comments within a namespace for a particular object. 
 * 
 * To use it:
 * include_component('sfComment', 'commentList', array('object' => $object, 'namespace' => $namespace)
 * 
 * The following parameters can be passed when using the component:
 * $object        - Usually artwork or file
 * $namespace     - In Reaktor the two namespaces used are 'frontend' for user comments and 'administration' for discussion
 * $limit         - How many comments should be displayed in the list
 * $order         - Order comments by date (desc/asc)
 * $unsuitable    - Include only comments with the unsuitable flag set to this 
 * $adminlist     - Is this an adminlist or not
 * $comment_pager - Which page, if using a pager
 * $overview      - Boolean, if list is an overview, and not possible to add comments to
 * 
 * This template can be used in an administration list as a partial:
 * include_partial('sfComment/commentList', array(
 *   'comments'      => $comments,
 *   'adminlist'     => true, 
 *   'unsuitable'    => 2, 
 *   "comment_pager" => $comment_pager))
 * 
 * The $comment_pager helps make the the list paginated.
 * 
 * The controller passes the following information:
 * $comments - An array of sfComment objects
 * 
 *
 * PHP version 5
 *
 * @author    juneih <juneih@linpro.no>
 * @copyright 2008 Linpro
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */

use_helper('Javascript', 'array', 'comment', 'button'); 
?>

<?php 
if(!isset($adminlist)): 
  $adminlist = false; 
endif;
if(!isset($unsuitable)): 
  $unsuitable = 0; 
endif;
if (!isset($divId)) 
{
  $divId = 0;
}
$isAuthenticated = $sf_user->isAuthenticated();
$count = 0;


?>

<div class="sf_comment_list">
  <?php if (isset($comment_pager)): //How many comments are there? ?>
    <h4 id="comment_header_total" class='comment_header_total' ><?php echo __('Total %number_of_comments% comments', array('%number_of_comments%' => $comment_pager->getNbResults())) ?></h4>
    <div class='comment_shift_left'>   
  <?php elseif (!isset($recursive)): ?>
    <?php if (isset($object)): ?>
      <h4 class='comment_header_total'>
        <?php echo __('Comments (%number_of_comments%)', array('%number_of_comments%' =>$object->getCommentCount($namespace))) ?>
        <?php if (!$isAuthenticated): ?>
          &nbsp; - &nbsp;
          <?php echo __("You must login to comment on this artwork"); ?>
        <?php endif; ?>
      </h4>
    <?php endif ?>
    <div class='comment_shift_left'>   
  <?php endif; ?>

<?php $threaded = isset($recursive) ? $recursive : false; ?>
<?php $zeroOrOne = $threaded ? zeroOrOne() : 0;?>
<ul class='comment_line comment<?php echo $zeroOrOne ?><?php if ($threaded): echo " goodleftpad"; endif; ?>'>
  <?php if (count($comments) > 0): //Display comments?>
    
    <?php foreach ($comments['children'] as $comment): ?>
      <?php ++$count; ?>
      <li class="comment<?php if(!$threaded) $zeroOrOne = zeroOrOne(); echo $zeroOrOne ?>">
      
        <?php include_partial('sfComment/commentView', array('comment' => $comment, 'adminlist'=> $adminlist, 'unsuitable'=>$unsuitable)) ?>
            
        <?php if (isset($object)): ?>

          <div class="comment<?php echo $zeroOrOne ?>">
          <?php if (($comment['Unsuitable']!= 2) ||($sf_user->hasCredential('commentadmin'))): ?>
            <div class='comment_buttons'>          
              <?php if(!$sf_user->hasCredential('postnewcomments') && $sf_user->isAuthenticated()): ?>
                <?php echo __("You don't have permission to comment"); ?>
              <?php endif; ?>
              <?php include_partial('sfComment/commentButtons',array('comment' => $comment, 'namespace' => $namespace)); ?>
            <?php if ($isAuthenticated && $sf_user->hasCredential("commentadmin")): ?>
              <?php include_partial("sfComment/adminButtons", array("comment" => $comment, "comment_pager" => (isset($comment_pager) ? $comment_pager : null))); ?>
            <?php endif; ?>
            </div>        
          <?php endif ?>
            <div id="comments_<?php echo $comment['Id']?>" style="display:none;">
              <?php include_component('sfComment', 'commentForm', array('object' => $object, 'namespace' => $namespace, 'parentId' => $comment['Id'])) ?>
            </div>
   
             
          </div>

        <?php elseif($isAuthenticated && $sf_user->hasCredential("commentadmin")): ?>
        <br /> 
        <?php include_partial("sfComment/adminButtons", array("comment" => $comment, "comment_pager" => (isset($comment_pager) ? $comment_pager : null))); ?>
       <?php endif; ?>
			
        <?php if (isset($comment['children'])): ?>
          <?php if(isset($object)): ?>  
          <?php include_partial('sfComment/commentList', array(
              'comments' => $comment, 
              'recursive' => 1, 
              'adminlist' => $adminlist,
              'unsuitable'=>$unsuitable, 
              'namespace'=>$namespace,
              'object' => $object,)) ?>
          <?php else: ?>   
          <?php include_partial('sfComment/commentList', array(
          		'comments' => $comment, 
              'recursive' => 1,
              'adminlist' => $adminlist,
              'unsuitable'=>$unsuitable)) ?>
          <?php endif ?>
        <?php endif ?>
      
      </li>
    
    <?php endforeach ?>
    
  <?php elseif(isset($overview)&&$overview):?>
    <li><p><?php echo __('No comments in list.') ?></p></li>
  <?php elseif($adminlist): //There are no comments?>
    <li><p><?php echo __('Start this discussion by adding a comment.') ?></p></li>
  <?php else: ?>
    <?php //include_component('sfComment', 'commentForm', array('object' => $object, 'namespace' => $namespace)) ?>
    <li><p><?php echo __('Be the first to comment on this artwork.') ?></p></li>
  <?php endif ?>
  </ul>
  
  <?php if (!isset($recursive) || isset($comment_pager)): ?>
    </div>
  <?php endif ?>
  
</div>
