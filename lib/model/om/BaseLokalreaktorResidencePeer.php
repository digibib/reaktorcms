<?php


abstract class BaseLokalreaktorResidencePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'lokalreaktor_residence';

	
	const CLASS_DEFAULT = 'lib.model.LokalreaktorResidence';

	
	const NUM_COLUMNS = 4;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'lokalreaktor_residence.ID';

	
	const CREATED_AT = 'lokalreaktor_residence.CREATED_AT';

	
	const SUBREAKTOR_ID = 'lokalreaktor_residence.SUBREAKTOR_ID';

	
	const RESIDENCE_ID = 'lokalreaktor_residence.RESIDENCE_ID';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'CreatedAt', 'SubreaktorId', 'ResidenceId', ),
		BasePeer::TYPE_COLNAME => array (LokalreaktorResidencePeer::ID, LokalreaktorResidencePeer::CREATED_AT, LokalreaktorResidencePeer::SUBREAKTOR_ID, LokalreaktorResidencePeer::RESIDENCE_ID, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'created_at', 'subreaktor_id', 'residence_id', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'CreatedAt' => 1, 'SubreaktorId' => 2, 'ResidenceId' => 3, ),
		BasePeer::TYPE_COLNAME => array (LokalreaktorResidencePeer::ID => 0, LokalreaktorResidencePeer::CREATED_AT => 1, LokalreaktorResidencePeer::SUBREAKTOR_ID => 2, LokalreaktorResidencePeer::RESIDENCE_ID => 3, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'created_at' => 1, 'subreaktor_id' => 2, 'residence_id' => 3, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/LokalreaktorResidenceMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.LokalreaktorResidenceMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = LokalreaktorResidencePeer::getTableMap();
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
		return str_replace(LokalreaktorResidencePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(LokalreaktorResidencePeer::ID);

		$criteria->addSelectColumn(LokalreaktorResidencePeer::CREATED_AT);

		$criteria->addSelectColumn(LokalreaktorResidencePeer::SUBREAKTOR_ID);

		$criteria->addSelectColumn(LokalreaktorResidencePeer::RESIDENCE_ID);

	}

	const COUNT = 'COUNT(lokalreaktor_residence.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT lokalreaktor_residence.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(LokalreaktorResidencePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LokalreaktorResidencePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = LokalreaktorResidencePeer::doSelectRS($criteria, $con);
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
		$objects = LokalreaktorResidencePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return LokalreaktorResidencePeer::populateObjects(LokalreaktorResidencePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseLokalreaktorResidencePeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseLokalreaktorResidencePeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			LokalreaktorResidencePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = LokalreaktorResidencePeer::getOMClass();
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
			$criteria->addSelectColumn(LokalreaktorResidencePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LokalreaktorResidencePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(LokalreaktorResidencePeer::SUBREAKTOR_ID, SubreaktorPeer::ID);

		$rs = LokalreaktorResidencePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinResidence(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(LokalreaktorResidencePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LokalreaktorResidencePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(LokalreaktorResidencePeer::RESIDENCE_ID, ResidencePeer::ID);

		$rs = LokalreaktorResidencePeer::doSelectRS($criteria, $con);
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

		LokalreaktorResidencePeer::addSelectColumns($c);
		$startcol = (LokalreaktorResidencePeer::NUM_COLUMNS - LokalreaktorResidencePeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		SubreaktorPeer::addSelectColumns($c);

		$c->addJoin(LokalreaktorResidencePeer::SUBREAKTOR_ID, SubreaktorPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = LokalreaktorResidencePeer::getOMClass();

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
										$temp_obj2->addLokalreaktorResidence($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initLokalreaktorResidences();
				$obj2->addLokalreaktorResidence($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinResidence(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		LokalreaktorResidencePeer::addSelectColumns($c);
		$startcol = (LokalreaktorResidencePeer::NUM_COLUMNS - LokalreaktorResidencePeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ResidencePeer::addSelectColumns($c);

		$c->addJoin(LokalreaktorResidencePeer::RESIDENCE_ID, ResidencePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = LokalreaktorResidencePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ResidencePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getResidence(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addLokalreaktorResidence($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initLokalreaktorResidences();
				$obj2->addLokalreaktorResidence($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(LokalreaktorResidencePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LokalreaktorResidencePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(LokalreaktorResidencePeer::SUBREAKTOR_ID, SubreaktorPeer::ID);

		$criteria->addJoin(LokalreaktorResidencePeer::RESIDENCE_ID, ResidencePeer::ID);

		$rs = LokalreaktorResidencePeer::doSelectRS($criteria, $con);
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

		LokalreaktorResidencePeer::addSelectColumns($c);
		$startcol2 = (LokalreaktorResidencePeer::NUM_COLUMNS - LokalreaktorResidencePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		SubreaktorPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + SubreaktorPeer::NUM_COLUMNS;

		ResidencePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ResidencePeer::NUM_COLUMNS;

		$c->addJoin(LokalreaktorResidencePeer::SUBREAKTOR_ID, SubreaktorPeer::ID);

		$c->addJoin(LokalreaktorResidencePeer::RESIDENCE_ID, ResidencePeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = LokalreaktorResidencePeer::getOMClass();


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
					$temp_obj2->addLokalreaktorResidence($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initLokalreaktorResidences();
				$obj2->addLokalreaktorResidence($obj1);
			}


					
			$omClass = ResidencePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getResidence(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addLokalreaktorResidence($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initLokalreaktorResidences();
				$obj3->addLokalreaktorResidence($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptSubreaktor(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(LokalreaktorResidencePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LokalreaktorResidencePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(LokalreaktorResidencePeer::RESIDENCE_ID, ResidencePeer::ID);

		$rs = LokalreaktorResidencePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptResidence(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(LokalreaktorResidencePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LokalreaktorResidencePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(LokalreaktorResidencePeer::SUBREAKTOR_ID, SubreaktorPeer::ID);

		$rs = LokalreaktorResidencePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptSubreaktor(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		LokalreaktorResidencePeer::addSelectColumns($c);
		$startcol2 = (LokalreaktorResidencePeer::NUM_COLUMNS - LokalreaktorResidencePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ResidencePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ResidencePeer::NUM_COLUMNS;

		$c->addJoin(LokalreaktorResidencePeer::RESIDENCE_ID, ResidencePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = LokalreaktorResidencePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ResidencePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getResidence(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addLokalreaktorResidence($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initLokalreaktorResidences();
				$obj2->addLokalreaktorResidence($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptResidence(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		LokalreaktorResidencePeer::addSelectColumns($c);
		$startcol2 = (LokalreaktorResidencePeer::NUM_COLUMNS - LokalreaktorResidencePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		SubreaktorPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + SubreaktorPeer::NUM_COLUMNS;

		$c->addJoin(LokalreaktorResidencePeer::SUBREAKTOR_ID, SubreaktorPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = LokalreaktorResidencePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = SubreaktorPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getSubreaktor(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addLokalreaktorResidence($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initLokalreaktorResidences();
				$obj2->addLokalreaktorResidence($obj1);
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
		return LokalreaktorResidencePeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseLokalreaktorResidencePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseLokalreaktorResidencePeer', $values, $con);
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

		$criteria->remove(LokalreaktorResidencePeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseLokalreaktorResidencePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseLokalreaktorResidencePeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseLokalreaktorResidencePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseLokalreaktorResidencePeer', $values, $con);
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
			$comparison = $criteria->getComparison(LokalreaktorResidencePeer::ID);
			$selectCriteria->add(LokalreaktorResidencePeer::ID, $criteria->remove(LokalreaktorResidencePeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseLokalreaktorResidencePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseLokalreaktorResidencePeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(LokalreaktorResidencePeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(LokalreaktorResidencePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof LokalreaktorResidence) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(LokalreaktorResidencePeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(LokalreaktorResidence $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(LokalreaktorResidencePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(LokalreaktorResidencePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(LokalreaktorResidencePeer::DATABASE_NAME, LokalreaktorResidencePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = LokalreaktorResidencePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(LokalreaktorResidencePeer::DATABASE_NAME);

		$criteria->add(LokalreaktorResidencePeer::ID, $pk);


		$v = LokalreaktorResidencePeer::doSelect($criteria, $con);

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
			$criteria->add(LokalreaktorResidencePeer::ID, $pks, Criteria::IN);
			$objs = LokalreaktorResidencePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseLokalreaktorResidencePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/LokalreaktorResidenceMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.LokalreaktorResidenceMapBuilder');
}
