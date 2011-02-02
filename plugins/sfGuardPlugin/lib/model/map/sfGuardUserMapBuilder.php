<?php



class sfGuardUserMapBuilder {

	
	const CLASS_NAME = 'plugins.sfGuardPlugin.lib.model.map.sfGuardUserMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('sf_guard_user');
		$tMap->setPhpName('sfGuardUser');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('USERNAME', 'Username', 'string', CreoleTypes::VARCHAR, true, 128);

		$tMap->addColumn('ALGORITHM', 'Algorithm', 'string', CreoleTypes::VARCHAR, true, 128);

		$tMap->addColumn('SALT', 'Salt', 'string', CreoleTypes::VARCHAR, true, 128);

		$tMap->addColumn('PASSWORD', 'Password', 'string', CreoleTypes::VARCHAR, true, 128);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('LAST_LOGIN', 'LastLogin', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('IS_ACTIVE', 'IsActive', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('IS_SUPER_ADMIN', 'IsSuperAdmin', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('IS_VERIFIED', 'IsVerified', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('SHOW_CONTENT', 'ShowContent', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('CULTURE', 'Culture', 'string', CreoleTypes::VARCHAR, false, 10);

		$tMap->addColumn('EMAIL', 'Email', 'string', CreoleTypes::VARCHAR, true, 128);

		$tMap->addColumn('EMAIL_PRIVATE', 'EmailPrivate', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('NEW_EMAIL', 'NewEmail', 'string', CreoleTypes::VARCHAR, false, 128);

		$tMap->addColumn('NEW_EMAIL_KEY', 'NewEmailKey', 'string', CreoleTypes::VARCHAR, false, 128);

		$tMap->addColumn('NEW_PASSWORD_KEY', 'NewPasswordKey', 'string', CreoleTypes::VARCHAR, false, 128);

		$tMap->addColumn('KEY_EXPIRES', 'KeyExpires', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 128);

		$tMap->addColumn('NAME_PRIVATE', 'NamePrivate', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('DOB', 'Dob', 'string', CreoleTypes::VARCHAR, true, null);

		$tMap->addColumn('SEX', 'Sex', 'int', CreoleTypes::INTEGER, true, 1);

		$tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addForeignKey('RESIDENCE_ID', 'ResidenceId', 'int', CreoleTypes::INTEGER, 'residence', 'ID', true, null);

		$tMap->addColumn('AVATAR', 'Avatar', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('MSN', 'Msn', 'string', CreoleTypes::VARCHAR, false, 128);

		$tMap->addColumn('ICQ', 'Icq', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('HOMEPAGE', 'Homepage', 'string', CreoleTypes::VARCHAR, false, 256);

		$tMap->addColumn('PHONE', 'Phone', 'string', CreoleTypes::VARCHAR, false, 32);

		$tMap->addColumn('OPT_IN', 'OptIn', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('EDITORIAL_NOTIFICATION', 'EditorialNotification', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('SHOW_LOGIN_STATUS', 'ShowLoginStatus', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('LAST_ACTIVE', 'LastActive', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('DOB_IS_DERIVED', 'DobIsDerived', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NEED_PROFILE_CHECK', 'NeedProfileCheck', 'int', CreoleTypes::INTEGER, true, 1);

		$tMap->addColumn('FIRST_REAKTOR_LOGIN', 'FirstReaktorLogin', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 