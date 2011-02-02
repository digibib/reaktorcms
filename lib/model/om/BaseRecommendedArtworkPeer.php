<?php


abstract class BaseRecommendedArtworkPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'recommended_artwork';

	
	const CLASS_DEFAULT = 'lib.model.RecommendedArtwork';

	
	const NUM_COLUMNS = 6;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'recommended_artwork.ID';

	
	const ARTWORK = 'recommended_artwork.ARTWORK';

	
	const SUBREAKTOR = 'recommended_artwork.SUBREAKTOR';

	
	const LOCALSUBREAKTOR = 'recommended_artwork.LOCALSUBREAKTOR';

	
	const UPDATED_BY = 'recommended_artwork.UPDATED_BY';

	
	const UPDATED_AT = 'recommended_artwork.UPDATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Artwork', 'Subreaktor', 'Localsubreaktor', 'UpdatedBy', 'UpdatedAt', ),
		BasePeer::TYPE_COLNAME => array (RecommendedArtworkPeer::ID, RecommendedArtworkPeer::ARTWORK, RecommendedArtworkPeer::SUBREAKTOR, RecommendedArtworkPeer::LOCALSUBREAKTOR, RecommendedArtworkPeer::UPDATED_BY, RecommendedArtworkPeer::UPDATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'artwork', 'subreaktor', 'localsubreaktor', 'updated_by', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Artwork' => 1, 'Subreaktor' => 2, 'Localsubreaktor' => 3, 'UpdatedBy' => 4, 'UpdatedAt' => 5, ),
		BasePeer::TYPE_COLNAME => array (RecommendedArtworkPeer::ID => 0, RecommendedArtworkPeer::ARTWORK => 1, RecommendedArtworkPeer::SUBREAKTOR => 2, RecommendedArtworkPeer::LOCALSUBREAKTOR => 3, RecommendedArtworkPeer::UPDATED_BY => 4, RecommendedArtworkPeer::UPDATED_AT => 5, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'artwork' => 1, 'subreaktor' => 2, 'localsubreaktor' => 3, 'updated_by' => 4, 'updated_at' => 5, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/RecommendedArtworkMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.RecommendedArtworkMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = RecommendedArtworkPeer::getTableMap();
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
		return str_replace(RecommendedArtworkPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(RecommendedArtworkPeer::ID);

		$criteria->addSelectColumn(RecommendedArtworkPeer::ARTWORK);

		$criteria->addSelectColumn(RecommendedArtworkPeer::SUBREAKTOR);

		$criteria->addSelectColumn(RecommendedArtworkPeer::LOCALSUBREAKTOR);

		$criteria->addSelectColumn(RecommendedArtworkPeer::UPDATED_BY);

		$criteria->addSelectColumn(RecommendedArtworkPeer::UPDATED_AT);

	}

	const COUNT = 'COUNT(recommended_artwork.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT recommended_artwork.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = RecommendedArtworkPeer::doSelectRS($criteria, $con);
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
		$objects = RecommendedArtworkPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return RecommendedArtworkPeer::populateObjects(RecommendedArtworkPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseRecommendedArtworkPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseRecommendedArtworkPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			RecommendedArtworkPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = RecommendedArtworkPeer::getOMClass();
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
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(RecommendedArtworkPeer::ARTWORK, ReaktorArtworkPeer::ID);

		$rs = RecommendedArtworkPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinSubreaktorRelatedBySubreaktor(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(RecommendedArtworkPeer::SUBREAKTOR, SubreaktorPeer::ID);

		$rs = RecommendedArtworkPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinSubreaktorRelatedByLocalsubreaktor(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(RecommendedArtworkPeer::LOCALSUBREAKTOR, SubreaktorPeer::ID);

		$rs = RecommendedArtworkPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(RecommendedArtworkPeer::UPDATED_BY, sfGuardUserPeer::ID);

		$rs = RecommendedArtworkPeer::doSelectRS($criteria, $con);
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

		RecommendedArtworkPeer::addSelectColumns($c);
		$startcol = (RecommendedArtworkPeer::NUM_COLUMNS - RecommendedArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ReaktorArtworkPeer::addSelectColumns($c);

		$c->addJoin(RecommendedArtworkPeer::ARTWORK, ReaktorArtworkPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = RecommendedArtworkPeer::getOMClass();

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
										$temp_obj2->addRecommendedArtwork($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initRecommendedArtworks();
				$obj2->addRecommendedArtwork($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinSubreaktorRelatedBySubreaktor(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		RecommendedArtworkPeer::addSelectColumns($c);
		$startcol = (RecommendedArtworkPeer::NUM_COLUMNS - RecommendedArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		SubreaktorPeer::addSelectColumns($c);

		$c->addJoin(RecommendedArtworkPeer::SUBREAKTOR, SubreaktorPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = RecommendedArtworkPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = SubreaktorPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getSubreaktorRelatedBySubreaktor(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addRecommendedArtworkRelatedBySubreaktor($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initRecommendedArtworksRelatedBySubreaktor();
				$obj2->addRecommendedArtworkRelatedBySubreaktor($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinSubreaktorRelatedByLocalsubreaktor(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		RecommendedArtworkPeer::addSelectColumns($c);
		$startcol = (RecommendedArtworkPeer::NUM_COLUMNS - RecommendedArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		SubreaktorPeer::addSelectColumns($c);

		$c->addJoin(RecommendedArtworkPeer::LOCALSUBREAKTOR, SubreaktorPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = RecommendedArtworkPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = SubreaktorPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getSubreaktorRelatedByLocalsubreaktor(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addRecommendedArtworkRelatedByLocalsubreaktor($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initRecommendedArtworksRelatedByLocalsubreaktor();
				$obj2->addRecommendedArtworkRelatedByLocalsubreaktor($obj1); 			}
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

		RecommendedArtworkPeer::addSelectColumns($c);
		$startcol = (RecommendedArtworkPeer::NUM_COLUMNS - RecommendedArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		sfGuardUserPeer::addSelectColumns($c);

		$c->addJoin(RecommendedArtworkPeer::UPDATED_BY, sfGuardUserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = RecommendedArtworkPeer::getOMClass();

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
										$temp_obj2->addRecommendedArtwork($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initRecommendedArtworks();
				$obj2->addRecommendedArtwork($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(RecommendedArtworkPeer::ARTWORK, ReaktorArtworkPeer::ID);

		$criteria->addJoin(RecommendedArtworkPeer::SUBREAKTOR, SubreaktorPeer::ID);

		$criteria->addJoin(RecommendedArtworkPeer::LOCALSUBREAKTOR, SubreaktorPeer::ID);

		$criteria->addJoin(RecommendedArtworkPeer::UPDATED_BY, sfGuardUserPeer::ID);

		$rs = RecommendedArtworkPeer::doSelectRS($criteria, $con);
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

		RecommendedArtworkPeer::addSelectColumns($c);
		$startcol2 = (RecommendedArtworkPeer::NUM_COLUMNS - RecommendedArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ReaktorArtworkPeer::NUM_COLUMNS;

		SubreaktorPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + SubreaktorPeer::NUM_COLUMNS;

		SubreaktorPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + SubreaktorPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(RecommendedArtworkPeer::ARTWORK, ReaktorArtworkPeer::ID);

		$c->addJoin(RecommendedArtworkPeer::SUBREAKTOR, SubreaktorPeer::ID);

		$c->addJoin(RecommendedArtworkPeer::LOCALSUBREAKTOR, SubreaktorPeer::ID);

		$c->addJoin(RecommendedArtworkPeer::UPDATED_BY, sfGuardUserPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = RecommendedArtworkPeer::getOMClass();


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
					$temp_obj2->addRecommendedArtwork($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initRecommendedArtworks();
				$obj2->addRecommendedArtwork($obj1);
			}


					
			$omClass = SubreaktorPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getSubreaktorRelatedBySubreaktor(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addRecommendedArtworkRelatedBySubreaktor($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initRecommendedArtworksRelatedBySubreaktor();
				$obj3->addRecommendedArtworkRelatedBySubreaktor($obj1);
			}


					
			$omClass = SubreaktorPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getSubreaktorRelatedByLocalsubreaktor(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addRecommendedArtworkRelatedByLocalsubreaktor($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj4->initRecommendedArtworksRelatedByLocalsubreaktor();
				$obj4->addRecommendedArtworkRelatedByLocalsubreaktor($obj1);
			}


					
			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5 = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getsfGuardUser(); 				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addRecommendedArtwork($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj5->initRecommendedArtworks();
				$obj5->addRecommendedArtwork($obj1);
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
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(RecommendedArtworkPeer::SUBREAKTOR, SubreaktorPeer::ID);

		$criteria->addJoin(RecommendedArtworkPeer::LOCALSUBREAKTOR, SubreaktorPeer::ID);

		$criteria->addJoin(RecommendedArtworkPeer::UPDATED_BY, sfGuardUserPeer::ID);

		$rs = RecommendedArtworkPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptSubreaktorRelatedBySubreaktor(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(RecommendedArtworkPeer::ARTWORK, ReaktorArtworkPeer::ID);

		$criteria->addJoin(RecommendedArtworkPeer::UPDATED_BY, sfGuardUserPeer::ID);

		$rs = RecommendedArtworkPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptSubreaktorRelatedByLocalsubreaktor(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(RecommendedArtworkPeer::ARTWORK, ReaktorArtworkPeer::ID);

		$criteria->addJoin(RecommendedArtworkPeer::UPDATED_BY, sfGuardUserPeer::ID);

		$rs = RecommendedArtworkPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(RecommendedArtworkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(RecommendedArtworkPeer::ARTWORK, ReaktorArtworkPeer::ID);

		$criteria->addJoin(RecommendedArtworkPeer::SUBREAKTOR, SubreaktorPeer::ID);

		$criteria->addJoin(RecommendedArtworkPeer::LOCALSUBREAKTOR, SubreaktorPeer::ID);

		$rs = RecommendedArtworkPeer::doSelectRS($criteria, $con);
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

		RecommendedArtworkPeer::addSelectColumns($c);
		$startcol2 = (RecommendedArtworkPeer::NUM_COLUMNS - RecommendedArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		SubreaktorPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + SubreaktorPeer::NUM_COLUMNS;

		SubreaktorPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + SubreaktorPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(RecommendedArtworkPeer::SUBREAKTOR, SubreaktorPeer::ID);

		$c->addJoin(RecommendedArtworkPeer::LOCALSUBREAKTOR, SubreaktorPeer::ID);

		$c->addJoin(RecommendedArtworkPeer::UPDATED_BY, sfGuardUserPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = RecommendedArtworkPeer::getOMClass();

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
				$temp_obj2 = $temp_obj1->getSubreaktorRelatedBySubreaktor(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addRecommendedArtworkRelatedBySubreaktor($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initRecommendedArtworksRelatedBySubreaktor();
				$obj2->addRecommendedArtworkRelatedBySubreaktor($obj1);
			}

			$omClass = SubreaktorPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getSubreaktorRelatedByLocalsubreaktor(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addRecommendedArtworkRelatedByLocalsubreaktor($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initRecommendedArtworksRelatedByLocalsubreaktor();
				$obj3->addRecommendedArtworkRelatedByLocalsubreaktor($obj1);
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
					$temp_obj4->addRecommendedArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initRecommendedArtworks();
				$obj4->addRecommendedArtwork($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptSubreaktorRelatedBySubreaktor(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		RecommendedArtworkPeer::addSelectColumns($c);
		$startcol2 = (RecommendedArtworkPeer::NUM_COLUMNS - RecommendedArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ReaktorArtworkPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(RecommendedArtworkPeer::ARTWORK, ReaktorArtworkPeer::ID);

		$c->addJoin(RecommendedArtworkPeer::UPDATED_BY, sfGuardUserPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = RecommendedArtworkPeer::getOMClass();

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
					$temp_obj2->addRecommendedArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initRecommendedArtworks();
				$obj2->addRecommendedArtwork($obj1);
			}

			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfGuardUser(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addRecommendedArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initRecommendedArtworks();
				$obj3->addRecommendedArtwork($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptSubreaktorRelatedByLocalsubreaktor(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		RecommendedArtworkPeer::addSelectColumns($c);
		$startcol2 = (RecommendedArtworkPeer::NUM_COLUMNS - RecommendedArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ReaktorArtworkPeer::NUM_COLUMNS;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(RecommendedArtworkPeer::ARTWORK, ReaktorArtworkPeer::ID);

		$c->addJoin(RecommendedArtworkPeer::UPDATED_BY, sfGuardUserPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = RecommendedArtworkPeer::getOMClass();

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
					$temp_obj2->addRecommendedArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initRecommendedArtworks();
				$obj2->addRecommendedArtwork($obj1);
			}

			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getsfGuardUser(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addRecommendedArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initRecommendedArtworks();
				$obj3->addRecommendedArtwork($obj1);
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

		RecommendedArtworkPeer::addSelectColumns($c);
		$startcol2 = (RecommendedArtworkPeer::NUM_COLUMNS - RecommendedArtworkPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ReaktorArtworkPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ReaktorArtworkPeer::NUM_COLUMNS;

		SubreaktorPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + SubreaktorPeer::NUM_COLUMNS;

		SubreaktorPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + SubreaktorPeer::NUM_COLUMNS;

		$c->addJoin(RecommendedArtworkPeer::ARTWORK, ReaktorArtworkPeer::ID);

		$c->addJoin(RecommendedArtworkPeer::SUBREAKTOR, SubreaktorPeer::ID);

		$c->addJoin(RecommendedArtworkPeer::LOCALSUBREAKTOR, SubreaktorPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = RecommendedArtworkPeer::getOMClass();

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
					$temp_obj2->addRecommendedArtwork($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initRecommendedArtworks();
				$obj2->addRecommendedArtwork($obj1);
			}

			$omClass = SubreaktorPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getSubreaktorRelatedBySubreaktor(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addRecommendedArtworkRelatedBySubreaktor($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initRecommendedArtworksRelatedBySubreaktor();
				$obj3->addRecommendedArtworkRelatedBySubreaktor($obj1);
			}

			$omClass = SubreaktorPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getSubreaktorRelatedByLocalsubreaktor(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addRecommendedArtworkRelatedByLocalsubreaktor($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initRecommendedArtworksRelatedByLocalsubreaktor();
				$obj4->addRecommendedArtworkRelatedByLocalsubreaktor($obj1);
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
		return RecommendedArtworkPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseRecommendedArtworkPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseRecommendedArtworkPeer', $values, $con);
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

		$criteria->remove(RecommendedArtworkPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseRecommendedArtworkPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseRecommendedArtworkPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseRecommendedArtworkPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseRecommendedArtworkPeer', $values, $con);
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
			$comparison = $criteria->getComparison(RecommendedArtworkPeer::ID);
			$selectCriteria->add(RecommendedArtworkPeer::ID, $criteria->remove(RecommendedArtworkPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseRecommendedArtworkPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseRecommendedArtworkPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(RecommendedArtworkPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(RecommendedArtworkPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof RecommendedArtwork) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(RecommendedArtworkPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(RecommendedArtwork $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(RecommendedArtworkPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(RecommendedArtworkPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(RecommendedArtworkPeer::DATABASE_NAME, RecommendedArtworkPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = RecommendedArtworkPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(RecommendedArtworkPeer::DATABASE_NAME);

		$criteria->add(RecommendedArtworkPeer::ID, $pk);


		$v = RecommendedArtworkPeer::doSelect($criteria, $con);

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
			$criteria->add(RecommendedArtworkPeer::ID, $pks, Criteria::IN);
			$objs = RecommendedArtworkPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseRecommendedArtworkPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/RecommendedArtworkMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.RecommendedArtworkMapBuilder');
}
