<?php
/**
 * RssReaderFrameSettingsController Test Case
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReaderFrameSettingsController', 'RssReaders.Controller');
App::uses('RssReadersControllerTestCase', 'RssReaders.Test/Case/Controller');

/**
 * Summary for RssReaderFrameSettingsController Test Case
 */
class RssReaderFrameSettingsControllerTest extends RssReadersControllerTestCase {

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
 * Expect admin user can access edit action
 *
 * @return void
 */
	public function testEditGet() {
		RolesControllerTest::login($this);

		$this->testAction(
			'/rss_readers/rss_reader_frame_settings/edit/181',
			array(
				'method' => 'get',
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('edit', $this->controller->view);

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect view action to be successfully handled w/ null frame.block_id
 * This situation typically occur after placing new plugin into page
 *
 * @return void
 */
	public function testAddFrameWithoutBlock() {
		RolesControllerTest::login($this);

		$this->testAction(
			'/rss_readers/rss_reader_frame_settings/edit/182',
			array(
				'method' => 'get',
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('edit', $this->controller->view);

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect admin user can publish edumap
 *
 * @return void
 */
	public function testEditPost() {
		RolesControllerTest::login($this);

		//データ生成
		$frameId = '181';
		$blockId = '181';
		$framekey = 'frame_181';
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

/**
 * Expect without block
 *
 * @return void
 */
	public function testEditPostWithoutBlock() {
		RolesControllerTest::login($this);

		//データ生成
		$frameId = '182';
		$blockId = '182';
		$framekey = 'frame_182';
		$rssFrameSettingId = '2';

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

