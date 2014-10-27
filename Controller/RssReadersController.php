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
		'Frames.Frame',
		'RssReaders.RssReader',
		'RssReaders.RssReaderFrameSetting'
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
		if (!CakeSession::read('Auth.User')) {
			$contentEditable = false;
			$this->set('contentEditable', $contentEditable);
			$this->set('contentPublishable', false);
		} else {
			$contentEditable = $this->viewVars['contentEditable'];
		}

		// RssReaderの取得。
		$rssReaderData = $this->RssReader->getContent(
			$this->viewVars['blockId'],
			$contentEditable
		);

		// RssReaderが存在しない場合は初期化する。
		if (empty($rssReaderData)) {
			$rssReaderData = $this->RssReader->create();
			$rssReaderData[$this->RssReader->name]['url'] = '';
			$rssReaderData[$this->RssReader->name]['title'] = '';
			$rssReaderData[$this->RssReader->name]['summary'] = '';
			$rssReaderData[$this->RssReader->name]['link'] = '';
			$rssReaderData[$this->RssReader->name]['cache_time'] = '';
			$rssXmlData = array();
		} else {
			// シリアライズされているRSSのデータを配列に戻す。
			$rssSerializeData = $this->RssReader->updateSerializeValue($rssReaderData);
			$rssXmlData = unserialize($rssSerializeData);
		}
		$this->set('rssReaderData', $rssReaderData);
		$this->set('rssXmlData', $rssXmlData);
		$this->request->data = $rssReaderData;

		// RssReaderFrameSettingの取得。
		$frameData = $this->Frame->findById($frameId);
		$frameKey = $frameData['Frame']['key'];
		$rssReaderFrameData =
			$this->RssReaderFrameSetting->getRssReaderFrameSetting($frameKey);

		// RssReaderFrameSettingが存在しない場合は初期化する。
		if (empty($rssReaderFrameData)) {
			$rssReaderFrameData = $this->RssReaderFrameSetting->create();
			$rssReaderFrameData[$this->RssReaderFrameSetting->name]['display_number_per_page'] = 1;
			$rssReaderFrameData[$this->RssReaderFrameSetting->name]['display_site_info'] = 0;
			$rssReaderFrameData[$this->RssReaderFrameSetting->name]['display_summary'] = 0;
			$rssReaderFrameData[$this->RssReaderFrameSetting->name]['frame_key'] = $frameKey;
		}
		$this->set('rssReaderFrameData', $rssReaderFrameData);
		$this->request->data = array_merge($this->request->data, $rssReaderFrameData);

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

		if ($result) {
			return $this->_renderJson(200, '', $result);
		} else {
			return $this->_renderJson(500, __d('rss_readers', 'I failed to save.'), $result);
		}
	}

/**
 * getRssInfo
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function getRssInfo() {
		$url = $this->request->data['url'];

		try {
			$rss = Xml::build($url);
			$rss = Xml::toArray($rss);
		} catch (XmlException $e) {
			// Xmlが取得できない場合異常終了
			return $this->_renderJson(500, __d('rss_readers', 'Feed Not Found.'), false);
		}

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

/**
 * edit RssReaderFrameSetting
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function editFrameSetting() {
		$saveData = $this->request->data;
		$result = $this->RssReaderFrameSetting->save($saveData);

		if ($result) {
			return $this->_renderJson(200, '', $result);
		} else {
			return $this->_renderJson(500, __d('rss_readers', 'I failed to save.'), $result);
		}
	}

/**
 * update RssReader status
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function updateStatus() {
		$saveData[$this->RssReader->name] = $this->request->data;
		$result = $this->RssReader->save($saveData);

		if ($result) {
			return $this->_renderJson(200, '', $result);
		} else {
			return $this->_renderJson(500, __d('rss_readers', 'I failed to save.'), $result);
		}
	}

}
