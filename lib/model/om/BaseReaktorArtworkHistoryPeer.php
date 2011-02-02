<?php


abstract class BaseReaktorArtworkHistoryPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'reaktor_artwork_history';

	
	const CLASS_DEFAULT = 'lib.model.ReaktorArtworkHistory';

	
	const NUM_COLUMNS = 8;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'reaktor_artwork_history.ID';

	
	const ARTWORK_ID = 'reaktor_artwork_history.ARTWORK_ID';

	
	const FILE_ID = 'reaktor_artwork_history.FILE_ID';

	
	const CREATED_AT = 'reaktor_artwork_history.CREATED_AT';

	
	const MODIFIED_FLAG = 'reaktor_artwork_history.MODIFIED_FLAG';

	
	const USER_ID = 'reaktor_artwork_history.USER_ID';

	
	const STATUS = 'reaktor_artwork_history.STATUS';

	
	const COMMENT = 'reaktor_artwork_history.COMMENT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'ArtworkId', 'FileId', 'CreatedAt', 'ModifiedFlag', 'UserId', 'Status', 'Comment', ),
		BasePeer::TYPE_COLNAME => array (ReaktorArtworkHistoryPeer::ID, ReaktorArtworkHistoryPeer::ARTWORK_ID, ReaktorArtworkHistoryPeer::FILE_ID, ReaktorArtworkHistoryPeer::CREATED_AT, ReaktorArtworkHistoryPeer::MODIFIED_FLAG, ReaktorArtworkHistoryPeer::USER_ID, ReaktorArtworkHistoryPeer::STATUS, ReaktorArtworkHistoryPeer::COMMENT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'artwork_id', 'file_id', 'created_at', 'modified_flag', 'user_id', 'status', 'comment', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'ArtworkId' => 1, 'FileId' => 2, 'CreatedAt' => 3, 'ModifiedFlag' => 4, 'UserId' => 5, 'Status' => 6, 'Comment' => 7, ),
		BasePeer::TYPE_COLNAME => array (ReaktorArtworkHistoryPeer::ID => 0, ReaktorArtworkHistoryPeer::ARTWORK_ID => 1, ReaktorArtworkHistoryPeer::FILE_ID => 2, ReaktorArtworkHistoryPeer::CREATED_AT => 3, ReaktorArtworkHistoryPeer::MODIFIED_FLAG => 4, ReaktorArtworkHistoryPeer::USER_ID => 5, ReaktorArtworkHistoryPeer::STATUS => 6, ReaktorArtworkHistoryPeer::COMMENT => 7, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'artwork_id' => 1, 'file_id' => 2, 'created_at' => 3, 'modified_flag' => 4, 'user_id' => 5, 'status' => 6, 'comment' => 7, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ReaktorArtworkHistoryMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ReaktorArtworkHistoryMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ReaktorArtworkHistoryPeer::getTableMap();
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
		return str_replace(ReaktorArtworkHistoryPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::ID);

		$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::ARTWORK_ID);

		$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::FILE_ID);

		$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::CREATED_AT);

		$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::MODIFIED_FLAG);

		$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::USER_ID);

		$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::STATUS);

		$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COMMENT);

	}

	const COUNT = 'COUNT(reaktor_artwork_history.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT reaktor_artwork_history.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ReaktorArtworkHistoryPeer::doSelectRS($criteria, $con);
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
		$objects = ReaktorArtworkHistoryPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ReaktorArtworkHistoryPeer::populateObjects(ReaktorArtworkHistoryPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorArtworkHistoryPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseReaktorArtworkHistoryPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ReaktorArtworkHistoryPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ReaktorArtworkHistoryPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinReaktorArtworkRelatedByArtworkId(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkHistoryPeer::ARTWORK_ID, ReaktorArtworkPeer::ID);

		$rs = ReaktorArtworkHistoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinReaktorArtworkRelatedByFileId(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkHistoryPeer::FILE_ID, ReaktorArtworkPeer::ID);

		$rs = ReaktorArtworkHistoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinsfGuardUser(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkHistoryPeer::USER_ID, sfGuardUserPeer::ID);

		$rs = ReaktorArtworkHistoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinArtworkStatus(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkHistoryPeer::STATUS, ArtworkStatusPeer::ID);

		$rs = ReaktorArtworkHistoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinReaktorArtworkRelatedByArtworkId(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReaktorArtworkHistoryPeer::addSelectColumns($c);
		$startcol = (ReaktorArtworkHistoryPeer::NUM_COLUMNS - ReaktorArtworkHistoryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ReaktorArtworkPeer::addSelectColumns($c);

		$c->addJoin(ReaktorArtworkHistoryPeer::ARTWORK_ID, ReaktorArtworkPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkHistoryPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ReaktorArtworkPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getReaktorArtworkRelatedByArtworkId(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addReaktorArtworkHistoryRelatedByArtworkId($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initReaktorArtworkHistorysRelatedByArtworkId();
				$obj2->addReaktorArtworkHistoryRelatedByArtworkId($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinReaktorArtworkRelatedByFileId(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReaktorArtworkHistoryPeer::addSelectColumns($c);
		$startcol = (ReaktorArtworkHistoryPeer::NUM_COLUMNS - ReaktorArtworkHistoryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ReaktorArtworkPeer::addSelectColumns($c);

		$c->addJoin(ReaktorArtworkHistoryPeer::FILE_ID, ReaktorArtworkPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkHistoryPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ReaktorArtworkPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getReaktorArtworkRelatedByFileId(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addReaktorArtworkHistoryRelatedByFileId($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initReaktorArtworkHistorysRelatedByFileId();
				$obj2->addReaktorArtworkHistoryRelatedByFileId($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinsfGuardUser(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReaktorArtworkHistoryPeer::addSelectColumns($c);
		$startcol = (ReaktorArtworkHistoryPeer::NUM_COLUMNS - ReaktorArtworkHistoryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		sfGuardUserPeer::addSelectColumns($c);

		$c->addJoin(ReaktorArtworkHistoryPeer::USER_ID, sfGuardUserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkHistoryPeer::getOMClass();

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
										$temp_obj2->addReaktorArtworkHistory($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initReaktorArtworkHistorys();
				$obj2->addReaktorArtworkHistory($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinArtworkStatus(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReaktorArtworkHistoryPeer::addSelectColumns($c);
		$startcol = (ReaktorArtworkHistoryPeer::NUM_COLUMNS - ReaktorArtworkHistoryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ArtworkStatusPeer::addSelectColumns($c);

		$c->addJoin(ReaktorArtworkHistoryPeer::STATUS, ArtworkStatusPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkHistoryPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ArtworkStatusPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getArtworkStatus(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addReaktorArtworkHistory($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initReaktorArtworkHistorys();
				$obj2->addReaktorArtworkHistory($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkHistoryPeer::ARTWORK_ID, ReaktorArtworkPeer::ID);

		$criteria->addJoin(ReaktorArtworkHistoryPeer::FILE_ID, ReaktorArtworkPeer::ID);

		$criteria->addJoin(ReaktorArtworkHistoryPeer::USER_ID, sfGuardUserPeer::ID);

		$criteria->addJoin(ReaktorArtworkHistoryPeer::STATUS, ArtworkStatusPeer::ID);

		$rs = ReaktorArtworkHistoryPeer::doSelectRS($criteria, $con);
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

		ReaktorArtworkHistoryPeer::addSelectColumns($c);
		$startcol2 = (ReaktorArtworkHistoryPeer::NUM_COLUMNS - ReaktorArtworkHistoryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ReaktorArtworkPeer::NUM_COLUMNS;

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ReaktorArtworkPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + sfGuardUserPeer::NUM_COLUMNS;

		ArtworkStatusPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + ArtworkStatusPeer::NUM_COLUMNS;

		$c->addJoin(ReaktorArtworkHistoryPeer::ARTWORK_ID, ReaktorArtworkPeer::ID);

		$c->addJoin(ReaktorArtworkHistoryPeer::FILE_ID, ReaktorArtworkPeer::ID);

		$c->addJoin(ReaktorArtworkHistoryPeer::USER_ID, sfGuardUserPeer::ID);

		$c->addJoin(ReaktorArtworkHistoryPeer::STATUS, ArtworkStatusPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkHistoryPeer::getOMClass();


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
				$temp_obj2 = $temp_obj1->getReaktorArtworkRelatedByArtworkId(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addReaktorArtworkHistoryRelatedByArtworkId($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initReaktorArtworkHistorysRelatedByArtworkId();
				$obj2->addReaktorArtworkHistoryRelatedByArtworkId($obj1);
			}


					
			$omClass = ReaktorArtworkPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getReaktorArtworkRelatedByFileId(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addReaktorArtworkHistoryRelatedByFileId($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initReaktorArtworkHistorysRelatedByFileId();
				$obj3->addReaktorArtworkHistoryRelatedByFileId($obj1);
			}


					
			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getsfGuardUser(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addReaktorArtworkHistory($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj4->initReaktorArtworkHistorys();
				$obj4->addReaktorArtworkHistory($obj1);
			}


					
			$omClass = ArtworkStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5 = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getArtworkStatus(); 				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addReaktorArtworkHistory($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj5->initReaktorArtworkHistorys();
				$obj5->addReaktorArtworkHistory($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptReaktorArtworkRelatedByArtworkId(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkHistoryPeer::USER_ID, sfGuardUserPeer::ID);

		$criteria->addJoin(ReaktorArtworkHistoryPeer::STATUS, ArtworkStatusPeer::ID);

		$rs = ReaktorArtworkHistoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptReaktorArtworkRelatedByFileId(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkHistoryPeer::USER_ID, sfGuardUserPeer::ID);

		$criteria->addJoin(ReaktorArtworkHistoryPeer::STATUS, ArtworkStatusPeer::ID);

		$rs = ReaktorArtworkHistoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptsfGuardUser(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkHistoryPeer::ARTWORK_ID, ReaktorArtworkPeer::ID);

		$criteria->addJoin(ReaktorArtworkHistoryPeer::FILE_ID, ReaktorArtworkPeer::ID);

		$criteria->addJoin(ReaktorArtworkHistoryPeer::STATUS, ArtworkStatusPeer::ID);

		$rs = ReaktorArtworkHistoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptArtworkStatus(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkHistoryPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkHistoryPeer::ARTWORK_ID, ReaktorArtworkPeer::ID);

		$criteria->addJoin(ReaktorArtworkHistoryPeer::FILE_ID, ReaktorArtworkPeer::ID);

		$criteria->addJoin(ReaktorArtworkHistoryPeer::USER_ID, sfGuardUserPeer::ID);

		$rs = ReaktorArtworkHistoryPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptReaktorArtworkRelatedByArtworkId(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReaktorArtworkHistoryPeer::addSelectColumns($c);
		$startcol2 = (ReaktorArtworkHistoryPeer::NUM_COLUMNS - ReaktorArtworkHistoryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		ArtworkStatusPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ArtworkStatusPeer::NUM_COLUMNS;

		$c->addJoin(ReaktorArtworkHistoryPeer::USER_ID, sfGuardUserPeer::ID);

		$c->addJoin(ReaktorArtworkHistoryPeer::STATUS, ArtworkStatusPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkHistoryPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfGuardUser(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addReaktorArtworkHistory($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initReaktorArtworkHistorys();
				$obj2->addReaktorArtworkHistory($obj1);
			}

			$omClass = ArtworkStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getArtworkStatus(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addReaktorArtworkHistory($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initReaktorArtworkHistorys();
				$obj3->addReaktorArtworkHistory($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptReaktorArtworkRelatedByFileId(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReaktorArtworkHistoryPeer::addSelectColumns($c);
		$startcol2 = (ReaktorArtworkHistoryPeer::NUM_COLUMNS - ReaktorArtworkHistoryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		ArtworkStatusPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ArtworkStatusPeer::NUM_COLUMNS;

		$c->addJoin(ReaktorArtworkHistoryPeer::USER_ID, sfGuardUserPeer::ID);

		$c->addJoin(ReaktorArtworkHistoryPeer::STATUS, ArtworkStatusPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkHistoryPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfGuardUser(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addReaktorArtworkHistory($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initReaktorArtworkHistorys();
				$obj2->addReaktorArtworkHistory($obj1);
			}

			$omClass = ArtworkStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getArtworkStatus(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addReaktorArtworkHistory($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initReaktorArtworkHistorys();
				$obj3->addReaktorArtworkHistory($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptsfGuardUser(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReaktorArtworkHistoryPeer::addSelectColumns($c);
		$startcol2 = (ReaktorArtworkHistoryPeer::NUM_COLUMNS - ReaktorArtworkHistoryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ReaktorArtworkPeer::NUM_COLUMNS;

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ReaktorArtworkPeer::NUM_COLUMNS;

		ArtworkStatusPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + ArtworkStatusPeer::NUM_COLUMNS;

		$c->addJoin(ReaktorArtworkHistoryPeer::ARTWORK_ID, ReaktorArtworkPeer::ID);

		$c->addJoin(ReaktorArtworkHistoryPeer::FILE_ID, ReaktorArtworkPeer::ID);

		$c->addJoin(ReaktorArtworkHistoryPeer::STATUS, ArtworkStatusPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkHistoryPeer::getOMClass();

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
				$temp_obj2 = $temp_obj1->getReaktorArtworkRelatedByArtworkId(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addReaktorArtworkHistoryRelatedByArtworkId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initReaktorArtworkHistorysRelatedByArtworkId();
				$obj2->addReaktorArtworkHistoryRelatedByArtworkId($obj1);
			}

			$omClass = ReaktorArtworkPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getReaktorArtworkRelatedByFileId(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addReaktorArtworkHistoryRelatedByFileId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initReaktorArtworkHistorysRelatedByFileId();
				$obj3->addReaktorArtworkHistoryRelatedByFileId($obj1);
			}

			$omClass = ArtworkStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getArtworkStatus(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addReaktorArtworkHistory($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initReaktorArtworkHistorys();
				$obj4->addReaktorArtworkHistory($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptArtworkStatus(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReaktorArtworkHistoryPeer::addSelectColumns($c);
		$startcol2 = (ReaktorArtworkHistoryPeer::NUM_COLUMNS - ReaktorArtworkHistoryPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ReaktorArtworkPeer::NUM_COLUMNS;

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ReaktorArtworkPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(ReaktorArtworkHistoryPeer::ARTWORK_ID, ReaktorArtworkPeer::ID);

		$c->addJoin(ReaktorArtworkHistoryPeer::FILE_ID, ReaktorArtworkPeer::ID);

		$c->addJoin(ReaktorArtworkHistoryPeer::USER_ID, sfGuardUserPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkHistoryPeer::getOMClass();

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
				$temp_obj2 = $temp_obj1->getReaktorArtworkRelatedByArtworkId(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addReaktorArtworkHistoryRelatedByArtworkId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initReaktorArtworkHistorysRelatedByArtworkId();
				$obj2->addReaktorArtworkHistoryRelatedByArtworkId($obj1);
			}

			$omClass = ReaktorArtworkPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getReaktorArtworkRelatedByFileId(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addReaktorArtworkHistoryRelatedByFileId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initReaktorArtworkHistorysRelatedByFileId();
				$obj3->addReaktorArtworkHistoryRelatedByFileId($obj1);
			}

			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getsfGuardUser(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addReaktorArtworkHistory($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initReaktorArtworkHistorys();
				$obj4->addReaktorArtworkHistory($obj1);
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
		return ReaktorArtworkHistoryPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorArtworkHistoryPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseReaktorArtworkHistoryPeer', $values, $con);
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

		$criteria->remove(ReaktorArtworkHistoryPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseReaktorArtworkHistoryPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseReaktorArtworkHistoryPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorArtworkHistoryPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseReaktorArtworkHistoryPeer', $values, $con);
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
			$comparison = $criteria->getComparison(ReaktorArtworkHistoryPeer::ID);
			$selectCriteria->add(ReaktorArtworkHistoryPeer::ID, $criteria->remove(ReaktorArtworkHistoryPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseReaktorArtworkHistoryPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseReaktorArtworkHistoryPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(ReaktorArtworkHistoryPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ReaktorArtworkHistoryPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ReaktorArtworkHistory) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ReaktorArtworkHistoryPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(ReaktorArtworkHistory $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ReaktorArtworkHistoryPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ReaktorArtworkHistoryPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ReaktorArtworkHistoryPeer::DATABASE_NAME, ReaktorArtworkHistoryPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ReaktorArtworkHistoryPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(ReaktorArtworkHistoryPeer::DATABASE_NAME);

		$criteria->add(ReaktorArtworkHistoryPeer::ID, $pk);


		$v = ReaktorArtworkHistoryPeer::doSelect($criteria, $con);

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
			$criteria->add(ReaktorArtworkHistoryPeer::ID, $pks, Criteria::IN);
			$objs = ReaktorArtworkHistoryPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseReaktorArtworkHistoryPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ReaktorArtworkHistoryMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ReaktorArtworkHistoryMapBuilder');
}
