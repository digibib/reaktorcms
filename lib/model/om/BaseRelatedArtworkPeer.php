<?php


abstract class BaseRelatedArtworkPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'related_artwork';

	
	const CLASS_DEFAULT = 'lib.model.RelatedArtwork';

	
	const NUM_COLUMNS = 6;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'related_artwork.ID';

	
	const FIRST_ARTWORK = 'related_artwork.FIRST_ARTWORK';

	
	const SECOND_ARTWORK = 'related_artwork.SECOND_ARTWORK';

	
	const CREATED_AT = 'related_artwork.CREATED_AT';

	
	const CREATED_BY = 'related_artwork.CREATED_BY';

	
	const ORDER_BY = 'related_artwork.ORDER_BY';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'FirstArtwork', 'SecondArtwork', 'CreatedAt', 'CreatedBy', 'OrderBy', ),
		BasePeer::TYPE_COLNAME => array (RelatedArtworkPeer::ID, RelatedArtworkPeer::FIRST_ARTWORK, RelatedArtworkPeer::SECOND_ARTWORK, RelatedArtworkPeer::CREATED_AT, RelatedArtworkPeer::CREATED_BY, RelatedArtworkPeer::ORDER_BY, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'first_artwork', 'second_artwork', 'created_at', 'created_by', 'order_by', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'FirstArtwork' => 1, 'SecondArtwork' => 2, 'CreatedAt' => 3, 'CreatedBy' => 4, 'OrderBy' => 5, ),
		BasePeer::TYPE_COLNAME => array (RelatedArtworkPeer::ID => 0, RelatedArtworkPeer::FIRST_ARTWORK => 1, RelatedArtworkPeer::SECOND_ARTWORK => 2, RelatedArtworkPeer::CREATED_AT => 3, RelatedArtworkPeer::CREATED_BY => 4, RelatedArtworkPeer::ORDER_BY => 5, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'first_artwork' => 1, 'second_artwork' => 2, 'created_at' => 3, 'created_by' => 4, 'order_by' => 5, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/RelatedArtworkMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.RelatedArtworkMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = RelatedArtworkPeer::getTableMap();
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
		return str_replace(RelatedArtworkPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(RelatedArtworkPeer::ID);

		$criteria->addSelectColumn(RelatedArtworkPeer::FIRST_ARTWORK);

		$criteria->addSelectColumn(RelatedArtworkPeer::SECOND_ARTWORK);

		$criteria->addSelectColumn(RelatedArtworkPeer::CREATED_AT);

		$criteria->addSelectColumn(RelatedArtworkPeer::CREATED_BY);

		$criteria->addSelectColumn(RelatedArtworkPeer::ORDER_BY);

	}

	const COUNT = 'COUNT(related_artwork.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT related_artwork.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(RelatedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RelatedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = RelatedArtworkPeer::doSelectRS($criteria, $con);
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
		$objects = RelatedArtworkPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return RelatedArtworkPeer::populateObjects(RelatedArtworkPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseRelatedArtworkPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseRelatedArtworkPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			RelatedArtworkPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = RelatedArtworkPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinReaktorArtworkRelatedByFirstArtwork(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(RelatedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RelatedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(RelatedArtworkPeer::FIRST_ARTWORK, ReaktorArtworkPeer::ID);

		$rs = RelatedArtworkPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinReaktorArtworkRelatedBySecondArtwork(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(RelatedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RelatedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(RelatedArtworkPeer::SECOND_ARTWORK, ReaktorArtworkPeer::ID);

		$rs = RelatedArtworkPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(RelatedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RelatedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(RelatedArtworkPeer::CREATED_BY, sfGuardUserPeer::ID);

		$rs = RelatedArtworkPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinReaktorArtworkRelatedByFirstArtwork(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		RelatedArtworkPeer::addSelectColumns($c);
		$startcol = (RelatedArtworkPeer::NUM_COLUMNS - RelatedArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ReaktorArtworkPeer::addSelectColumns($c);

		$c->addJoin(RelatedArtworkPeer::FIRST_ARTWORK, ReaktorArtworkPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = RelatedArtworkPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ReaktorArtworkPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getReaktorArtworkRelatedByFirstArtwork(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addRelatedArtworkRelatedByFirstArtwork($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initRelatedArtworksRelatedByFirstArtwork();
				$obj2->addRelatedArtworkRelatedByFirstArtwork($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinReaktorArtworkRelatedBySecondArtwork(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		RelatedArtworkPeer::addSelectColumns($c);
		$startcol = (RelatedArtworkPeer::NUM_COLUMNS - RelatedArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ReaktorArtworkPeer::addSelectColumns($c);

		$c->addJoin(RelatedArtworkPeer::SECOND_ARTWORK, ReaktorArtworkPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = RelatedArtworkPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ReaktorArtworkPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getReaktorArtworkRelatedBySecondArtwork(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addRelatedArtworkRelatedBySecondArtwork($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initRelatedArtworksRelatedBySecondArtwork();
				$obj2->addRelatedArtworkRelatedBySecondArtwork($obj1); 			}
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

		RelatedArtworkPeer::addSelectColumns($c);
		$startcol = (RelatedArtworkPeer::NUM_COLUMNS - RelatedArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		sfGuardUserPeer::addSelectColumns($c);

		$c->addJoin(RelatedArtworkPeer::CREATED_BY, sfGuardUserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = RelatedArtworkPeer::getOMClass();

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
										$temp_obj2->addRelatedArtwork($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initRelatedArtworks();
				$obj2->addRelatedArtwork($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(RelatedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RelatedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(RelatedArtworkPeer::FIRST_ARTWORK, ReaktorArtworkPeer::ID);

		$criteria->addJoin(RelatedArtworkPeer::SECOND_ARTWORK, ReaktorArtworkPeer::ID);

		$criteria->addJoin(RelatedArtworkPeer::CREATED_BY, sfGuardUserPeer::ID);

		$rs = RelatedArtworkPeer::doSelectRS($criteria, $con);
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

		RelatedArtworkPeer::addSelectColumns($c);
		$startcol2 = (RelatedArtworkPeer::NUM_COLUMNS - RelatedArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ReaktorArtworkPeer::NUM_COLUMNS;

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ReaktorArtworkPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(RelatedArtworkPeer::FIRST_ARTWORK, ReaktorArtworkPeer::ID);

		$c->addJoin(RelatedArtworkPeer::SECOND_ARTWORK, ReaktorArtworkPeer::ID);

		$c->addJoin(RelatedArtworkPeer::CREATED_BY, sfGuardUserPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = RelatedArtworkPeer::getOMClass();


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
				$temp_obj2 = $temp_obj1->getReaktorArtworkRelatedByFirstArtwork(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addRelatedArtworkRelatedByFirstArtwork($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initRelatedArtworksRelatedByFirstArtwork();
				$obj2->addRelatedArtworkRelatedByFirstArtwork($obj1);
			}


					
			$omClass = ReaktorArtworkPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getReaktorArtworkRelatedBySecondArtwork(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addRelatedArtworkRelatedBySecondArtwork($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initRelatedArtworksRelatedBySecondArtwork();
				$obj3->addRelatedArtworkRelatedBySecondArtwork($obj1);
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
					$temp_obj4->addRelatedArtwork($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj4->initRelatedArtworks();
				$obj4->addRelatedArtwork($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptReaktorArtworkRelatedByFirstArtwork(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(RelatedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RelatedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(RelatedArtworkPeer::CREATED_BY, sfGuardUserPeer::ID);

		$rs = RelatedArtworkPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptReaktorArtworkRelatedBySecondArtwork(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(RelatedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RelatedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(RelatedArtworkPeer::CREATED_BY, sfGuardUserPeer::ID);

		$rs = RelatedArtworkPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(RelatedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RelatedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(RelatedArtworkPeer::FIRST_ARTWORK, ReaktorArtworkPeer::ID);

		$criteria->addJoin(RelatedArtworkPeer::SECOND_ARTWORK, ReaktorArtworkPeer::ID);

		$rs = RelatedArtworkPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptReaktorArtworkRelatedByFirstArtwork(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		RelatedArtworkPeer::addSelectColumns($c);
		$startcol2 = (RelatedArtworkPeer::NUM_COLUMNS - RelatedArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(RelatedArtworkPeer::CREATED_BY, sfGuardUserPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = RelatedArtworkPeer::getOMClass();

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
					$temp_obj2->addRelatedArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initRelatedArtworks();
				$obj2->addRelatedArtwork($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptReaktorArtworkRelatedBySecondArtwork(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		RelatedArtworkPeer::addSelectColumns($c);
		$startcol2 = (RelatedArtworkPeer::NUM_COLUMNS - RelatedArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(RelatedArtworkPeer::CREATED_BY, sfGuardUserPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = RelatedArtworkPeer::getOMClass();

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
					$temp_obj2->addRelatedArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initRelatedArtworks();
				$obj2->addRelatedArtwork($obj1);
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

		RelatedArtworkPeer::addSelectColumns($c);
		$startcol2 = (RelatedArtworkPeer::NUM_COLUMNS - RelatedArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ReaktorArtworkPeer::NUM_COLUMNS;

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ReaktorArtworkPeer::NUM_COLUMNS;

		$c->addJoin(RelatedArtworkPeer::FIRST_ARTWORK, ReaktorArtworkPeer::ID);

		$c->addJoin(RelatedArtworkPeer::SECOND_ARTWORK, ReaktorArtworkPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = RelatedArtworkPeer::getOMClass();

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
				$temp_obj2 = $temp_obj1->getReaktorArtworkRelatedByFirstArtwork(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addRelatedArtworkRelatedByFirstArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initRelatedArtworksRelatedByFirstArtwork();
				$obj2->addRelatedArtworkRelatedByFirstArtwork($obj1);
			}

			$omClass = ReaktorArtworkPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getReaktorArtworkRelatedBySecondArtwork(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addRelatedArtworkRelatedBySecondArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initRelatedArtworksRelatedBySecondArtwork();
				$obj3->addRelatedArtworkRelatedBySecondArtwork($obj1);
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
		return RelatedArtworkPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseRelatedArtworkPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseRelatedArtworkPeer', $values, $con);
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

		$criteria->remove(RelatedArtworkPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseRelatedArtworkPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseRelatedArtworkPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseRelatedArtworkPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseRelatedArtworkPeer', $values, $con);
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
			$comparison = $criteria->getComparison(RelatedArtworkPeer::ID);
			$selectCriteria->add(RelatedArtworkPeer::ID, $criteria->remove(RelatedArtworkPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseRelatedArtworkPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseRelatedArtworkPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(RelatedArtworkPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(RelatedArtworkPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof RelatedArtwork) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(RelatedArtworkPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(RelatedArtwork $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(RelatedArtworkPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(RelatedArtworkPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(RelatedArtworkPeer::DATABASE_NAME, RelatedArtworkPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = RelatedArtworkPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(RelatedArtworkPeer::DATABASE_NAME);

		$criteria->add(RelatedArtworkPeer::ID, $pk);


		$v = RelatedArtworkPeer::doSelect($criteria, $con);

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
			$criteria->add(RelatedArtworkPeer::ID, $pks, Criteria::IN);
			$objs = RelatedArtworkPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseRelatedArtworkPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/RelatedArtworkMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.RelatedArtworkMapBuilder');
}
