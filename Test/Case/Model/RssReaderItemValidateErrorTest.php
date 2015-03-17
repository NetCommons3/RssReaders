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
 * Expect RssReader on validate error
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReader\Test\Case\Model
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class RssReaderItemValidateErrorTest extends RssReadersModelTestCase {

/**
 * Expect RssReader->saveRssReader() to validate not empty fields
 *   and return false on validation error
 *
 * @return void
 */
	public function testSaveRssReaderItemByNotEmpty() {
		$rssReaderId = 1;

		//コンテンツの公開権限true
		$this->RssReader->Behaviors->attach('Publishable');
		$this->RssReader->Behaviors->Publishable->setup($this->RssReader, ['contentPublishable' => true]);

		//Checkカラム
		$fields = array(
			'link' => sprintf(__d('net_commons', 'Please input %s.'), __d('rss_readers', 'Url')),
			'title' => sprintf(__d('net_commons', 'Please input %s.'), __d('rss_readers', 'Title')),
		);
		//Check項目
		$checks = array(
			null, '', false,
		);

		//デフォルトデータ生成
		$rssReader = $this->RssReader->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $rssReaderId)
		));
		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml';
		$xmlData = $this->RssReaderItem->serializeXmlToArray($url);
		$xmlData = Hash::insert($xmlData, '{n}.rss_reader_id', $rssReaderId);

		foreach ($fields as $field => $message) {
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
			$this->__assertSaveRssReaderItem($field, $data, $expected);

			//テスト実施
			foreach ($checks as $check) {
				$data['RssReaderItem'][0][$field] = $check;
				$this->__assertSaveRssReaderItem($field, $data, $expected);
			}
		}
	}

/**
 * Expect RssReader->saveRssReader() to validate url field
 *   and return false on validation error
 *
 * @return void
 */
	public function testSaveRssReaderByUrl() {
		$rssReaderId = 1;

		//コンテンツの公開権限true
		$this->RssReader->Behaviors->attach('Publishable');
		$this->RssReader->Behaviors->Publishable->setup($this->RssReader, ['contentPublishable' => true]);

		//Checkカラム
		$fields = array(
			'link' => sprintf(__d('net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'), __d('rss_readers', 'Url'), __d('rss_readers', 'URL')),
		);
		//Check項目
		$checks = array(
			'http:', 'https:', 'ftp:', 'javascript:',
			'http:/', 'https:/', 'ftp:/', 'javascript:/',
			'http://', 'https://', 'ftp://', 'javascript://',
			'http://test', 'https://test', 'ftp://test', 'javascript:test', 'abc://exapmle.com',
		);
		//デフォルトデータ生成
		$rssReader = $this->RssReader->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $rssReaderId)
		));
		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml';
		$xmlData = $this->RssReaderItem->serializeXmlToArray($url);
		$xmlData = Hash::insert($xmlData, '{n}.rss_reader_id', $rssReaderId);

		foreach ($fields as $field => $message) {
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
			foreach ($checks as $check) {
				$data['RssReaderItem'][0][$field] = $check;
				$this->__assertSaveRssReaderItem($field, $data, $expected);
			}
		}
	}

/**
 * Expect RssReader->saveRssReader() to validate file asspcoated
 *   and return false on validation error
 *
 * @return void
 */
	public function testSaveRssReaderByRssReader() {
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

/**
 * __assertSaveRssReader
 *
 * @param string $field Field name
 * @param array $data Save data
 * @param array $expected Expected value
 * @return void
 */
	private function __assertSaveRssReaderItem($field, $data, $expected) {
		//初期処理
		$this->setUp();
		//登録処理実行
		$result = $this->RssReaderItem->updateRssReaderItems($data);
		//戻り値テスト
		$this->assertFalse($result, 'Result error: ' . $field . ' ' . print_r($data, true));
		//validationErrorsテスト
		$this->assertEquals($this->RssReaderItem->validationErrors, $expected,
							'Validation error: ' . $field . ' ' . print_r($this->RssReaderItem->validationErrors, true) . print_r($data, true));
		//終了処理
		$this->tearDown();
	}

}
