<?php



class TagMapBuilder {

	
	const CLASS_NAME = 'plugins.sfPropelActAsTaggableBehaviorPlugin.lib.model.map.TagMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('tag');
		$tMap->setPhpName('Tag');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'ID', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('APPROVED', 'Approved', 'int', CreoleTypes::TINYINT, true, null);

		$tMap->addForeignKey('APPROVED_BY', 'ApprovedBy', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', false, null);

		$tMap->addColumn('APPROVED_AT', 'ApprovedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('WIDTH', 'Width', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 