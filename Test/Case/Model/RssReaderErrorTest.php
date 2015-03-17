<?php
/**
 * RssReader Model Test Case
 *
 * @property RssReader $RssReader
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RssReadersModelTestCase', 'RssReaders.Test/Case/Model');

/**
 * RssReader Model Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Edumap\Test\Case\Model
 */
class RssReaderErrorTest extends RssReadersModelTestCase {

/**
 * Expect RssReader->saveRssReader() to validate frames.id and throw exception on error
 *
 * @return void
 */
	public function testSaveRssReaderByUnknownFrameId() {
		$this->setExpectedException('InternalErrorException');

		$frameId = 10;
		$blockId = 1;

		//データ生成
		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId),
			'RssReader' => array(
				'key' => 'rss_reader_1',
				'status' => NetCommonsBlockComponent::STATUS_APPROVED,
				'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
				'title' => 'Edit title',
				'summary' => 'Edit summary',
				'link' => 'http://example.com',
			),
			'Comment' => array('comment' => 'Edit comment'),
		);
		$data['RssReaderItem'] = $this->RssReaderItem->serializeXmlToArray(
			APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml'
		);

		//登録処理実行
		$this->RssReader->saveRssReader($data);
	}

}
