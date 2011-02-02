<?php


abstract class BaseReaktorFilePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'reaktor_file';

	
	const CLASS_DEFAULT = 'lib.model.ReaktorFile';

	
	const NUM_COLUMNS = 19;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'reaktor_file.ID';

	
	const FILENAME = 'reaktor_file.FILENAME';

	
	const USER_ID = 'reaktor_file.USER_ID';

	
	const REALPATH = 'reaktor_file.REALPATH';

	
	const THUMBPATH = 'reaktor_file.THUMBPATH';

	
	const ORIGINALPATH = 'reaktor_file.ORIGINALPATH';

	
	const ORIGINAL_MIMETYPE_ID = 'reaktor_file.ORIGINAL_MIMETYPE_ID';

	
	const CONVERTED_MIMETYPE_ID = 'reaktor_file.CONVERTED_MIMETYPE_ID';

	
	const THUMBNAIL_MIMETYPE_ID = 'reaktor_file.THUMBNAIL_MIMETYPE_ID';

	
	const UPLOADED_AT = 'reaktor_file.UPLOADED_AT';

	
	const MODIFIED_AT = 'reaktor_file.MODIFIED_AT';

	
	const REPORTED_AT = 'reaktor_file.REPORTED_AT';

	
	const REPORTED = 'reaktor_file.REPORTED';

	
	const TOTAL_REPORTED_EVER = 'reaktor_file.TOTAL_REPORTED_EVER';

	
	const MARKED_UNSUITABLE = 'reaktor_file.MARKED_UNSUITABLE';

	
	const UNDER_DISCUSSION = 'reaktor_file.UNDER_DISCUSSION';

	
	const IDENTIFIER = 'reaktor_file.IDENTIFIER';

	
	const HIDDEN = 'reaktor_file.HIDDEN';

	
	const DELETED = 'reaktor_file.DELETED';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Filename', 'UserId', 'Realpath', 'Thumbpath', 'Originalpath', 'OriginalMimetypeId', 'ConvertedMimetypeId', 'ThumbnailMimetypeId', 'UploadedAt', 'ModifiedAt', 'ReportedAt', 'Reported', 'TotalReportedEver', 'MarkedUnsuitable', 'UnderDiscussion', 'Identifier', 'Hidden', 'Deleted', ),
		BasePeer::TYPE_COLNAME => array (ReaktorFilePeer::ID, ReaktorFilePeer::FILENAME, ReaktorFilePeer::USER_ID, ReaktorFilePeer::REALPATH, ReaktorFilePeer::THUMBPATH, ReaktorFilePeer::ORIGINALPATH, ReaktorFilePeer::ORIGINAL_MIMETYPE_ID, ReaktorFilePeer::CONVERTED_MIMETYPE_ID, ReaktorFilePeer::THUMBNAIL_MIMETYPE_ID, ReaktorFilePeer::UPLOADED_AT, ReaktorFilePeer::MODIFIED_AT, ReaktorFilePeer::REPORTED_AT, ReaktorFilePeer::REPORTED, ReaktorFilePeer::TOTAL_REPORTED_EVER, ReaktorFilePeer::MARKED_UNSUITABLE, ReaktorFilePeer::UNDER_DISCUSSION, ReaktorFilePeer::IDENTIFIER, ReaktorFilePeer::HIDDEN, ReaktorFilePeer::DELETED, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'filename', 'user_id', 'realpath', 'thumbpath', 'originalpath', 'original_mimetype_id', 'converted_mimetype_id', 'thumbnail_mimetype_id', 'uploaded_at', 'modified_at', 'reported_at', 'reported', 'total_reported_ever', 'marked_unsuitable', 'under_discussion', 'identifier', 'hidden', 'deleted', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Filename' => 1, 'UserId' => 2, 'Realpath' => 3, 'Thumbpath' => 4, 'Originalpath' => 5, 'OriginalMimetypeId' => 6, 'ConvertedMimetypeId' => 7, 'ThumbnailMimetypeId' => 8, 'UploadedAt' => 9, 'ModifiedAt' => 10, 'ReportedAt' => 11, 'Reported' => 12, 'TotalReportedEver' => 13, 'MarkedUnsuitable' => 14, 'UnderDiscussion' => 15, 'Identifier' => 16, 'Hidden' => 17, 'Deleted' => 18, ),
		BasePeer::TYPE_COLNAME => array (ReaktorFilePeer::ID => 0, ReaktorFilePeer::FILENAME => 1, ReaktorFilePeer::USER_ID => 2, ReaktorFilePeer::REALPATH => 3, ReaktorFilePeer::THUMBPATH => 4, ReaktorFilePeer::ORIGINALPATH => 5, ReaktorFilePeer::ORIGINAL_MIMETYPE_ID => 6, ReaktorFilePeer::CONVERTED_MIMETYPE_ID => 7, ReaktorFilePeer::THUMBNAIL_MIMETYPE_ID => 8, ReaktorFilePeer::UPLOADED_AT => 9, ReaktorFilePeer::MODIFIED_AT => 10, ReaktorFilePeer::REPORTED_AT => 11, ReaktorFilePeer::REPORTED => 12, ReaktorFilePeer::TOTAL_REPORTED_EVER => 13, ReaktorFilePeer::MARKED_UNSUITABLE => 14, ReaktorFilePeer::UNDER_DISCUSSION => 15, ReaktorFilePeer::IDENTIFIER => 16, ReaktorFilePeer::HIDDEN => 17, ReaktorFilePeer::DELETED => 18, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'filename' => 1, 'user_id' => 2, 'realpath' => 3, 'thumbpath' => 4, 'originalpath' => 5, 'original_mimetype_id' => 6, 'converted_mimetype_id' => 7, 'thumbnail_mimetype_id' => 8, 'uploaded_at' => 9, 'modified_at' => 10, 'reported_at' => 11, 'reported' => 12, 'total_reported_ever' => 13, 'marked_unsuitable' => 14, 'under_discussion' => 15, 'identifier' => 16, 'hidden' => 17, 'deleted' => 18, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ReaktorFileMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ReaktorFileMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ReaktorFilePeer::getTableMap();
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
		return str_replace(ReaktorFilePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ReaktorFilePeer::ID);

		$criteria->addSelectColumn(ReaktorFilePeer::FILENAME);

		$criteria->addSelectColumn(ReaktorFilePeer::USER_ID);

		$criteria->addSelectColumn(ReaktorFilePeer::REALPATH);

		$criteria->addSelectColumn(ReaktorFilePeer::THUMBPATH);

		$criteria->addSelectColumn(ReaktorFilePeer::ORIGINALPATH);

		$criteria->addSelectColumn(ReaktorFilePeer::ORIGINAL_MIMETYPE_ID);

		$criteria->addSelectColumn(ReaktorFilePeer::CONVERTED_MIMETYPE_ID);

		$criteria->addSelectColumn(ReaktorFilePeer::THUMBNAIL_MIMETYPE_ID);

		$criteria->addSelectColumn(ReaktorFilePeer::UPLOADED_AT);

		$criteria->addSelectColumn(ReaktorFilePeer::MODIFIED_AT);

		$criteria->addSelectColumn(ReaktorFilePeer::REPORTED_AT);

		$criteria->addSelectColumn(ReaktorFilePeer::REPORTED);

		$criteria->addSelectColumn(ReaktorFilePeer::TOTAL_REPORTED_EVER);

		$criteria->addSelectColumn(ReaktorFilePeer::MARKED_UNSUITABLE);

		$criteria->addSelectColumn(ReaktorFilePeer::UNDER_DISCUSSION);

		$criteria->addSelectColumn(ReaktorFilePeer::IDENTIFIER);

		$criteria->addSelectColumn(ReaktorFilePeer::HIDDEN);

		$criteria->addSelectColumn(ReaktorFilePeer::DELETED);

	}

	const COUNT = 'COUNT(reaktor_file.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT reaktor_file.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorFilePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorFilePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ReaktorFilePeer::doSelectRS($criteria, $con);
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
		$objects = ReaktorFilePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ReaktorFilePeer::populateObjects(ReaktorFilePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorFilePeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseReaktorFilePeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ReaktorFilePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ReaktorFilePeer::getOMClass();
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
			$criteria->addSelectColumn(ReaktorFilePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorFilePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorFilePeer::USER_ID, sfGuardUserPeer::ID);

		$rs = ReaktorFilePeer::doSelectRS($criteria, $con);
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

		ReaktorFilePeer::addSelectColumns($c);
		$startcol = (ReaktorFilePeer::NUM_COLUMNS - ReaktorFilePeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		sfGuardUserPeer::addSelectColumns($c);

		$c->addJoin(ReaktorFilePeer::USER_ID, sfGuardUserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorFilePeer::getOMClass();

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
										$temp_obj2->addReaktorFile($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initReaktorFiles();
				$obj2->addReaktorFile($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorFilePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorFilePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorFilePeer::USER_ID, sfGuardUserPeer::ID);

		$rs = ReaktorFilePeer::doSelectRS($criteria, $con);
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

		ReaktorFilePeer::addSelectColumns($c);
		$startcol2 = (ReaktorFilePeer::NUM_COLUMNS - ReaktorFilePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(ReaktorFilePeer::USER_ID, sfGuardUserPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorFilePeer::getOMClass();


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
					$temp_obj2->addReaktorFile($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initReaktorFiles();
				$obj2->addReaktorFile($obj1);
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
		return ReaktorFilePeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorFilePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseReaktorFilePeer', $values, $con);
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

		$criteria->remove(ReaktorFilePeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseReaktorFilePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseReaktorFilePeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorFilePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseReaktorFilePeer', $values, $con);
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
			$comparison = $criteria->getComparison(ReaktorFilePeer::ID);
			$selectCriteria->add(ReaktorFilePeer::ID, $criteria->remove(ReaktorFilePeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseReaktorFilePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseReaktorFilePeer', $values, $con, $ret);
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
			$affectedRows += ReaktorFilePeer::doOnDeleteCascade(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(ReaktorFilePeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ReaktorFilePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ReaktorFile) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ReaktorFilePeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			$affectedRows += ReaktorFilePeer::doOnDeleteCascade($criteria, $con);
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

				$objects = ReaktorFilePeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			include_once 'lib/model/FileMetadata.php';

						$c = new Criteria();
			
			$c->add(FileMetadataPeer::FILE, $obj->getId());
			$affectedRows += FileMetadataPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	
	public static function doValidate(ReaktorFile $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ReaktorFilePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ReaktorFilePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ReaktorFilePeer::DATABASE_NAME, ReaktorFilePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ReaktorFilePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(ReaktorFilePeer::DATABASE_NAME);

		$criteria->add(ReaktorFilePeer::ID, $pk);


		$v = ReaktorFilePeer::doSelect($criteria, $con);

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
			$criteria->add(ReaktorFilePeer::ID, $pks, Criteria::IN);
			$objs = ReaktorFilePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseReaktorFilePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ReaktorFileMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ReaktorFileMapBuilder');
}
