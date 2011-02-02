<?php



class ResidenceLevelMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ResidenceLevelMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('residence_level');
		$tMap->setPhpName('ResidenceLevel');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('LEVELNAME', 'Levelname', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('LISTORDER', 'Listorder', 'int', CreoleTypes::INTEGER, false, 2);

	} 
} 