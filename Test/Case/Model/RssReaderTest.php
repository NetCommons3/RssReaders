<?php
/**
 * RssReader Test Case
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReader', 'RssReaders.Model');

/**
 * Summary for RssReader Test Case
 */
class RssReaderTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rss_readers.rss_reader',
		'plugin.rss_readers.block',
		'plugin.rss_readers.frame',
		'plugin.rss_readers.box',
		'plugin.rss_readers.plugin',
		'plugin.rss_readers.language'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RssReader = ClassRegistry::init('RssReaders.RssReader');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RssReader);

		parent::tearDown();
	}

/**
 * testGetContent method
 *
 * @return void
 */
	public function testGetContent() {
		$blockId = 1;
		$rssReaderData = $this->RssReader->getContent($blockId);
		$this->assertEquals(1, $rssReaderData['RssReader']['block_id']);

		// 引数2を指定しないと下書きのデータを取得しないことを確認。
		$blockId = 2;
		$rssReaderData = $this->RssReader->getContent($blockId);
		$this->assertEmpty($rssReaderData);

		// 引数2にfalseを指定すると下書きのデータを取得しないことを確認。
		$blockId = 2;
		$rssReaderData = $this->RssReader->getContent($blockId, false);
		$this->assertEmpty($rssReaderData);

		// 引数2にtrueを指定すると下書きのデータを取得することを確認。
		$blockId = 2;
		$rssReaderData = $this->RssReader->getContent($blockId, true);
		$this->assertEquals(2, $rssReaderData['RssReader']['block_id']);
	}

/**
 * testSaveRssReader method
 *
 * @return void
 */
	public function testSaveRssReaderCaseInsert() {
		// 新規登録
		$data = array(
			'RssReader' => array(
				'id' => '',
				'status' => 1,
				'url' => 'http://zenk.co.jp/feed/rdf',
				'title' => 'テストサイト',
				'summary' => 'Rssのテスト用サイト',
				'link' => 'http://test.com',
				'cache_time' => 1800
			),
			'Block' => array(
			)
		);
		$frameId = 3;

		$result = $this->RssReader->saveRssReader($data, $frameId);
		$this->assertTrue($result);

		$rssReaderId = $this->RssReader->getLastInsertID();
		$rssReaderData = $this->RssReader->findById($rssReaderId);
		// データが正しく登録されているか確認。
		$this->assertNotEmpty($rssReaderData);
		$this->assertEquals(
			$data['RssReader']['status'],
			$rssReaderData['RssReader']['status']
		);
		$this->assertEquals(
			$data['RssReader']['url'],
			$rssReaderData['RssReader']['url']
		);
		$this->assertEquals(
			$data['RssReader']['title'],
			$rssReaderData['RssReader']['title']
		);
		$this->assertEquals(
			$data['RssReader']['summary'],
			$rssReaderData['RssReader']['summary']
		);
		$this->assertEquals(
			$data['RssReader']['link'],
			$rssReaderData['RssReader']['link']
		);
		$this->assertEquals(
			$data['RssReader']['cache_time'],
			$rssReaderData['RssReader']['cache_time']
		);
		$this->assertEquals(
			$data['RssReader']['title'],
			$rssReaderData['Block']['name']
		);

		// framesテーブルのblock_idが更新されているか確認
		$this->Frame = ClassRegistry::init('Frame');
		$frameData = $this->Frame->findById($frameId);
		$this->assertEquals(
			$rssReaderData['RssReader']['block_id'],
			$frameData['Frame']['block_id']
		);
	}

/**
 * testSaveRssReader method
 *
 * @return void
 */
	public function testSaveRssReaderCaseUpdate() {
		// 更新
		$data = array(
			'RssReader' => array(
				'id' => 1,
				'status' => 1,
				'url' => 'http://zenk.co.jp/feed/rdf',
				'title' => 'テストサイト',
				'summary' => 'Rssのテスト用サイト',
				'link' => 'http://test.com',
				'cache_time' => 3600
			),
			'Block' => array(
				'id' => 1
			)
		);
		$frameId = 1;

		$oldRssReaderCount = $this->RssReader->find('count');
		$oldBlockCount = $this->RssReader->Block->find('count');

		$result = $this->RssReader->saveRssReader($data, $frameId);
		$this->assertTrue($result);

		$rssReaderData = $this->RssReader->findById($data['RssReader']['id']);
		// データが正しく更新されているか確認。
		$this->assertEquals(
			$data['RssReader']['status'],
			$rssReaderData['RssReader']['status']
		);
		$this->assertEquals(
			$data['RssReader']['url'],
			$rssReaderData['RssReader']['url']
		);
		$this->assertEquals(
			$data['RssReader']['title'],
			$rssReaderData['RssReader']['title']
		);
		$this->assertEquals(
			$data['RssReader']['summary'],
			$rssReaderData['RssReader']['summary']
		);
		$this->assertEquals(
			$data['RssReader']['link'],
			$rssReaderData['RssReader']['link']
		);
		$this->assertEquals(
			$data['RssReader']['cache_time'],
			$rssReaderData['RssReader']['cache_time']
		);
		$this->assertEquals(
			$data['RssReader']['title'],
			$rssReaderData['Block']['name']
		);

		// 更新後にテーブルに新しいレコードが登録されていない確認。
		$newRssReaderCount = $this->RssReader->find('count');
		$newBlockCount = $this->RssReader->Block->find('count');
		$this->assertEquals($oldRssReaderCount, $newRssReaderCount);
		$this->assertEquals($oldBlockCount, $newBlockCount);
	}

/**
 * updateSerializeValue method
 *
 * @return void
 */
	public function testUpdateSerializeValueCaseNotUpdate() {
		$rssReaderId = 1;
		$rssReaderData = $this->RssReader->findById($rssReaderId);

		// キャッシュ時間を経過しない場合、serialize_valueが更新されないか確認。
		$date = new DateTime();
		$date->modify('-1 day');
		$rssReaderData[$this->RssReader->name]['modified'] = $date->format('Y-m-d h:i:s');
		$serializeValue = $this->RssReader->updateSerializeValue($rssReaderData);

		$this->assertEquals(
			$rssReaderData[$this->RssReader->name]['serialize_value'],
			$serializeValue
		);

		$newRssReaderData = $this->RssReader->findById($rssReaderId);
		$this->assertEquals(
			$rssReaderData[$this->RssReader->name]['serialize_value'],
			$newRssReaderData[$this->RssReader->name]['serialize_value']
		);
	}

/**
 * updateSerializeValue method
 *
 * @return void
 */
	public function testUpdateSerializeValueCaseUpdate() {
		$rssReaderId = 1;
		$rssReaderData = $this->RssReader->findById($rssReaderId);

		// キャッシュ時間を経過した場合、serialize_valueが更新されるか確認。
		$date = new DateTime();
		$date->modify('-5 day');
		$rssReaderData[$this->RssReader->name]['modified'] = $date->format('Y-m-d h:i:s');
		$serializeValue = $this->RssReader->updateSerializeValue($rssReaderData);

		$this->assertNotEquals(
			$rssReaderData[$this->RssReader->name]['serialize_value'],
			$serializeValue
		);

		$newRssReaderData = $this->RssReader->findById($rssReaderId);
		$this->assertNotEquals(
			$rssReaderData[$this->RssReader->name]['serialize_value'],
			$newRssReaderData[$this->RssReader->name]['serialize_value']
		);
	}
}
