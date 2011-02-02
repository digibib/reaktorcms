<?php



class UserInterestMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.UserInterestMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('user_interest');
		$tMap->setPhpName('UserInterest');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('USER_ID', 'UserId', 'int' , CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

		$tMap->addForeignPrimaryKey('SUBREAKTOR_ID', 'SubreaktorId', 'int' , CreoleTypes::INTEGER, 'subreaktor', 'ID', true, null);

	} 
} 