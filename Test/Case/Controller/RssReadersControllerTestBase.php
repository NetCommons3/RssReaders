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

App::uses('NetCommonsFrameComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');
App::uses('YAControllerTestCase', 'NetCommons.TestSuite');
App::uses('RolesControllerTest', 'Roles.Test/Case/Controller');
App::uses('AuthGeneralControllerTest', 'AuthGeneral.Test/Case/Controller');
App::uses('RssReader', 'RssReaders.Model');
App::uses('RssReaderItem', 'RssReaders.Model');
App::uses('RssReaderFrameSetting', 'RssReaders.Model');

/**
 * RssReadersController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test\Case\Controller
 */
class RssReadersControllerTestBase extends YAControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		//'plugin.blocks.block',
		//'plugin.blocks.block_role_permission',
		//'plugin.boxes.box',
		//'plugin.boxes.boxes_page',
		//'plugin.containers.container',
		//'plugin.containers.containers_page',
		'plugin.comments.comment',
		//'plugin.frames.frame',
		//'plugin.m17n.language',
		//'plugin.net_commons.site_setting',
		//'plugin.pages.languages_page',
		//'plugin.pages.page',
		//'plugin.pages.space',
		//'plugin.plugin_manager.plugin',
		//'plugin.plugin_manager.plugins_room',
		//'plugin.roles.default_role_permission',
		//'plugin.rooms.roles_room',
		//'plugin.rooms.roles_rooms_user',
		//'plugin.rooms.room',
		//'plugin.rooms.room_role_permission',
		'plugin.rss_readers.rss_reader',
		'plugin.rss_readers.rss_reader_frame_setting',
		'plugin.rss_readers.rss_reader_item',
		//'plugin.users.user',
		//'plugin.users.user_attributes_user',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		YACakeTestCase::loadTestPlugin($this, 'NetCommons', 'TestPlugin');

		Configure::write('Config.language', 'ja');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Configure::write('Config.language', null);
		CakeSession::write('Auth.User', null);
		parent::tearDown();
	}
}
