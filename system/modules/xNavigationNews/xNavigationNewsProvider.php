<?php
class xNavigationContentProvider extends xNavigationProvider
{
	public function generateItems(DC_Table $objCurrentPage, $blnActive, &$arrItems, $arrGroups, $intLevel, $intMaxLevel) 
	{
		
		// Get news navigation
		if (	$objCurrentPageID > 0
			&& (	$objCurrentPage->xNavigationIncludeNewsArchives == 'map_always'
				||  (	$this instanceof ModuleXSitemap
					|| $blnActive)
				&& 	$objCurrentPage->xNavigationIncludeNewsArchives == 'map_active'))
		{
			$objNewsArchives = unserialize($objCurrentPage->xNavigationNewsArchives);
			$this->generateNewsItems($objCurrentPage, $objNewsArchives, $arrItems, $time);
		}
	}
	
	/**
	 * Generate the news archive items.
	 * 
	 * @param Database_Result $objCurrentPage
	 * @param array $objNewsArchives
	 * @param array $arrItems
	 * @param integer $time
	 */
	protected function generateNewsItems(Database_Result &$objCurrentPage, &$objNewsArchives, &$arrItems, $time) {
		$arrData = array();
		$maxQuantity = 0;
		switch ($objCurrentPage->xNavigationNewsArchiveFormat) {
		case 'news_year':
			$format = 'Y';
			$param = 'year';
			break;
		case 'news_month':
		default:
			$format = 'Ym';
			$param = 'month';
		}

		$jumpTo = $objCurrentPage->row();
		if ($objCurrentPage->xNavigationNewsArchiveJumpTo > 0) {
			$objJumpTo = $this->Database->prepare("SELECT * FROM tl_page WHERE id = ?")
										->execute($objCurrentPage->xNavigationNewsArchiveJumpTo);
			if ($objJumpTo->next())
				$jumpTo = $objJumpTo->row();
		}
		
		foreach ($objNewsArchives as $id)
		{
			// Get all active items
			$objArchives = $this->Database->prepare("SELECT date FROM tl_news WHERE pid=?" . (!BE_USER_LOGGED_IN ? " AND (start='' OR start<$time) AND (stop='' OR stop>$time) AND published=1" : "") . " ORDER BY date DESC")
										  ->execute($id);

			while ($objArchives->next())
			{
				++$arrData[date($format, $objArchives->date)];
				if ($arrData[date($format, $objArchives->date)] > $maxQuantity) {
					$maxQuantity = $arrData[date($format, $objArchives->date)];
				}
			}
		}
		krsort($arrData);
		
		$url = $this->generateFrontendUrl($jumpTo, sprintf('/%s/%%s', $param));
		
		if (count($arrData)) {
			$n = count($arrItems);
			foreach ($arrData as $intDate => $intCount) {
				$quantity = sprintf((($intCount < 2) ? $GLOBALS['TL_LANG']['MSC']['entry'] : $GLOBALS['TL_LANG']['MSC']['entries']), $intCount);
				switch ($objCurrentPage->xNavigationNewsArchiveFormat) {
				case 'news_year':
					$intYear = $intDate;
					$intMonth = '0';
					$link = $title = specialchars($intYear . ($objCurrentPage->xNavigationNewsArchiveShowQuantity=='1' ? ' (' . $quantity . ')' : ''));
					break;
				case 'news_month':
				default:
					$intYear = intval(substr($intDate, 0, 4));
					$intMonth = intval(substr($intDate, 4));
					$link = $title = specialchars($GLOBALS['TL_LANG']['MONTHS'][$intMonth-1].' '.$intYear . ($objCurrentPage->xNavigationNewsArchiveShowQuantity=='1' ? ' (' . $quantity . ')' : ''));
				}
				
				$arrItems[] = array(
					'date' => $intDate,
					'link' => $link,
					'href' => sprintf($url, $intDate),
					'title' => $title,
					'isActive' => ($this->Input->get($param) == $intDate),
					'quantity' => $quantity,
					'maxQuantity' => $maxQuantity,
					'itemtype' => 'news_archive',
					'class' => ''
				);
			}
			
			$last = count($arrItems) - 1;
			
			$arrItems[$n]['class'] = trim($arrItems[$n]['class'] . ' first_news_archive');
			$arrItems[$last]['class'] = trim($arrItems[$last]['class'] . ' last_news_archive');
		}
	}
	
}
?>