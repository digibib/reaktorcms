<?php



class ArticleSubreaktorMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArticleSubreaktorMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('article_subreaktor');
		$tMap->setPhpName('ArticleSubreaktor');

		$tMap->setUseIdGenerator(true);

		$tMap->addForeignKey('ARTICLE_ID', 'ArticleId', 'int', CreoleTypes::INTEGER, 'article', 'ID', true, null);

		$tMap->addForeignKey('SUBREAKTOR_ID', 'SubreaktorId', 'int', CreoleTypes::INTEGER, 'subreaktor', 'ID', true, null);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 