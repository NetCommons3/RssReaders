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

App::uses('RssReadersController', 'RssReaders.Controller');
App::uses('RssReadersControllerTestCase', 'RssReaders.Test/Case/Controller');

/**
 * RssReadersController Validation Error Test Case based on models
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test\Case\Controller
 */
class RssReadersControllerValidateErrorTest extends RssReadersControllerTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		$this->generate(
			'RssReaders.RssReaders',
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
	public function testEditWithInvalidStatus() {
		RolesControllerTest::login($this);

		$frameId = 1;
		$blockId = 1;

		//データ生成
		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId),
			'RssReader' => array(
				'key' => 'rss_reader_1',
				'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
				'title' => 'Edit title',
				'summary' => 'Edit summary',
				'link' => 'http://example.com',
			),
			'Comment' => array('comment' => 'Edit comment'),
		);

		//テスト実行
		$this->setExpectedException('BadRequestException');
		$this->testAction(
			'/rss_readers/rss_readers/edit/' . $frameId,
			array(
				'method' => 'post',
				'data' => $data,
				'return' => 'contents'
			)
		);

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect user cannot edit w/o valid edumap.status as ajax request
 *
 * @return void
 */
	public function testEditWithInvalidStatusJson() {
		RolesControllerTest::login($this);

		//データ生成
		$frameId = 1;
		$blockId = 1;

		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId),
			'RssReader' => array(
				'key' => 'rss_reader_1',
				'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
				'title' => 'Edit title',
				'summary' => 'Edit summary',
				'link' => 'http://example.com',
			),
			'Comment' => array('comment' => 'Edit comment'),
		);

		//テスト実行
		$ret = $this->testAction(
			'/rss_readers/rss_readers/edit/' . $frameId . '.json',
			array(
				'method' => 'post',
				'data' => $data,
				'type' => 'json',
				'return' => 'contents'
			)
		);
		$result = json_decode($ret, true);
		$this->assertArrayHasKey('code', $result, print_r($result, true));
		$this->assertEquals(400, $result['code'], print_r($result, true));

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect user cannot edit w/o valid announcements.content
 *
 * @return void
 */
	public function testEditTitleError() {
		RolesControllerTest::login($this);

		//データ生成
		$frameId = 1;
		$blockId = 1;

		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId),
			'RssReader' => array(
				'key' => 'rss_reader_1',
				'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
				'title' => '',
				'summary' => 'Edit summary',
				'link' => 'http://example.com',
			),
			'Comment' => array('comment' => 'Edit comment'),
			sprintf('save_%s', NetCommonsBlockComponent::STATUS_APPROVED) => '',
		);

		//テスト実行
		$ret = $this->testAction(
			'/rss_readers/rss_readers/edit/' . $frameId . '.json',
			array(
				'method' => 'post',
				'data' => $data,
				'type' => 'json',
				'return' => 'contents'
			)
		);
		$result = json_decode($ret, true);

		$this->assertArrayHasKey('code', $result, print_r($result, true));
		$this->assertEquals(400, $result['code'], print_r($result, true));
		$this->assertArrayHasKey('name', $result, print_r($result, true));
		$this->assertArrayHasKey('error', $result, print_r($result, true));
		$this->assertArrayHasKey('validationErrors', $result['error'], print_r($result, true));
		$this->assertArrayHasKey('title', $result['error']['validationErrors'], print_r($result, true));

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect admin user cannot disapprove publish request from editor w/o comments.comment
 *
 * @return void
 */
	public function testEditCommentError() {
		RolesControllerTest::login($this);

		//データ生成
		$frameId = 1;
		$blockId = 1;

		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId),
			'RssReader' => array(
				'key' => 'rss_reader_1',
				'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
				'title' => 'Edit title',
				'summary' => 'Edit summary',
				'link' => 'http://example.com',
			),
			'Comment' => array('comment' => ''),
			sprintf('save_%s', NetCommonsBlockComponent::STATUS_DISAPPROVED) => '',
		);

		//テスト実行
		$ret = $this->testAction(
			'/rss_readers/rss_readers/edit/' . $frameId . '.json',
			array(
				'method' => 'post',
				'data' => $data,
				'type' => 'json',
				'return' => 'contents'
			)
		);
		$result = json_decode($ret, true);

		$this->assertArrayHasKey('code', $result, print_r($result, true));
		$this->assertEquals(400, $result['code'], print_r($result, true));
		$this->assertArrayHasKey('name', $result, print_r($result, true));
		$this->assertArrayHasKey('error', $result, print_r($result, true));
		$this->assertArrayHasKey('validationErrors', $result['error'], print_r($result, true));

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect admin user can access edit action
 *
 * @return void
 */
	public function testEditGetSiteInfoError() {
		RolesControllerTest::login($this);

		$url = 'test';
		$this->testAction(
			'/rss_readers/rss_readers/edit/1?url=' . rawurlencode($url),
			array(
				'method' => 'get',
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('edit', $this->controller->view);

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect access view action
 *
 * @return void
 */
	public function testViewUpdateCacheError() {
		$this->testAction(
			'/rss_readers/rss_readers/view/4',
			array(
				'method' => 'get',
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('view', $this->controller->view);
	}

}
