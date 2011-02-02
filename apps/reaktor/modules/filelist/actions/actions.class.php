<?php

/**
 * filelist actions.
 *
 * @package    reaktor
 * @subpackage filelist
 * @author     Hannes Magnusson <bjori@linpro.no>
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class filelistActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->forward('default', 'module');
  }

  public function executeBrowseFiles()
  {
    $article = ArticlePeer::retrieveByPK($this->getRequestParameter("article_id"));
    $this->forward404Unless($article);

    $tfiles = ArticleFilePeer::getAll();
    $files = array();
    foreach($tfiles as $file)
    {
      $fn = $file->getFilename();
      if (!$fn)
      {
        continue;
      }

      $files[$file->getId()] = $file;
    }
    $this->files = $files;
    $this->article = $article;
  }

}

