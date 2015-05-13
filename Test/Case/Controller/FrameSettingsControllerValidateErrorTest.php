<?php
/**
 * RssReadersController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RssReaderFrameSettingsController', 'RssReaders.Controller');
App::uses('RssReadersControllerTestCase', 'RssReaders.Test/Case/Controller');

/**
 * RssReadersController Validation Error Test Case based on models
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test\Case\Controller
 */
class RssReaderFrameSettingsControllerValidateErrorTest extends RssReadersControllerTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		$this->generate(
			'RssReaders.RssReaderFrameSettings',
			[
				'components' => [
					'Auth' => ['user'],
					'Session',
					'Security',
				]
			]
		);
		parent::setUp();
	}

/**
 * Expect user cannot edit w/o valid edumap.status
 *
 * @return void
 */
	public function testEditPostValidationError() {
		RolesControllerTest::login($this);

		//データ生成
		$frameId = '181';
		$blockId = '181';
		$framekey = '';
		$rssFrameSettingId = '1';

		//登録処理実行
		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId),
			'RssReaderFrameSetting' => array(
				'id' => $rssFrameSettingId,
				'frame_key' => $framekey,
				'display_number_per_page' => '5'
			),
			'save' => ''
		);

		$this->testAction(
			'/rss_readers/rss_reader_frame_settings/edit/' . $frameId,
			array(
				'method' => 'post',
				'data' => $data,
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('edit', $this->controller->view);

		AuthGeneralControllerTest::logout($this);
	}
}
