<?php
/**
 * RssReaderFrameSettingsController Test Case
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('FrameSettingsController', 'RssReaders.Controller');
App::uses('RssReadersControllerTestBase', 'RssReaders.Test/Case/Controller');

/**
 * Summary for RssReaderFrameSettingsController Test Case
 */
class FrameSettingsControllerTest extends RssReadersControllerTestBase {

/**
 * test form
 *
 * @return void
 */
	//public function testForm() {
	//	$frameId = 1;
	//	$this->testAction(
	//		'/rss_readers/rss_reader_frame_settings/form/' . $frameId . '/',
	//		array('method' => 'get')
	//	);
	//	$this->assertTextContains('data[RssReaderFrameSetting][frame_key]', $this->view);
	//	$this->assertTextContains('data[RssReaderFrameSetting][display_number_per_page]', $this->view);
	//	$this->assertTextContains('data[RssReaderFrameSetting][display_site_info]', $this->view);
	//	$this->assertTextContains('data[RssReaderFrameSetting][display_summary]', $this->view);
	//	$this->assertTextContains('data[RssReaderFrameSetting][id]', $this->view);
	//	$this->assertTextContains('data[RssReaderFrameSetting][frame_key]', $this->view);
	//}

/**
 * test form case not exist data
 *
 * @return void
 */
	//public function testFormNotExistData() {
	//	$frameId = 5;
	//	$this->testAction(
	//		'/rss_readers/rss_reader_frame_settings/form/' . $frameId . '/',
	//		array('method' => 'get')
	//	);
	//	$this->assertTextContains('data[RssReaderFrameSetting][frame_key]', $this->view);
	//	$this->assertTextContains('data[RssReaderFrameSetting][display_number_per_page]', $this->view);
	//	$this->assertTextContains('data[RssReaderFrameSetting][display_site_info]', $this->view);
	//	$this->assertTextContains('data[RssReaderFrameSetting][display_summary]', $this->view);
	//	$this->assertTextContains('data[RssReaderFrameSetting][id]', $this->view);
	//	$this->assertTextContains('data[RssReaderFrameSetting][frame_key]', $this->view);
	//}

/**
 * test form case not exist frame
 *
 * @return void
 */
	//public function testFormNotExistFrame() {
	//	$frameId = 999;
	//	try {
	//		$this->testAction(
	//			'/rss_readers/rss_reader_frame_settings/form/' . $frameId . '/',
	//			array('method' => 'get')
	//		);
	//	} catch (ForbiddenException $e) {
	//		$this->assertEquals('NetCommonsFrame', $e->getMessage());
	//	}
	//}

/**
 * test view
 *
 * @return void
 */
	//public function testView() {
	//	$frameId = 1;
	//
	//	$this->testAction(
	//		'/rss_readers/rss_reader_frame_settings/view/' . $frameId,
	//		array('method' => 'get')
	//	);
	//	$this->assertTextContains(
	//		'data[RssReaderFrameSetting][frame_key]',
	//		$this->view
	//	);
	//	$this->assertTextContains(
	//		'data[RssReaderFrameSetting][display_number_per_page]',
	//		$this->view
	//	);
	//	$this->assertTextContains(
	//		'data[RssReaderFrameSetting][display_site_info]',
	//		$this->view
	//	);
	//	$this->assertTextContains(
	//		'data[RssReaderFrameSetting][display_summary]',
	//		$this->view
	//	);
	//}

/**
 * test view case not exist frame
 *
 * @return void
 */
	//public function testViewNotExistFrame() {
	//	$frameId = 999;
	//	try {
	//		$this->testAction(
	//			'/rss_readers/rss_reader_frame_settings/view/' . $frameId . '/',
	//			array('method' => 'get')
	//		);
	//	} catch (ForbiddenException $e) {
	//		$this->assertEquals('NetCommonsFrame', $e->getMessage());
	//	}
	//}

/**
 * test view case not exist data
 *
 * @return void
 */
	//public function testViewNotExistData() {
	//	$frameId = 5;
	//	try {
	//		$this->testAction(
	//			'/rss_readers/rss_reader_frame_settings/view/' . $frameId . '/',
	//			array('method' => 'get')
	//		);
	//	} catch (ForbiddenException $e) {
	//		$this->assertEquals('NetCommonsFrame', $e->getMessage());
	//	}
	//}

}

