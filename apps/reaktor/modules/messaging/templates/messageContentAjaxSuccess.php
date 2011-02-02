<?php use_helper('Javascript') ?>  
<?php foreach ($messages as $message): ?>
    <?php if ($message->getIsRead()) continue; ?>
    <?php include_partial('messaging/messageContent', array('message' => $message, 'maxlen' => sfConfig::get("app_message_max_length", 500))); ?>
  <?php endforeach ?>