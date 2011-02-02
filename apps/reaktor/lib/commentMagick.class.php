<?php

class CommentMagick {

  public static function sortRecursive($comments, &$sorted, $parentId = 0, $justParents = false)
  {
    foreach ($comments as  $comment)
    {
      if ($parentId == -1 || $comment['ParentId'] == $parentId || $justParents)
      {
        $sorted['children'][] = $comment;
        if (!$justParents)
        {
          self::sortRecursive($comments, $sorted['children'][count($sorted['children']) -1], $comment['Id']);
        }
      }
    }
  }
}

?>
