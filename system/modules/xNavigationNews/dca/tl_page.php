<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  InfinitySoft 2010
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    xNavigation - News
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Table tl_page
 */
/*
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'xNavigation_includeContentItems';
foreach (array('regular', 'forward', 'redirect') as $type) {
	$GLOBALS['TL_DCA']['tl_page']['palettes'][$type] = preg_replace(
		'/,(sitemap,)?hide([^;]*;)/',
		',sitemap,xNavigation$2{xNavigation_legend:hide},xNavigationIncludeArticles,xNavigationIncludeNewsArchives;{xNavigationNewsArchives_legend:hide},xNavigationNewsArchives,xNavigationNewsArchivePosition,xNavigationNewsArchiveFormat,xNavigationNewsArchiveShowQuantity,xNavigationNewsArchiveJumpTo;',
		$GLOBALS['TL_DCA']['tl_page']['palettes'][$type]);
}
$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] = str_replace(
		',includeChmod;',
		',includeChmod;{xNavigation_legend:hide},xNavigationIncludeArticles,xNavigationIncludeNewsArchives;{xNavigationNewsArchives_legend:hide},xNavigationNewsArchives,xNavigationNewsArchivePosition,xNavigationNewsArchiveFormat,xNavigationNewsArchiveShowQuantity,xNavigationNewsArchiveJumpTo;',
		$GLOBALS['TL_DCA']['tl_page']['palettes']['root']);

if (!isset($GLOBALS['TL_DCA']['tl_page']['fields']['sitemap'])) {
	$GLOBALS['TL_DCA']['tl_page']['fields']['sitemap'] = array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_page']['sitemap'],
		'exclude'                 => true,
		'inputType'               => 'select',
		'options'                 => array('map_default', 'map_always', 'map_never'),
		'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
		'reference'               => &$GLOBALS['TL_LANG']['tl_page']
	);
}

$GLOBALS['TL_DCA']['tl_page']['fields']['xNavigation'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xNavigation'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('map_default', 'map_always', 'map_never'),
	'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_page'],
	'load_callback'           => array(
		array('tl_page_xNavigation', 'loadXNavigation')
	)
);

$GLOBALS['TL_DCA']['tl_page']['fields']['xNavigationIncludeArticles'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xNavigationIncludeArticles'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('map_active', 'map_always', 'map_never'),
	'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50', 'alwaysSave'=>true),
	'reference'               => &$GLOBALS['TL_LANG']['tl_page']
);

$GLOBALS['TL_DCA']['tl_page']['fields']['xNavigationIncludeNewsArchives'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xNavigationIncludeNewsArchives'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('map_active', 'map_always', 'map_never'),
	'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_page']
);

$GLOBALS['TL_DCA']['tl_page']['fields']['xNavigationNewsArchives'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xNavigationNewsArchives'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options_callback'        => array('tl_page_xNavigation', 'getNewsArchives'),
	'eval'                    => array('multiple'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_page']['fields']['xNavigationNewsArchivePosition'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xNavigationNewsArchivePosition'],
	'default'                 => '0',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_page_xNavigation', 'getNewsArchivePositions'),
	'eval'                    => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_page']['fields']['xNavigationNewsArchiveFormat'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xNavigationNewsArchiveFormat'],
	'default'                 => 'news_month',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('news_month', 'news_year'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_page'],
	'eval'                    => array('tl_class'=>'w50 clr'),
	'wizard' => array
	(
		array('tl_page_xNavigation', 'hideStartDay')
	)
);

$GLOBALS['TL_DCA']['tl_page']['fields']['xNavigationNewsArchiveShowQuantity'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xNavigationNewsArchiveShowQuantity'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_page']['fields']['xNavigationNewsArchiveJumpTo'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xNavigationNewsArchiveJumpTo'],
	'exclude'                 => true,
	'inputType'               => 'pageTree',
	'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr')
);

class tl_page_xNavigation extends Backend
{

	/**
	 * Import the back end user object
	 * /
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	/**
	 * Get all news archives and return them as array
	 * @return array
	 * /
	public function getNewsArchives()
	{
		if (!$this->User->isAdmin && !is_array($this->User->news))
		{
			return array();
		}

		$arrForms = array();
		$objForms = $this->Database->execute("SELECT id, title FROM tl_news_archive ORDER BY title");

		while ($objForms->next())
		{
			if ($this->User->isAdmin || in_array($objForms->id, $this->User->news))
			{
				$arrForms[$objForms->id] = $objForms->title;
			}
		}

		return $arrForms;
	}
*/
?>