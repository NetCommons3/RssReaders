<?php
/**
 * RssReadersController Test Case
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersController', 'RssReaders.Controller');
App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');

/**
 * Summary for RssReadersController Test Case
 */
class RssReadersControllerTest extends ControllerTestCase {

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
		'plugin.rooms.user'
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
 * test index
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testIndex() {
		$frameId = 1;
		$this->testAction('/rss_readers/rss_readers/index/' . $frameId . '/', array('method' => 'get'));
		$this->assertTextContains('nc-rss-readers-body-' . $frameId, $this->view);
	}

/**
 * test index case rss_reader status approving
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testIndexApprovingData() {
		// statusが申請中状態の表示
		$frameId = 2;
		$this->testAction('/rss_readers/rss_readers/index/' . $frameId . '/', array('method' => 'get'));
		$this->assertTextContains('nc-rss-readers-body-' . $frameId, $this->view);
	}

/**
 * test index case rss_reader status drafting
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testIndexDraftingData() {
		// statusが下書き状態の表示
		$frameId = 3;
		$this->testAction('/rss_readers/rss_readers/index/' . $frameId . '/', array('method' => 'get'));
		$this->assertTextContains('nc-rss-readers-body-' . $frameId, $this->view);
	}

/**
 * test index case rss_reader status drafting and logout
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testIndexDraftingDataCaseLogout() {
		// ログアウト時のstatusが下書き状態のデータが非表示になるか確認
		CakeSession::write('Auth.User', null);
		$frameId = 3;
		$this->testAction('/rss_readers/rss_readers/index/' . $frameId . '/', array('method' => 'get'));
		$this->assertTextNotContains('nc-rss-readers-body-' . $frameId, $this->view);
	}

/**
 * test index case rss_reader status disapproving
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testIndexDisapprovingData() {
		// statusが下書き状態の表示
		$frameId = 4;
		$this->testAction('/rss_readers/rss_readers/index/' . $frameId . '/', array('method' => 'get'));
		$this->assertTextContains('nc-rss-readers-body-' . $frameId, $this->view);
	}

/**
 * test index case not exist rss_reader
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function testIndexNotExistData() {
		// RssReaderが存在しない場合の表示
		$frameId = 5;
		$this->testAction('/rss_readers/rss_readers/index/' . $frameId . '/', array('method' => 'get'));
		$this->assertTextNotContains('nc-rss-readers-body-' . $frameId, $this->view);
	}

/**
 * login　method
 *
 * @return void
 */
	private function __login() {
		// ログイン処理
		$this->Controller = $this->generate(
			'RssReaders.RssReaders',
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
