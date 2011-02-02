<?php



class FavouriteMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.FavouriteMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('favourite');
		$tMap->setPhpName('Favourite');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

		$tMap->addForeignKey('ARTWORK_ID', 'ArtworkId', 'int', CreoleTypes::INTEGER, 'reaktor_artwork', 'ID', true, null);

		$tMap->addForeignKey('ARTICLE_ID', 'ArticleId', 'int', CreoleTypes::INTEGER, 'article', 'ID', true, null);

		$tMap->addForeignKey('FRIEND_ID', 'FriendId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', true, null);

		$tMap->addColumn('FAV_TYPE', 'FavType', 'string', CreoleTypes::VARCHAR, true, 8);

	} 
} 