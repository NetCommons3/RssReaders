<?php
/**
 * RssReaders Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsBlockComponent', 'NetCommons.Controller/Component');
App::uses('NetCommonsRoomRoleComponent', 'NetCommons.Controller/Component');
App::uses('YACakeTestCase', 'NetCommons.TestSuite');
App::uses('AuthComponent', 'Component');
App::uses('RssReader', 'RssReaders.Model');
App::uses('RssReaderItem', 'RssReaders.Model');
App::uses('RssReaderFrameSetting', 'RssReaders.Model');

/**
 * RssReaders Model Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test\Case\Model
 */
class RssReadersModelTestBase extends YACakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block',
		'plugin.boxes.box',
		'plugin.comments.comment',
		'plugin.frames.frame',
		'plugin.m17n.language',
		'plugin.plugin_manager.plugin',
		'plugin.rss_readers.rss_reader',
		'plugin.rss_readers.rss_reader_frame_setting',
		'plugin.rss_readers.rss_reader_item',
		'plugin.roles.default_role_permission',
		'plugin.rooms.roles_room',
		'plugin.rooms.roles_rooms_user',
		'plugin.rooms.room',
		'plugin.rooms.room_role_permission',
		'plugin.users.user',
		'plugin.users.user_attributes_user',
	);

/**
 * Test case of status
 *
 * @var array
 */
	public $testCaseStatus = array(
		null, '', -1, 0, 5, 9999, 'abcde', false,
	);

/**
 * Test case of notEmpty
 *
 * @var array
 */
	public $testCaseNotEmpty = array(
		null, '', false,
	);

/**
 * Test case of url
 *
 * @var array
 */
	public $testCaseUrl = array(
		'http:', 'https:', 'ftp:', 'javascript:',
		'http:/', 'https:/', 'ftp:/', 'javascript:/',
		'http://', 'https://', 'ftp://', 'javascript://',
		'http://test', 'https://test', 'ftp://test', 'javascript:test', 'abc://exapmle.com',
	);

/**
 * Test case of number
 *
 * @var array
 */
	public $testCaseNumber = array(
		null, '', 'abcde', false, true, '123abcd', 'false', 'true'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Block = ClassRegistry::init('Blocks.Block');
		$this->RssReader = ClassRegistry::init('RssReaders.RssReader');
		$this->RssReaderItem = ClassRegistry::init('RssReaders.RssReaderItem');
		$this->RssReaderFrameSetting = ClassRegistry::init('RssReaders.RssReaderFrameSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Block);
		unset($this->RssReader);
		unset($this->RssReaderItem);
		unset($this->RssReaderFrameSetting);

		parent::tearDown();
	}

/**
 * _assertArray method
 *
 * @param string $key target key
 * @param mixed $value array or string, number
 * @param array $result result data
 * @return void
 */
	protected function _assertArray($key, $value, $result) {
		if ($key !== null) {
			$this->assertArrayHasKey($key, $result);
			$target = $result[$key];
		} else {
			$target = $result;
		}
		if (is_array($value)) {
			foreach ($value as $nextKey => $nextValue) {
				$this->_assertArray($nextKey, $nextValue, $target);
			}
		} elseif (isset($value)) {
			$this->assertEquals($value, $target, 'key=' . print_r($key, true) . '|value=' . print_r($value, true) . '|result=' . print_r($result, true));
		}
	}
}