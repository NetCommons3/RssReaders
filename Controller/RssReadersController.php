<?php
/**
 * RssReaders Controller
 *
 * @property RssReader $RssReader
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Xml', 'Utility');
App::uses('RssReadersAppController', 'RssReaders.Controller');

/**
 * RssReaders Controller
 *
 * @author  Kosuke Miura <k_miura@zenk.co.jp>
 * @package app.Plugin.RssReaders.Controller
 */
class RssReadersController extends RssReadersAppController {

/**
 * Model name
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @var    array
 */
	public $uses = array(
		'RssReaders.RssReader'
	);

/**
 * beforeFilter
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}

/**
 * index
 *
 * @param int $frameId frames.id
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return CakeResponse
 */
	public function index($frameId = 0) {
		$this->_initializeFrame($frameId);

		// ログインしていない場合は下書きは表示しない。
		$contentEditable = !CakeSession::read('Auth.User') ? false : $this->viewVars['contentEditable'];

		$this->request->data = $this->RssReader->getContent(
			$this->viewVars['blockId'],
			$contentEditable
		);
		$this->set('rssReaderData', $this->request->data);

		return $this->render();
	}

/**
 * edit
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function edit() {
		$frameId = $this->request->data['Frame']['id'];
		unset($this->request->data['Frame']);
		$saveData = $this->request->data;

		$result = $this->RssReader->saveRssReader($saveData, $frameId);

		return $this->_renderJson(200, '', $result);
	}

/**
 * getRssInfo
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function getRssInfo() {
		$url = $this->request->data['url'];

		$rss = Xml::toArray(Xml::build($url));

		$title = $rss['RDF']['channel']['title'];
		$link = $rss['RDF']['channel']['link'];
		$summary = $rss['RDF']['channel']['description'];

		$datas = array(
			'title' => $title,
			'link' => $link,
			'summary' => $summary
		);

		return $this->_renderJson(200, '', $datas);
	}

}
