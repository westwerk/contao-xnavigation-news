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

-- CREATE TABLE `tl_page` (
--   `sitemap` varchar(32) NOT NULL default '',
--   `xNavigation` varchar(32) NOT NULL default '',
--   `xNavigationIncludeArticles` varchar(32) NOT NULL default 'map_never',
--   `xNavigationIncludeNewsArchives` varchar(32) NOT NULL default 'map_never',
--   `xNavigationNewsArchives` blob NULL,
--   `xNavigationNewsArchivePosition` int(10) unsigned NOT NULL default '0',
--   `xNavigationNewsArchiveFormat` varchar(32) NOT NULL default '',
--   `xNavigationNewsArchiveShowQuantity` char(1) NOT NULL default '',
--   `xNavigationNewsArchiveJumpTo` int(10) unsigned NOT NULL default '0',
-- ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table `tl_module`
-- 

-- CREATE TABLE `tl_module` (
--   `hardLevel` int(10) unsigned NOT NULL default '0'
-- ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table `tl_article`
-- 

-- CREATE TABLE `tl_article` (
--   `xNavigation` varchar(32) NOT NULL default '',
-- ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
