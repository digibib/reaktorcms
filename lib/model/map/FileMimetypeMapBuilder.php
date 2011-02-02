<?php



class FileMimetypeMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.FileMimetypeMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('file_mimetype');
		$tMap->setPhpName('FileMimetype');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('MIMETYPE', 'Mimetype', 'string', CreoleTypes::VARCHAR, true, 100);

		$tMap->addColumn('IDENTIFIER', 'Identifier', 'string', CreoleTypes::VARCHAR, true, 20);

	} 
} 