<?php


abstract class BaseSubreaktorPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'subreaktor';

	
	const CLASS_DEFAULT = 'lib.model.Subreaktor';

	
	const NUM_COLUMNS = 5;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'subreaktor.ID';

	
	const REFERENCE = 'subreaktor.REFERENCE';

	
	const LOKALREAKTOR = 'subreaktor.LOKALREAKTOR';

	
	const LIVE = 'subreaktor.LIVE';

	
	const SUBREAKTOR_ORDER = 'subreaktor.SUBREAKTOR_ORDER';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Reference', 'Lokalreaktor', 'Live', 'SubreaktorOrder', ),
		BasePeer::TYPE_COLNAME => array (SubreaktorPeer::ID, SubreaktorPeer::REFERENCE, SubreaktorPeer::LOKALREAKTOR, SubreaktorPeer::LIVE, SubreaktorPeer::SUBREAKTOR_ORDER, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'reference', 'lokalreaktor', 'live', 'subreaktor_order', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Reference' => 1, 'Lokalreaktor' => 2, 'Live' => 3, 'SubreaktorOrder' => 4, ),
		BasePeer::TYPE_COLNAME => array (SubreaktorPeer::ID => 0, SubreaktorPeer::REFERENCE => 1, SubreaktorPeer::LOKALREAKTOR => 2, SubreaktorPeer::LIVE => 3, SubreaktorPeer::SUBREAKTOR_ORDER => 4, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'reference' => 1, 'lokalreaktor' => 2, 'live' => 3, 'subreaktor_order' => 4, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/SubreaktorMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.SubreaktorMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = SubreaktorPeer::getTableMap();
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
		return str_replace(SubreaktorPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(SubreaktorPeer::ID);

		$criteria->addSelectColumn(SubreaktorPeer::REFERENCE);

		$criteria->addSelectColumn(SubreaktorPeer::LOKALREAKTOR);

		$criteria->addSelectColumn(SubreaktorPeer::LIVE);

		$criteria->addSelectColumn(SubreaktorPeer::SUBREAKTOR_ORDER);

	}

	const COUNT = 'COUNT(subreaktor.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT subreaktor.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SubreaktorPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SubreaktorPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = SubreaktorPeer::doSelectRS($criteria, $con);
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
		$objects = SubreaktorPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return SubreaktorPeer::populateObjects(SubreaktorPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseSubreaktorPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseSubreaktorPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			SubreaktorPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = SubreaktorPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

  
  public static function doSelectWithI18n(Criteria $c, $culture = null, $con = null)
  {
    if ($culture === null)
    {
      $culture = sfContext::getInstance()->getUser()->getCulture();
    }

        if ($c->getDbName() == Propel::getDefaultDB())
    {
      $c->setDbName(self::DATABASE_NAME);
    }

    SubreaktorPeer::addSelectColumns($c);
    $startcol = (SubreaktorPeer::NUM_COLUMNS - SubreaktorPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

    SubreaktorI18nPeer::addSelectColumns($c);

    $c->addJoin(SubreaktorPeer::ID, SubreaktorI18nPeer::ID);
    $c->add(SubreaktorI18nPeer::CULTURE, $culture);

    $rs = BasePeer::doSelect($c, $con);
    $results = array();

    while($rs->next()) {

      $omClass = SubreaktorPeer::getOMClass();

      $cls = Propel::import($omClass);
      $obj1 = new $cls();
      $obj1->hydrate($rs);
      $obj1->setCulture($culture);

      $omClass = SubreaktorI18nPeer::getOMClass($rs, $startcol);

      $cls = Propel::import($omClass);
      $obj2 = new $cls();
      $obj2->hydrate($rs, $startcol);

      $obj1->setSubreaktorI18nForCulture($obj2, $culture);
      $obj2->setSubreaktor($obj1);

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
		return SubreaktorPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseSubreaktorPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseSubreaktorPeer', $values, $con);
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

		$criteria->remove(SubreaktorPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseSubreaktorPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseSubreaktorPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseSubreaktorPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseSubreaktorPeer', $values, $con);
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
			$comparison = $criteria->getComparison(SubreaktorPeer::ID);
			$selectCriteria->add(SubreaktorPeer::ID, $criteria->remove(SubreaktorPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseSubreaktorPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseSubreaktorPeer', $values, $con, $ret);
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
			$affectedRows += SubreaktorPeer::doOnDeleteCascade(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(SubreaktorPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(SubreaktorPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof Subreaktor) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(SubreaktorPeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			$affectedRows += SubreaktorPeer::doOnDeleteCascade($criteria, $con);
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected static function doOnDeleteCascade(Criteria $criteria, Connection $con)
	{
				$affectedRows = 0;

				$objects = SubreaktorPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			include_once 'lib/model/UserInterest.php';

						$c = new Criteria();
			
			$c->add(UserInterestPeer::SUBREAKTOR_ID, $obj->getId());
			$affectedRows += UserInterestPeer::doDelete($c, $con);

			include_once 'lib/model/SubreaktorI18n.php';

						$c = new Criteria();
			
			$c->add(SubreaktorI18nPeer::ID, $obj->getId());
			$affectedRows += SubreaktorI18nPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	
	public static function doValidate(Subreaktor $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(SubreaktorPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(SubreaktorPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(SubreaktorPeer::DATABASE_NAME, SubreaktorPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = SubreaktorPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(SubreaktorPeer::DATABASE_NAME);

		$criteria->add(SubreaktorPeer::ID, $pk);


		$v = SubreaktorPeer::doSelect($criteria, $con);

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
			$criteria->add(SubreaktorPeer::ID, $pks, Criteria::IN);
			$objs = SubreaktorPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseSubreaktorPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/SubreaktorMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.SubreaktorMapBuilder');
}
