<?php



class SubreaktorArtworkMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.SubreaktorArtworkMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('subreaktor_artwork');
		$tMap->setPhpName('SubreaktorArtwork');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('SUBREAKTOR_ID', 'SubreaktorId', 'int', CreoleTypes::INTEGER, 'subreaktor', 'ID', true, null);

		$tMap->addForeignKey('ARTWORK_ID', 'ArtworkId', 'int', CreoleTypes::INTEGER, 'reaktor_artwork', 'ID', true, null);

	} 
} 