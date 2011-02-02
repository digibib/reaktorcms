<?php
$active = array_shift($active);
?>

<h2><?php echo __('Most active users last month') ?></h2>
<table border="0">
<tr>
<?php foreach ($active as $a): ?> 
<td style="padding-right:15px;">
<?php echo link_to($a['username'],'@portfolio?user='.$a['username'],array()); ?>
</td>
</tr>
<?php endforeach; ?>
</table>
