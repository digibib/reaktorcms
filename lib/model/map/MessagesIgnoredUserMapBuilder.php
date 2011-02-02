<?php



class MessagesIgnoredUserMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MessagesIgnoredUserMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('messages_ignored_user');
		$tMap->setPhpName('MessagesIgnoredUser');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

		$tMap->addForeignKey('IGNORES_USER_ID', 'IgnoresUserId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

	} 
} 