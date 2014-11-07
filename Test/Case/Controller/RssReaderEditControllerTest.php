<?php
/**
 * RssReaderEditController Test Case
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReaderEditController', 'RssReaders.Controller');
App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');

/**
 * Summary for RssReaderEditController Test Case
 */
class RssReaderEditControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rss_readers.rss_reader',
		'plugin.rss_readers.rss_reader_frame_setting',
		'plugin.rss_readers.block',
		'plugin.rss_readers.frame',
		'plugin.rss_readers.site_setting',
		'plugin.rss_readers.box',
		'plugin.rss_readers.plugin',
		'plugin.rss_readers.language',
		'plugin.rooms.room',
		'plugin.rooms.roles_rooms_user',
		'plugin.roles.default_role_permission',
		'plugin.rooms.roles_room',
		'plugin.rooms.room_role_permission',
		'plugin.rooms.user',
		'plugin.pages.page'
	);

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		Configure::write('Config.language', 'ja');
		$this->__login();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Configure::write('Config.language', null);
		parent::tearDown();
		$this->__logout();
	}

/**
 * authUserCallback method
 *
 * @return array user
 */
	public function authUserCallback() {
		$user = array(
			'id' => 1,
			'username' => 'admin',
			'role_key' => 'system_administrator'
		);
		CakeSession::write('Auth.User', $user);
		return $user;
	}

/**
 * test view
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testView() {
		$frameId = 1;
		$this->testAction('/rss_readers/rss_reader_edit/view/' . $frameId . '/', array('method' => 'get'));
		$this->assertTextContains('data[RssReader][url]', $this->view);
		$this->assertTextContains('data[RssReader][title]', $this->view);
		$this->assertTextContains('data[RssReader][summary]', $this->view);
		$this->assertTextContains('data[RssReader][link]', $this->view);
	}

/**
 * test view case not exist rss_reader
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testViewNotExistData() {
		$frameId = 5;
		$this->testAction('/rss_readers/rss_reader_edit/view/' . $frameId . '/', array('method' => 'get'));
		$this->assertTextContains('data[RssReader][url]', $this->view);
		$this->assertTextContains('data[RssReader][title]', $this->view);
		$this->assertTextContains('data[RssReader][summary]', $this->view);
		$this->assertTextContains('data[RssReader][link]', $this->view);
	}

/**
 * test view case not room role
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testViewNotRoomRole() {
		CakeSession::write('Auth.User', null);
		$user = array(
			'id' => 999
		);
		CakeSession::write('Auth.User', $user);
		$frameId = 1;
		try {
			$this->testAction('/rss_readers/rss_reader_edit/view/' . $frameId . '/', array('method' => 'get'));
		} catch (ForbiddenException $e) {
			$this->assertEquals('Forbidden', $e->getMessage());
		}
	}

/**
 * test view case not exist frame
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testViewNotExistFrame() {
		$frameId = 999;
		try {
			$this->testAction('/rss_readers/rss_reader_edit/view/' . $frameId . '/', array('method' => 'get'));
		} catch (ForbiddenException $e) {
			$this->assertEquals('NetCommonsFrame', $e->getMessage());
		}
	}

/**
 * test edit case post
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testEditPost() {
		$data = array(
			'RssReader' => array(
				'id' => '',
				'url' => 'http://zenk.co.jp/feed/rdf',
				'title' => '株式会社ゼンク',
				'summary' => '株式会社ゼンクです。',
				'link' => 'http://zenk.co.jp',
				'cache_time' => 259200
			),
			'Block' => array(
			),
			'Frame' => array(
				'id' => 5
			)
		);
		$result = $this->testAction('/rss_readers/rss_reader_edit/edit', array('method' => 'post', 'data' => $data));
		$this->assertTextContains('true', $result);
	}

/**
 * test getRssInfo
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testGetRssInfo() {
		$data = array(
			'RssReader' => array(
				'url' => 'http://zenk.co.jp/feed/rdf'
			)
		);
		$result = $this->testAction('/rss_readers/rss_reader_edit/getRssInfo', array('method' => 'post', 'data' => $data));
		$this->assertTextContains('data', $result);
		$this->assertTextContains('title', $result);
		$this->assertTextContains('link', $result);
		$this->assertTextContains('summary', $result);

		// 存在しないURLを指定時
		$data = array(
			'RssReader' => array(
				'url' => 'http://test.example'
			)
		);
		$result = $this->testAction('/rss_readers/rss_reader_edit/getRssInfo', array('method' => 'post', 'data' => $data));
		$encodeMessage = json_encode(__d('rss_readers', 'Feed Not Found.'));
		$this->assertTextContains($encodeMessage, $result);
		$this->assertTextContains('false', $result);
	}

/**
 * login　method
 *
 * @return void
 */
	private function __login() {
		//ログイン処理
		$this->Controller = $this->generate(
			'RssReaders.RssReaderEdit',
			array(
				'components' => array(
					'Auth' => array('user'),
					'Session',
					'Security',
					'RequestHandler'
				)
			)
		);

		$this->Controller->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnCallback(array($this, 'authUserCallback')));

		$this->Controller->Auth->login(array(
				'username' => 'admin',
				'password' => 'admin',
				'role_key' => 'system_administrator'
			)
		);
		$this->assertTrue($this->Controller->Auth->loggedIn(), 'login');
	}

/**
 * logout method
 *
 * @return void
 */
	private function __logout() {
		//ログアウト処理
		$this->Controller->Auth->logout();
		$this->assertFalse($this->Controller->Auth->loggedIn(), 'logout');

		CakeSession::write('Auth.User', null);
		unset($this->Controller);
	}

}
