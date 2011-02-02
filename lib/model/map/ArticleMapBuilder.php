<?php



class ArticleMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArticleMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('article');
		$tMap->setPhpName('Article');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addForeignKey('AUTHOR_ID', 'AuthorId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

		$tMap->addColumn('BASE_TITLE', 'BaseTitle', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('PERMALINK', 'Permalink', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('INGRESS', 'Ingress', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('CONTENT', 'Content', 'string', CreoleTypes::LONGVARCHAR, true, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_BY', 'UpdatedBy', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('ARTICLE_TYPE', 'ArticleType', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('ARTICLE_ORDER', 'ArticleOrder', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('EXPIRES_AT', 'ExpiresAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('STATUS', 'Status', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('PUBLISHED_AT', 'PublishedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addForeignKey('BANNER_FILE_ID', 'BannerFileId', 'int', CreoleTypes::INTEGER, 'article_file', 'ID', false, null);

		$tMap->addColumn('IS_STICKY', 'IsSticky', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('FRONTPAGE', 'Frontpage', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 