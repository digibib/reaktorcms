<?php echo isset($message) ? $message : '' ?>
<?php if (isset($token)): ?>
<script type="text/javascript">
$('<?php echo 'current_rating_'.$token ?>').style.width = '<?php echo (string)($star_width * floor($rating)) ?>px';
$('<?php echo 'current-rating-1' ?>').style.width = '<?php echo (string)($star_width * floor($rating) + 20) ?>px';
$('<?php echo 'current-rating-2' ?>').style.width = '<?php echo (string)($star_width * floor($rating) + 20) ?>px';
<?php $rest = $rating - floor($rating); ?>
<?php if ($rest <= 0.33):?>
$('<?php echo 'current-rating-1' ?>').style.display = 'none';
$('<?php echo 'current-rating-2' ?>').style.display = 'none';
<?php endif; ?>
<?php if ($rest > 0.33 && $rest <= 0.66):?>
$('<?php echo 'current-rating-1' ?>').style.display = 'block';
$('<?php echo 'current-rating-2' ?>').style.display = 'none';	
<?php endif; ?>
<?php if ($rest > 0.66):?>
$('<?php echo 'current-rating-1' ?>').style.display = 'none';
$('<?php echo 'current-rating-2' ?>').style.display = 'block';
<?php endif; ?>
</script>
<?php endif; ?>