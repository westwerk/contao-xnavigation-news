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
 * @package    xNavigation News
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Table tl_page
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'xnav_include_news_items';

foreach (array('root', 'regular', 'forward', 'redirect') as $type) {
	$GLOBALS['TL_DCA']['tl_page']['palettes'][$type] = preg_replace(
		'#(\{expert_legend(?::hide)?\}.*);#U',
		'$1,xnav_include_news_items;',
		$GLOBALS['TL_DCA']['tl_page']['palettes'][$type]);
}

$GLOBALS['TL_DCA']['tl_page']['subpalettes']['xnav_include_news_items'] = 'xnav_news_items_visibility,xnav_news_items_limit,xnav_news_archives';

$GLOBALS['TL_DCA']['tl_page']['fields']['xnav_include_news_items'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xnav_include_news_items'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'clr')
);

$GLOBALS['TL_DCA']['tl_page']['fields']['xnav_news_items_visibility'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xnav_news_items_visibility'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => array('map_default', 'map_always'),
	'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_page']
);

$GLOBALS['TL_DCA']['tl_page']['fields']['xnav_news_items_limit'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xnav_news_items_limit'],
	'default'                 => '0',
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_page']['fields']['xnav_news_archives'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['xnav_news_archives'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options_callback'        => array('tl_page_xnav_news_items', 'getNewsArchives'),
	'eval'                    => array('multiple'=>true)
);

class tl_page_xnav_news_items extends Backend
{
	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	/**
	 * Get all news archives and return them as array
	 * @return array
	 */
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
}
?>