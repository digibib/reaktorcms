<?php



class ReaktorArtworkMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ReaktorArtworkMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('reaktor_artwork');
		$tMap->setPhpName('ReaktorArtwork');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

		$tMap->addColumn('ARTWORK_IDENTIFIER', 'ArtworkIdentifier', 'string', CreoleTypes::VARCHAR, true, 20);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('SUBMITTED_AT', 'SubmittedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('ACTIONED_AT', 'ActionedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('MODIFIED_FLAG', 'ModifiedFlag', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('ACTIONED_BY', 'ActionedBy', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('STATUS', 'Status', 'int', CreoleTypes::INTEGER, 'artwork_status', 'ID', true, null);

		$tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('MODIFIED_NOTE', 'ModifiedNote', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('ARTWORK_ORDER', 'ArtworkOrder', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('AVERAGE_RATING', 'AverageRating', 'double', CreoleTypes::FLOAT, false, null);

		$tMap->addForeignKey('TEAM_ID', 'TeamId', 'int', CreoleTypes::INTEGER, 'sf_guard_group', 'ID', true, null);

		$tMap->addColumn('UNDER_DISCUSSION', 'UnderDiscussion', 'int', CreoleTypes::INTEGER, true, 1);

		$tMap->addColumn('MULTI_USER', 'MultiUser', 'int', CreoleTypes::INTEGER, true, 1);

		$tMap->addForeignKey('FIRST_FILE_ID', 'FirstFileId', 'int', CreoleTypes::INTEGER, 'reaktor_file', 'ID', false, null);

		$tMap->addColumn('DELETED', 'Deleted', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 