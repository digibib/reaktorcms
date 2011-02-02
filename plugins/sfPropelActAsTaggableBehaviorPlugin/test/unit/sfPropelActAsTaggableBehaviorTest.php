<?php
// test variables definition
define('TEST_CLASS', 'Post');
define('TEST_CLASS_2', 'Link');

// initializes testing framework
$sf_root_dir = realpath(dirname(__FILE__).'/../../../../');
$apps_dir = glob($sf_root_dir.'/apps/*', GLOB_ONLYDIR);
$app = substr($apps_dir[0],
              strrpos($apps_dir[0], DIRECTORY_SEPARATOR) + 1,
              strlen($apps_dir[0]));
if (!$app)
{
  throw new Exception('No app has been detected in this project');
}

require_once($sf_root_dir.'/test/bootstrap/functional.php');
require_once($sf_symfony_lib_dir.'/vendor/lime/lime.php');

if (!defined('TEST_CLASS') || !class_exists(TEST_CLASS)
    || !defined('TEST_CLASS_2') || !class_exists(TEST_CLASS_2))
{
  // Don't run tests
  return;
}

// initialize database manager
$databaseManager = new sfDatabaseManager();
$databaseManager->initialize();
$con = Propel::getConnection();

// clean the database
TagPeer::doDeleteAll();
TaggingPeer::doDeleteAll();
call_user_func(array(_create_object()->getPeer(), 'doDeleteAll'));

// create a new test browser
$browser = new sfTestBrowser();
$browser->initialize();

// start tests
$t = new lime_test(36, new lime_output_color());


// these tests check for the tags attachement consistency
$t->diag('tagging consistency');

$object = _create_object();
$t->ok($object->getTags() == array(), 'a new object has no tag.');

$object->addTag('toto');
$object_tags = $object->getTags();
$t->ok((count($object_tags) == 1) && ($object_tags['toto'] == 'toto'), 'a non-saved object can get tagged.');

$object->addTag('toto');
$object_tags = $object->getTags();
$t->ok(count($object_tags) == 1, 'a tag is only applied once to non-saved objects.');
$object->save();

$object->addTag('toto');
$object_tags = $object->getTags();
$t->ok(count($object_tags) == 1, 'a tag is also only applied once to saved objects.');
$object->save();

$object->addTag('tutu');
$object_tags = $object->getTags();
$t->ok($object->hasTag('tutu'), 'a saved object can get tagged.');
$object->save();

// get the key of this object
$id1 = $object->getPrimaryKey();

$object->removeTag('tutu');
$t->ok(!$object->hasTag('tutu'), 'a previously saved tag can be removed.');

$object->addTag('tata');
$object->removeTag('tata');
$t->ok(!$object->hasTag('tata'), 'a non-saved tag can also be removed.');

$object2 = _create_object();
$object_tags = $object2->getTags();
$t->ok(count($object_tags) == 0, 'a new object has no tag, even if other tagged objects exist.');
$object2->save();

$object2->addTag('titi');
$t->ok($object2->hasTag('titi'), 'a new object can get tagged, even if other tagged objects exist.');
$t->ok(!$object->hasTag('titi'), 'tags applied to new objects do not affect old ones.');
$object2->save();
$id2 = $object2->getPrimaryKey();

$object2_copy = call_user_func(array(_create_object()->getPeer(), 'retrieveByPk'), $id2);
$object2_copy->addTag('clever');
$t->ok($object2_copy->hasTag('clever') && !$object2->hasTag('clever'), 'tags are applied to the object instances independently.');

$object = _create_object();
$object->addTag('tutu');
$object->addTag('titi');
$object->save();
$object->addTag('tata');
$object->removeAllTags();
$t->ok(!$object->hasTag(), 'tags can all be removed at once.');

$object = _create_object();
$object->addTag('toto,tutu,tata');
$object->save();
$id = $object->getPrimaryKey();
$object = call_user_func(array(_create_object()->getPeer(), 'retrieveByPk'), $id);
$object->removeTag('tata');
$object->addTag('tata');
$object->save();
$object = call_user_func(array(_create_object()->getPeer(), 'retrieveByPk'), $id);
$object_tags = $object->getTags();
$t->ok(count($object_tags) == 3, 'when removing one previously saved tags, then restoring it, and then saving it again, tags are not duplicated.');

$object = _create_object();
$object->addTag('toto,tutu,tata');
$object->save();
$object->removeAllTags();
$object->addTag('toto,tutu,tata');
$object->save();
$id = $object->getPrimaryKey();
$object = call_user_func(array(_create_object()->getPeer(), 'retrieveByPk'), $id);
$object_tags = $object->getTags();
$t->ok(count($object_tags) == 3, 'when removing all previously saved tags, then restoring it, and then saving it again, tags are not duplicated.');

$object = _create_object();
$object->addTag('toto,tutu,tata');
$object->save();
$previous_count = count($object->getTags());
$object->removeAllTags();
$object->save();
$id = $object->getPrimaryKey();
$object = call_user_func(array(_create_object()->getPeer(), 'retrieveByPk'), $id);
$t->ok(($previous_count == 3) && !$object->hasTag(), 'previously in-database tags can be deleted.');

$object = _create_object();
$object->addTag('toto, tutu, test');
$object->save();
$id = $object->getPrimaryKey();
$object = call_user_func(array(_create_object()->getPeer(), 'retrieveByPk'), $id);

$object2 = _create_object();
$object2->addTag('clever age, symfony, test');
$object2->save();
$object2->removeTag('test');
$object2->save();

$object_tags = $object->getTags();
$object2_tags = $object2->getTags();
$t->ok((count($object2_tags) == 2) && (count($object_tags) == 3), 'removing one tag as no effect on the other tags of the object, neither on the other objects.');

$object2_tags = $object2->getTags(array('serialized' => true));
$t->ok($object2_tags == 'clever age, symfony', 'tags can be retrieved in a serialized form.');

unset($object, $object2, $object2_copy);


// these tests check the various methods for applying tags to an object
$t->diag('various methods for applying tags');
$object = _create_object();
$object->addTag('toto');
$object_tags = $object->getTags();
$t->ok((count($object_tags) == 1) && ($object_tags['toto'] == 'toto'), 'one tag can be added alone.');

$object->addTag('titi,tutu');
$object_tags = $object->getTags();
$t->ok((count($object_tags) == 3) && $object->hasTag('tutu') && $object->hasTag('titi'), 'tags can be added with a comma-separated string.');
$t->ok($object->hasTag('titi, tutu'), 'comma-separated strings are divided into several tags.');

$object = _create_object();
$object->addTag(array('titi', 'tutu'));
$object_tags = $object->getTags();
$t->ok((count($object_tags) == 2) && $object->hasTag('tutu') && $object->hasTag('titi'), 'tags can be added with an array.');

unset($object);


// these tests check for TagPeer methods (tag clouds generation)

// clean the database
TagPeer::doDeleteAll();
TaggingPeer::doDeleteAll();
call_user_func(array(_create_object()->getPeer(), 'doDeleteAll'));

$t->diag('tag clouds');
$object1 = _create_object();
$object1->addTag('tag2,tag3,tag1,tag4,tag5,tag6');
$object1->save();

$object2 = _create_object();
$object2->addTag('tag1,tag3,tag4,tag7');
$object2->save();

$object3 = _create_object();
$object3->addTag('tag2,tag3,tag7,tag8');
$object3->save();

$object4 = _create_object();
$object4->addTag('tag3');
$object4->save();

$object5 = _create_object();
$object5->addTag('tag1,tag3,tag7');
$object5->save();

// getAll() test
$tags = TagPeer::getAll();
$result = array();

foreach ($tags as $tag)
{
  $result[] = $tag->getName();
}

$t->ok($result == array('tag2', 'tag3', 'tag1', 'tag4', 'tag5', 'tag6', 'tag7', 'tag8'), 'all tags can be retrieved with getAll().');

// getAllWithCount() test
$tags = TagPeer::getAllWithCount();
$t->ok($tags == array('tag1' => 3, 'tag2' => 2, 'tag3' => 5, 'tag4' => 2, 'tag5' => 1, 'tag6' => 1, 'tag7' => 3, 'tag8' => 1), 'all tags can be retrieved with getAll().');

// getPopulars() test
$c = new Criteria();
$c->setLimit(3);
$tags = TagPeer::getPopulars($c);
$t->ok(array_keys($tags) == array('tag1', 'tag3', 'tag7'), 'most popular tags can be retrieved with getPopulars().');
$t->ok($tags['tag3'] >= $tags['tag1'], 'getPopulars() preserves tag importance.');

// getRelatedTags() test
$tags = TagPeer::getRelatedTags('tag8');
$t->ok(array_keys($tags) == array('tag2', 'tag3', 'tag7'), 'related tags can be retrieved with getRelatedTags().');

$c = new Criteria();
$tags = TagPeer::getRelatedTags('tag2', array('limit' => 1));
$t->ok(array_keys($tags) == array('tag3'), 'when a limit is set, only most popular related tags are returned by getRelatedTags().');

// getRelatedTags() test
$tags = TagPeer::getRelatedTags('tag7');
$t->ok(array_keys($tags) == array('tag1', 'tag2', 'tag3', 'tag4', 'tag8'), 'getRelatedTags() aggregates tags from different objects.');

// getRelatedTags() test
$tags = TagPeer::getRelatedTags(array('tag2', 'tag7'));
$t->ok(array_keys($tags) == array('tag3', 'tag8'), 'getRelatedTags() can retrieve tags related to an array of tags.');

// getRelatedTags() test
$tags = TagPeer::getRelatedTags('tag2,tag7');
$t->ok(array_keys($tags) == array('tag3', 'tag8'), 'getRelatedTags() also accepts a coma-separated string.');

// getTaggedWith() tests
$object_2_1 = _create_object_2();
$object_2_1->addTag('tag1,tag3,tag7');
$object_2_1->save();

$object_2_2 = _create_object_2();
$object_2_2->addTag('tag2,tag7');
$object_2_2->save();

$tagged_with_tag4 = TagPeer::getTaggedWith('tag4');
$t->ok(count($tagged_with_tag4) == 2, 'getTaggedWith() returns objects tagged with one specific tag.');

$tagged_with_tag7 = TagPeer::getTaggedWith('tag7');
$t->ok(count($tagged_with_tag7) == 5, 'getTaggedWith() can return several object types.');

$tagged_with_tag17 = TagPeer::getTaggedWith(array('tag1', 'tag7'));
$t->ok(count($tagged_with_tag17) == 3, 'getTaggedWith() returns objects tagged with several specific tags.');

// these tests check the isTaggable() method
$t->diag('detecting if a model is taggable or not');

$t->ok(sfPropelActAsTaggableToolkit::isTaggable(TEST_CLASS) === true, 'it is possible to tell if a model is taggable from its name.');

$object = _create_object();
$t->ok(sfPropelActAsTaggableToolkit::isTaggable($object) === true, 'it is possible to tell if a model is taggable from one of its instances.');
$t->ok(sfPropelActAsTaggableToolkit::isTaggable('Tristan\'s cat') === false, 'Tristan\'s cat is not taggable, and that is fine.');


TagPeer::doDeleteAll();
TaggingPeer::doDeleteAll();
call_user_func(array(_create_object()->getPeer(), 'doDeleteAll'));


$object = _create_object();
$object->addTag('tutu');
$object->save();

// test object creation
function _create_object()
{
  $classname = TEST_CLASS;

  if (!class_exists($classname))
  {
    throw new Exception(sprintf('Unknow class "%s"', $classname));
  }

  return new $classname();
}

// second type of test object creation
function _create_object_2()
{
  $classname = TEST_CLASS_2;

  if (!class_exists($classname))
  {
    throw new Exception(sprintf('Unknow class "%s"', $classname));
  }

  return new $classname();
}
