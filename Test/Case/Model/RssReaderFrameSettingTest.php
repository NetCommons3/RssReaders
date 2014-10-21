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
		'plugin.rss_readers.rss_reader_frame_setting'
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
 * testFind method
 *
 * @return void
 */
	public function testFind() {
		$rssReaderFrameId = 1;
		$rssReaderFrameData = $this->RssReaderFrameSetting->findById($rssReaderFrameId);

		$this->assertNotEmpty($rssReaderFrameData);
	}

}
