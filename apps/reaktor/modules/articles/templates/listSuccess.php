<div id="article_calendar_container">
  <?php include_component('articles', 'articleCalendar', array('year' => $year, 'month' => $month, 'article_type' => $article_type, 'article_id' => $article->getId(), 'edit' => 1, 'status' => isset($status) ? $status : 'all')); ?>
</div>

