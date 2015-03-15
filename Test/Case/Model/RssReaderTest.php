<?php
/**
 * RssReader Test Case
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersModelTestBase', 'RssReaders.Test/Case/Model');

/**
 * Summary for RssReader Test Case
 */
class RssReaderTest extends RssReadersModelTestBase {

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

/**
 * Test RssReader->getRssReader()
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
 * Test RssReader->getRssReader() by no editabale
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
 * Test RssReader->saveRssReader()
 *
 * @return void
 */
	public function testSaveRssReader() {
		$frameId = 1;
		$blockId = 1;

		//コンテンツの公開権限true
		$this->RssReader->Behaviors->attach('Publishable');
		$this->RssReader->Behaviors->Publishable->setup($this->RssReader, ['contentPublishable' => true]);

		$xml = '<?xml version="1.0" encoding="utf-8"?>' .
			'<rdf:RDF>' .
				'<channel>' .
					'<item>' .
						'<title>title</title>' .
						'<link>link</link>' .
						'<pubDate>Sat, 13 Dec 2003 18:30:02 GMT</pubDate>' .
						'<description>description</description>' .
					'</item>' .
				'</channel>' .
				'<item>' .
					'<title>title1</title>' .
					'<link>http://example.com/1</link>' .
					'<dc:date>Fri, 13 Mar 2015 17:07:41 +0900</dc:date>' .
					'<description>description1</description>' .
				'</item>' .
			'</rdf:RDF>';

		//データ生成
		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId),
			'RssReader' => array(
				'block_id' => $blockId,
				'key' => 'rss_reader_1',
				'status' => NetCommonsBlockComponent::STATUS_PUBLISHED,
				'url' => $xml,
				'title' => 'Edit title',
				'summary' => 'Edit summary',
				'link' => 'http://example.com',
			),
		);

		//登録処理実行
		$this->RssReader->saveRssReader($data);

		//期待値の生成
		$rssReaderId = 4;

		$expected = $data;
		$expected['RssReader']['id'] = $rssReaderId;

		//テスト実施
		$this->__assertSaveRssReader($expected);
	}

/**
 * testGetContent method
 *
 * @return void
 */
	//public function testGetContent() {
	//	$blockId = 1;
	//	$rssReaderData = $this->RssReader->getContent($blockId);
	//	$this->assertEquals(1, $rssReaderData['RssReader']['block_id']);
	//
	//	// 引数2を指定しないと下書きのデータを取得しないことを確認。
	//	$blockId = 2;
	//	$rssReaderData = $this->RssReader->getContent($blockId);
	//	$this->assertEmpty($rssReaderData);
	//
	//	// 引数2にfalseを指定すると下書きのデータを取得しないことを確認。
	//	$blockId = 2;
	//	$rssReaderData = $this->RssReader->getContent($blockId, false);
	//	$this->assertEmpty($rssReaderData);
	//
	//	// 引数2にtrueを指定すると下書きのデータを取得することを確認。
	//	$blockId = 2;
	//	$rssReaderData = $this->RssReader->getContent($blockId, true);
	//	$this->assertEquals(2, $rssReaderData['RssReader']['block_id']);
	//}

/**
 * testSaveRssReader method
 *
 * @return void
 */
	//public function testSaveRssReaderCaseInsert() {
		/*
		$xml = '<?xml version="1.0" encoding="utf-8"?><rdf:RDF><channel><item><title>title</title><link>link</link><pubDate>Sat, 13 Dec 2003 18:30:02 GMT</pubDate><description>description</description></item></channel></rdf:RDF>';
		*/
		//// 新規登録
		//$data = array(
		//	'RssReader' => array(
		//		'id' => '',
		//		'status' => 1,
		//		'url' => $xml,
		//		'title' => 'テストサイト',
		//		'summary' => 'Rssのテスト用サイト',
		//		'link' => 'http://example.com',
		//		'cache_time' => 1800
		//	),
		//	'Block' => array(
		//	)
		//);
		//$frameId = 3;
		//
		//$result = $this->RssReader->saveRssReader($data, $frameId);
		//$this->assertTrue($result);
		//
		//$rssReaderId = $this->RssReader->getLastInsertID();
		//$rssReaderData = $this->RssReader->findById($rssReaderId);
		//// データが正しく登録されているか確認。
		//$this->assertNotEmpty($rssReaderData);
		//$this->assertEquals(
		//	$data['RssReader']['status'],
		//	$rssReaderData['RssReader']['status']
		//);
		//$this->assertEquals(
		//	$data['RssReader']['url'],
		//	$rssReaderData['RssReader']['url']
		//);
		//$this->assertEquals(
		//	$data['RssReader']['title'],
		//	$rssReaderData['RssReader']['title']
		//);
		//$this->assertEquals(
		//	$data['RssReader']['summary'],
		//	$rssReaderData['RssReader']['summary']
		//);
		//$this->assertEquals(
		//	$data['RssReader']['link'],
		//	$rssReaderData['RssReader']['link']
		//);
		//$this->assertEquals(
		//	$data['RssReader']['cache_time'],
		//	$rssReaderData['RssReader']['cache_time']
		//);
		//$this->assertEquals(
		//	$data['RssReader']['title'],
		//	$rssReaderData['Block']['name']
		//);
		//
		//// framesテーブルのblock_idが更新されているか確認
		//$this->Frame = ClassRegistry::init('Frame');
		//$frameData = $this->Frame->findById($frameId);
		//$this->assertEquals(
		//	$rssReaderData['RssReader']['block_id'],
		//	$frameData['Frame']['block_id']
		//);
		//
		//// 存在しないURLを指定した場合は、falseが返ってくることを確認
		//$data = array(
		//	'RssReader' => array(
		//		'id' => '',
		//		'status' => 1,
		//		'url' => 'http://example.com',
		//		'title' => 'テストサイト',
		//		'summary' => 'Rssのテスト用サイト',
		//		'link' => 'http://example.com',
		//		'cache_time' => 1800
		//	),
		//	'Block' => array(
		//	)
		//);
		//$frameId = 3;
		//
		//$result = $this->RssReader->saveRssReader($data, $frameId);
		//$this->assertFalse($result);
	//}

/**
 * testSaveRssReader method
 *
 * @return void
 */
	//public function testSaveRssReaderCaseUpdate() {
		/*
		$xml = '<?xml version="1.0" encoding="utf-8"?><rdf:RDF><channel><item><title>title</title><link>link</link><pubDate>Sat, 13 Dec 2003 18:30:02 GMT</pubDate><description>description</description></item></channel></rdf:RDF>';
		*/
		//// 更新
		//$data = array(
		//	'RssReader' => array(
		//		'id' => 1,
		//		'status' => 1,
		//		'url' => $xml,
		//		'title' => 'テストサイト',
		//		'summary' => 'Rssのテスト用サイト',
		//		'link' => 'http://example.com',
		//		'cache_time' => 3600
		//	),
		//	'Block' => array(
		//		'id' => 1
		//	)
		//);
		//$frameId = 1;
		//
		//$oldRssReaderCount = $this->RssReader->find('count');
		//$oldBlockCount = $this->RssReader->Block->find('count');
		//
		//$result = $this->RssReader->saveRssReader($data, $frameId);
		//$this->assertTrue($result);
		//
		//$rssReaderData = $this->RssReader->findById($data['RssReader']['id']);
		//// データが正しく更新されているか確認。
		//$this->assertEquals(
		//	$data['RssReader']['status'],
		//	$rssReaderData['RssReader']['status']
		//);
		//$this->assertEquals(
		//	$data['RssReader']['url'],
		//	$rssReaderData['RssReader']['url']
		//);
		//$this->assertEquals(
		//	$data['RssReader']['title'],
		//	$rssReaderData['RssReader']['title']
		//);
		//$this->assertEquals(
		//	$data['RssReader']['summary'],
		//	$rssReaderData['RssReader']['summary']
		//);
		//$this->assertEquals(
		//	$data['RssReader']['link'],
		//	$rssReaderData['RssReader']['link']
		//);
		//$this->assertEquals(
		//	$data['RssReader']['cache_time'],
		//	$rssReaderData['RssReader']['cache_time']
		//);
		//$this->assertEquals(
		//	$data['RssReader']['title'],
		//	$rssReaderData['Block']['name']
		//);
		//
		//// 更新後にテーブルに新しいレコードが登録されていない確認。
		//$newRssReaderCount = $this->RssReader->find('count');
		//$newBlockCount = $this->RssReader->Block->find('count');
		//$this->assertEquals($oldRssReaderCount, $newRssReaderCount);
		//$this->assertEquals($oldBlockCount, $newBlockCount);
	//}

/**
 * updateSerializeValue method
 *
 * @return void
 */
	//public function testUpdateSerializeValueCaseNotUpdate() {
	//	$rssReaderId = 1;
	//	$rssReaderData = $this->RssReader->findById($rssReaderId);
	//
	//	// キャッシュ時間を経過しない場合、serialize_valueが更新されないか確認。
	//	$date = new DateTime();
	//	$date->modify('-1 day');
	//	$rssReaderData[$this->RssReader->name]['modified'] = $date->format('Y-m-d h:i:s');
	//	$serializeValue = $this->RssReader->updateSerializeValue($rssReaderData);
	//
	//	$this->assertEquals(
	//		$rssReaderData[$this->RssReader->name]['serialize_value'],
	//		$serializeValue
	//	);
	//
	//	$newRssReaderData = $this->RssReader->findById($rssReaderId);
	//	$this->assertEquals(
	//		$rssReaderData[$this->RssReader->name]['serialize_value'],
	//		$newRssReaderData[$this->RssReader->name]['serialize_value']
	//	);
	//}

/**
 * updateSerializeValue method
 *
 * @return void
 */
	//public function testUpdateSerializeValueCaseUpdate() {
	//	$rssReaderId = 1;
	//	$rssReaderData = $this->RssReader->findById($rssReaderId);
	//
	//	// キャッシュ時間を経過した場合、serialize_valueが更新されるか確認。
	//	$date = new DateTime();
	//	$date->modify('-5 day');
	//	$rssReaderData[$this->RssReader->name]['modified'] = $date->format('Y-m-d h:i:s');
	//	$serializeValue = $this->RssReader->updateSerializeValue($rssReaderData);
	//
	//	$this->assertNotEquals(
	//		$rssReaderData[$this->RssReader->name]['serialize_value'],
	//		$serializeValue
	//	);
	//
	//	$newRssReaderData = $this->RssReader->findById($rssReaderId);
	//	$this->assertNotEquals(
	//		$rssReaderData[$this->RssReader->name]['serialize_value'],
	//		$newRssReaderData[$this->RssReader->name]['serialize_value']
	//	);
	//}

/**
 * serializeRssData method
 *
 * @return void
 */
	//public function testSerializeRssData() {
		/*
		$xml = '<?xml version="1.0" encoding="utf-8"?><rdf:RDF><channel><item><title>title</title><link>link</link><pubDate>Sat, 13 Dec 2003 18:30:02 GMT</pubDate><description>description</description></item></channel></rdf:RDF>';
		*/
		//$serializeValue = $this->RssReader->serializeRssData($xml);
		//$this->assertNotEmpty($serializeValue);
		//
		//// 存在しないURLを指定時はXmlExceptionが発生することを確認。
		//$url = 'http://exaple.xml';
		//$errorMessage = '';
		//try {
		//	$this->RssReader->serializeRssData($url);
		//} catch (XmlException $e) {
		//	$errorMessage = $e;
		//}
		//$this->assertNotEmpty($errorMessage);
	//}
}
