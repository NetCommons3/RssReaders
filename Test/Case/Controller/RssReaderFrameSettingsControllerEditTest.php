<?php
/**
 * RssReaderFrameSettingsController Edit Test Case
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReaderFrameSettingsController', 'RssReaders.Controller');
App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');

/**
 * Summary for RssReaderFrameSettingsController Edit Test Case
 */
class RssReaderFrameSettingsControllerEditTest extends ControllerTestCase {

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
 * test edit
 *
 * @return void
 */
	public function testEdit() {
		$data = array(
			'RssReaderFrameSetting' => array(
				'frame_key' => 'jidkgji409u490u032jalk4j02jgraljijgkak494958030jj0hjaalek339rr',
				'display_number_per_page' => 10,
				'display_site_info' => true,
				'display_summary' => true
			)
		);
		$frameId = 1;

		$this->testAction(
			'/rss_readers/rss_reader_frame_settings/edit/' . $frameId,
			array('method' => 'post', 'data' => $data)
		);
	}

/**
 * test edit case not room role
 *
 * @return void
 */
	public function testEditNotRoomRole() {
		CakeSession::write('Auth.User', null);
		$user = array(
			'id' => 999
		);
		CakeSession::write('Auth.User', $user);
		$frameId = 1;

		$data = array(
			'RssReaderFrameSetting' => array(
				'frame_key' => 'jidkgji409u490u032jalk4j02jgraljijgkak494958030jj0hjaalek339rr',
				'display_number_per_page' => 10,
				'display_site_info' => true,
				'display_summary' => true
			)
		);
		try {
			$this->testAction(
				'/rss_readers/rss_reader_frame_settings/edit/' . $frameId,
				array('method' => 'post', 'data' => $data)
			);
		} catch (ForbiddenException $e) {
			$this->assertEquals('Forbidden', $e->getMessage());
		}
	}

/**
 * login　method
 *
 * @return void
 */
	private function __login() {
		//ログイン処理
		$this->Controller = $this->generate(
			'RssReaders.RssReaderFrameSettings',
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

