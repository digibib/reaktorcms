<?php


abstract class BaseMessagesPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'messages';

	
	const CLASS_DEFAULT = 'lib.model.Messages';

	
	const NUM_COLUMNS = 12;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'messages.ID';

	
	const TO_USER_ID = 'messages.TO_USER_ID';

	
	const FROM_USER_ID = 'messages.FROM_USER_ID';

	
	const SUBJECT = 'messages.SUBJECT';

	
	const MESSAGE = 'messages.MESSAGE';

	
	const TIMESTAMP = 'messages.TIMESTAMP';

	
	const DELETED_BY_FROM = 'messages.DELETED_BY_FROM';

	
	const DELETED_BY_TO = 'messages.DELETED_BY_TO';

	
	const IS_READ = 'messages.IS_READ';

	
	const IS_IGNORED = 'messages.IS_IGNORED';

	
	const IS_ARCHIVED = 'messages.IS_ARCHIVED';

	
	const REPLY_TO = 'messages.REPLY_TO';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'ToUserId', 'FromUserId', 'Subject', 'Message', 'Timestamp', 'DeletedByFrom', 'DeletedByTo', 'IsRead', 'IsIgnored', 'IsArchived', 'ReplyTo', ),
		BasePeer::TYPE_COLNAME => array (MessagesPeer::ID, MessagesPeer::TO_USER_ID, MessagesPeer::FROM_USER_ID, MessagesPeer::SUBJECT, MessagesPeer::MESSAGE, MessagesPeer::TIMESTAMP, MessagesPeer::DELETED_BY_FROM, MessagesPeer::DELETED_BY_TO, MessagesPeer::IS_READ, MessagesPeer::IS_IGNORED, MessagesPeer::IS_ARCHIVED, MessagesPeer::REPLY_TO, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'to_user_id', 'from_user_id', 'subject', 'message', 'timestamp', 'deleted_by_from', 'deleted_by_to', 'is_read', 'is_ignored', 'is_archived', 'reply_to', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'ToUserId' => 1, 'FromUserId' => 2, 'Subject' => 3, 'Message' => 4, 'Timestamp' => 5, 'DeletedByFrom' => 6, 'DeletedByTo' => 7, 'IsRead' => 8, 'IsIgnored' => 9, 'IsArchived' => 10, 'ReplyTo' => 11, ),
		BasePeer::TYPE_COLNAME => array (MessagesPeer::ID => 0, MessagesPeer::TO_USER_ID => 1, MessagesPeer::FROM_USER_ID => 2, MessagesPeer::SUBJECT => 3, MessagesPeer::MESSAGE => 4, MessagesPeer::TIMESTAMP => 5, MessagesPeer::DELETED_BY_FROM => 6, MessagesPeer::DELETED_BY_TO => 7, MessagesPeer::IS_READ => 8, MessagesPeer::IS_IGNORED => 9, MessagesPeer::IS_ARCHIVED => 10, MessagesPeer::REPLY_TO => 11, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'to_user_id' => 1, 'from_user_id' => 2, 'subject' => 3, 'message' => 4, 'timestamp' => 5, 'deleted_by_from' => 6, 'deleted_by_to' => 7, 'is_read' => 8, 'is_ignored' => 9, 'is_archived' => 10, 'reply_to' => 11, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/MessagesMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.MessagesMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = MessagesPeer::getTableMap();
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
		return str_replace(MessagesPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MessagesPeer::ID);

		$criteria->addSelectColumn(MessagesPeer::TO_USER_ID);

		$criteria->addSelectColumn(MessagesPeer::FROM_USER_ID);

		$criteria->addSelectColumn(MessagesPeer::SUBJECT);

		$criteria->addSelectColumn(MessagesPeer::MESSAGE);

		$criteria->addSelectColumn(MessagesPeer::TIMESTAMP);

		$criteria->addSelectColumn(MessagesPeer::DELETED_BY_FROM);

		$criteria->addSelectColumn(MessagesPeer::DELETED_BY_TO);

		$criteria->addSelectColumn(MessagesPeer::IS_READ);

		$criteria->addSelectColumn(MessagesPeer::IS_IGNORED);

		$criteria->addSelectColumn(MessagesPeer::IS_ARCHIVED);

		$criteria->addSelectColumn(MessagesPeer::REPLY_TO);

	}

	const COUNT = 'COUNT(messages.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT messages.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MessagesPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MessagesPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MessagesPeer::doSelectRS($criteria, $con);
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
		$objects = MessagesPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return MessagesPeer::populateObjects(MessagesPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMessagesPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseMessagesPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MessagesPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = MessagesPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinsfGuardUserRelatedByToUserId(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MessagesPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MessagesPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MessagesPeer::TO_USER_ID, sfGuardUserPeer::ID);

		$rs = MessagesPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinsfGuardUserRelatedByFromUserId(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MessagesPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MessagesPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MessagesPeer::FROM_USER_ID, sfGuardUserPeer::ID);

		$rs = MessagesPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinsfGuardUserRelatedByToUserId(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MessagesPeer::addSelectColumns($c);
		$startcol = (MessagesPeer::NUM_COLUMNS - MessagesPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		sfGuardUserPeer::addSelectColumns($c);

		$c->addJoin(MessagesPeer::TO_USER_ID, sfGuardUserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MessagesPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfGuardUserPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getsfGuardUserRelatedByToUserId(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addMessagesRelatedByToUserId($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initMessagessRelatedByToUserId();
				$obj2->addMessagesRelatedByToUserId($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinsfGuardUserRelatedByFromUserId(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MessagesPeer::addSelectColumns($c);
		$startcol = (MessagesPeer::NUM_COLUMNS - MessagesPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		sfGuardUserPeer::addSelectColumns($c);

		$c->addJoin(MessagesPeer::FROM_USER_ID, sfGuardUserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MessagesPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfGuardUserPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getsfGuardUserRelatedByFromUserId(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addMessagesRelatedByFromUserId($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initMessagessRelatedByFromUserId();
				$obj2->addMessagesRelatedByFromUserId($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MessagesPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MessagesPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(MessagesPeer::TO_USER_ID, sfGuardUserPeer::ID);

		$criteria->addJoin(MessagesPeer::FROM_USER_ID, sfGuardUserPeer::ID);

		$rs = MessagesPeer::doSelectRS($criteria, $con);
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

		MessagesPeer::addSelectColumns($c);
		$startcol2 = (MessagesPeer::NUM_COLUMNS - MessagesPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(MessagesPeer::TO_USER_ID, sfGuardUserPeer::ID);

		$c->addJoin(MessagesPeer::FROM_USER_ID, sfGuardUserPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MessagesPeer::getOMClass();


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
				$temp_obj2 = $temp_obj1->getsfGuardUserRelatedByToUserId(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addMessagesRelatedByToUserId($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initMessagessRelatedByToUserId();
				$obj2->addMessagesRelatedByToUserId($obj1);
			}


					
			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfGuardUserRelatedByFromUserId(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addMessagesRelatedByFromUserId($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initMessagessRelatedByFromUserId();
				$obj3->addMessagesRelatedByFromUserId($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptsfGuardUserRelatedByToUserId(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MessagesPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MessagesPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MessagesPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptsfGuardUserRelatedByFromUserId(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(MessagesPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(MessagesPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = MessagesPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptsfGuardUserRelatedByToUserId(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MessagesPeer::addSelectColumns($c);
		$startcol2 = (MessagesPeer::NUM_COLUMNS - MessagesPeer::NUM_LAZY_LOAD_COLUMNS) + 1;


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MessagesPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptsfGuardUserRelatedByFromUserId(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MessagesPeer::addSelectColumns($c);
		$startcol2 = (MessagesPeer::NUM_COLUMNS - MessagesPeer::NUM_LAZY_LOAD_COLUMNS) + 1;


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = MessagesPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

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
		return MessagesPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMessagesPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseMessagesPeer', $values, $con);
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

		$criteria->remove(MessagesPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseMessagesPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseMessagesPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseMessagesPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseMessagesPeer', $values, $con);
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
			$comparison = $criteria->getComparison(MessagesPeer::ID);
			$selectCriteria->add(MessagesPeer::ID, $criteria->remove(MessagesPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseMessagesPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseMessagesPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(MessagesPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(MessagesPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof Messages) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MessagesPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(Messages $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MessagesPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MessagesPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(MessagesPeer::DATABASE_NAME, MessagesPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = MessagesPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(MessagesPeer::DATABASE_NAME);

		$criteria->add(MessagesPeer::ID, $pk);


		$v = MessagesPeer::doSelect($criteria, $con);

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
			$criteria->add(MessagesPeer::ID, $pks, Criteria::IN);
			$objs = MessagesPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseMessagesPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/MessagesMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.MessagesMapBuilder');
}
