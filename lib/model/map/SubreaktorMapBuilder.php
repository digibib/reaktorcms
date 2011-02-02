<?php



class SubreaktorMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.SubreaktorMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('subreaktor');
		$tMap->setPhpName('Subreaktor');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('REFERENCE', 'Reference', 'string', CreoleTypes::VARCHAR, true, 15);

		$tMap->addColumn('LOKALREAKTOR', 'Lokalreaktor', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('LIVE', 'Live', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('SUBREAKTOR_ORDER', 'SubreaktorOrder', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 