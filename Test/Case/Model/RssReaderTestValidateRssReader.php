<?php
/**
 * Test of RssReader->validateRssReader()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersModelTestCase', 'RssReaders.Test/Case/Model');

/**
 * Test of RssReader->validateRssReader()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test\Case\Model
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class RssReaderTestValidateRssReader extends RssReadersModelTestCase {

/**
 * default value
 *
 * @var array
 */
	private $__saveDefault = array(
		'RssReader' => array(
			'language_id' => '2',
			'key' => 'rss_reader_1',
			'status' => NetCommonsBlockComponent::STATUS_APPROVED,
			'title' => 'Edit title',
			'summary' => 'Edit summary',
			'link' => 'http://example.com',
		),
		'Comment' => array('comment' => 'Edit comment'),
	);

/**
 * Expect `status` validate error
 *
 * @return void
 */
	public function testStatus() {
		$frameId = '181';
		$blockId = '181';

		//コンテンツの公開権限true
		$this->RssReader->Behaviors->attach('Publishable');
		$this->RssReader->Behaviors->Publishable->setup($this->RssReader, ['contentPublishable' => true]);

		//データ生成
		$data = Hash::merge(
			$this->__saveDefault,
			array(
				'Frame' => array('id' => $frameId),
				'Block' => array('id' => $blockId),
				'RssReader' => array(
					'block_id' => $blockId,
					'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
				),
			)
		);

		//期待値
		$expected = array(
			'status' => array(
				__d('net_commons', 'Invalid request.')
			)
		);

		//テスト実施(カラムなし)
		unset($data['RssReader']['status']);
		$this->__assert('status', $data, $expected);

		foreach ($this->testCaseStatus as $check) {
			//テスト実施
			$data['RssReader']['status'] = $check;
			$this->__assert('status', $data, $expected);
		}
	}

/**
 * Expect `url` validate error by notEmpty
 *
 * @return void
 */
	public function testUrlByNotEmpty() {
		$frameId = '181';
		$blockId = '181';

		$field = 'url';
		$message = sprintf(__d('net_commons', 'Please input %s.'), __d('rss_readers', 'RDF/RSS URL'));

		//データ生成
		$data = Hash::merge(
			$this->__saveDefault,
			array(
				'Frame' => array('id' => $frameId),
				'Block' => array('id' => $blockId),
				'RssReader' => array(
					'block_id' => $blockId,
					'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
				),
			)
		);

		//期待値
		$expected = array(
			$field => array($message)
		);

		//テスト実施(カラムなし)
		unset($data['RssReader'][$field]);
		$this->__assert($field, $data, $expected);

		//テスト実施
		foreach ($this->testCaseNotEmpty as $check) {
			$data['RssReader'][$field] = $check;
			$this->__assert($field, $data, $expected);
		}
	}

/**
 * Expect `title` validate error by notEmpty
 *
 * @return void
 */
	public function testTitleByNotEmpty() {
		$frameId = '181';
		$blockId = '181';

		$field = 'title';
		$message = sprintf(__d('net_commons', 'Please input %s.'), __d('rss_readers', 'Site Title'));

		//データ生成
		$data = Hash::merge(
			$this->__saveDefault,
			array(
				'Frame' => array('id' => $frameId),
				'Block' => array('id' => $blockId),
				'RssReader' => array(
					'block_id' => $blockId,
					'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
				),
			)
		);

		//期待値
		$expected = array(
			$field => array($message)
		);

		//テスト実施(カラムなし)
		unset($data['RssReader'][$field]);
		$this->__assert($field, $data, $expected);

		//テスト実施
		foreach ($this->testCaseNotEmpty as $check) {
			$data['RssReader'][$field] = $check;
			$this->__assert($field, $data, $expected);
		}
	}

/**
 * Expect `url` validate error by url
 *
 * @return void
 */
	public function testUrlByUrl() {
		$frameId = '181';
		$blockId = '181';

		$field = 'url';
		$message = sprintf(__d('net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'), __d('rss_readers', 'RDF/RSS URL'), __d('net_commons', 'URL'));

		//データ生成
		$data = Hash::merge(
			$this->__saveDefault,
			array(
				'Frame' => array('id' => $frameId),
				'Block' => array('id' => $blockId),
				'RssReader' => array(
					'block_id' => $blockId,
					'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
				),
			)
		);

		//期待値
		$expected = array(
			$field => array($message)
		);

		//テスト実施
		foreach ($this->testCaseUrl as $check) {
			$data['RssReader'][$field] = $check;
			$this->__assert($field, $data, $expected);
		}
	}

/**
 * Expect `link` validate error by url
 *
 * @return void
 */
	public function testLinkByUrl() {
		$frameId = '181';
		$blockId = '181';

		$field = 'link';
		$message = sprintf(__d('net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'), __d('rss_readers', 'Site Url'), __d('net_commons', 'URL'));

		//データ生成
		$data = Hash::merge(
			$this->__saveDefault,
			array(
				'Frame' => array('id' => $frameId),
				'Block' => array('id' => $blockId),
				'RssReader' => array(
					'block_id' => $blockId,
					'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
				),
			)
		);

		//期待値
		$expected = array(
			$field => array($message)
		);

		//テスト実施
		foreach ($this->testCaseUrl as $check) {
			$data['RssReader'][$field] = $check;
			$this->__assert($field, $data, $expected);
		}
	}

/**
 * Expect RssReader->validateRssReader() to validate comment
 *   and return false on validation error
 *
 * @return void
 */
	public function testComment() {
		$frameId = '181';
		$blockId = '181';

		//コンテンツの公開権限true
		$this->RssReader->Behaviors->attach('Publishable');
		$this->RssReader->Behaviors->Publishable->setup($this->RssReader, ['contentPublishable' => true]);
		$this->RssReader->Comment = ClassRegistry::init('Comments.Comment');

		//データ生成
		$data = Hash::merge(
			$this->__saveDefault,
			array(
				'Frame' => array('id' => $frameId),
				'Block' => array('id' => $blockId),
				'RssReader' => array(
					'block_id' => $blockId,
					'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
					'status' => NetCommonsBlockComponent::STATUS_DISAPPROVED,
				),
				'Comment' => array('comment' => ''),
			)
		);

		//期待値
		$expected = array(
			'comment' => array(
				__d('net_commons', 'If it is not approved, comment is a required input.')
			)
		);

		//テスト実施
		$result = $this->RssReader->validateRssReader($data, ['comment']);

		$this->assertFalse($result);
		$this->assertEquals($this->RssReader->validationErrors, $expected);
	}

/**
 * Expect RssReader->validateRssReader() to validate file asspcoated
 *   and return false on validation error
 *
 * @return void
 */
	public function testRssReaderItem() {
		$frameId = '181';
		$blockId = '181';

		//データ生成
		$data = Hash::merge(
			$this->__saveDefault,
			array(
				'Frame' => array('id' => $frameId),
				'Block' => array('id' => $blockId),
				'RssReader' => array(
					'block_id' => $blockId,
					'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
				),
			)
		);
		$data['RssReaderItem'] = $this->RssReaderItem->serializeXmlToArray(
			APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml'
		);
		$data['RssReaderItem'][0]['title'] = '';

		//テスト実施(詳細なバリデーションのチェックは、RssReaderItemValidateErrorTestで行う)
		$result = $this->RssReader->validateRssReader($data, ['rss_reader_item']);
		$this->assertFalse($result);
	}

/**
 * __assert
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
		$result = $this->RssReader->validateRssReader($data);
		//戻り値テスト
		$this->assertFalse($result, 'Result error: ' . $field . ' ' . print_r($data, true));
		//validationErrorsテスト
		$this->assertEquals($this->RssReader->validationErrors, $expected,
							'Validation error: ' . $field . ' ' . print_r($this->RssReader->validationErrors, true) . print_r($data, true));
		//終了処理
		$this->tearDown();
	}

}
