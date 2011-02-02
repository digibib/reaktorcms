<?php


abstract class BaseArticlePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'article';

	
	const CLASS_DEFAULT = 'lib.model.Article';

	
	const NUM_COLUMNS = 17;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'article.ID';

	
	const CREATED_AT = 'article.CREATED_AT';

	
	const AUTHOR_ID = 'article.AUTHOR_ID';

	
	const BASE_TITLE = 'article.BASE_TITLE';

	
	const PERMALINK = 'article.PERMALINK';

	
	const INGRESS = 'article.INGRESS';

	
	const CONTENT = 'article.CONTENT';

	
	const UPDATED_AT = 'article.UPDATED_AT';

	
	const UPDATED_BY = 'article.UPDATED_BY';

	
	const ARTICLE_TYPE = 'article.ARTICLE_TYPE';

	
	const ARTICLE_ORDER = 'article.ARTICLE_ORDER';

	
	const EXPIRES_AT = 'article.EXPIRES_AT';

	
	const STATUS = 'article.STATUS';

	
	const PUBLISHED_AT = 'article.PUBLISHED_AT';

	
	const BANNER_FILE_ID = 'article.BANNER_FILE_ID';

	
	const IS_STICKY = 'article.IS_STICKY';

	
	const FRONTPAGE = 'article.FRONTPAGE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'CreatedAt', 'AuthorId', 'BaseTitle', 'Permalink', 'Ingress', 'Content', 'UpdatedAt', 'UpdatedBy', 'ArticleType', 'ArticleOrder', 'ExpiresAt', 'Status', 'PublishedAt', 'BannerFileId', 'IsSticky', 'Frontpage', ),
		BasePeer::TYPE_COLNAME => array (ArticlePeer::ID, ArticlePeer::CREATED_AT, ArticlePeer::AUTHOR_ID, ArticlePeer::BASE_TITLE, ArticlePeer::PERMALINK, ArticlePeer::INGRESS, ArticlePeer::CONTENT, ArticlePeer::UPDATED_AT, ArticlePeer::UPDATED_BY, ArticlePeer::ARTICLE_TYPE, ArticlePeer::ARTICLE_ORDER, ArticlePeer::EXPIRES_AT, ArticlePeer::STATUS, ArticlePeer::PUBLISHED_AT, ArticlePeer::BANNER_FILE_ID, ArticlePeer::IS_STICKY, ArticlePeer::FRONTPAGE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'created_at', 'author_id', 'base_title', 'permalink', 'ingress', 'content', 'updated_at', 'updated_by', 'article_type', 'article_order', 'expires_at', 'status', 'published_at', 'banner_file_id', 'is_sticky', 'frontpage', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'CreatedAt' => 1, 'AuthorId' => 2, 'BaseTitle' => 3, 'Permalink' => 4, 'Ingress' => 5, 'Content' => 6, 'UpdatedAt' => 7, 'UpdatedBy' => 8, 'ArticleType' => 9, 'ArticleOrder' => 10, 'ExpiresAt' => 11, 'Status' => 12, 'PublishedAt' => 13, 'BannerFileId' => 14, 'IsSticky' => 15, 'Frontpage' => 16, ),
		BasePeer::TYPE_COLNAME => array (ArticlePeer::ID => 0, ArticlePeer::CREATED_AT => 1, ArticlePeer::AUTHOR_ID => 2, ArticlePeer::BASE_TITLE => 3, ArticlePeer::PERMALINK => 4, ArticlePeer::INGRESS => 5, ArticlePeer::CONTENT => 6, ArticlePeer::UPDATED_AT => 7, ArticlePeer::UPDATED_BY => 8, ArticlePeer::ARTICLE_TYPE => 9, ArticlePeer::ARTICLE_ORDER => 10, ArticlePeer::EXPIRES_AT => 11, ArticlePeer::STATUS => 12, ArticlePeer::PUBLISHED_AT => 13, ArticlePeer::BANNER_FILE_ID => 14, ArticlePeer::IS_STICKY => 15, ArticlePeer::FRONTPAGE => 16, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'created_at' => 1, 'author_id' => 2, 'base_title' => 3, 'permalink' => 4, 'ingress' => 5, 'content' => 6, 'updated_at' => 7, 'updated_by' => 8, 'article_type' => 9, 'article_order' => 10, 'expires_at' => 11, 'status' => 12, 'published_at' => 13, 'banner_file_id' => 14, 'is_sticky' => 15, 'frontpage' => 16, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ArticleMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ArticleMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ArticlePeer::getTableMap();
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
		return str_replace(ArticlePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ArticlePeer::ID);

		$criteria->addSelectColumn(ArticlePeer::CREATED_AT);

		$criteria->addSelectColumn(ArticlePeer::AUTHOR_ID);

		$criteria->addSelectColumn(ArticlePeer::BASE_TITLE);

		$criteria->addSelectColumn(ArticlePeer::PERMALINK);

		$criteria->addSelectColumn(ArticlePeer::INGRESS);

		$criteria->addSelectColumn(ArticlePeer::CONTENT);

		$criteria->addSelectColumn(ArticlePeer::UPDATED_AT);

		$criteria->addSelectColumn(ArticlePeer::UPDATED_BY);

		$criteria->addSelectColumn(ArticlePeer::ARTICLE_TYPE);

		$criteria->addSelectColumn(ArticlePeer::ARTICLE_ORDER);

		$criteria->addSelectColumn(ArticlePeer::EXPIRES_AT);

		$criteria->addSelectColumn(ArticlePeer::STATUS);

		$criteria->addSelectColumn(ArticlePeer::PUBLISHED_AT);

		$criteria->addSelectColumn(ArticlePeer::BANNER_FILE_ID);

		$criteria->addSelectColumn(ArticlePeer::IS_STICKY);

		$criteria->addSelectColumn(ArticlePeer::FRONTPAGE);

	}

	const COUNT = 'COUNT(article.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT article.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArticlePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArticlePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ArticlePeer::doSelectRS($criteria, $con);
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
		$objects = ArticlePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ArticlePeer::populateObjects(ArticlePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseArticlePeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseArticlePeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ArticlePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ArticlePeer::getOMClass();
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
			$criteria->addSelectColumn(ArticlePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArticlePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArticlePeer::AUTHOR_ID, sfGuardUserPeer::ID);

		$rs = ArticlePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinArticleFile(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArticlePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArticlePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArticlePeer::BANNER_FILE_ID, ArticleFilePeer::ID);

		$rs = ArticlePeer::doSelectRS($criteria, $con);
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

		ArticlePeer::addSelectColumns($c);
		$startcol = (ArticlePeer::NUM_COLUMNS - ArticlePeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		sfGuardUserPeer::addSelectColumns($c);

		$c->addJoin(ArticlePeer::AUTHOR_ID, sfGuardUserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArticlePeer::getOMClass();

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
										$temp_obj2->addArticle($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initArticles();
				$obj2->addArticle($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinArticleFile(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ArticlePeer::addSelectColumns($c);
		$startcol = (ArticlePeer::NUM_COLUMNS - ArticlePeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ArticleFilePeer::addSelectColumns($c);

		$c->addJoin(ArticlePeer::BANNER_FILE_ID, ArticleFilePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArticlePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ArticleFilePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getArticleFile(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addArticle($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initArticles();
				$obj2->addArticle($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArticlePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArticlePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArticlePeer::AUTHOR_ID, sfGuardUserPeer::ID);

		$criteria->addJoin(ArticlePeer::BANNER_FILE_ID, ArticleFilePeer::ID);

		$rs = ArticlePeer::doSelectRS($criteria, $con);
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

		ArticlePeer::addSelectColumns($c);
		$startcol2 = (ArticlePeer::NUM_COLUMNS - ArticlePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		ArticleFilePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ArticleFilePeer::NUM_COLUMNS;

		$c->addJoin(ArticlePeer::AUTHOR_ID, sfGuardUserPeer::ID);

		$c->addJoin(ArticlePeer::BANNER_FILE_ID, ArticleFilePeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArticlePeer::getOMClass();


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
					$temp_obj2->addArticle($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initArticles();
				$obj2->addArticle($obj1);
			}


					
			$omClass = ArticleFilePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getArticleFile(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addArticle($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initArticles();
				$obj3->addArticle($obj1);
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
			$criteria->addSelectColumn(ArticlePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArticlePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArticlePeer::BANNER_FILE_ID, ArticleFilePeer::ID);

		$rs = ArticlePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptArticleFile(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArticlePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArticlePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArticlePeer::AUTHOR_ID, sfGuardUserPeer::ID);

		$rs = ArticlePeer::doSelectRS($criteria, $con);
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

		ArticlePeer::addSelectColumns($c);
		$startcol2 = (ArticlePeer::NUM_COLUMNS - ArticlePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ArticleFilePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ArticleFilePeer::NUM_COLUMNS;

		$c->addJoin(ArticlePeer::BANNER_FILE_ID, ArticleFilePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArticlePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ArticleFilePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getArticleFile(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addArticle($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initArticles();
				$obj2->addArticle($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptArticleFile(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ArticlePeer::addSelectColumns($c);
		$startcol2 = (ArticlePeer::NUM_COLUMNS - ArticlePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfGuardUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfGuardUserPeer::NUM_COLUMNS;

		$c->addJoin(ArticlePeer::AUTHOR_ID, sfGuardUserPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArticlePeer::getOMClass();

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
					$temp_obj2->addArticle($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initArticles();
				$obj2->addArticle($obj1);
			}

			$results[] = $obj1;
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

    ArticlePeer::addSelectColumns($c);
    $startcol = (ArticlePeer::NUM_COLUMNS - ArticlePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

    ArticleI18nPeer::addSelectColumns($c);

    $c->addJoin(ArticlePeer::ID, ArticleI18nPeer::ID);
    $c->add(ArticleI18nPeer::CULTURE, $culture);

    $rs = BasePeer::doSelect($c, $con);
    $results = array();

    while($rs->next()) {

      $omClass = ArticlePeer::getOMClass();

      $cls = Propel::import($omClass);
      $obj1 = new $cls();
      $obj1->hydrate($rs);
      $obj1->setCulture($culture);

      $omClass = ArticleI18nPeer::getOMClass($rs, $startcol);

      $cls = Propel::import($omClass);
      $obj2 = new $cls();
      $obj2->hydrate($rs, $startcol);

      $obj1->setArticleI18nForCulture($obj2, $culture);
      $obj2->setArticle($obj1);

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
		return ArticlePeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseArticlePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseArticlePeer', $values, $con);
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

		$criteria->remove(ArticlePeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseArticlePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseArticlePeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseArticlePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseArticlePeer', $values, $con);
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
			$comparison = $criteria->getComparison(ArticlePeer::ID);
			$selectCriteria->add(ArticlePeer::ID, $criteria->remove(ArticlePeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseArticlePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseArticlePeer', $values, $con, $ret);
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
			$affectedRows += ArticlePeer::doOnDeleteCascade(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(ArticlePeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ArticlePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof Article) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ArticlePeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			$affectedRows += ArticlePeer::doOnDeleteCascade($criteria, $con);
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

				$objects = ArticlePeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			include_once 'lib/model/ArticleI18n.php';

						$c = new Criteria();
			
			$c->add(ArticleI18nPeer::ID, $obj->getId());
			$affectedRows += ArticleI18nPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	
	public static function doValidate(Article $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ArticlePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ArticlePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ArticlePeer::DATABASE_NAME, ArticlePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ArticlePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(ArticlePeer::DATABASE_NAME);

		$criteria->add(ArticlePeer::ID, $pk);


		$v = ArticlePeer::doSelect($criteria, $con);

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
			$criteria->add(ArticlePeer::ID, $pks, Criteria::IN);
			$objs = ArticlePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseArticlePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ArticleMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ArticleMapBuilder');
}
