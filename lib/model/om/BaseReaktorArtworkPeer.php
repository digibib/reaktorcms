<?php


abstract class BaseReaktorArtworkPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'reaktor_artwork';

	
	const CLASS_DEFAULT = 'lib.model.ReaktorArtwork';

	
	const NUM_COLUMNS = 19;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'reaktor_artwork.ID';

	
	const USER_ID = 'reaktor_artwork.USER_ID';

	
	const ARTWORK_IDENTIFIER = 'reaktor_artwork.ARTWORK_IDENTIFIER';

	
	const CREATED_AT = 'reaktor_artwork.CREATED_AT';

	
	const SUBMITTED_AT = 'reaktor_artwork.SUBMITTED_AT';

	
	const ACTIONED_AT = 'reaktor_artwork.ACTIONED_AT';

	
	const MODIFIED_FLAG = 'reaktor_artwork.MODIFIED_FLAG';

	
	const TITLE = 'reaktor_artwork.TITLE';

	
	const ACTIONED_BY = 'reaktor_artwork.ACTIONED_BY';

	
	const STATUS = 'reaktor_artwork.STATUS';

	
	const DESCRIPTION = 'reaktor_artwork.DESCRIPTION';

	
	const MODIFIED_NOTE = 'reaktor_artwork.MODIFIED_NOTE';

	
	const ARTWORK_ORDER = 'reaktor_artwork.ARTWORK_ORDER';

	
	const AVERAGE_RATING = 'reaktor_artwork.AVERAGE_RATING';

	
	const TEAM_ID = 'reaktor_artwork.TEAM_ID';

	
	const UNDER_DISCUSSION = 'reaktor_artwork.UNDER_DISCUSSION';

	
	const MULTI_USER = 'reaktor_artwork.MULTI_USER';

	
	const FIRST_FILE_ID = 'reaktor_artwork.FIRST_FILE_ID';

	
	const DELETED = 'reaktor_artwork.DELETED';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'UserId', 'ArtworkIdentifier', 'CreatedAt', 'SubmittedAt', 'ActionedAt', 'ModifiedFlag', 'Title', 'ActionedBy', 'Status', 'Description', 'ModifiedNote', 'ArtworkOrder', 'AverageRating', 'TeamId', 'UnderDiscussion', 'MultiUser', 'FirstFileId', 'Deleted', ),
		BasePeer::TYPE_COLNAME => array (ReaktorArtworkPeer::ID, ReaktorArtworkPeer::USER_ID, ReaktorArtworkPeer::ARTWORK_IDENTIFIER, ReaktorArtworkPeer::CREATED_AT, ReaktorArtworkPeer::SUBMITTED_AT, ReaktorArtworkPeer::ACTIONED_AT, ReaktorArtworkPeer::MODIFIED_FLAG, ReaktorArtworkPeer::TITLE, ReaktorArtworkPeer::ACTIONED_BY, ReaktorArtworkPeer::STATUS, ReaktorArtworkPeer::DESCRIPTION, ReaktorArtworkPeer::MODIFIED_NOTE, ReaktorArtworkPeer::ARTWORK_ORDER, ReaktorArtworkPeer::AVERAGE_RATING, ReaktorArtworkPeer::TEAM_ID, ReaktorArtworkPeer::UNDER_DISCUSSION, ReaktorArtworkPeer::MULTI_USER, ReaktorArtworkPeer::FIRST_FILE_ID, ReaktorArtworkPeer::DELETED, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'user_id', 'artwork_identifier', 'created_at', 'submitted_at', 'actioned_at', 'modified_flag', 'title', 'actioned_by', 'status', 'description', 'modified_note', 'artwork_order', 'average_rating', 'team_id', 'under_discussion', 'multi_user', 'first_file_id', 'deleted', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'UserId' => 1, 'ArtworkIdentifier' => 2, 'CreatedAt' => 3, 'SubmittedAt' => 4, 'ActionedAt' => 5, 'ModifiedFlag' => 6, 'Title' => 7, 'ActionedBy' => 8, 'Status' => 9, 'Description' => 10, 'ModifiedNote' => 11, 'ArtworkOrder' => 12, 'AverageRating' => 13, 'TeamId' => 14, 'UnderDiscussion' => 15, 'MultiUser' => 16, 'FirstFileId' => 17, 'Deleted' => 18, ),
		BasePeer::TYPE_COLNAME => array (ReaktorArtworkPeer::ID => 0, ReaktorArtworkPeer::USER_ID => 1, ReaktorArtworkPeer::ARTWORK_IDENTIFIER => 2, ReaktorArtworkPeer::CREATED_AT => 3, ReaktorArtworkPeer::SUBMITTED_AT => 4, ReaktorArtworkPeer::ACTIONED_AT => 5, ReaktorArtworkPeer::MODIFIED_FLAG => 6, ReaktorArtworkPeer::TITLE => 7, ReaktorArtworkPeer::ACTIONED_BY => 8, ReaktorArtworkPeer::STATUS => 9, ReaktorArtworkPeer::DESCRIPTION => 10, ReaktorArtworkPeer::MODIFIED_NOTE => 11, ReaktorArtworkPeer::ARTWORK_ORDER => 12, ReaktorArtworkPeer::AVERAGE_RATING => 13, ReaktorArtworkPeer::TEAM_ID => 14, ReaktorArtworkPeer::UNDER_DISCUSSION => 15, ReaktorArtworkPeer::MULTI_USER => 16, ReaktorArtworkPeer::FIRST_FILE_ID => 17, ReaktorArtworkPeer::DELETED => 18, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'user_id' => 1, 'artwork_identifier' => 2, 'created_at' => 3, 'submitted_at' => 4, 'actioned_at' => 5, 'modified_flag' => 6, 'title' => 7, 'actioned_by' => 8, 'status' => 9, 'description' => 10, 'modified_note' => 11, 'artwork_order' => 12, 'average_rating' => 13, 'team_id' => 14, 'under_discussion' => 15, 'multi_user' => 16, 'first_file_id' => 17, 'deleted' => 18, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ReaktorArtworkMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ReaktorArtworkMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ReaktorArtworkPeer::getTableMap();
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
		return str_replace(ReaktorArtworkPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ReaktorArtworkPeer::ID);

		$criteria->addSelectColumn(ReaktorArtworkPeer::USER_ID);

		$criteria->addSelectColumn(ReaktorArtworkPeer::ARTWORK_IDENTIFIER);

		$criteria->addSelectColumn(ReaktorArtworkPeer::CREATED_AT);

		$criteria->addSelectColumn(ReaktorArtworkPeer::SUBMITTED_AT);

		$criteria->addSelectColumn(ReaktorArtworkPeer::ACTIONED_AT);

		$criteria->addSelectColumn(ReaktorArtworkPeer::MODIFIED_FLAG);

		$criteria->addSelectColumn(ReaktorArtworkPeer::TITLE);

		$criteria->addSelectColumn(ReaktorArtworkPeer::ACTIONED_BY);

		$criteria->addSelectColumn(ReaktorArtworkPeer::STATUS);

		$criteria->addSelectColumn(ReaktorArtworkPeer::DESCRIPTION);

		$criteria->addSelectColumn(ReaktorArtworkPeer::MODIFIED_NOTE);

		$criteria->addSelectColumn(ReaktorArtworkPeer::ARTWORK_ORDER);

		$criteria->addSelectColumn(ReaktorArtworkPeer::AVERAGE_RATING);

		$criteria->addSelectColumn(ReaktorArtworkPeer::TEAM_ID);

		$criteria->addSelectColumn(ReaktorArtworkPeer::UNDER_DISCUSSION);

		$criteria->addSelectColumn(ReaktorArtworkPeer::MULTI_USER);

		$criteria->addSelectColumn(ReaktorArtworkPeer::FIRST_FILE_ID);

		$criteria->addSelectColumn(ReaktorArtworkPeer::DELETED);

	}

	const COUNT = 'COUNT(reaktor_artwork.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT reaktor_artwork.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ReaktorArtworkPeer::doSelectRS($criteria, $con);
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
		$objects = ReaktorArtworkPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ReaktorArtworkPeer::populateObjects(ReaktorArtworkPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorArtworkPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseReaktorArtworkPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ReaktorArtworkPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ReaktorArtworkPeer::getOMClass();
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
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::ID);

		$rs = ReaktorArtworkPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkPeer::STATUS, ArtworkStatusPeer::ID);

		$rs = ReaktorArtworkPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinsfGuardGroup(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkPeer::TEAM_ID, sfGuardGroupPeer::ID);

		$rs = ReaktorArtworkPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkPeer::FIRST_FILE_ID, ReaktorFilePeer::ID);

		$rs = ReaktorArtworkPeer::doSelectRS($criteria, $con);
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

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol = (ReaktorArtworkPeer::NUM_COLUMNS - ReaktorArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		sfGuardUserPeer::addSelectColumns($c);

		$c->addJoin(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkPeer::getOMClass();

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
										$temp_obj2->addReaktorArtwork($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initReaktorArtworks();
				$obj2->addReaktorArtwork($obj1); 			}
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

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol = (ReaktorArtworkPeer::NUM_COLUMNS - ReaktorArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ArtworkStatusPeer::addSelectColumns($c);

		$c->addJoin(ReaktorArtworkPeer::STATUS, ArtworkStatusPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkPeer::getOMClass();

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
										$temp_obj2->addReaktorArtwork($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initReaktorArtworks();
				$obj2->addReaktorArtwork($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinsfGuardGroup(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol = (ReaktorArtworkPeer::NUM_COLUMNS - ReaktorArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		sfGuardGroupPeer::addSelectColumns($c);

		$c->addJoin(ReaktorArtworkPeer::TEAM_ID, sfGuardGroupPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfGuardGroupPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getsfGuardGroup(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addReaktorArtwork($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initReaktorArtworks();
				$obj2->addReaktorArtwork($obj1); 			}
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

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol = (ReaktorArtworkPeer::NUM_COLUMNS - ReaktorArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ReaktorFilePeer::addSelectColumns($c);

		$c->addJoin(ReaktorArtworkPeer::FIRST_FILE_ID, ReaktorFilePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkPeer::getOMClass();

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
										$temp_obj2->addReaktorArtwork($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initReaktorArtworks();
				$obj2->addReaktorArtwork($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::ID);

		$criteria->addJoin(ReaktorArtworkPeer::STATUS, ArtworkStatusPeer::ID);

		$criteria->addJoin(ReaktorArtworkPeer::TEAM_ID, sfGuardGroupPeer::ID);

		$criteria->addJoin(ReaktorArtworkPeer::FIRST_FILE_ID, ReaktorFilePeer::ID);

		$rs = ReaktorArtworkPeer::doSelectRS($criteria, $con);
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

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol2 = (ReaktorArtworkPeer::NUM_COLUMNS - ReaktorArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		ArtworkStatusPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ArtworkStatusPeer::NUM_COLUMNS;

		sfGuardGroupPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + sfGuardGroupPeer::NUM_COLUMNS;

		ReaktorFilePeer::addSelectColumns($c);
		$startcol6 = $startcol5 + ReaktorFilePeer::NUM_COLUMNS;

		$c->addJoin(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::ID);

		$c->addJoin(ReaktorArtworkPeer::STATUS, ArtworkStatusPeer::ID);

		$c->addJoin(ReaktorArtworkPeer::TEAM_ID, sfGuardGroupPeer::ID);

		$c->addJoin(ReaktorArtworkPeer::FIRST_FILE_ID, ReaktorFilePeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkPeer::getOMClass();


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
					$temp_obj2->addReaktorArtwork($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initReaktorArtworks();
				$obj2->addReaktorArtwork($obj1);
			}


					
			$omClass = ArtworkStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getArtworkStatus(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addReaktorArtwork($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initReaktorArtworks();
				$obj3->addReaktorArtwork($obj1);
			}


					
			$omClass = sfGuardGroupPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getsfGuardGroup(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addReaktorArtwork($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj4->initReaktorArtworks();
				$obj4->addReaktorArtwork($obj1);
			}


					
			$omClass = ReaktorFilePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5 = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getReaktorFile(); 				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addReaktorArtwork($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj5->initReaktorArtworks();
				$obj5->addReaktorArtwork($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptsfGuardUser(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkPeer::STATUS, ArtworkStatusPeer::ID);

		$criteria->addJoin(ReaktorArtworkPeer::TEAM_ID, sfGuardGroupPeer::ID);

		$criteria->addJoin(ReaktorArtworkPeer::FIRST_FILE_ID, ReaktorFilePeer::ID);

		$rs = ReaktorArtworkPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::ID);

		$criteria->addJoin(ReaktorArtworkPeer::TEAM_ID, sfGuardGroupPeer::ID);

		$criteria->addJoin(ReaktorArtworkPeer::FIRST_FILE_ID, ReaktorFilePeer::ID);

		$rs = ReaktorArtworkPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptsfGuardGroup(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::ID);

		$criteria->addJoin(ReaktorArtworkPeer::STATUS, ArtworkStatusPeer::ID);

		$criteria->addJoin(ReaktorArtworkPeer::FIRST_FILE_ID, ReaktorFilePeer::ID);

		$rs = ReaktorArtworkPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ReaktorArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::ID);

		$criteria->addJoin(ReaktorArtworkPeer::STATUS, ArtworkStatusPeer::ID);

		$criteria->addJoin(ReaktorArtworkPeer::TEAM_ID, sfGuardGroupPeer::ID);

		$rs = ReaktorArtworkPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptsfGuardUser(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol2 = (ReaktorArtworkPeer::NUM_COLUMNS - ReaktorArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ArtworkStatusPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ArtworkStatusPeer::NUM_COLUMNS;

		sfGuardGroupPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfGuardGroupPeer::NUM_COLUMNS;

		ReaktorFilePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + ReaktorFilePeer::NUM_COLUMNS;

		$c->addJoin(ReaktorArtworkPeer::STATUS, ArtworkStatusPeer::ID);

		$c->addJoin(ReaktorArtworkPeer::TEAM_ID, sfGuardGroupPeer::ID);

		$c->addJoin(ReaktorArtworkPeer::FIRST_FILE_ID, ReaktorFilePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ArtworkStatusPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getArtworkStatus(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addReaktorArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initReaktorArtworks();
				$obj2->addReaktorArtwork($obj1);
			}

			$omClass = sfGuardGroupPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfGuardGroup(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addReaktorArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initReaktorArtworks();
				$obj3->addReaktorArtwork($obj1);
			}

			$omClass = ReaktorFilePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getReaktorFile(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addReaktorArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initReaktorArtworks();
				$obj4->addReaktorArtwork($obj1);
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

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol2 = (ReaktorArtworkPeer::NUM_COLUMNS - ReaktorArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		sfGuardGroupPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfGuardGroupPeer::NUM_COLUMNS;

		ReaktorFilePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + ReaktorFilePeer::NUM_COLUMNS;

		$c->addJoin(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::ID);

		$c->addJoin(ReaktorArtworkPeer::TEAM_ID, sfGuardGroupPeer::ID);

		$c->addJoin(ReaktorArtworkPeer::FIRST_FILE_ID, ReaktorFilePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkPeer::getOMClass();

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
					$temp_obj2->addReaktorArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initReaktorArtworks();
				$obj2->addReaktorArtwork($obj1);
			}

			$omClass = sfGuardGroupPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfGuardGroup(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addReaktorArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initReaktorArtworks();
				$obj3->addReaktorArtwork($obj1);
			}

			$omClass = ReaktorFilePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getReaktorFile(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addReaktorArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initReaktorArtworks();
				$obj4->addReaktorArtwork($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptsfGuardGroup(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol2 = (ReaktorArtworkPeer::NUM_COLUMNS - ReaktorArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		ArtworkStatusPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ArtworkStatusPeer::NUM_COLUMNS;

		ReaktorFilePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + ReaktorFilePeer::NUM_COLUMNS;

		$c->addJoin(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::ID);

		$c->addJoin(ReaktorArtworkPeer::STATUS, ArtworkStatusPeer::ID);

		$c->addJoin(ReaktorArtworkPeer::FIRST_FILE_ID, ReaktorFilePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkPeer::getOMClass();

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
					$temp_obj2->addReaktorArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initReaktorArtworks();
				$obj2->addReaktorArtwork($obj1);
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
					$temp_obj3->addReaktorArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initReaktorArtworks();
				$obj3->addReaktorArtwork($obj1);
			}

			$omClass = ReaktorFilePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getReaktorFile(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addReaktorArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initReaktorArtworks();
				$obj4->addReaktorArtwork($obj1);
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

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol2 = (ReaktorArtworkPeer::NUM_COLUMNS - ReaktorArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		ArtworkStatusPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ArtworkStatusPeer::NUM_COLUMNS;

		sfGuardGroupPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + sfGuardGroupPeer::NUM_COLUMNS;

		$c->addJoin(ReaktorArtworkPeer::USER_ID, sfGuardUserPeer::ID);

		$c->addJoin(ReaktorArtworkPeer::STATUS, ArtworkStatusPeer::ID);

		$c->addJoin(ReaktorArtworkPeer::TEAM_ID, sfGuardGroupPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ReaktorArtworkPeer::getOMClass();

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
					$temp_obj2->addReaktorArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initReaktorArtworks();
				$obj2->addReaktorArtwork($obj1);
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
					$temp_obj3->addReaktorArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initReaktorArtworks();
				$obj3->addReaktorArtwork($obj1);
			}

			$omClass = sfGuardGroupPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getsfGuardGroup(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addReaktorArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initReaktorArtworks();
				$obj4->addReaktorArtwork($obj1);
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
		return ReaktorArtworkPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorArtworkPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseReaktorArtworkPeer', $values, $con);
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

		$criteria->remove(ReaktorArtworkPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseReaktorArtworkPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseReaktorArtworkPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseReaktorArtworkPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseReaktorArtworkPeer', $values, $con);
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
			$comparison = $criteria->getComparison(ReaktorArtworkPeer::ID);
			$selectCriteria->add(ReaktorArtworkPeer::ID, $criteria->remove(ReaktorArtworkPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseReaktorArtworkPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseReaktorArtworkPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(ReaktorArtworkPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ReaktorArtworkPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ReaktorArtwork) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ReaktorArtworkPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(ReaktorArtwork $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ReaktorArtworkPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ReaktorArtworkPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ReaktorArtworkPeer::DATABASE_NAME, ReaktorArtworkPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ReaktorArtworkPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(ReaktorArtworkPeer::DATABASE_NAME);

		$criteria->add(ReaktorArtworkPeer::ID, $pk);


		$v = ReaktorArtworkPeer::doSelect($criteria, $con);

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
			$criteria->add(ReaktorArtworkPeer::ID, $pks, Criteria::IN);
			$objs = ReaktorArtworkPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseReaktorArtworkPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ReaktorArtworkMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ReaktorArtworkMapBuilder');
}
