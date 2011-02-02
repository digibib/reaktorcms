<?php


abstract class BasesfCommentPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sf_comment';

	
	const CLASS_DEFAULT = 'plugins.sfPropelActAsCommentableBehaviorPlugin.lib.model.sfComment';

	
	const NUM_COLUMNS = 13;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'sf_comment.ID';

	
	const PARENT_ID = 'sf_comment.PARENT_ID';

	
	const COMMENTABLE_MODEL = 'sf_comment.COMMENTABLE_MODEL';

	
	const COMMENTABLE_ID = 'sf_comment.COMMENTABLE_ID';

	
	const NAMESPACE = 'sf_comment.NAMESPACE';

	
	const TITLE = 'sf_comment.TITLE';

	
	const TEXT = 'sf_comment.TEXT';

	
	const AUTHOR_ID = 'sf_comment.AUTHOR_ID';

	
	const AUTHOR_NAME = 'sf_comment.AUTHOR_NAME';

	
	const AUTHOR_EMAIL = 'sf_comment.AUTHOR_EMAIL';

	
	const CREATED_AT = 'sf_comment.CREATED_AT';

	
	const UNSUITABLE = 'sf_comment.UNSUITABLE';

	
	const EMAIL_NOTIFY = 'sf_comment.EMAIL_NOTIFY';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'ParentId', 'CommentableModel', 'CommentableId', 'Namespace', 'Title', 'Text', 'AuthorId', 'AuthorName', 'AuthorEmail', 'CreatedAt', 'Unsuitable', 'EmailNotify', ),
		BasePeer::TYPE_COLNAME => array (sfCommentPeer::ID, sfCommentPeer::PARENT_ID, sfCommentPeer::COMMENTABLE_MODEL, sfCommentPeer::COMMENTABLE_ID, sfCommentPeer::NAMESPACE, sfCommentPeer::TITLE, sfCommentPeer::TEXT, sfCommentPeer::AUTHOR_ID, sfCommentPeer::AUTHOR_NAME, sfCommentPeer::AUTHOR_EMAIL, sfCommentPeer::CREATED_AT, sfCommentPeer::UNSUITABLE, sfCommentPeer::EMAIL_NOTIFY, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'parent_id', 'commentable_model', 'commentable_id', 'namespace', 'title', 'text', 'author_id', 'author_name', 'author_email', 'created_at', 'unsuitable', 'email_notify', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'ParentId' => 1, 'CommentableModel' => 2, 'CommentableId' => 3, 'Namespace' => 4, 'Title' => 5, 'Text' => 6, 'AuthorId' => 7, 'AuthorName' => 8, 'AuthorEmail' => 9, 'CreatedAt' => 10, 'Unsuitable' => 11, 'EmailNotify' => 12, ),
		BasePeer::TYPE_COLNAME => array (sfCommentPeer::ID => 0, sfCommentPeer::PARENT_ID => 1, sfCommentPeer::COMMENTABLE_MODEL => 2, sfCommentPeer::COMMENTABLE_ID => 3, sfCommentPeer::NAMESPACE => 4, sfCommentPeer::TITLE => 5, sfCommentPeer::TEXT => 6, sfCommentPeer::AUTHOR_ID => 7, sfCommentPeer::AUTHOR_NAME => 8, sfCommentPeer::AUTHOR_EMAIL => 9, sfCommentPeer::CREATED_AT => 10, sfCommentPeer::UNSUITABLE => 11, sfCommentPeer::EMAIL_NOTIFY => 12, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'parent_id' => 1, 'commentable_model' => 2, 'commentable_id' => 3, 'namespace' => 4, 'title' => 5, 'text' => 6, 'author_id' => 7, 'author_name' => 8, 'author_email' => 9, 'created_at' => 10, 'unsuitable' => 11, 'email_notify' => 12, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'plugins/sfPropelActAsCommentableBehaviorPlugin/lib/model/map/sfCommentMapBuilder.php';
		return BasePeer::getMapBuilder('plugins.sfPropelActAsCommentableBehaviorPlugin.lib.model.map.sfCommentMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = sfCommentPeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(sfCommentPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(sfCommentPeer::ID);

		$criteria->addSelectColumn(sfCommentPeer::PARENT_ID);

		$criteria->addSelectColumn(sfCommentPeer::COMMENTABLE_MODEL);

		$criteria->addSelectColumn(sfCommentPeer::COMMENTABLE_ID);

		$criteria->addSelectColumn(sfCommentPeer::NAMESPACE);

		$criteria->addSelectColumn(sfCommentPeer::TITLE);

		$criteria->addSelectColumn(sfCommentPeer::TEXT);

		$criteria->addSelectColumn(sfCommentPeer::AUTHOR_ID);

		$criteria->addSelectColumn(sfCommentPeer::AUTHOR_NAME);

		$criteria->addSelectColumn(sfCommentPeer::AUTHOR_EMAIL);

		$criteria->addSelectColumn(sfCommentPeer::CREATED_AT);

		$criteria->addSelectColumn(sfCommentPeer::UNSUITABLE);

		$criteria->addSelectColumn(sfCommentPeer::EMAIL_NOTIFY);

	}

	const COUNT = 'COUNT(sf_comment.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sf_comment.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfCommentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfCommentPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = sfCommentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}
	
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = sfCommentPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return sfCommentPeer::populateObjects(sfCommentPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfCommentPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BasesfCommentPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			sfCommentPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = sfCommentPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinsfGuardUser(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfCommentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfCommentPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfCommentPeer::AUTHOR_ID, sfGuardUserPeer::ID);

		$rs = sfCommentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinsfGuardUser(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfCommentPeer::addSelectColumns($c);
		$startcol = (sfCommentPeer::NUM_COLUMNS - sfCommentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		sfGuardUserPeer::addSelectColumns($c);

		$c->addJoin(sfCommentPeer::AUTHOR_ID, sfGuardUserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfCommentPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfGuardUserPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getsfGuardUser(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addsfComment($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initsfComments();
				$obj2->addsfComment($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfCommentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfCommentPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfCommentPeer::AUTHOR_ID, sfGuardUserPeer::ID);

		$rs = sfCommentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAll(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfCommentPeer::addSelectColumns($c);
		$startcol2 = (sfCommentPeer::NUM_COLUMNS - sfCommentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(sfCommentPeer::AUTHOR_ID, sfGuardUserPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfCommentPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfGuardUser(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addsfComment($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initsfComments();
				$obj2->addsfComment($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}

	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return sfCommentPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfCommentPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfCommentPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(sfCommentPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BasesfCommentPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasesfCommentPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfCommentPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfCommentPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(sfCommentPeer::ID);
			$selectCriteria->add(sfCommentPeer::ID, $criteria->remove(sfCommentPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasesfCommentPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasesfCommentPeer', $values, $con, $ret);
    }

    return $ret;
  }

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
									$con->begin();
			$affectedRows += BasePeer::doDeleteAll(sfCommentPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(sfCommentPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof sfComment) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(sfCommentPeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public static function doValidate(sfComment $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfCommentPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfCommentPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(sfCommentPeer::DATABASE_NAME, sfCommentPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = sfCommentPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(sfCommentPeer::DATABASE_NAME);

		$criteria->add(sfCommentPeer::ID, $pk);


		$v = sfCommentPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(sfCommentPeer::ID, $pks, Criteria::IN);
			$objs = sfCommentPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BasesfCommentPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'plugins/sfPropelActAsCommentableBehaviorPlugin/lib/model/map/sfCommentMapBuilder.php';
	Propel::registerMapBuilder('plugins.sfPropelActAsCommentableBehaviorPlugin.lib.model.map.sfCommentMapBuilder');
}
