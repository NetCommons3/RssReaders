<?php
/**
 * RssReaderFrameSetting Test Case
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReaderFrameSetting', 'RssReaders.Model');

/**
 * Summary for RssReaderFrameSetting Test Case
 */
class RssReaderFrameSettingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rss_readers.rss_reader_frame_setting',
		'plugin.rss_readers.frame'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->RssReaderFrameSetting = ClassRegistry::init('RssReaders.RssReaderFrameSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RssReaderFrameSetting);

		parent::tearDown();
	}

/**
 * testGetRssReaderFrameSetting method
 *
 * @return void
 */
	public function testGetRssReaderFrameSetting() {
		$frameKey = 'd6c512c3cb0e3cde4892ffbc1bf05b6dd0da70f22ce1404907d36b30cebe1553';
		$rssReaderFrameData = $this->RssReaderFrameSetting->getRssReaderFrameSetting($frameKey);

		$this->assertNotEmpty($rssReaderFrameData);
	}

}
