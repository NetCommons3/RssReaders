<?php
/**
 * RssReaderFrameSettingsController Test Case
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
 * Summary for RssReaderFrameSettingsController Test Case
 */
class RssReaderFrameSettingsControllerTest extends ControllerTestCase {

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
 * test form
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testForm() {
		$frameId = 1;
		$this->testAction(
			'/rss_readers/rss_reader_frame_settings/form/' . $frameId . '/',
			array('method' => 'get')
		);
		$this->assertTextContains('data[RssReaderFrameSetting][frame_key]', $this->view);
		$this->assertTextContains('data[RssReaderFrameSetting][display_number_per_page]', $this->view);
		$this->assertTextContains('data[RssReaderFrameSetting][display_site_info]', $this->view);
		$this->assertTextContains('data[RssReaderFrameSetting][display_summary]', $this->view);
		$this->assertTextContains('data[RssReaderFrameSetting][id]', $this->view);
		$this->assertTextContains('data[RssReaderFrameSetting][frame_key]', $this->view);
	}

/**
 * test form case not exist data
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testFormNotExistData() {
		$frameId = 5;
		$this->testAction(
			'/rss_readers/rss_reader_frame_settings/form/' . $frameId . '/',
			array('method' => 'get')
		);
		$this->assertTextContains('data[RssReaderFrameSetting][frame_key]', $this->view);
		$this->assertTextContains('data[RssReaderFrameSetting][display_number_per_page]', $this->view);
		$this->assertTextContains('data[RssReaderFrameSetting][display_site_info]', $this->view);
		$this->assertTextContains('data[RssReaderFrameSetting][display_summary]', $this->view);
		$this->assertTextContains('data[RssReaderFrameSetting][id]', $this->view);
		$this->assertTextContains('data[RssReaderFrameSetting][frame_key]', $this->view);
	}

/**
 * test form case not exist frame
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testFormNotExistFrame() {
		$frameId = 999;
		try {
			$this->testAction(
				'/rss_readers/rss_reader_frame_settings/form/' . $frameId . '/',
				array('method' => 'get')
			);
		} catch (ForbiddenException $e) {
			$this->assertEquals('NetCommonsFrame', $e->getMessage());
		}
	}

/**
 * test view
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testView() {
		$frameId = 1;

		$this->testAction(
			'/rss_readers/rss_reader_frame_settings/view/' . $frameId,
			array('method' => 'get')
		);
		$this->assertTextContains(
			'data[RssReaderFrameSetting][frame_key]',
			$this->view
		);
		$this->assertTextContains(
			'data[RssReaderFrameSetting][display_number_per_page]',
			$this->view
		);
		$this->assertTextContains(
			'data[RssReaderFrameSetting][display_site_info]',
			$this->view
		);
		$this->assertTextContains(
			'data[RssReaderFrameSetting][display_summary]',
			$this->view
		);
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
			$this->testAction(
				'/rss_readers/rss_reader_frame_settings/view/' . $frameId . '/',
				array('method' => 'get')
			);
		} catch (ForbiddenException $e) {
			$this->assertEquals('NetCommonsFrame', $e->getMessage());
		}
	}

/**
 * test view case not exist data
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testViewNotExistData() {
		$frameId = 5;
		try {
			$this->testAction(
				'/rss_readers/rss_reader_frame_settings/view/' . $frameId . '/',
				array('method' => 'get')
			);
		} catch (ForbiddenException $e) {
			$this->assertEquals('NetCommonsFrame', $e->getMessage());
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

