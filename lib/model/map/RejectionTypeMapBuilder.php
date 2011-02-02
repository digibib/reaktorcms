<?php



class RejectionTypeMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.RejectionTypeMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('rejection_type');
		$tMap->setPhpName('RejectionType');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('BASENAME', 'Basename', 'string', CreoleTypes::VARCHAR, true, 255);

	} 
} 