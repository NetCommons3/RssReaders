<?php
/**
 * Test of RssReaderItem->getRssReaderItems()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersModelTestCase', 'RssReaders.Test/Case/Model');

/**
 * Test of RssReaderItem->getRssReaderItems()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test\Case\Model
 */
class RssReaderItemTestGetRssReaderItems extends RssReadersModelTestCase {

/**
 * Expect RssReaderItem->getRssReaderItems()
 *
 * @return void
 */
	public function testGetRssReaderItems() {
		$rssReaderId = 1;
		$result = $this->RssReaderItem->getRssReaderItems($rssReaderId);

		$expected = array(
			array(
				'RssReaderItem' => array(
					'id' => 1,
					'rss_reader_id' => 1,
					'title' => 'Title',
					'summary' => 'Summary',
					'link' => 'http://example.com',
					'serialize_value' => 'serialize()',
				)
			),
		);

		$this->_assertArray(null, $expected, $result);
	}

}
