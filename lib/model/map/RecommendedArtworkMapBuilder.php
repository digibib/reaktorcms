<?php



class RecommendedArtworkMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.RecommendedArtworkMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('recommended_artwork');
		$tMap->setPhpName('RecommendedArtwork');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('ARTWORK', 'Artwork', 'int', CreoleTypes::INTEGER, 'reaktor_artwork', 'ID', true, null);

		$tMap->addForeignKey('SUBREAKTOR', 'Subreaktor', 'int', CreoleTypes::INTEGER, 'subreaktor', 'ID', true, null);

		$tMap->addForeignKey('LOCALSUBREAKTOR', 'Localsubreaktor', 'int', CreoleTypes::INTEGER, 'subreaktor', 'ID', false, null);

		$tMap->addForeignKey('UPDATED_BY', 'UpdatedBy', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 