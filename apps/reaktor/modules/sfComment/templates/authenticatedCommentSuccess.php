<?php include_component('sfComment', 'commentList', array('object' => $object, 'namespace' => $namespace)) ?>
<a name="_newcomment"></a>
<div id="comment_new" style="display: none">
<?php include_component('sfComment', 'commentForm', array('object' => $object, 'namespace' => $namespace)); ?>
</div>