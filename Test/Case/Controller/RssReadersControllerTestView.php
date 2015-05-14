<?php
/**
 * Test of RssReadersController view action
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersController', 'RssReaders.Controller');
App::uses('RssReadersControllerTestCase', 'RssReaders.Test/Case/Controller');

/**
 * Test of RssReadersController view action
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test\Case\Controller
 */
class RssReadersControllerTestView extends RssReadersControllerTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		$this->generate(
			'RssReaders.RssReaders',
			[
				'components' => [
					'Auth' => ['user'],
					'Session',
					'Security',
				]
			]
		);
		parent::setUp();
	}

/**
 * Expect visitor can access view action
 *
 * @return void
 */
	public function testView() {
		$this->testAction(
			'/rss_readers/rss_readers/view/181',
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);

		$this->assertTextEquals('view', $this->controller->view);
	}

/**
 * Expect visitor can access view action by json
 *
 * @return void
 */
	public function testViewJson() {
		$ret = $this->testAction(
			'/rss_readers/rss_readers/view/181.json',
			array(
				'method' => 'get',
				'type' => 'json',
				'return' => 'contents',
			)
		);
		$result = json_decode($ret, true);

		$this->assertTextEquals('view', $this->controller->view);
		$this->assertArrayHasKey('code', $result, print_r($result, true));
		$this->assertEquals(200, $result['code'], print_r($result, true));
	}

/**
 * Expect admin user can access view action
 *
 * @return void
 */
	public function testViewByAdmin() {
		RolesControllerTest::login($this);

		$view = $this->testAction(
			'/rss_readers/rss_readers/view/181',
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);

		$this->assertTextEquals('view', $this->controller->view);
		$this->assertTextContains('nc-rss-readers-1', $view, print_r($view, true));
		$this->assertTextContains('/rss_readers/rss_readers/edit/1', $view, print_r($view, true));

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect user cannot access view action with unknown frames.id
 *
 * @return void
 */
	public function testViewByUnkownFrameId() {
		$this->setExpectedException('InternalErrorException');
		$this->testAction(
			'/rss_readers/rss_readers/view/999',
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);
	}

/**
 * Expect visitor can access view action by expired cache time
 *
 * @return void
 */
	public function testViewCache() {
		$this->testAction(
			'/rss_readers/rss_readers/view/182',
			array(
				'method' => 'get',
				'return' => 'view',
			)
		);

		$this->assertTextEquals('view', $this->controller->view);
	}

/**
 * Expect visitor can access view action by update rss_reader_items error
 *
 * @return void
 */
	public function testViewUpdateCacheError() {
		$this->testAction(
			'/rss_readers/rss_readers/view/185',
			array(
				'method' => 'get',
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('view', $this->controller->view);
	}

}
