<?php



class ResidenceMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ResidenceMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('residence');
		$tMap->setPhpName('Residence');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addForeignKey('LEVEL', 'Level', 'int', CreoleTypes::INTEGER, 'residence_level', 'ID', true, null);

		$tMap->addColumn('PARENT', 'Parent', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 