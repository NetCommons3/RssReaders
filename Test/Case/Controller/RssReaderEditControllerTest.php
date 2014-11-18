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
 * test view
 *
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
 * @return void
 */
	public function testEditPost() {
		$xml = <<<EOF
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
    <channel>

        <title>Example Feed</title>
        <description>Insert witty or insightful remark here</description>
        <link>http://example.org/</link>
        <lastBuildDate>Sat, 13 Dec 2003 18:30:02 GMT</lastBuildDate>
        <managingEditor>johndoe@example.com (John Doe)</managingEditor>

        <item>
            <title>Atom-Powered Robots Run Amok</title>
            <link>http://example.org/2003/12/13/atom03</link>
            <guid isPermaLink="false">urn:uuid:1225c695-cfb8-4ebb-aaaa-80da344efa6a</guid>
            <pubDate>Sat, 13 Dec 2003 18:30:02 GMT</pubDate>
            <description>Some text.</description>
        </item>

    </channel>
</rss>
EOF;
		$data = array(
			'RssReader' => array(
				'id' => '',
				'url' => $xml,
				'title' => 'テストサイト',
				'summary' => 'Rssのテスト用サイト',
				'link' => 'http://example.com',
				'cache_time' => 259200
			),
			'Block' => array(
			),
			'Frame' => array(
				'id' => 5
			)
		);
		$this->testAction(
			'/rss_readers/rss_reader_edit/edit',
			array('method' => 'post', 'data' => $data)
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
