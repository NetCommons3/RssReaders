<?php
/**
 * Test of RssReadersController edit action
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersController', 'RssReaders.Controller');
App::uses('RssReadersControllerTestCase', 'RssReaders.Test/Case/Controller');

/**
 * Test of RssReadersController edit action
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test\Case\Controller
 */
class RssReadersControllerTestEdit extends RssReadersControllerTestCase {

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
 * Expect admin user can access edit action as get request
 *
 * @return void
 */
	public function testEditGet() {
		RolesControllerTest::login($this);

		$this->testAction(
			'/rss_readers/rss_readers/edit/181',
			array(
				'method' => 'get',
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('edit', $this->controller->view);

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect admin user can access edit action as get request
 *
 * @return void
 */
	public function testEditGetWithoutBlock() {
		RolesControllerTest::login($this);

		$this->testAction(
			'/rss_readers/rss_readers/edit/183',
			array(
				'method' => 'get',
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('edit', $this->controller->view);

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect edit action to be successfully handled w/ null frame.block_id
 * This situation typically occur after placing new plugin into page
 *
 * @return void
 */
	public function testAddFrameWithoutBlock() {
		$this->testAction(
			'/rss_readers/rss_readers/view/183',
			array(
				'method' => 'get',
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('view', $this->controller->view);
	}

/**
 * Expect admin user can access edit action as post request
 *
 * @return void
 */
	public function testEditPost() {
		RolesControllerTest::login($this);

		//データ生成
		$frameId = '181';
		$blockId = '181';
		$blockKey = 'block_' . $blockId;
		$roomId = '1';

		//データ生成
		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId, 'key' => $blockKey, 'room_id' => $roomId),
			'RssReader' => array(
				'key' => 'rss_reader_1',
				'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
				'title' => 'Edit title',
				'summary' => 'Edit summary',
				'link' => 'http://example.com',
			),
			'Comment' => array('comment' => 'Edit comment'),
			sprintf('save_%s', NetCommonsBlockComponent::STATUS_PUBLISHED) => '',
		);

		//テスト実行
		$this->testAction(
			'/rss_readers/rss_readers/edit/' . $frameId,
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
 * Expect without block as post request
 *
 * @return void
 */
	public function testEditPostWithoutBlock() {
		RolesControllerTest::login($this);

		//データ生成
		$frameId = '183';
		$blockId = '';
		$blockKey = '';
		$roomId = '1';

		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId, 'key' => $blockKey, 'room_id' => $roomId),
			'RssReader' => array(
				'id' => '',
				'key' => 'rss_reader_3',
				'url' => APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml',
				'title' => 'Edit title',
				'summary' => 'Edit summary',
				'link' => 'http://example.com',
			),
			'Comment' => array('comment' => 'Edit comment'),
			sprintf('save_%s', NetCommonsBlockComponent::STATUS_PUBLISHED) => '',
		);

		//テスト実行
		$this->testAction(
			'/rss_readers/rss_readers/edit/' . $frameId,
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
 * Expect user cannot edit w/o valid rss_readers.status
 *
 * @return void
 */
	public function testEditWithInvalidStatus() {
		RolesControllerTest::login($this);

		$frameId = '181';
		$blockId = '181';
		$blockKey = 'block_' . $blockId;
		$roomId = '1';

		//データ生成
		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId, 'key' => $blockKey, 'room_id' => $roomId),
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
 * Expect user cannot edit w/o valid rss_readers.status as ajax post request
 *
 * @return void
 */
	public function testEditWithInvalidStatusJson() {
		RolesControllerTest::login($this);

		//データ生成
		$frameId = '181';
		$blockId = '181';
		$blockKey = 'block_' . $blockId;
		$roomId = '1';

		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId, 'key' => $blockKey, 'room_id' => $roomId),
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
 * Expect user cannot edit w/o valid rss_readers.title
 *
 * @return void
 */
	public function testEditTitleError() {
		RolesControllerTest::login($this);

		//データ生成
		$frameId = '181';
		$blockId = '181';
		$blockKey = 'block_' . $blockId;
		$roomId = '1';

		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId, 'key' => $blockKey, 'room_id' => $roomId),
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
		$frameId = '181';
		$blockId = '181';
		$blockKey = 'block_' . $blockId;
		$roomId = '1';

		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId, 'key' => $blockKey, 'room_id' => $roomId),
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

}
