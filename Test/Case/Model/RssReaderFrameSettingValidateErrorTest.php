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
class RssReaderFrameSettingValidateErrorTest extends RssReadersModelTestCase {

/**
 * Expect RssReaderFrameSetting->saveRssReaderFrameSetting() to validate not empty fields
 *   and return false on validation error
 *
 * @return void
 */
	public function testSaveRssReaderFrameSettingByFrameKey() {
		$frameId = '181';
		$framekey = 'frame_181';
		$blockId = '181';
		$rssFrameSettingId = 1;

		//Check項目
		$checks = array(
			null, '', false,
		);

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
		$result = $this->RssReaderFrameSetting->saveRssReaderFrameSetting($data);
		$this->assertFalse($result, 'Result error: frame_key ' . print_r($data, true));

		//テスト実施
		foreach ($checks as $check) {
			$data['RssReaderFrameSetting']['frame_key'] = $check;
			$result = $this->RssReaderFrameSetting->saveRssReaderFrameSetting($data);
			$this->assertFalse($result, 'Result error: frame_key ' . print_r($data, true));
		}
	}

/**
 * Expect RssReaderFrameSetting->saveRssReaderFrameSetting() to validate not empty fields
 *   and return false on validation error
 *
 * @return void
 */
	public function testSaveRssReaderFrameSettingByNumber() {
		$frameId = '181';
		$framekey = 'frame_181';
		$blockId = '181';
		$rssFrameSettingId = 1;

		//Check項目
		$checks = array(
			null, '', 'abcde', false, true, '123abcd'
		);

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
		$result = $this->RssReaderFrameSetting->saveRssReaderFrameSetting($data);
		$this->assertFalse($result, 'Result error: display_number_per_page ' . print_r($data, true));

		//テスト実施
		foreach ($checks as $check) {
			$data['RssReaderFrameSetting']['display_number_per_page'] = $check;
			$result = $this->RssReaderFrameSetting->saveRssReaderFrameSetting($data);
			$this->assertFalse($result, 'Result error: display_number_per_page ' . print_r($data, true));
		}
	}
}
