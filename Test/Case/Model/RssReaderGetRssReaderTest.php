<?php
/**
 * Test of RssReader->getRssReader()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersModelTestBase', 'RssReaders.Test/Case/Model');

/**
 * Test of RssReader->getRssReader()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test\Case\Model
 */
class RssReaderGetRssReaderTest extends RssReadersModelTestBase {

/**
 * Expect RssReader->getRssReader()
 *
 * @return void
 */
	public function testGetRssReader() {
		$blockId = '181';
		$roomId = '1';
		$contentEditable = true;
		$result = $this->RssReader->getRssReader($blockId, $roomId, $contentEditable);

		$expected = array(
			'RssReader' => array(
				'id' => '2',
				'block_id' => $blockId,
				'status' => NetCommonsBlockComponent::STATUS_IN_DRAFT,
				'key' => 'rss_reader_1',
			),
		);

		$this->_assertArray(null, $expected, $result);
	}

/**
 * Expect RssReader->getRssReader() by not editabale
 *
 * @return void
 */
	public function testGetRssReaderByNoEditable() {
		$blockId = '181';
		$roomId = '1';
		$contentEditable = false;
		$result = $this->RssReader->getRssReader($blockId, $roomId, $contentEditable);

		$expected = array(
			'RssReader' => array(
				'id' => '1',
				'block_id' => $blockId,
				'status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
				'key' => 'rss_reader_1',
			),
		);

		$this->_assertArray(null, $expected, $result);
	}
}
