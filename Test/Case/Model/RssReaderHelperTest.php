<?php
/**
 * RssReaderHelper Test Case
 *
 * @property  RssReader $RssReader
 * @author    Kosuke Miura <k_miura@zenk.co.jp>
 * @link      http://www.netcommons.org NetCommons Project
 * @license   http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('View', 'View');
App::uses('Helper', 'View');
//App::uses('RssReaderHelper', 'RssReaders.View/Helper');
App::uses('RssReadersModelTestBase', 'RssReaders.Test/Case/Model');

/**
 * Summary for RssReaderHelper Test Case
 */
class RssReaderHelperTest extends RssReadersModelTestBase {

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->assertTrue(true);
	}

/**
 * testShowItem method case rss type atom
 *
 * @return void
 */
	//public function testShowItemRssTypeAtom() {
		//$rssXmlData = array(
		//	'feed' => array(
		//		'entry' => array(
		//			array(
		//				'published' => '2014-11-18T00:00:00Z',
		//				'link' => array(
		//					'@href' => 'http://example1.com',
		//					'@type' => 'text/html'
		//				),
		//				'title' => '記事1',
		//				'summary' => '記事1の説明です。'
		//			),
		//			array(
		//				'published' => '2014-11-18T00:00:00Z',
		//				'link' => array(
		//					'@href' => 'http://example2.com',
		//					'@type' => 'text/html'
		//				),
		//				'title' => '記事2',
		//				'summary' => '記事2の説明です。'
		//			)
		//		)
		//	)
		//);
		//$pageLimit = 5;
		//$displaySummary = true;
		//
		//$this->RssReader->showItem($rssXmlData, $pageLimit, $displaySummary);
	//}

/**
 * testShowItem method case rss type 2.0
 *
 * @return void
 */
	//public function testShowItemRssType2() {
		//$rssXmlData = array(
		//	'rss' => array(
		//		'@version' => '2.0',
		//		'channel' => array(
		//			'item' => array(
		//				array(
		//					'pubDate' => 'Fri, 31 Oct 2014 15:09:23 +0900',
		//					'link' => 'http://example1.com',
		//					'title' => '記事1',
		//					'description' => '記事1の説明です。'
		//				),
		//				array(
		//					'pubDate' => 'Fri, 31 Oct 2014 15:09:23 +0900',
		//					'link' => 'http://example1.com',
		//					'title' => '記事2',
		//					'description' => '記事2の説明です。'
		//				)
		//			)
		//		)
		//	)
		//);
		//$pageLimit = 5;
		//$displaySummary = true;
		//
		//$this->RssReader->showItem($rssXmlData, $pageLimit, $displaySummary);
	//}

/**
 * testShowItem method case rss type 1.0
 *
 * @return void
 */
	//public function testShowItemRssType1() {
		//$rssXmlData = array(
		//	'RDF' => array(
		//		'item' => array(
		//			array(
		//				'dc:date' => 'Tue, 18 Nov 2014 09:00:00 JST',
		//				'link' => 'http://example1.com',
		//				'title' => '記事1',
		//				'description' => '記事1の説明です。'
		//			),
		//			array(
		//				'dc:date' => 'Tue, 18 Nov 2014 09:00:00 JST',
		//				'link' => 'http://example1.com',
		//				'title' => '記事2',
		//				'description' => '記事2の説明です。'
		//			)
		//		)
		//	)
		//);
		//$pageLimit = 5;
		//$displaySummary = true;
		//
		//$this->RssReader->showItem($rssXmlData, $pageLimit, $displaySummary);
	//}

}
