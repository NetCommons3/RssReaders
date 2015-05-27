<?php
/**
 * Test of RssReaderItem->validateRssReaderItems()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersModelTestBase', 'RssReaders.Test/Case/Model');

/**
 * Test of RssReaderItem->validateRssReaderItems()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReader\Test\Case\Model
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class RssReaderItemValidateRssReaderItemsTest extends RssReadersModelTestBase {

/**
 * Expect `link` validate error by notEmpty
 *
 * @return void
 */
	public function testLinkByNotEmpty() {
		$rssReaderId = 1;

		//コンテンツの公開権限true
		$this->RssReader->Behaviors->attach('Publishable');
		$this->RssReader->Behaviors->Publishable->setup($this->RssReader, ['contentPublishable' => true]);

		$field = 'link';
		$message = sprintf(__d('net_commons', 'Please input %s.'), __d('rss_readers', 'Url'));

		//デフォルトデータ生成
		$rssReader = $this->RssReader->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $rssReaderId)
		));
		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml';
		$xmlData = $this->RssReaderItem->serializeXmlToArray($url);
		$xmlData = Hash::insert($xmlData, '{n}.rss_reader_id', $rssReaderId);

		//データ生成
		$data = array(
			'RssReader' => $rssReader['RssReader'],
			'RssReaderItem' => $xmlData,
		);

		//期待値
		$expected = array(0 => array(
			$field => array($message)
		));

		//テスト実施(カラムなし)
		unset($data['RssReaderItem'][0][$field]);
		$this->__assert($field, $data, $expected);

		//テスト実施
		foreach ($this->testCaseNotEmpty as $check) {
			$data['RssReaderItem'][0][$field] = $check;
			$this->__assert($field, $data, $expected);
		}
	}

/**
 * Expect `title` validate error by notEmpty
 *
 * @return void
 */
	public function testTitleByNotEmpty() {
		$rssReaderId = 1;

		//コンテンツの公開権限true
		$this->RssReader->Behaviors->attach('Publishable');
		$this->RssReader->Behaviors->Publishable->setup($this->RssReader, ['contentPublishable' => true]);

		$field = 'title';
		$message = sprintf(__d('net_commons', 'Please input %s.'), __d('rss_readers', 'Title'));

		//デフォルトデータ生成
		$rssReader = $this->RssReader->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $rssReaderId)
		));
		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml';
		$xmlData = $this->RssReaderItem->serializeXmlToArray($url);
		$xmlData = Hash::insert($xmlData, '{n}.rss_reader_id', $rssReaderId);

		//データ生成
		$data = array(
			'RssReader' => $rssReader['RssReader'],
			'RssReaderItem' => $xmlData,
		);

		//期待値
		$expected = array(0 => array(
			$field => array($message)
		));

		//テスト実施(カラムなし)
		unset($data['RssReaderItem'][0][$field]);
		$this->__assert($field, $data, $expected);

		//テスト実施
		foreach ($this->testCaseNotEmpty as $check) {
			$data['RssReaderItem'][0][$field] = $check;
			$this->__assert($field, $data, $expected);
		}
	}

/**
 * Expect `link` validate error by url
 *
 * @return void
 */
	public function testLinkByUrl() {
		$rssReaderId = 1;

		//コンテンツの公開権限true
		$this->RssReader->Behaviors->attach('Publishable');
		$this->RssReader->Behaviors->Publishable->setup($this->RssReader, ['contentPublishable' => true]);

		$field = 'link';
		$message = sprintf(__d('net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'), __d('rss_readers', 'Url'), __d('net_commons', 'URL'));

		//デフォルトデータ生成
		$rssReader = $this->RssReader->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $rssReaderId)
		));
		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml';
		$xmlData = $this->RssReaderItem->serializeXmlToArray($url);
		$xmlData = Hash::insert($xmlData, '{n}.rss_reader_id', $rssReaderId);

		//データ生成
		$data = array(
			'RssReader' => $rssReader['RssReader'],
			'RssReaderItem' => $xmlData,
		);

		//期待値
		$expected = array(0 => array(
			$field => array($message)
		));

		//テスト実施
		foreach ($this->testCaseUrl as $check) {
			$data['RssReaderItem'][0][$field] = $check;
			$this->__assert($field, $data, $expected);
		}
	}

/**
 * Assert RssReaderItem->validateRssReaderItems()
 *
 * @param string $field Field name
 * @param array $data Save data
 * @param array $expected Expected value
 * @return void
 */
	private function __assert($field, $data, $expected) {
		//初期処理
		$this->setUp();
		//登録処理実行
		$result = $this->RssReaderItem->validateRssReaderItems($data['RssReaderItem']);
		//戻り値テスト
		$this->assertFalse($result, 'Result error: ' . $field . ' ' . print_r($data, true));
		//validationErrorsテスト
		$this->assertEquals($this->RssReaderItem->validationErrors, $expected,
							'Validation error: ' . $field . ' ' . print_r($this->RssReaderItem->validationErrors, true) . print_r($data, true));
		//終了処理
		$this->tearDown();
	}

}
