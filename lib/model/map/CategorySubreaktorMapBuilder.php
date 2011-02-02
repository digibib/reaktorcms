<?php



class CategorySubreaktorMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.CategorySubreaktorMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('category_subreaktor');
		$tMap->setPhpName('CategorySubreaktor');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('CATEGORY_ID', 'CategoryId', 'int', CreoleTypes::INTEGER, 'category', 'ID', false, null);

		$tMap->addForeignKey('SUBREAKTOR_ID', 'SubreaktorId', 'int', CreoleTypes::INTEGER, 'subreaktor', 'ID', false, null);

	} 
} 