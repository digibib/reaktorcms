<?php



class ReaktorArtworkHistoryMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ReaktorArtworkHistoryMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('reaktor_artwork_history');
		$tMap->setPhpName('ReaktorArtworkHistory');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('ARTWORK_ID', 'ArtworkId', 'int', CreoleTypes::INTEGER, 'reaktor_artwork', 'ID', false, null);

		$tMap->addForeignKey('FILE_ID', 'FileId', 'int', CreoleTypes::INTEGER, 'reaktor_artwork', 'ID', false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('MODIFIED_FLAG', 'ModifiedFlag', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

		$tMap->addForeignKey('STATUS', 'Status', 'int', CreoleTypes::INTEGER, 'artwork_status', 'ID', true, null);

		$tMap->addColumn('COMMENT', 'Comment', 'string', CreoleTypes::LONGVARCHAR, false, null);

	} 
} 