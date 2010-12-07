-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

-- 
-- Table `tl_page`
-- 

CREATE TABLE `tl_page` (
  `xnav_include_news_items` char(1) NOT NULL default '',
  `xnav_news_items_visibility` varchar(32) NOT NULL default '',
  `xnav_news_archives` blob NULL,
  `xnav_news_items_limit` int(10) unsigned NOT NULL default '0',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
