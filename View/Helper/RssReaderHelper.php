<?php
/**
 * RssReader Helper
 *
 * @property  RssReader $RssReader
 * @author    Kosuke Miura <k_miura@zenk.co.jp>
 * @link      http://www.netcommons.org NetCommons Project
 * @license   http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Helper', 'View');

/**
 * RssReader Helper
 *
 * @author  Kosuke Miura <k_miura@zenk.co.jp>
 * @package app\Plugin\RssReaders\Helper
 */
class RssReaderHelper extends Helper {

/**
 * show item
 *
 * @param array $rssXmlData RssReader.serialize
 * @param int $pageLimit RssReaderFrameSettig.display_number_per_page
 * @param boolean $displaySummary RssReaderFrameSettig.display_summary
 * @return void
 */
	public function showItem($rssXmlData, $pageLimit, $displaySummary) {
		// rssの種類によってタグ名が異なる
		if (isset($rssXmlData['feed'])) {
			$items = Hash::get($rssXmlData, 'feed.entry');
			$dateKey = 'published';
			$linkKey = 'link.@href';
			$summaryKey = 'summary.@';
		} elseif (Hash::get($rssXmlData, 'rss.@version') === '2.0') {
			$items = Hash::get($rssXmlData, 'rss.channel.item');
			$dateKey = 'pubDate';
			$linkKey = 'link';
			$summaryKey = 'description';
		} else {
			$items = Hash::get($rssXmlData, 'RDF.item');
			$dateKey = 'dc:date';
			$linkKey = 'link';
			$summaryKey = 'description';
		}

		foreach ($items as $key => $item) {
			if ($key >= $pageLimit) {
				break;
			}
			$date = new DateTime($item[$dateKey]);
			$link = Hash::get($item, $linkKey);
			$summary = Hash::get($item, $summaryKey);
			$title = $item['title'];
			echo $this->_View->element(
				'RssReaders.RssReaders/view_item_detail',
				array(
					'key' => $key,
					'itemData' => $item,
					'pageLimit' => $pageLimit,
					'displaySummary' => $displaySummary,
					'date' => $date,
					'link' => $link,
					'summary' => $summary,
					'title' => $title
				)
			);
		}
	}
}
