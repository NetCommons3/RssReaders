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
class RssReaderValidateErrorTest extends RssReadersModelTestCase {

/**
 * Expect RssReader->saveRssReader() to validate edumap.status
 *   and return false on validation error
 *
 * @return void
 */
	public function testSaveRssReaderByStatus() {
		$frameId = 1;
		$blockId = 1;

		//コンテンツの公開権限true
		$this->RssReader->Behaviors->attach('Publishable');
		$this->RssReader->Behaviors->Publishable->setup($this->RssReader, ['contentPublishable' => true]);

		//Check項目
		$checks = array(
			null, '', -1, 0, 5, 9999, 'abcde', false,
		);

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

		//期待値
		$expected = array(
			'status' => array(
				__d('net_commons', 'Invalid request.')
			)
		);

		//テスト実施(カラムなし)
		unset($data['RssReader']['status']);
		$this->__assertSaveRssReader('status', $data, $expected);

		foreach ($checks as $check) {
			//テスト実施
			$data['RssReader']['status'] = $check;
			$this->__assertSaveRssReader('status', $data, $expected);
		}
	}

/**
 * Expect RssReader->saveRssReader() to validate not empty fields
 *   and return false on validation error
 *
 * @return void
 */
	public function testSaveRssReaderByNotEmpty() {
		$frameId = 1;
		$blockId = 1;

		//Checkカラム
		$fields = array(
			'url' => sprintf(__d('net_commons', 'Please input %s.'), __d('rss_readers', 'RDF/RSS URL')),
			'title' => sprintf(__d('net_commons', 'Please input %s.'), __d('rss_readers', 'Site Title')),
		);
		//Check項目
		$checks = array(
			null, '', false,
		);

		foreach ($fields as $field => $message) {
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

			//期待値
			$expected = array(
				$field => array($message)
			);

			//テスト実施(カラムなし)
			unset($data['RssReader'][$field]);
			$this->__assertSaveRssReader($field, $data, $expected);

			//テスト実施
			foreach ($checks as $check) {
				$data['RssReader'][$field] = $check;
				$this->__assertSaveRssReader($field, $data, $expected);
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
		$frameId = 1;
		$blockId = 1;

		//Checkカラム
		$fields = array(
			'url' => sprintf(__d('net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'), __d('rss_readers', 'RDF/RSS URL'), __d('rss_readers', 'URL')),
			'link' => sprintf(__d('net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'), __d('rss_readers', 'Site Url'), __d('rss_readers', 'URL')),
		);
		//Check項目
		$checks = array(
			'http:', 'https:', 'ftp:', 'javascript:',
			'http:/', 'https:/', 'ftp:/', 'javascript:/',
			'http://', 'https://', 'ftp://', 'javascript://',
			'http://test', 'https://test', 'ftp://test', 'javascript:test', 'abc://exapmle.com',
		);

		foreach ($fields as $field => $message) {
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

			//期待値
			$expected = array(
				$field => array($message)
			);

			//テスト実施
			foreach ($checks as $check) {
				$data['RssReader'][$field] = $check;
				$this->__assertSaveRssReader($field, $data, $expected);
			}
		}
	}

/**
 * Expect RssReader->saveRssReader() to validate comment
 *   and return false on validation error
 *
 * @return void
 */
	public function testSaveRssReaderByComment() {
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
				'status' => NetCommonsBlockComponent::STATUS_DISAPPROVED,
				'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
				'title' => 'Edit title',
				'summary' => 'Edit summary',
				'link' => 'http://example.com',
			),
			'Comment' => array('comment' => ''),
		);

		//期待値
		$expected = array(
			'comment' => array(
				__d('net_commons', 'If it is not approved, comment is a required input.')
			)
		);

		//テスト実施
		$this->__assertSaveRssReader('comment', $data, $expected);
	}

/**
 * Expect RssReader->saveRssReader() to validate file asspcoated
 *   and return false on validation error
 *
 * @return void
 */
	public function testSaveRssReaderByRssReaderItem() {
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
		$data['RssReaderItem'] = $this->RssReaderItem->serializeXmlToArray(
			APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml'
		);
		$data['RssReaderItem'][0]['title'] = '';

		//テスト実施(詳細なバリデーションのチェックは、RssReaderItemValidateErrorTestで行う)
		$result = $this->RssReader->saveRssReader($data);
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
	private function __assertSaveRssReader($field, $data, $expected) {
		//初期処理
		$this->setUp();
		//登録処理実行
		$result = $this->RssReader->saveRssReader($data);
		//戻り値テスト
		$this->assertFalse($result, 'Result error: ' . $field . ' ' . print_r($data, true));
		//validationErrorsテスト
		$this->assertEquals($this->RssReader->validationErrors, $expected,
							'Validation error: ' . $field . ' ' . print_r($this->RssReader->validationErrors, true) . print_r($data, true));
		//終了処理
		$this->tearDown();
	}

}
