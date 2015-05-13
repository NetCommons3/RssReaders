<?php
/**
 * Test of RssReaderFrameSetting->saveRssReaderFrameSetting()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersModelTestCase', 'RssReaders.Test/Case/Model');

/**
 * Test of RssReaderFrameSetting->saveRssReaderFrameSetting()
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test\Case\Model
 */
class RssReaderFrameSettingTestSaveRssReaderFrameSetting extends RssReadersModelTestCase {

/**
 * Expect RssReader->testSaveRssReaderFrameSetting()
 *
 * @return void
 */
	public function testSaveRssReaderFrameSetting() {
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

		//登録処理実行
		$this->RssReaderFrameSetting->saveRssReaderFrameSetting($data);

		//期待値の生成
		$expected = $data;

		//テスト実施
		$result = $this->RssReaderFrameSetting->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'id' => $expected['RssReaderFrameSetting']['id']
			)
		));

		$this->_assertArray(null, $expected['RssReaderFrameSetting'], $result['RssReaderFrameSetting']);
	}

}
