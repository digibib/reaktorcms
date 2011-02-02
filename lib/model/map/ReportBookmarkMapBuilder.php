<?php



class ReportBookmarkMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ReportBookmarkMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('report_bookmark');
		$tMap->setPhpName('ReportBookmark');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::LONGVARCHAR, true, null);

		$tMap->addColumn('ARGS', 'Args', 'string', CreoleTypes::LONGVARCHAR, true, null);

		$tMap->addColumn('TYPE', 'Type', 'string', CreoleTypes::VARCHAR, true, 10);

		$tMap->addColumn('LIST_ORDER', 'ListOrder', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 