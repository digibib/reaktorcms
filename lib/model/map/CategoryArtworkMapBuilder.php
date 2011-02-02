<?php



class CategoryArtworkMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.CategoryArtworkMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('category_artwork');
		$tMap->setPhpName('CategoryArtwork');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('CATEGORY_ID', 'CategoryId', 'int', CreoleTypes::INTEGER, 'category', 'ID', false, null);

		$tMap->addForeignKey('ARTWORK_ID', 'ArtworkId', 'int', CreoleTypes::INTEGER, 'reaktor_artwork', 'ID', false, null);

		$tMap->addForeignKey('ADDED_BY', 'AddedBy', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 