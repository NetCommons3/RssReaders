<?php
/**
 * RssReaderFrameSetting Test Case
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersModelTestCase', 'RssReaders.Test/Case/Model');
App::uses('Xml', 'Utility');

/**
 * Summary for RssReaderFrameSetting Test Case
 */
class RssReaderItemTest extends RssReadersModelTestCase {

/**
 * Expect RssReaderItem->serializeXmlToArray()
 *
 * @return void
 */
	public function testSerializeXmlToArrayByRss1() {
		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml';

		//テスト実施
		$result = $this->RssReaderItem->serializeXmlToArray($url);

		//期待値
		$xmlData = Xml::toArray(Xml::build($url));
		$items = Hash::get($xmlData, 'RDF.item');
		$serializeValue = isset($items[0]) && is_array($items[0]) ? $items[0] : $items;

		$expected = array(
			array(
				'title' => 'content title',
				'link' => 'http://example.com/1.html',
				'summary' => 'content description',
				'last_updated' => '2015-03-13 17:07:41',
				'serialize_value' => serialize($serializeValue)
			)
		);

		$this->assertEquals($result, $expected);
	}

/**
 * Expect RssReaderItem->serializeXmlToArray()
 *
 * @return void
 */
	public function testSerializeXmlToArrayByRss2() {
		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v2.xml';

		//テスト実施
		$result = $this->RssReaderItem->serializeXmlToArray($url);

		//期待値
		$xmlData = Xml::toArray(Xml::build($url));
		$items = Hash::get($xmlData, 'rss.channel.item');
		$serializeValue = isset($items[0]) && is_array($items[0]) ? $items[0] : $items;

		$expected = array(
			array(
				'title' => 'content title',
				'link' => 'http://example.com/1.html',
				'summary' => 'content description',
				'last_updated' => '2015-03-13 17:07:41',
				'serialize_value' => serialize($serializeValue)
			)
		);

		$this->assertEquals($result, $expected);
	}

/**
 * Expect RssReaderItem->serializeXmlToArray()
 *
 * @return void
 */
	public function testSerializeXmlToArrayByAtom() {
		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_atom.xml';

		//テスト実施
		$result = $this->RssReaderItem->serializeXmlToArray($url);

		//期待値
		$xmlData = Xml::toArray(Xml::build($url));
		$items = Hash::get($xmlData, 'feed.entry');
		$serializeValue = isset($items[0]) && is_array($items[0]) ? $items[0] : $items;

		$expected = array(
			array(
				'title' => 'content title',
				'link' => 'http://example.com/1.html',
				'summary' => 'content description',
				'last_updated' => '2015-03-13 17:07:41',
				'serialize_value' => serialize($serializeValue)
			)
		);

		$this->assertEquals($result, $expected);
	}

/**
 * Expect RssReader->saveRssReader()
 *
 * @return void
 */
	public function testUpdateRssReaderItems() {
		$frameId = 1;
		$blockId = 1;
		$rssReaderId = 1;

		//データ生成
		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml';
		$xmlData = $this->RssReaderItem->serializeXmlToArray($url);
		$data = array(
			'RssReader' => array('id' => $rssReaderId),
			'RssReaderItem' => $xmlData,
		);

		//登録処理実行
		$this->RssReaderItem->updateRssReaderItems($data);

		//期待値の生成
		$expected = $data;
		$expected['RssReaderItem'] = Hash::insert($expected['RssReaderItem'], '{n}.rss_reader_id', $rssReaderId);

		//RssReaderのテスト実施
		$now = date('Y-m-d H:i:s');
		$rssReader = $this->RssReader->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'id' => $rssReaderId
			)
		));
		$date = new DateTime($rssReader['RssReader']['modified']);
		$this->assertTrue($date->format('Y-m-d H:i:s') <= $now);

		//RssReaderItemのテスト実施
		$result = $this->RssReaderItem->find('all', array(
			'fields' => array('id', 'rss_reader_id', 'title', 'summary', 'link', 'last_updated', 'serialize_value'),
			'recursive' => -1,
			'conditions' => array(
				'rss_reader_id' => $rssReaderId
			)
		));
		var_dump($result);
		$result = Hash::combine($result, '{n}.RssReaderItem.id', '{n}.RssReaderItem');
		$result = Hash::remove($result, '{n}.id');

		var_dump($expected['RssReaderItem'], array_values($result));
		$this->_assertArray(null, $expected['RssReaderItem'], array_values($result));
	}

/**
 * testGetRssReaderFrameSetting method
 *
 * @return void
 */
	//public function testGetRssReaderFrameSetting() {
	//	$frameKey = 'd6c512c3cb0e3cde4892ffbc1bf05b6dd0da70f22ce1404907d36b30cebe1553';
	//	$rssReaderFrameData = $this->RssReaderFrameSetting->getRssReaderFrameSetting($frameKey);
	//
	//	$this->assertNotEmpty($rssReaderFrameData);
	//}
}
