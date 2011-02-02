<?php



class ArticleFileMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArticleFileMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('article_file');
		$tMap->setPhpName('ArticleFile');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('FILENAME', 'Filename', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('PATH', 'Path', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addForeignKey('UPLOADED_BY', 'UploadedBy', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

		$tMap->addColumn('UPLOADED_AT', 'UploadedAt', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addForeignKey('FILE_MIMETYPE_ID', 'FileMimetypeId', 'int', CreoleTypes::INTEGER, 'file_mimetype', 'ID', true, null);

	} 
} 