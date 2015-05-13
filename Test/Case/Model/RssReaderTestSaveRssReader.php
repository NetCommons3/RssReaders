<?php
/**
 * Test of RssReader->saveRssReader()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersModelTestCase', 'RssReaders.Test/Case/Model');

/**
 * Test of RssReader->saveRssReader()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test\Case\Model
 */
class RssReaderTestSaveRssReader extends RssReadersModelTestCase {

/**
 * Expect RssReader->saveRssReader()
 *
 * @return void
 */
	public function testSaveRssReader() {
		$frameId = '181';
		$blockId = '181';
		$blockKey = 'block_' . $blockId;
		$roomId = '1';

		//コンテンツの公開権限true
		$this->RssReader->Behaviors->attach('Publishable');
		$this->RssReader->Behaviors->Publishable->setup($this->RssReader, ['contentPublishable' => true]);

		//データ生成
		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId, 'key' => $blockKey, 'plugin_key' => 'rss_readers', 'room_id' => $roomId, 'language_id' => '2'),
			'RssReader' => array(
				'language_id' => '2',
				'key' => 'rss_reader_1',
				'status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
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

		//期待値の生成
		$rssReaderId = $this->RssReader->getLastInsertID();

		$expected = $data;
		$expected['RssReader']['id'] = $rssReaderId;
		$expected['RssReaderItem'] = Hash::insert($expected['RssReaderItem'], '{n}.rss_reader_id', $rssReaderId);

		//テスト実施
		$this->__assertSaveRssReader($expected, $roomId);
	}

/**
 * Expect RssReader->saveRssReader() without blockId
 *
 * @return void
 */
	public function testSaveRssReaderWithoutBlockId() {
		$frameId = '183';
		$blockId = null;
		$blockKey = '';
		$roomId = '2';

		//コンテンツの公開権限true
		$this->RssReader->Behaviors->attach('Publishable');
		$this->RssReader->Behaviors->Publishable->setup($this->RssReader, ['contentPublishable' => true]);

		//データ生成
		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId, 'key' => $blockKey, 'plugin_key' => 'rss_readers', 'room_id' => $roomId, 'language_id' => '2'),
			'RssReader' => array(
				'language_id' => '2',
				'key' => '',
				'status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
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
		$rssReader = $this->RssReader->saveRssReader($data);

		//期待値の生成
		$rssReaderId = $this->RssReader->getLastInsertID();

		$expected = $data;
		$expected['RssReader']['id'] = $rssReaderId;
		$expected['RssReader']['key'] = $rssReader['RssReader']['key'];
		$expected['RssReaderItem'] = Hash::insert($expected['RssReaderItem'], '{n}.rss_reader_id', $rssReaderId);
		$expected['Block']['id'] = $this->Block->getLastInsertID();
		$expected['RssReader']['block_id'] = $expected['Block']['id'];

		//テスト実施
		$this->__assertSaveRssReader($expected, $roomId);
	}

/**
 * Expect RssReader->saveRssReader() without publishable
 *
 * @return void
 */
	public function testSaveRssReaderWithoutPublishable() {
		$frameId = '181';
		$blockId = '181';
		$blockKey = 'block_' . $blockId;
		$roomId = '1';

		//データ生成
		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId, 'key' => $blockKey, 'plugin_key' => 'rss_readers', 'room_id' => $roomId, 'language_id' => '2'),
			'RssReader' => array(
				'language_id' => '2',
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

		//期待値の生成
		$rssReaderId = $this->RssReader->getLastInsertID();

		$expected = $data;
		$expected['RssReader']['id'] = $rssReaderId;
		$expected['RssReaderItem'] = Hash::insert($expected['RssReaderItem'], '{n}.rss_reader_id', $rssReaderId);

		//テスト実施
		$this->__assertSaveRssReader($expected, $roomId);
	}

/**
 * __assertSaveRssReader
 *
 * @param array $expected Expected value
 * @param int $roomId rooms.id
 * @return void
 */
	private function __assertSaveRssReader($expected, $roomId) {
		//RssReader
		$result = $this->RssReader->getRssReader($expected['Block']['id'], $roomId, true);
		$this->_assertArray(null, $expected['RssReader'], $result['RssReader']);

		//RssReaderItem
		$result = $this->RssReaderItem->find('all', array(
			'fields' => array('id', 'rss_reader_id', 'title', 'summary', 'link', 'last_updated', 'serialize_value'),
			'recursive' => -1,
			'conditions' => array(
				'rss_reader_id' => $expected['RssReader']['id']
			)
		));
		$result = Hash::combine($result, '{n}.RssReaderItem.id', '{n}.RssReaderItem');
		$result = Hash::remove($result, '{n}.id');

		$this->_assertArray(null, $expected['RssReaderItem'], array_values($result));
	}

/**
 * Expect RssReader->saveRssReader() to validate frames.id and throw exception on error
 *
 * @return void
 */
	public function testSaveRssReaderByUnknownFrameId() {
		$this->setExpectedException('InternalErrorException');

		$frameId = '99999';
		$blockId = '181';

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
