<?php
/**
 * Test of RssReaderFrameSetting->validateRssReaderFrameSetting()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersModelTestBase', 'RssReaders.Test/Case/Model');

/**
 * Test of RssReaderFrameSetting->validateRssReaderFrameSetting()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test\Case\Model
 * @SuppressWarnings(PHPMD.DevelopmentCodeFragment)
 */
class RssReaderFrameSettingValidateRssReaderFrameSettingTest extends RssReadersModelTestBase {

/**
 * Expect `frame_key` validate error by notBlank
 *
 * @return void
 */
	public function testFrameKeyByNotEmpty() {
		$frameId = '181';
		$framekey = 'frame_181';
		$blockId = '181';
		$rssFrameSettingId = 1;

		//データ生成
		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId),
			'RssReaderFrameSetting' => array(
				'id' => $rssFrameSettingId,
				'frame_key' => $framekey,
				'display_number_per_page' => '5'
			),
		);

		//テスト実施(カラムなし)
		unset($data['RssReaderFrameSetting']['frame_key']);
		$result = $this->RssReaderFrameSetting->validateRssReaderFrameSetting($data);
		$this->assertFalse($result, 'Result error: frame_key ' . print_r($data, true));

		//テスト実施
		foreach ($this->testCaseNotEmpty as $check) {
			$data['RssReaderFrameSetting']['frame_key'] = $check;
			$result = $this->RssReaderFrameSetting->validateRssReaderFrameSetting($data);
			$this->assertFalse($result, 'Result error: frame_key ' . print_r($data, true));
		}
	}

/**
 * Expect `display_number_per_page` validate error by number
 *
 * @return void
 */
	public function testDisplayNumberPerPageByNumber() {
		$frameId = '181';
		$framekey = 'frame_181';
		$blockId = '181';
		$rssFrameSettingId = 1;

		//データ生成
		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId),
			'RssReaderFrameSetting' => array(
				'id' => $rssFrameSettingId,
				'frame_key' => $framekey,
				'display_number_per_page' => '5'
			),
		);

		//テスト実施(カラムなし)
		unset($data['RssReaderFrameSetting']['display_number_per_page']);
		$result = $this->RssReaderFrameSetting->validateRssReaderFrameSetting($data);
		$this->assertFalse($result, 'Result error: display_number_per_page ' . print_r($data, true));

		//テスト実施
		foreach ($this->testCaseNumber as $check) {
			$data['RssReaderFrameSetting']['display_number_per_page'] = $check;
			$result = $this->RssReaderFrameSetting->validateRssReaderFrameSetting($data);
			$this->assertFalse($result, 'Result error: display_number_per_page ' . print_r($data, true));
		}
	}
}
