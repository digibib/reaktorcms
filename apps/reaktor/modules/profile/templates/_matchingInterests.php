<?php
/**
 * User's can browse other user's content by viewing user's with the same interests on themselves.
 * This component template prints the 5 last registered users with the same interests as a given user. 
 * Example of use:
 * 
 * include_component('profile', 'matchingInterests', array(
 *   'user_id'  => $user->getId(),
 *   'username' => $user->getUsername(),
 *   'all'      => false,
 * ))
 * 
 * $user_id : Integer Match interest with this user 
 * $username: String Name of the same user
 * $all     : Boolean If false use config to decide length of list
 * 
 * The controller passes the following information:
 * $users - array of sfGuardUser objects 
 *  
 * PHP version 5
 * 
 * @author    June Henriksen <juneih@linpro.no>
 * @copyright 2008 Linpro AS
 * @license   http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 */
use_helper('Javascript')
?>
<?php include_partial('feed/rssLink', array('description' => __('users with shared interests'), 'slug' => 'shared_interest&username=' . $username, 'route' => 'userfeed')); ?>
<div <?php if($all) echo "class='overflow'"?> id='matcing_interests_user_list' >
  <?php if(count($users)>0):?>
  
    <ul>
    <?php foreach ($users as $user):?>
      <li>
        <?php echo link_to($user->getUserName(), '@portfolio?user='.$user->getUserName()) ?>
      </li>
    <?php endforeach ?>
    
    <?php if((!$all)&&(count($users)>= sfConfig::get('app_home_list_length', 5))): ?>
      <li>
        <?php echo link_to_remote(__('All users'), array(
          'url'    => '@allusersmatchinginterests?user_id='.$user_id.'&all=1',      
          'class'  => 'differ',          
          'update' => 'matcing_interests_user_list' 
        ))  ?>
      </li>   
    <?php endif ?>
    </ul>
    
  <?php else: ?>
    <?php echo __('There are no users with matching interests. You can register your interests in your profile page.');?>
  <?php endif ?>
  
</div>
