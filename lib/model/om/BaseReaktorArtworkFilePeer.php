<?php


abstract class BaseReaktorArtworkFilePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'reaktor_artwork_file';

	
	const CLASS_DEFAULT = 'lib.model.ReaktorArtworkFile';

	
	const NUM_COLUMNS = 3;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ARTWORK_ID = 'reaktor_artwork_file.ARTWORK_ID';

	
	const FILE_ID = 'reaktor_artwork_file.FILE_ID';

	
	const FILE_ORDER = 'reaktor_artwork_file.FILE_ORDER';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('ArtworkId', 'FileId', 'FileOrder', ),
		BasePeer::TYPE_COLNAME => array (ReaktorArtworkFilePeer::ARTWORK_ID, ReaktorArtworkFilePeer::FILE_ID, ReaktorArtworkFilePeer::FILE_ORDER, ),
		BasePeer::TYPE_FIELDNAME => array ('artwork_id', 'file_id', 'file_order', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('ArtworkId' => 0, 'FileId' => 1, 'FileOrder' => 2, ),
		BasePeer::TYPE_COLNAME => array (ReaktorArtworkFilePeer::ARTWORK_ID => 0, ReaktorArtworkFilePeer::FILE_ID => 1, ReaktorArtworkFilePeer::FILE_ORDER => 2, ),
		BasePeer::TYPE_FIELDNAME => array ('artwork_id' => 0, 'file_id' => 1, 'file_order' => 2, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ReaktorArtworkFileMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ReaktorArtworkFileMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ReaktorArtworkFilePeer::getTableMap();
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
		return str_replace(ReaktorArtworkFilePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ReaktorArtworkFilePeer::ARTWORK_ID);

		$criteria->addSelectColumn(ReaktorArtworkFilePeer::FILE_ID);

		$criteria->addSelectColumn(ReaktorArtworkFilePeer::FILE_ORDER);

	}

	const COUNT = 'COUNT(reaktor_artwork_file.ARTWORK_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT reaktor_artwork_file.ARTWORK_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkFilePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkFilePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ReaktorArtworkFilePeer::doSelectRS($criteria, $con);
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
		$objects = ReaktorArtworkFilePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ReaktorArtworkFilePeer::populateObjects(ReaktorArtworkFilePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorArtworkFilePeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseReaktorArtworkFilePeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ReaktorArtworkFilePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ReaktorArtworkFilePeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinReaktorArtwork(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkFilePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkFilePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkFilePeer::ARTWORK_ID, ReaktorArtworkPeer::ID);

		$rs = ReaktorArtworkFilePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinReaktorFile(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkFilePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkFilePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkFilePeer::FILE_ID, ReaktorFilePeer::ID);

		$rs = ReaktorArtworkFilePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinReaktorArtwork(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReaktorArtworkFilePeer::addSelectColumns($c);
		$startcol = (ReaktorArtworkFilePeer::NUM_COLUMNS - ReaktorArtworkFilePeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ReaktorArtworkPeer::addSelectColumns($c);

		$c->addJoin(ReaktorArtworkFilePeer::ARTWORK_ID, ReaktorArtworkPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkFilePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ReaktorArtworkPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getReaktorArtwork(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addReaktorArtworkFile($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initReaktorArtworkFiles();
				$obj2->addReaktorArtworkFile($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinReaktorFile(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReaktorArtworkFilePeer::addSelectColumns($c);
		$startcol = (ReaktorArtworkFilePeer::NUM_COLUMNS - ReaktorArtworkFilePeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ReaktorFilePeer::addSelectColumns($c);

		$c->addJoin(ReaktorArtworkFilePeer::FILE_ID, ReaktorFilePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkFilePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ReaktorFilePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getReaktorFile(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addReaktorArtworkFile($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initReaktorArtworkFiles();
				$obj2->addReaktorArtworkFile($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkFilePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkFilePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkFilePeer::ARTWORK_ID, ReaktorArtworkPeer::ID);

		$criteria->addJoin(ReaktorArtworkFilePeer::FILE_ID, ReaktorFilePeer::ID);

		$rs = ReaktorArtworkFilePeer::doSelectRS($criteria, $con);
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

		ReaktorArtworkFilePeer::addSelectColumns($c);
		$startcol2 = (ReaktorArtworkFilePeer::NUM_COLUMNS - ReaktorArtworkFilePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ReaktorArtworkPeer::NUM_COLUMNS;

		ReaktorFilePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ReaktorFilePeer::NUM_COLUMNS;

		$c->addJoin(ReaktorArtworkFilePeer::ARTWORK_ID, ReaktorArtworkPeer::ID);

		$c->addJoin(ReaktorArtworkFilePeer::FILE_ID, ReaktorFilePeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkFilePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = ReaktorArtworkPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getReaktorArtwork(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addReaktorArtworkFile($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initReaktorArtworkFiles();
				$obj2->addReaktorArtworkFile($obj1);
			}


					
			$omClass = ReaktorFilePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getReaktorFile(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addReaktorArtworkFile($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initReaktorArtworkFiles();
				$obj3->addReaktorArtworkFile($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptReaktorArtwork(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkFilePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkFilePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkFilePeer::FILE_ID, ReaktorFilePeer::ID);

		$rs = ReaktorArtworkFilePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptReaktorFile(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkFilePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkFilePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkFilePeer::ARTWORK_ID, ReaktorArtworkPeer::ID);

		$rs = ReaktorArtworkFilePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptReaktorArtwork(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReaktorArtworkFilePeer::addSelectColumns($c);
		$startcol2 = (ReaktorArtworkFilePeer::NUM_COLUMNS - ReaktorArtworkFilePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ReaktorFilePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ReaktorFilePeer::NUM_COLUMNS;

		$c->addJoin(ReaktorArtworkFilePeer::FILE_ID, ReaktorFilePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkFilePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ReaktorFilePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getReaktorFile(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addReaktorArtworkFile($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initReaktorArtworkFiles();
				$obj2->addReaktorArtworkFile($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptReaktorFile(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReaktorArtworkFilePeer::addSelectColumns($c);
		$startcol2 = (ReaktorArtworkFilePeer::NUM_COLUMNS - ReaktorArtworkFilePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ReaktorArtworkPeer::NUM_COLUMNS;

		$c->addJoin(ReaktorArtworkFilePeer::ARTWORK_ID, ReaktorArtworkPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkFilePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ReaktorArtworkPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getReaktorArtwork(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addReaktorArtworkFile($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initReaktorArtworkFiles();
				$obj2->addReaktorArtworkFile($obj1);
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
		return ReaktorArtworkFilePeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorArtworkFilePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseReaktorArtworkFilePeer', $values, $con);
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


				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseReaktorArtworkFilePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseReaktorArtworkFilePeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorArtworkFilePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseReaktorArtworkFilePeer', $values, $con);
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
			$comparison = $criteria->getComparison(ReaktorArtworkFilePeer::ARTWORK_ID);
			$selectCriteria->add(ReaktorArtworkFilePeer::ARTWORK_ID, $criteria->remove(ReaktorArtworkFilePeer::ARTWORK_ID), $comparison);

			$comparison = $criteria->getComparison(ReaktorArtworkFilePeer::FILE_ID);
			$selectCriteria->add(ReaktorArtworkFilePeer::FILE_ID, $criteria->remove(ReaktorArtworkFilePeer::FILE_ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseReaktorArtworkFilePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseReaktorArtworkFilePeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(ReaktorArtworkFilePeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ReaktorArtworkFilePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ReaktorArtworkFile) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
												if(count($values) == count($values, COUNT_RECURSIVE))
			{
								$values = array($values);
			}
			$vals = array();
			foreach($values as $value)
			{

				$vals[0][] = $value[0];
				$vals[1][] = $value[1];
			}

			$criteria->add(ReaktorArtworkFilePeer::ARTWORK_ID, $vals[0], Criteria::IN);
			$criteria->add(ReaktorArtworkFilePeer::FILE_ID, $vals[1], Criteria::IN);
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

	
	public static function doValidate(ReaktorArtworkFile $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ReaktorArtworkFilePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ReaktorArtworkFilePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ReaktorArtworkFilePeer::DATABASE_NAME, ReaktorArtworkFilePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ReaktorArtworkFilePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK( $artwork_id, $file_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(ReaktorArtworkFilePeer::ARTWORK_ID, $artwork_id);
		$criteria->add(ReaktorArtworkFilePeer::FILE_ID, $file_id);
		$v = ReaktorArtworkFilePeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseReaktorArtworkFilePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ReaktorArtworkFileMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ReaktorArtworkFileMapBuilder');
}
