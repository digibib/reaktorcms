<?php


abstract class BasesfGuardUserPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sf_guard_user';

	
	const CLASS_DEFAULT = 'plugins.sfGuardPlugin.lib.model.sfGuardUser';

	
	const NUM_COLUMNS = 36;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'sf_guard_user.ID';

	
	const USERNAME = 'sf_guard_user.USERNAME';

	
	const ALGORITHM = 'sf_guard_user.ALGORITHM';

	
	const SALT = 'sf_guard_user.SALT';

	
	const PASSWORD = 'sf_guard_user.PASSWORD';

	
	const CREATED_AT = 'sf_guard_user.CREATED_AT';

	
	const LAST_LOGIN = 'sf_guard_user.LAST_LOGIN';

	
	const IS_ACTIVE = 'sf_guard_user.IS_ACTIVE';

	
	const IS_SUPER_ADMIN = 'sf_guard_user.IS_SUPER_ADMIN';

	
	const IS_VERIFIED = 'sf_guard_user.IS_VERIFIED';

	
	const SHOW_CONTENT = 'sf_guard_user.SHOW_CONTENT';

	
	const CULTURE = 'sf_guard_user.CULTURE';

	
	const EMAIL = 'sf_guard_user.EMAIL';

	
	const EMAIL_PRIVATE = 'sf_guard_user.EMAIL_PRIVATE';

	
	const NEW_EMAIL = 'sf_guard_user.NEW_EMAIL';

	
	const NEW_EMAIL_KEY = 'sf_guard_user.NEW_EMAIL_KEY';

	
	const NEW_PASSWORD_KEY = 'sf_guard_user.NEW_PASSWORD_KEY';

	
	const KEY_EXPIRES = 'sf_guard_user.KEY_EXPIRES';

	
	const NAME = 'sf_guard_user.NAME';

	
	const NAME_PRIVATE = 'sf_guard_user.NAME_PRIVATE';

	
	const DOB = 'sf_guard_user.DOB';

	
	const SEX = 'sf_guard_user.SEX';

	
	const DESCRIPTION = 'sf_guard_user.DESCRIPTION';

	
	const RESIDENCE_ID = 'sf_guard_user.RESIDENCE_ID';

	
	const AVATAR = 'sf_guard_user.AVATAR';

	
	const MSN = 'sf_guard_user.MSN';

	
	const ICQ = 'sf_guard_user.ICQ';

	
	const HOMEPAGE = 'sf_guard_user.HOMEPAGE';

	
	const PHONE = 'sf_guard_user.PHONE';

	
	const OPT_IN = 'sf_guard_user.OPT_IN';

	
	const EDITORIAL_NOTIFICATION = 'sf_guard_user.EDITORIAL_NOTIFICATION';

	
	const SHOW_LOGIN_STATUS = 'sf_guard_user.SHOW_LOGIN_STATUS';

	
	const LAST_ACTIVE = 'sf_guard_user.LAST_ACTIVE';

	
	const DOB_IS_DERIVED = 'sf_guard_user.DOB_IS_DERIVED';

	
	const NEED_PROFILE_CHECK = 'sf_guard_user.NEED_PROFILE_CHECK';

	
	const FIRST_REAKTOR_LOGIN = 'sf_guard_user.FIRST_REAKTOR_LOGIN';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Username', 'Algorithm', 'Salt', 'Password', 'CreatedAt', 'LastLogin', 'IsActive', 'IsSuperAdmin', 'IsVerified', 'ShowContent', 'Culture', 'Email', 'EmailPrivate', 'NewEmail', 'NewEmailKey', 'NewPasswordKey', 'KeyExpires', 'Name', 'NamePrivate', 'Dob', 'Sex', 'Description', 'ResidenceId', 'Avatar', 'Msn', 'Icq', 'Homepage', 'Phone', 'OptIn', 'EditorialNotification', 'ShowLoginStatus', 'LastActive', 'DobIsDerived', 'NeedProfileCheck', 'FirstReaktorLogin', ),
		BasePeer::TYPE_COLNAME => array (sfGuardUserPeer::ID, sfGuardUserPeer::USERNAME, sfGuardUserPeer::ALGORITHM, sfGuardUserPeer::SALT, sfGuardUserPeer::PASSWORD, sfGuardUserPeer::CREATED_AT, sfGuardUserPeer::LAST_LOGIN, sfGuardUserPeer::IS_ACTIVE, sfGuardUserPeer::IS_SUPER_ADMIN, sfGuardUserPeer::IS_VERIFIED, sfGuardUserPeer::SHOW_CONTENT, sfGuardUserPeer::CULTURE, sfGuardUserPeer::EMAIL, sfGuardUserPeer::EMAIL_PRIVATE, sfGuardUserPeer::NEW_EMAIL, sfGuardUserPeer::NEW_EMAIL_KEY, sfGuardUserPeer::NEW_PASSWORD_KEY, sfGuardUserPeer::KEY_EXPIRES, sfGuardUserPeer::NAME, sfGuardUserPeer::NAME_PRIVATE, sfGuardUserPeer::DOB, sfGuardUserPeer::SEX, sfGuardUserPeer::DESCRIPTION, sfGuardUserPeer::RESIDENCE_ID, sfGuardUserPeer::AVATAR, sfGuardUserPeer::MSN, sfGuardUserPeer::ICQ, sfGuardUserPeer::HOMEPAGE, sfGuardUserPeer::PHONE, sfGuardUserPeer::OPT_IN, sfGuardUserPeer::EDITORIAL_NOTIFICATION, sfGuardUserPeer::SHOW_LOGIN_STATUS, sfGuardUserPeer::LAST_ACTIVE, sfGuardUserPeer::DOB_IS_DERIVED, sfGuardUserPeer::NEED_PROFILE_CHECK, sfGuardUserPeer::FIRST_REAKTOR_LOGIN, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'username', 'algorithm', 'salt', 'password', 'created_at', 'last_login', 'is_active', 'is_super_admin', 'is_verified', 'show_content', 'culture', 'email', 'email_private', 'new_email', 'new_email_key', 'new_password_key', 'key_expires', 'name', 'name_private', 'dob', 'sex', 'description', 'residence_id', 'avatar', 'msn', 'icq', 'homepage', 'phone', 'opt_in', 'editorial_notification', 'show_login_status', 'last_active', 'dob_is_derived', 'need_profile_check', 'first_reaktor_login', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Username' => 1, 'Algorithm' => 2, 'Salt' => 3, 'Password' => 4, 'CreatedAt' => 5, 'LastLogin' => 6, 'IsActive' => 7, 'IsSuperAdmin' => 8, 'IsVerified' => 9, 'ShowContent' => 10, 'Culture' => 11, 'Email' => 12, 'EmailPrivate' => 13, 'NewEmail' => 14, 'NewEmailKey' => 15, 'NewPasswordKey' => 16, 'KeyExpires' => 17, 'Name' => 18, 'NamePrivate' => 19, 'Dob' => 20, 'Sex' => 21, 'Description' => 22, 'ResidenceId' => 23, 'Avatar' => 24, 'Msn' => 25, 'Icq' => 26, 'Homepage' => 27, 'Phone' => 28, 'OptIn' => 29, 'EditorialNotification' => 30, 'ShowLoginStatus' => 31, 'LastActive' => 32, 'DobIsDerived' => 33, 'NeedProfileCheck' => 34, 'FirstReaktorLogin' => 35, ),
		BasePeer::TYPE_COLNAME => array (sfGuardUserPeer::ID => 0, sfGuardUserPeer::USERNAME => 1, sfGuardUserPeer::ALGORITHM => 2, sfGuardUserPeer::SALT => 3, sfGuardUserPeer::PASSWORD => 4, sfGuardUserPeer::CREATED_AT => 5, sfGuardUserPeer::LAST_LOGIN => 6, sfGuardUserPeer::IS_ACTIVE => 7, sfGuardUserPeer::IS_SUPER_ADMIN => 8, sfGuardUserPeer::IS_VERIFIED => 9, sfGuardUserPeer::SHOW_CONTENT => 10, sfGuardUserPeer::CULTURE => 11, sfGuardUserPeer::EMAIL => 12, sfGuardUserPeer::EMAIL_PRIVATE => 13, sfGuardUserPeer::NEW_EMAIL => 14, sfGuardUserPeer::NEW_EMAIL_KEY => 15, sfGuardUserPeer::NEW_PASSWORD_KEY => 16, sfGuardUserPeer::KEY_EXPIRES => 17, sfGuardUserPeer::NAME => 18, sfGuardUserPeer::NAME_PRIVATE => 19, sfGuardUserPeer::DOB => 20, sfGuardUserPeer::SEX => 21, sfGuardUserPeer::DESCRIPTION => 22, sfGuardUserPeer::RESIDENCE_ID => 23, sfGuardUserPeer::AVATAR => 24, sfGuardUserPeer::MSN => 25, sfGuardUserPeer::ICQ => 26, sfGuardUserPeer::HOMEPAGE => 27, sfGuardUserPeer::PHONE => 28, sfGuardUserPeer::OPT_IN => 29, sfGuardUserPeer::EDITORIAL_NOTIFICATION => 30, sfGuardUserPeer::SHOW_LOGIN_STATUS => 31, sfGuardUserPeer::LAST_ACTIVE => 32, sfGuardUserPeer::DOB_IS_DERIVED => 33, sfGuardUserPeer::NEED_PROFILE_CHECK => 34, sfGuardUserPeer::FIRST_REAKTOR_LOGIN => 35, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'username' => 1, 'algorithm' => 2, 'salt' => 3, 'password' => 4, 'created_at' => 5, 'last_login' => 6, 'is_active' => 7, 'is_super_admin' => 8, 'is_verified' => 9, 'show_content' => 10, 'culture' => 11, 'email' => 12, 'email_private' => 13, 'new_email' => 14, 'new_email_key' => 15, 'new_password_key' => 16, 'key_expires' => 17, 'name' => 18, 'name_private' => 19, 'dob' => 20, 'sex' => 21, 'description' => 22, 'residence_id' => 23, 'avatar' => 24, 'msn' => 25, 'icq' => 26, 'homepage' => 27, 'phone' => 28, 'opt_in' => 29, 'editorial_notification' => 30, 'show_login_status' => 31, 'last_active' => 32, 'dob_is_derived' => 33, 'need_profile_check' => 34, 'first_reaktor_login' => 35, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'plugins/sfGuardPlugin/lib/model/map/sfGuardUserMapBuilder.php';
		return BasePeer::getMapBuilder('plugins.sfGuardPlugin.lib.model.map.sfGuardUserMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = sfGuardUserPeer::getTableMap();
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
		return str_replace(sfGuardUserPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(sfGuardUserPeer::ID);

		$criteria->addSelectColumn(sfGuardUserPeer::USERNAME);

		$criteria->addSelectColumn(sfGuardUserPeer::ALGORITHM);

		$criteria->addSelectColumn(sfGuardUserPeer::SALT);

		$criteria->addSelectColumn(sfGuardUserPeer::PASSWORD);

		$criteria->addSelectColumn(sfGuardUserPeer::CREATED_AT);

		$criteria->addSelectColumn(sfGuardUserPeer::LAST_LOGIN);

		$criteria->addSelectColumn(sfGuardUserPeer::IS_ACTIVE);

		$criteria->addSelectColumn(sfGuardUserPeer::IS_SUPER_ADMIN);

		$criteria->addSelectColumn(sfGuardUserPeer::IS_VERIFIED);

		$criteria->addSelectColumn(sfGuardUserPeer::SHOW_CONTENT);

		$criteria->addSelectColumn(sfGuardUserPeer::CULTURE);

		$criteria->addSelectColumn(sfGuardUserPeer::EMAIL);

		$criteria->addSelectColumn(sfGuardUserPeer::EMAIL_PRIVATE);

		$criteria->addSelectColumn(sfGuardUserPeer::NEW_EMAIL);

		$criteria->addSelectColumn(sfGuardUserPeer::NEW_EMAIL_KEY);

		$criteria->addSelectColumn(sfGuardUserPeer::NEW_PASSWORD_KEY);

		$criteria->addSelectColumn(sfGuardUserPeer::KEY_EXPIRES);

		$criteria->addSelectColumn(sfGuardUserPeer::NAME);

		$criteria->addSelectColumn(sfGuardUserPeer::NAME_PRIVATE);

		$criteria->addSelectColumn(sfGuardUserPeer::DOB);

		$criteria->addSelectColumn(sfGuardUserPeer::SEX);

		$criteria->addSelectColumn(sfGuardUserPeer::DESCRIPTION);

		$criteria->addSelectColumn(sfGuardUserPeer::RESIDENCE_ID);

		$criteria->addSelectColumn(sfGuardUserPeer::AVATAR);

		$criteria->addSelectColumn(sfGuardUserPeer::MSN);

		$criteria->addSelectColumn(sfGuardUserPeer::ICQ);

		$criteria->addSelectColumn(sfGuardUserPeer::HOMEPAGE);

		$criteria->addSelectColumn(sfGuardUserPeer::PHONE);

		$criteria->addSelectColumn(sfGuardUserPeer::OPT_IN);

		$criteria->addSelectColumn(sfGuardUserPeer::EDITORIAL_NOTIFICATION);

		$criteria->addSelectColumn(sfGuardUserPeer::SHOW_LOGIN_STATUS);

		$criteria->addSelectColumn(sfGuardUserPeer::LAST_ACTIVE);

		$criteria->addSelectColumn(sfGuardUserPeer::DOB_IS_DERIVED);

		$criteria->addSelectColumn(sfGuardUserPeer::NEED_PROFILE_CHECK);

		$criteria->addSelectColumn(sfGuardUserPeer::FIRST_REAKTOR_LOGIN);

	}

	const COUNT = 'COUNT(sf_guard_user.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sf_guard_user.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfGuardUserPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfGuardUserPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = sfGuardUserPeer::doSelectRS($criteria, $con);
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
		$objects = sfGuardUserPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return sfGuardUserPeer::populateObjects(sfGuardUserPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfGuardUserPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BasesfGuardUserPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			sfGuardUserPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = sfGuardUserPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinResidence(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfGuardUserPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfGuardUserPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfGuardUserPeer::RESIDENCE_ID, ResidencePeer::ID);

		$rs = sfGuardUserPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinResidence(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfGuardUserPeer::addSelectColumns($c);
		$startcol = (sfGuardUserPeer::NUM_COLUMNS - sfGuardUserPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ResidencePeer::addSelectColumns($c);

		$c->addJoin(sfGuardUserPeer::RESIDENCE_ID, ResidencePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfGuardUserPeer::getOMClass();

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
										$temp_obj2->addsfGuardUser($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initsfGuardUsers();
				$obj2->addsfGuardUser($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfGuardUserPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfGuardUserPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfGuardUserPeer::RESIDENCE_ID, ResidencePeer::ID);

		$rs = sfGuardUserPeer::doSelectRS($criteria, $con);
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

		sfGuardUserPeer::addSelectColumns($c);
		$startcol2 = (sfGuardUserPeer::NUM_COLUMNS - sfGuardUserPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ResidencePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ResidencePeer::NUM_COLUMNS;

		$c->addJoin(sfGuardUserPeer::RESIDENCE_ID, ResidencePeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfGuardUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = ResidencePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getResidence(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addsfGuardUser($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initsfGuardUsers();
				$obj2->addsfGuardUser($obj1);
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
		return sfGuardUserPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfGuardUserPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfGuardUserPeer', $values, $con);
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

		$criteria->remove(sfGuardUserPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BasesfGuardUserPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasesfGuardUserPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfGuardUserPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfGuardUserPeer', $values, $con);
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
			$comparison = $criteria->getComparison(sfGuardUserPeer::ID);
			$selectCriteria->add(sfGuardUserPeer::ID, $criteria->remove(sfGuardUserPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasesfGuardUserPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasesfGuardUserPeer', $values, $con, $ret);
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
			$affectedRows += sfGuardUserPeer::doOnDeleteCascade(new Criteria(), $con);
			$affectedRows += BasePeer::doDeleteAll(sfGuardUserPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(sfGuardUserPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof sfGuardUser) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(sfGuardUserPeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			$affectedRows += sfGuardUserPeer::doOnDeleteCascade($criteria, $con);
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

				$objects = sfGuardUserPeer::doSelect($criteria, $con);
		foreach($objects as $obj) {


			include_once 'plugins/sfGuardPlugin/lib/model/sfGuardUserPermission.php';

						$c = new Criteria();
			
			$c->add(sfGuardUserPermissionPeer::USER_ID, $obj->getId());
			$affectedRows += sfGuardUserPermissionPeer::doDelete($c, $con);

			include_once 'plugins/sfGuardPlugin/lib/model/sfGuardUserGroup.php';

						$c = new Criteria();
			
			$c->add(sfGuardUserGroupPeer::USER_ID, $obj->getId());
			$affectedRows += sfGuardUserGroupPeer::doDelete($c, $con);

			include_once 'plugins/sfGuardPlugin/lib/model/sfGuardRememberKey.php';

						$c = new Criteria();
			
			$c->add(sfGuardRememberKeyPeer::USER_ID, $obj->getId());
			$affectedRows += sfGuardRememberKeyPeer::doDelete($c, $con);

			include_once 'lib/model/UserInterest.php';

						$c = new Criteria();
			
			$c->add(UserInterestPeer::USER_ID, $obj->getId());
			$affectedRows += UserInterestPeer::doDelete($c, $con);

			include_once 'lib/model/UserResource.php';

						$c = new Criteria();
			
			$c->add(UserResourcePeer::USER_ID, $obj->getId());
			$affectedRows += UserResourcePeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	
	public static function doValidate(sfGuardUser $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfGuardUserPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfGuardUserPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(sfGuardUserPeer::DATABASE_NAME, sfGuardUserPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = sfGuardUserPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(sfGuardUserPeer::DATABASE_NAME);

		$criteria->add(sfGuardUserPeer::ID, $pk);


		$v = sfGuardUserPeer::doSelect($criteria, $con);

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
			$criteria->add(sfGuardUserPeer::ID, $pks, Criteria::IN);
			$objs = sfGuardUserPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BasesfGuardUserPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'plugins/sfGuardPlugin/lib/model/map/sfGuardUserMapBuilder.php';
	Propel::registerMapBuilder('plugins.sfGuardPlugin.lib.model.map.sfGuardUserMapBuilder');
}
