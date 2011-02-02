<?php



class RelatedArtworkMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.RelatedArtworkMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('related_artwork');
		$tMap->setPhpName('RelatedArtwork');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('FIRST_ARTWORK', 'FirstArtwork', 'int', CreoleTypes::INTEGER, 'reaktor_artwork', 'ID', true, null);

		$tMap->addForeignKey('SECOND_ARTWORK', 'SecondArtwork', 'int', CreoleTypes::INTEGER, 'reaktor_artwork', 'ID', true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addForeignKey('CREATED_BY', 'CreatedBy', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

		$tMap->addColumn('ORDER_BY', 'OrderBy', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 