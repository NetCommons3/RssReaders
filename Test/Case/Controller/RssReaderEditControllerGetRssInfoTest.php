<?php
/**
 * RssReaderEditController Test Case getRssInfo method
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
 * Summary for RssReaderEditController Test Case getRssInfo method
 */
class RssReaderEditControllerGetRssInfoTest extends ControllerTestCase {

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
		'plugin.frames.language',
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
 * test getRssInfo
 *
 * @return void
 */
	public function testGetRssInfo() {
		$xml = '<?xml version="1.0" encoding="utf-8"?><rss version="2.0"></rss>';
		$this->testAction(
			'/rss_readers/rss_reader_edit/get_rss_info?url=' . urlencode($xml),
			array('method' => 'get')
		);

		// 存在しないURLを指定時
		$url = 'http://test.example';
		try {
			$this->testAction(
				'/rss_readers/rss_reader_edit/get_rss_info?url=' . $url,
				array('method' => 'get')
			);
		} catch (ForbiddenException $e) {
			$this->assertEquals(__d('rss_readers', 'Feed Not Found.'), $e->getMessage());
		}
	}

/**
 * test getRssInfo case rss type atom
 *
 * @return void
 */
	public function testGetRssInfoTypeAtom() {
		// RSSの種類がatomの場合
		$xml = '<?xml version="1.0" encoding="utf-8"?><feed><link rel="alternate" type="text/html" href="http://test.example.com"></link></feed>';
		$this->testAction(
			'/rss_readers/rss_reader_edit/get_rss_info?url=' . urlencode($xml),
			array('method' => 'get')
		);
	}

/**
 * login　method
 *
 * @return void
 */
	private function __login() {
		// ログイン処理
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
		// ログアウト処理
		$this->Controller->Auth->logout();
		$this->assertFalse($this->Controller->Auth->loggedIn(), 'logout');

		CakeSession::write('Auth.User', null);
		unset($this->Controller);
	}

}
