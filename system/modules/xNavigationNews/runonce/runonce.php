<?php
class xNavigationNewsRunonce extends Frontend
{

	/**
	 * Initialize the object
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->import('Database');
	}

	public function run()
	{
		$this->import('Database');
		if (	$this->Database->fieldExists('xnav_news_archives', 'tl_page')
			&& !$this->Database->fieldExists('xnav_news_items_archives', 'tl_page')) {
			$this->Database->execute("ALTER TABLE tl_page ADD xnav_news_items_archives blob NULL");
			$this->Database->execute("UPDATE tl_page SET xnav_news_items_archives=xnav_news_archives");
		}
		if ($this->Database->fieldExists('xNavigationIncludeNewsArchives', 'tl_page')) {
			$this->Database->execute("ALTER TABLE tl_page CHANGE xNavigationIncludeNewsArchives xnav_news_archives_visibility varchar(32) NOT NULL default ''");
		}
		if ($this->Database->fieldExists('xNavigationNewsArchives', 'tl_page')) {
			$this->Database->execute("ALTER TABLE tl_page CHANGE xNavigationNewsArchives xnav_news_archives blob NULL");
		}
		if ($this->Database->fieldExists('xNavigationNewsArchiveFormat', 'tl_page')) {
			$this->Database->execute("ALTER TABLE tl_page CHANGE xNavigationNewsArchiveFormat xnav_news_archives_scope varchar(32) NOT NULL default ''");
		}
		if ($this->Database->fieldExists('xNavigationNewsArchiveShowQuantity', 'tl_page')) {
			$this->Database->execute("ALTER TABLE tl_page CHANGE xNavigationNewsArchiveShowQuantity xnav_news_archives_quantity char(1) NOT NULL default ''");
		}
	}
}

/**
 * Instantiate controller
 */
$objXNavigationNewsRunonce = new xNavigationNewsRunonce();
$objXNavigationNewsRunonce->run();

?>