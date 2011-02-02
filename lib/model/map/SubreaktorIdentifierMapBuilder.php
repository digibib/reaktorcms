<?php



class SubreaktorIdentifierMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.SubreaktorIdentifierMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('subreaktor_identifier');
		$tMap->setPhpName('SubreaktorIdentifier');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('SUBREAKTOR_ID', 'SubreaktorId', 'int', CreoleTypes::INTEGER, 'subreaktor', 'ID', true, null);

		$tMap->addColumn('IDENTIFIER', 'Identifier', 'string', CreoleTypes::VARCHAR, true, 20);

	} 
} 