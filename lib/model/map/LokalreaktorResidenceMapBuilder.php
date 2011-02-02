<?php



class LokalreaktorResidenceMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.LokalreaktorResidenceMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('lokalreaktor_residence');
		$tMap->setPhpName('LokalreaktorResidence');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addForeignKey('SUBREAKTOR_ID', 'SubreaktorId', 'int', CreoleTypes::INTEGER, 'subreaktor', 'ID', true, null);

		$tMap->addForeignKey('RESIDENCE_ID', 'ResidenceId', 'int', CreoleTypes::INTEGER, 'residence', 'ID', true, null);

	} 
} 