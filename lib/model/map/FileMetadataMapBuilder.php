<?php



class FileMetadataMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.FileMetadataMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('file_metadata');
		$tMap->setPhpName('FileMetadata');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('FILE', 'File', 'int', CreoleTypes::INTEGER, 'reaktor_file', 'ID', true, null);

		$tMap->addColumn('META_ELEMENT', 'MetaElement', 'string', CreoleTypes::VARCHAR, true, 100);

		$tMap->addColumn('META_QUALIFIER', 'MetaQualifier', 'string', CreoleTypes::VARCHAR, true, 100);

		$tMap->addColumn('META_VALUE', 'MetaValue', 'string', CreoleTypes::LONGVARCHAR, true, null);

	} 
} 