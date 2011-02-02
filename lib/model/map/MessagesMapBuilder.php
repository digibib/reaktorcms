<?php



class MessagesMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MessagesMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('messages');
		$tMap->setPhpName('Messages');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('TO_USER_ID', 'ToUserId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

		$tMap->addForeignKey('FROM_USER_ID', 'FromUserId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

		$tMap->addColumn('SUBJECT', 'Subject', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('MESSAGE', 'Message', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('TIMESTAMP', 'Timestamp', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('DELETED_BY_FROM', 'DeletedByFrom', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('DELETED_BY_TO', 'DeletedByTo', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('IS_READ', 'IsRead', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('IS_IGNORED', 'IsIgnored', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('IS_ARCHIVED', 'IsArchived', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('REPLY_TO', 'ReplyTo', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 