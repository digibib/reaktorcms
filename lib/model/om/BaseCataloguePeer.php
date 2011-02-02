<?php


abstract class BaseCataloguePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'catalogue';

	
	const CLASS_DEFAULT = 'lib.model.Catalogue';

	
	const NUM_COLUMNS = 8;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const CAT_ID = 'catalogue.CAT_ID';

	
	const NAME = 'catalogue.NAME';

	
	const SOURCE_LANG = 'catalogue.SOURCE_LANG';

	
	const TARGET_LANG = 'catalogue.TARGET_LANG';

	
	const DATE_CREATED = 'catalogue.DATE_CREATED';

	
	const DATE_MODIFIED = 'catalogue.DATE_MODIFIED';

	
	const AUTHOR = 'catalogue.AUTHOR';

	
	const DESCRIPTION = 'catalogue.DESCRIPTION';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CatId', 'Name', 'SourceLang', 'TargetLang', 'DateCreated', 'DateModified', 'Author', 'Description', ),
		BasePeer::TYPE_COLNAME => array (CataloguePeer::CAT_ID, CataloguePeer::NAME, CataloguePeer::SOURCE_LANG, CataloguePeer::TARGET_LANG, CataloguePeer::DATE_CREATED, CataloguePeer::DATE_MODIFIED, CataloguePeer::AUTHOR, CataloguePeer::DESCRIPTION, ),
		BasePeer::TYPE_FIELDNAME => array ('cat_id', 'name', 'source_lang', 'target_lang', 'date_created', 'date_modified', 'author', 'description', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CatId' => 0, 'Name' => 1, 'SourceLang' => 2, 'TargetLang' => 3, 'DateCreated' => 4, 'DateModified' => 5, 'Author' => 6, 'Description' => 7, ),
		BasePeer::TYPE_COLNAME => array (CataloguePeer::CAT_ID => 0, CataloguePeer::NAME => 1, CataloguePeer::SOURCE_LANG => 2, CataloguePeer::TARGET_LANG => 3, CataloguePeer::DATE_CREATED => 4, CataloguePeer::DATE_MODIFIED => 5, CataloguePeer::AUTHOR => 6, CataloguePeer::DESCRIPTION => 7, ),
		BasePeer::TYPE_FIELDNAME => array ('cat_id' => 0, 'name' => 1, 'source_lang' => 2, 'target_lang' => 3, 'date_created' => 4, 'date_modified' => 5, 'author' => 6, 'description' => 7, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/CatalogueMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.CatalogueMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = CataloguePeer::getTableMap();
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
		return str_replace(CataloguePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(CataloguePeer::CAT_ID);

		$criteria->addSelectColumn(CataloguePeer::NAME);

		$criteria->addSelectColumn(CataloguePeer::SOURCE_LANG);

		$criteria->addSelectColumn(CataloguePeer::TARGET_LANG);

		$criteria->addSelectColumn(CataloguePeer::DATE_CREATED);

		$criteria->addSelectColumn(CataloguePeer::DATE_MODIFIED);

		$criteria->addSelectColumn(CataloguePeer::AUTHOR);

		$criteria->addSelectColumn(CataloguePeer::DESCRIPTION);

	}

	const COUNT = 'COUNT(catalogue.CAT_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT catalogue.CAT_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(CataloguePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(CataloguePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = CataloguePeer::doSelectRS($criteria, $con);
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
		$objects = CataloguePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return CataloguePeer::populateObjects(CataloguePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseCataloguePeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseCataloguePeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			CataloguePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = CataloguePeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}
	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return CataloguePeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseCataloguePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseCataloguePeer', $values, $con);
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

		$criteria->remove(CataloguePeer::CAT_ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseCataloguePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseCataloguePeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseCataloguePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseCataloguePeer', $values, $con);
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
			$comparison = $criteria->getComparison(CataloguePeer::CAT_ID);
			$selectCriteria->add(CataloguePeer::CAT_ID, $criteria->remove(CataloguePeer::CAT_ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseCataloguePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseCataloguePeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(CataloguePeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(CataloguePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof Catalogue) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(CataloguePeer::CAT_ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(Catalogue $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(CataloguePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(CataloguePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(CataloguePeer::DATABASE_NAME, CataloguePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = CataloguePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(CataloguePeer::DATABASE_NAME);

		$criteria->add(CataloguePeer::CAT_ID, $pk);


		$v = CataloguePeer::doSelect($criteria, $con);

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
			$criteria->add(CataloguePeer::CAT_ID, $pks, Criteria::IN);
			$objs = CataloguePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseCataloguePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/CatalogueMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.CatalogueMapBuilder');
}
