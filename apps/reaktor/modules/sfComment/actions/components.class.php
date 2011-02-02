<?php
require_once SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'plugins/sfPropelActAsCommentableBehaviorPlugin/modules/sfComment/lib/BasesfCommentComponents.class.php';
/**
 * sfPropelActAsCommentableBehaviorPlugin components. Feel free to override this
 * class in your dedicated app module.
 * 
 * @package    plugins
 * @subpackage comment 
 * @author     Xavier Lacot <xavier@lacot.org>
 * @link       http://trac.symfony-project.com/trac/wiki/sfPropelActAsCommentableBehaviorPlugin
 */
class sfCommentComponents extends BasesfCommentComponents
{ 


  public function executeCommentForm()
  {
    sfContext::getInstance()->getResponse()->addStylesheet('sf_comment');
    $this->getConfig();

    if ($this->object instanceof sfOutputEscaperObjectDecorator)
    {
      $object = $this->object->getRawValue();
    }
    else
    {
      $object = $this->object;
    }

    $this->object_model = get_class($object);
    $this->object_id = $object->getPrimaryKey();
    $this->token = sfPropelActAsCommentableToolkit::addTokenToSession($this->object_model, $this->object_id);
    
    if ($this->getUser()->isAuthenticated() && $this->config_user['enabled'])
    {
      $this->action      = 'authenticatedComment';
      $this->config_used = $this->config_user;
    }
    else
    {
      $this->action      = 'anonymousComment';
      $this->config_used = $this->config_anonymous;
    }
  }
  
  public function executeCommentList()
  {

    $object = $this->object;
    $order = $this->order;
    $namespace = $this->namespace;
    $limit = $this->limit;

    if (!$order)
    {
      $order = 'asc';
    }

    if (!$namespace)
    {
      $namespace = null;
    }

    if (!$limit)
    {
      $criteria = null;
    }
    else
    {
      $criteria = new Criteria();
      $criteria->setLimit($limit);
    }

    $comments = sfCommentPeer::getComments($object, array('order' => $order, 'namespace' => $namespace), $criteria);
    //sort comments threaded
    $this->comments = array();

    CommentMagick::sortRecursive($comments,$this->comments);
    
    
  }
  
  /**
   * The latest commented artworks by a user. The comments object
   * is a join between comments and artworks.
   *
   * @return void
   */
  public function executeLatestCommentedArtworksByUser()
  {
    $this->comments = sfComment::getLatestCommented($this->user_id);
  }
  
  /**
   * List the latest comments made to user or reaktor 
   *
   * 
   */
  public function executeCommentTitleList()  
  {
    if($this->mode == 'written')
    {    
      $this->comments = sfComment::getLatestWrittenComments($this->user_id);
    }
    elseif($this->mode =='reaktor')
    {      
      $this->comments = sfComment::getReaktorsLatestComments($this->subreaktor, 5, $this->lokalreaktor);
    }
    else
    {
      $this->comments = sfComment::getLatestReceivedComments($this->user_id);
    } 
       
  }

}
