<?php
/**
 * RssReader Test Case
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersModelTestCase', 'RssReaders.Test/Case/Model');

/**
 * Summary for RssReader Test Case
 */
class RssReaderTest extends RssReadersModelTestCase {

/**
 * Expect RssReader->getRssReader()
 *
 * @return void
 */
	public function testGetRssReader() {
		$blockId = 1;
		$contentEditable = true;
		$result = $this->RssReader->getRssReader($blockId, $contentEditable);

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
		$blockId = 1;
		$contentEditable = false;
		$result = $this->RssReader->getRssReader($blockId, $contentEditable);

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

/**
 * Expect RssReader->saveRssReader()
 *
 * @return void
 */
	public function testSaveRssReader() {
		$frameId = 1;
		$blockId = 1;

		//コンテンツの公開権限true
		$this->RssReader->Behaviors->attach('Publishable');
		$this->RssReader->Behaviors->Publishable->setup($this->RssReader, ['contentPublishable' => true]);

		//データ生成
		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId),
			'RssReader' => array(
				'key' => 'rss_reader_1',
				'status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
				'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
				'title' => 'Edit title',
				'summary' => 'Edit summary',
				'link' => 'http://example.com',
			),
			'Comment' => array('comment' => 'Edit comment'),
		);

		//登録処理実行
		$this->RssReader->saveRssReader($data);

		//期待値の生成
		$rssReaderId = 4;

		$expected = $data;
		$expected['RssReader']['id'] = $rssReaderId;
		$expected['RssReaderItem'] = $this->RssReaderItem->serializeXmlToArray(
			APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml'
		);
		$expected['RssReaderItem'] = Hash::insert($expected['RssReaderItem'], '{n}.rss_reader_id', $rssReaderId);

		//テスト実施
		$this->__assertSaveRssReader($expected);
	}

/**
 * Expect RssReader->saveRssReader() without blockId
 *
 * @return void
 */
	public function testSaveRssReaderWithoutBlockId() {
		$frameId = 3;
		$blockId = null;

		//コンテンツの公開権限true
		$this->RssReader->Behaviors->attach('Publishable');
		$this->RssReader->Behaviors->Publishable->setup($this->RssReader, ['contentPublishable' => true]);

		//データ生成
		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId),
			'RssReader' => array(
				'key' => 'rss_reader_1',
				'status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
				'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
				'title' => 'Edit title',
				'summary' => 'Edit summary',
				'link' => 'http://example.com',
			),
			'Comment' => array('comment' => 'Edit comment'),
		);

		//登録処理実行
		$this->RssReader->saveRssReader($data);

		//期待値の生成
		$rssReaderId = 4;

		$expected = $data;
		$expected['RssReader']['id'] = $rssReaderId;
		$expected['RssReaderItem'] = $this->RssReaderItem->serializeXmlToArray(
			APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml'
		);
		$expected['RssReaderItem'] = Hash::insert($expected['RssReaderItem'], '{n}.rss_reader_id', $rssReaderId);
		$expected['Block']['id'] = 3;
		$expected['RssReader']['block_id'] = $expected['Block']['id'];

		//テスト実施
		$this->__assertSaveRssReader($expected);
	}

/**
 * Expect RssReader->saveRssReader() without publishable
 *
 * @return void
 */
	public function testSaveRssReaderWithoutPublishable() {
		$frameId = 1;
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

		//登録処理実行
		$this->RssReader->saveRssReader($data);

		//期待値の生成
		$rssReaderId = 4;

		$expected = $data;
		$expected['RssReader']['id'] = $rssReaderId;
		$expected['RssReaderItem'] = $this->RssReaderItem->serializeXmlToArray(
			APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml'
		);
		$expected['RssReaderItem'] = Hash::insert($expected['RssReaderItem'], '{n}.rss_reader_id', $rssReaderId);

		//テスト実施
		$this->__assertSaveRssReader($expected);
	}

/**
 * __assertSaveRssReader
 *
 * @param array $expected Expected value
 * @return void
 */
	private function __assertSaveRssReader($expected) {
		//RssReader
		$result = $this->RssReader->getRssReader($expected['Block']['id'], true);
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
}
