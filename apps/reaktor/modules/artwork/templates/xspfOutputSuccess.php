<?php use_helper('content') ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<?php $image = $sf_request->getHost() . '/' . sfConfig::get('app_image_path') . '/'; ?>
<?php if (count($artwork->getCategories()) > 1): ?> 
  <?php $image .= 'samlealbum'; ?>
<?php else: ?>
  <?php $awtmp = $artwork->getCategories(); ?>
  <?php $image .= array_shift($awtmp); ?>
<?php endif; ?>
<?php $image .= '.jpg'; ?>
<?php
  $title = $artwork->getTitle();
  $search = array('æ', 'Æ', 'ø', 'Ø', 'å', 'Å');
  $replace = array('ae', 'AE', 'oe', 'OE', 'aa', 'AA');
  $title = str_replace($search, $replace, $title);
/*$title = str_replace('Æ', 'AE', $title);
  $title = str_replace('ø', 'oe', $title);
  $title = str_replace('Ø', 'OE', $title);
  $title = str_replace('å', 'aa', $title);
  $title = str_replace('Å', 'AA', $title);*/

  ?>
<playlist version="1" xmlns="http://xspf.org/ns/0/">
    <title><?php echo $title ?></title>
    <image>http://<?php echo $image; ?></image>
    <creator><?php echo $artwork->getUser()->getName(); ?></creator>
    <location><?php echo  $sf_request->getHost() .url_for($artwork->getLink('xml').'&format=xspf'); ?></location>
    <date><?php echo date("Y-m-d\TH:i:sO") ?></date>
    <trackList>
<?php foreach ($artwork->getFiles() as $aFile): ?>
        <track>
              <?php $trackTitle = $aFile->getMetadata('title');
                    $trackCreator = $aFile->getMetadata('creator');
                    $search = array('æ', 'Æ', 'ø', 'Ø', 'å', 'Å');
                    $replace = array('ae', 'AE', 'oe', 'OE', 'aa', 'AA');
                    $trackTitle = str_replace($search, $replace, $trackTitle);
                    $trackCreator = str_replace($search, $replace, $trackCreator);
                    ?>
            
            <title><?php echo $trackTitle; ?></title>
            <?php if ($aFile->getThumbPath()): ?>
            <image>http://<?php echo $sf_request->getHost() . contentPath($aFile, "thumb"); ?></image>
            <?php else: ?>
            <image>http://<?php echo $image; ?></image>
            <?php endif; ?>
            <location>http://<?php echo $sf_request->getHost() . contentPath($aFile); ?></location>
            <annotation><?php echo $aFile->getMetadata('description', 'abstract') ?></annotation>
            <creator><?php echo $trackCreator ?></creator>
        </track>
<?php endforeach; ?>
    </trackList>
</playlist>
