<?php



class ReaktorArtworkFileMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ReaktorArtworkFileMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('reaktor_artwork_file');
		$tMap->setPhpName('ReaktorArtworkFile');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('ARTWORK_ID', 'ArtworkId', 'int' , CreoleTypes::INTEGER, 'reaktor_artwork', 'ID', true, null);

		$tMap->addForeignPrimaryKey('FILE_ID', 'FileId', 'int' , CreoleTypes::INTEGER, 'reaktor_file', 'ID', true, null);

		$tMap->addColumn('FILE_ORDER', 'FileOrder', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 