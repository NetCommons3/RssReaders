<?php
/**
 * Test of RssReaderItem->serializeXmlToArray()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersModelTestCase', 'RssReaders.Test/Case/Model');
App::uses('Xml', 'Utility');

/**
 * Test of RssReaderItem->serializeXmlToArray()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test\Case\Model
 */
class RssReaderItemTestSerializeXmlToArray extends RssReadersModelTestCase {

/**
 * Expect RssReaderItem->serializeXmlToArray() by rss1 format
 *
 * @return void
 */
	public function testByRss1() {
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
 * Expect RssReaderItem->serializeXmlToArray() by rss2 format
 *
 * @return void
 */
	public function testByRss2() {
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
 * Expect RssReaderItem->serializeXmlToArray() by atom format
 *
 * @return void
 */
	public function testByAtom() {
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

}
