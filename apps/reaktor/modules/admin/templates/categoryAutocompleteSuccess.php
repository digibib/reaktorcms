<ul>
<?php if ( $categories ): ?>
  <?php foreach ( $categories as $category ):?>
    <li><?php echo $category->getBasename() ?></li>
  <?php endforeach; ?>
<?php endif; ?>
</ul>