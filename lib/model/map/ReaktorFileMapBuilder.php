<?php



class ReaktorFileMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ReaktorFileMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('reaktor_file');
		$tMap->setPhpName('ReaktorFile');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('FILENAME', 'Filename', 'string', CreoleTypes::VARCHAR, true, 200);

		$tMap->addForeignKey('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

		$tMap->addColumn('REALPATH', 'Realpath', 'string', CreoleTypes::VARCHAR, true, 300);

		$tMap->addColumn('THUMBPATH', 'Thumbpath', 'string', CreoleTypes::VARCHAR, true, 300);

		$tMap->addColumn('ORIGINALPATH', 'Originalpath', 'string', CreoleTypes::VARCHAR, true, 300);

		$tMap->addColumn('ORIGINAL_MIMETYPE_ID', 'OriginalMimetypeId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CONVERTED_MIMETYPE_ID', 'ConvertedMimetypeId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('THUMBNAIL_MIMETYPE_ID', 'ThumbnailMimetypeId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('UPLOADED_AT', 'UploadedAt', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('MODIFIED_AT', 'ModifiedAt', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('REPORTED_AT', 'ReportedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('REPORTED', 'Reported', 'int', CreoleTypes::INTEGER, true, 8);

		$tMap->addColumn('TOTAL_REPORTED_EVER', 'TotalReportedEver', 'int', CreoleTypes::INTEGER, true, 8);

		$tMap->addColumn('MARKED_UNSUITABLE', 'MarkedUnsuitable', 'int', CreoleTypes::INTEGER, true, 1);

		$tMap->addColumn('UNDER_DISCUSSION', 'UnderDiscussion', 'int', CreoleTypes::INTEGER, true, 1);

		$tMap->addColumn('IDENTIFIER', 'Identifier', 'string', CreoleTypes::VARCHAR, true, 20);

		$tMap->addColumn('HIDDEN', 'Hidden', 'int', CreoleTypes::INTEGER, true, 1);

		$tMap->addColumn('DELETED', 'Deleted', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 