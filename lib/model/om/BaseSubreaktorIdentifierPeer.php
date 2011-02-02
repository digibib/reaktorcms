<?php


abstract class BaseSubreaktorIdentifierPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'subreaktor_identifier';

	
	const CLASS_DEFAULT = 'lib.model.SubreaktorIdentifier';

	
	const NUM_COLUMNS = 3;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'subreaktor_identifier.ID';

	
	const SUBREAKTOR_ID = 'subreaktor_identifier.SUBREAKTOR_ID';

	
	const IDENTIFIER = 'subreaktor_identifier.IDENTIFIER';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'SubreaktorId', 'Identifier', ),
		BasePeer::TYPE_COLNAME => array (SubreaktorIdentifierPeer::ID, SubreaktorIdentifierPeer::SUBREAKTOR_ID, SubreaktorIdentifierPeer::IDENTIFIER, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'subreaktor_id', 'identifier', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'SubreaktorId' => 1, 'Identifier' => 2, ),
		BasePeer::TYPE_COLNAME => array (SubreaktorIdentifierPeer::ID => 0, SubreaktorIdentifierPeer::SUBREAKTOR_ID => 1, SubreaktorIdentifierPeer::IDENTIFIER => 2, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'subreaktor_id' => 1, 'identifier' => 2, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/SubreaktorIdentifierMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.SubreaktorIdentifierMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = SubreaktorIdentifierPeer::getTableMap();
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
		return str_replace(SubreaktorIdentifierPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(SubreaktorIdentifierPeer::ID);

		$criteria->addSelectColumn(SubreaktorIdentifierPeer::SUBREAKTOR_ID);

		$criteria->addSelectColumn(SubreaktorIdentifierPeer::IDENTIFIER);

	}

	const COUNT = 'COUNT(subreaktor_identifier.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT subreaktor_identifier.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SubreaktorIdentifierPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SubreaktorIdentifierPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = SubreaktorIdentifierPeer::doSelectRS($criteria, $con);
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
		$objects = SubreaktorIdentifierPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return SubreaktorIdentifierPeer::populateObjects(SubreaktorIdentifierPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseSubreaktorIdentifierPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseSubreaktorIdentifierPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			SubreaktorIdentifierPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = SubreaktorIdentifierPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinSubreaktor(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SubreaktorIdentifierPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SubreaktorIdentifierPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(SubreaktorIdentifierPeer::SUBREAKTOR_ID, SubreaktorPeer::ID);

		$rs = SubreaktorIdentifierPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinSubreaktor(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		SubreaktorIdentifierPeer::addSelectColumns($c);
		$startcol = (SubreaktorIdentifierPeer::NUM_COLUMNS - SubreaktorIdentifierPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		SubreaktorPeer::addSelectColumns($c);

		$c->addJoin(SubreaktorIdentifierPeer::SUBREAKTOR_ID, SubreaktorPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = SubreaktorIdentifierPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = SubreaktorPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getSubreaktor(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addSubreaktorIdentifier($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initSubreaktorIdentifiers();
				$obj2->addSubreaktorIdentifier($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SubreaktorIdentifierPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SubreaktorIdentifierPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(SubreaktorIdentifierPeer::SUBREAKTOR_ID, SubreaktorPeer::ID);

		$rs = SubreaktorIdentifierPeer::doSelectRS($criteria, $con);
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

		SubreaktorIdentifierPeer::addSelectColumns($c);
		$startcol2 = (SubreaktorIdentifierPeer::NUM_COLUMNS - SubreaktorIdentifierPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		SubreaktorPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + SubreaktorPeer::NUM_COLUMNS;

		$c->addJoin(SubreaktorIdentifierPeer::SUBREAKTOR_ID, SubreaktorPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = SubreaktorIdentifierPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = SubreaktorPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getSubreaktor(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addSubreaktorIdentifier($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initSubreaktorIdentifiers();
				$obj2->addSubreaktorIdentifier($obj1);
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
		return SubreaktorIdentifierPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseSubreaktorIdentifierPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseSubreaktorIdentifierPeer', $values, $con);
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

		$criteria->remove(SubreaktorIdentifierPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseSubreaktorIdentifierPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseSubreaktorIdentifierPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseSubreaktorIdentifierPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseSubreaktorIdentifierPeer', $values, $con);
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
			$comparison = $criteria->getComparison(SubreaktorIdentifierPeer::ID);
			$selectCriteria->add(SubreaktorIdentifierPeer::ID, $criteria->remove(SubreaktorIdentifierPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseSubreaktorIdentifierPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseSubreaktorIdentifierPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(SubreaktorIdentifierPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(SubreaktorIdentifierPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof SubreaktorIdentifier) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(SubreaktorIdentifierPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(SubreaktorIdentifier $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(SubreaktorIdentifierPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(SubreaktorIdentifierPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(SubreaktorIdentifierPeer::DATABASE_NAME, SubreaktorIdentifierPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = SubreaktorIdentifierPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(SubreaktorIdentifierPeer::DATABASE_NAME);

		$criteria->add(SubreaktorIdentifierPeer::ID, $pk);


		$v = SubreaktorIdentifierPeer::doSelect($criteria, $con);

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
			$criteria->add(SubreaktorIdentifierPeer::ID, $pks, Criteria::IN);
			$objs = SubreaktorIdentifierPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseSubreaktorIdentifierPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/SubreaktorIdentifierMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.SubreaktorIdentifierMapBuilder');
}
