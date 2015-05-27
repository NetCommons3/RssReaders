<?php
/**
 * Test of RssReaderItem->updateRssReaderItems()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersModelTestBase', 'RssReaders.Test/Case/Model');

/**
 * Test of RssReaderItem->updateRssReaderItems()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test\Case\Model
 */
class RssReaderItemUpdateRssReaderItemsTest extends RssReadersModelTestBase {

/**
 * Expect RssReaderItem->updateRssReaderItems()
 *
 * @return void
 */
	public function testUpdateRssReaderItems() {
		$rssReaderId = 1;

		//コンテンツの公開権限true
		$this->RssReader->Behaviors->attach('Publishable');
		$this->RssReader->Behaviors->Publishable->setup($this->RssReader, ['contentPublishable' => true]);

		//データ生成
		$rssReader = $this->RssReader->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $rssReaderId)
		));
		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml';
		$xmlData = $this->RssReaderItem->serializeXmlToArray($url);
		$xmlData = Hash::insert($xmlData, '{n}.rss_reader_id', $rssReaderId);
		$data = array(
			'RssReader' => $rssReader['RssReader'],
			'RssReaderItem' => $xmlData,
		);

		//登録処理実行
		$this->RssReaderItem->updateRssReaderItems($data);

		//期待値の生成
		$expected = $data;

		//RssReaderのテスト実施
		$now = date('Y-m-d H:i:s');
		$rssReader = $this->RssReader->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $rssReaderId)
		));
		$date = new DateTime($rssReader['RssReader']['modified']);
		$this->assertTrue($date->format('Y-m-d H:i:s') <= $now);

		//RssReaderItemのテスト実施
		$result = $this->RssReaderItem->find('all', array(
			'fields' => array('id', 'rss_reader_id', 'title', 'summary', 'link', 'last_updated', 'serialize_value'),
			'recursive' => -1,
			'conditions' => array('rss_reader_id' => $rssReaderId)
		));
		$result = Hash::combine($result, '{n}.RssReaderItem.id', '{n}.RssReaderItem');
		$result = Hash::remove($result, '{n}.id');

		$this->_assertArray(null, $expected['RssReaderItem'], array_values($result));
	}

/**
 * Expect RssReaderItem->updateRssReaderItems() validate error by RssReader
 *
 * @return void
 */
	public function testValidateErrorByRssReader() {
		$rssReaderId = 1;

		//コンテンツの公開権限true
		$this->RssReader->Behaviors->attach('Publishable');
		$this->RssReader->Behaviors->Publishable->setup($this->RssReader, ['contentPublishable' => true]);

		//データ生成
		$rssReader = $this->RssReader->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $rssReaderId)
		));
		$rssReader['RssReader']['url'] = '';
		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml';
		$xmlData = $this->RssReaderItem->serializeXmlToArray($url);
		$xmlData = Hash::insert($xmlData, '{n}.rss_reader_id', $rssReaderId);

		$data = array(
			'RssReader' => $rssReader['RssReader'],
			'RssReaderItem' => $xmlData,
		);

		//登録処理実行
		$result = $this->RssReaderItem->updateRssReaderItems($data);

		//テスト実施(詳細なバリデーションのチェックは、RssReaderValidateErrorTestで行う)
		$this->assertFalse($result);
	}

}
