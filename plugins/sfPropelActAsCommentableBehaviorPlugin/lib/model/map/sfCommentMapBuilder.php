<?php



class sfCommentMapBuilder {

	
	const CLASS_NAME = 'plugins.sfPropelActAsCommentableBehaviorPlugin.lib.model.map.sfCommentMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_comment');
		$tMap->setPhpName('sfComment');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('PARENT_ID', 'ParentId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('COMMENTABLE_MODEL', 'CommentableModel', 'string', CreoleTypes::VARCHAR, false, 30);

		$tMap->addColumn('COMMENTABLE_ID', 'CommentableId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('NAMESPACE', 'Namespace', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('TEXT', 'Text', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addForeignKey('AUTHOR_ID', 'AuthorId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

		$tMap->addColumn('AUTHOR_NAME', 'AuthorName', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('AUTHOR_EMAIL', 'AuthorEmail', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UNSUITABLE', 'Unsuitable', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('EMAIL_NOTIFY', 'EmailNotify', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 