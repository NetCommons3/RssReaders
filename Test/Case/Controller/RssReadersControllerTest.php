<?php
/**
 * RssReadersController Test Case
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersController', 'RssReaders.Controller');
App::uses('RssReadersControllerTestCase', 'RssReaders.Test/Case/Controller');

/**
 * Expect RssReadersController
 *
 * @package NetCommons\RssReaders\Test\Case\Controller
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class RssReadersControllerTest extends RssReadersControllerTestCase {

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
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->testAction(
			'/rss_readers/rss_readers/index/181',
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);

		$this->assertTextEquals('view', $this->controller->view);
	}

/**
 * Expect visitor can access view action
 *
 * @return void
 */
	public function testView() {
		$this->testAction(
			'/rss_readers/rss_readers/view/181',
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);

		$this->assertTextEquals('view', $this->controller->view);
	}

/**
 * Expect visitor can access view action by json
 *
 * @return void
 */
	public function testViewJson() {
		$ret = $this->testAction(
			'/rss_readers/rss_readers/view/181.json',
			array(
				'method' => 'get',
				'type' => 'json',
				'return' => 'contents',
			)
		);
		$result = json_decode($ret, true);

		$this->assertTextEquals('view', $this->controller->view);
		$this->assertArrayHasKey('code', $result, print_r($result, true));
		$this->assertEquals(200, $result['code'], print_r($result, true));
	}

/**
 * Expect admin user can access view action
 *
 * @return void
 */
	public function testViewByAdmin() {
		RolesControllerTest::login($this);

		$view = $this->testAction(
			'/rss_readers/rss_readers/view/181',
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);

		$this->assertTextEquals('view', $this->controller->view);
		$this->assertTextContains('nc-rss-readers-1', $view, print_r($view, true));
		$this->assertTextContains('/rss_readers/rss_readers/edit/1', $view, print_r($view, true));

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect user cannot access view action with unknown frame id
 *
 * @return void
 */
	public function testViewByUnkownFrameId() {
		$this->setExpectedException('InternalErrorException');
		$this->testAction(
			'/rss_readers/rss_readers/view/999',
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);
	}

/**
 * Expect visitor can access view action
 *
 * @return void
 */
	public function testViewCache() {
		$this->testAction(
			'/rss_readers/rss_readers/view/182',
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);

		$this->assertTextEquals('view', $this->controller->view);
	}

/**
 * Expect admin user can access edit action
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
 * Expect admin user can access edit action
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
 * Expect admin user can access edit action
 *
 * @return void
 */
	public function testEditGetSiteInfoByRss1() {
		RolesControllerTest::login($this);

		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml';
		$this->testAction(
			'/rss_readers/rss_readers/edit/181?url=' . rawurlencode($url),
			array(
				'method' => 'get',
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('edit', $this->controller->view);

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect admin user can access edit action
 *
 * @return void
 */
	public function testEditGetSiteInfoByRss2() {
		RolesControllerTest::login($this);

		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v2.xml';
		$this->testAction(
			'/rss_readers/rss_readers/edit/181?url=' . rawurlencode($url),
			array(
				'method' => 'get',
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('edit', $this->controller->view);

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect admin user can access edit action
 *
 * @return void
 */
	public function testEditGetSiteInfoByAtom() {
		RolesControllerTest::login($this);

		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_atom.xml';
		$this->testAction(
			'/rss_readers/rss_readers/edit/181?url=' . rawurlencode($url),
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
 * Expect admin user can publish edumap
 *
 * @return void
 */
	public function testEditPost() {
		RolesControllerTest::login($this);

		//データ生成
		$frameId = '181';
		$blockId = '181';

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
 * Expect admin user can publish edumap
 *
 * @return void
 */
	public function testEditPostWithoutBlock() {
		RolesControllerTest::login($this);

		//データ生成
		$frameId = '183';
		$blockId = '';

		$data = array(
			'Frame' => array('id' => $frameId),
			'Block' => array('id' => $blockId),
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

}
