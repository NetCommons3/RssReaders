<?php
/**
 * Test of RssReadersController get action
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersController', 'RssReaders.Controller');
App::uses('RssReadersControllerTestBase', 'RssReaders.Test/Case/Controller');

/**
 * Test of RssReadersController get action
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test\Case\Controller
 */
class RssReadersControllerGetTest extends RssReadersControllerTestBase {

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
 * Expect get site info by rss1 format
 *
 * @return void
 */
	public function testEditGetSiteInfoByRss1() {
		RolesControllerTest::login($this);

		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml';
		$this->testAction(
			'/rss_readers/rss_readers/get/181?url=' . rawurlencode($url),
			array(
				'method' => 'get',
				'type' => 'json',
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('get', $this->controller->view);

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect get site info by rss2 format
 *
 * @return void
 */
	public function testEditGetSiteInfoByRss2() {
		RolesControllerTest::login($this);

		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v2.xml';
		$this->testAction(
			'/rss_readers/rss_readers/get/181?url=' . rawurlencode($url),
			array(
				'method' => 'get',
				'type' => 'json',
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('get', $this->controller->view);

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect get site info by atom format
 *
 * @return void
 */
	public function testEditGetSiteInfoByAtom() {
		RolesControllerTest::login($this);

		$url = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_atom.xml';
		$this->testAction(
			'/rss_readers/rss_readers/get/181?url=' . rawurlencode($url),
			array(
				'method' => 'get',
				'type' => 'json',
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('get', $this->controller->view);

		AuthGeneralControllerTest::logout($this);
	}

/**
 * Expect get site info by format error
 *
 * @return void
 */
	public function testEditGetSiteInfoError() {
		$this->setExpectedException('XmlException');

		RolesControllerTest::login($this);

		$url = 'test';
		$this->testAction(
			'/rss_readers/rss_readers/get/181?url=' . rawurlencode($url),
			array(
				'method' => 'get',
				'type' => 'json',
				'return' => 'contents'
			)
		);
		$this->assertTextEquals('get', $this->controller->view);

		AuthGeneralControllerTest::logout($this);
	}

}
