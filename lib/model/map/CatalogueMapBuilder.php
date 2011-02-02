<?php



class CatalogueMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.CatalogueMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('catalogue');
		$tMap->setPhpName('Catalogue');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('CAT_ID', 'CatId', 'int', CreoleTypes::INTEGER, true, 11);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, true, 100);

		$tMap->addColumn('SOURCE_LANG', 'SourceLang', 'string', CreoleTypes::VARCHAR, true, 100);

		$tMap->addColumn('TARGET_LANG', 'TargetLang', 'string', CreoleTypes::VARCHAR, true, 100);

		$tMap->addColumn('DATE_CREATED', 'DateCreated', 'int', CreoleTypes::INTEGER, true, 11);

		$tMap->addColumn('DATE_MODIFIED', 'DateModified', 'int', CreoleTypes::INTEGER, true, 11);

		$tMap->addColumn('AUTHOR', 'Author', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::VARCHAR, true, 255);

	} 
} 