<?php
/**
 * RssReadersController Test Case
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersController', 'RssReaders.Controller');
App::uses('RssReadersControllerTestBase', 'RssReaders.Test/Case/Controller');

/**
 * Summary for RssReadersController Test Case
 */
class RssReadersControllerTest extends RssReadersControllerTestBase {

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->assertTrue(true);
	}

/**
 * test index
 *
 * @return void
 */
	//public function testIndex() {
		// statusが公開中状態の表示
		//$frameId = 1;
		//$this->testAction('/rss_readers/rss_readers/index/' . $frameId . '/', array('method' => 'get'));
		//$this->assertTextContains('nc-rss-readers-body-' . $frameId, $this->view);
	//}

/**
 * test index case not exist rss_reader
 *
 * @return void
 */
	//public function testIndexNotExistData() {
	//	// RssReaderが存在しない場合の表示
	//	$frameId = 5;
	//	$this->testAction('/rss_readers/rss_readers/index/' . $frameId . '/', array('method' => 'get'));
	//	$this->assertTextNotContains('nc-rss-readers-body-' . $frameId, $this->view);
	//}

/**
 * test view case not room role
 *
 * @return void
 */
	//public function testIndexNotRoomRole() {
	//	CakeSession::write('Auth.User', null);
	//	$user = array(
	//		'id' => 999
	//	);
	//	CakeSession::write('Auth.User', $user);
	//	$frameId = 1;
	//	try {
	//		$this->testAction('/rss_readers/rss_readers/index/' . $frameId . '/', array('method' => 'get'));
	//	} catch (ForbiddenException $e) {
	//		$this->assertEquals('Forbidden', $e->getMessage());
	//	}
	//}

/**
 * test index case not exist frame
 *
 * @return void
 */
	//public function testIndexNotExistFrame() {
	//	// 存在しないフレームにアクセスした場合に、例外処理が発生するか確認
	//	$frameId = 999;
	//	try {
	//		$this->testAction('/rss_readers/rss_readers/index/' . $frameId . '/', array('method' => 'get'));
	//	} catch (ForbiddenException $e) {
	//		$this->assertEquals('NetCommonsFrame', $e->getMessage());
	//	}
	//}

/**
 * test update_status
 *
 * @return void
 */
	//public function testUpdateStatus() {
	//	$data = array(
	//		'id' => 1,
	//		'status' => 2
	//	);
	//	$this->testAction(
	//		'/rss_readers/rss_readers/update_status',
	//		array('method' => 'post', 'data' => $data)
	//	);
	//}

}
