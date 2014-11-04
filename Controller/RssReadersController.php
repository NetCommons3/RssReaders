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
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsBlock',
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole'
	);

/**
 * beforeFilter
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 * @throws ForbiddenException
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();

		//Roleのデータをviewにセット
		if (!$this->NetCommonsRoomRole->setView($this)) {
			throw new ForbiddenException();
		}
	}

/**
 * index
 *
 * @param int $frameId frames.id
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return CakeResponse
 */
	public function index($frameId = 0) {
		return $this->view($frameId);
	}

/**
 * view
 *
 * @param int $frameId frames.id
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return CakeResponse
 * @throws ForbiddenException
 */
	public function view($frameId = 0) {
		//Frameのデータをviewにセット
		if (!$this->NetCommonsFrame->setView($this, $frameId)) {
			throw new ForbiddenException('NetCommonsFrame');
		}

		// RssReaderの取得。
		$rssReaderData = $this->RssReader->getContent(
			$this->viewVars['blockId'],
			$this->viewVars['contentEditable']
		);

		$rssXmlData = array();
		if (!empty($rssReaderData)) {
			// シリアライズされているRSSのデータを配列に戻す。
			$rssSerializeData = $this->RssReader->updateSerializeValue($rssReaderData);
			$rssXmlData = unserialize($rssSerializeData);
		}
		$this->set('rssReaderData', $rssReaderData);
		$this->set('rssXmlData', $rssXmlData);

		// RssReaderFrameSettingの取得。
		$rssReaderFrameData =
			$this->RssReaderFrameSetting->getRssReaderFrameSetting($this->viewVars['frameKey']);
		// RssReaderFrameSettingが存在しない場合は初期化する。
		if (empty($rssReaderFrameData)) {
			$rssReaderFrameData = $this->RssReaderFrameSetting->create();
			$rssReaderFrameData[$this->RssReaderFrameSetting->name]['display_number_per_page'] = 1;
			$rssReaderFrameData[$this->RssReaderFrameSetting->name]['display_site_info'] = 0;
			$rssReaderFrameData[$this->RssReaderFrameSetting->name]['display_summary'] = 0;
			$rssReaderFrameData[$this->RssReaderFrameSetting->name]['frame_key'] = $this->viewVars['frameKey'];
		}
		$this->set('rssReaderFrameSettingData', $rssReaderFrameData);

		return $this->render('RssReaders/view');
	}

/**
 * edit
 *
 * @param int $frameId frames.id
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @throws ForbiddenException
 * @return void
 */
	public function edit($frameId = 0) {
		if ($frameId !== 0) {
			//Frameのデータをviewにセット
			if (!$this->NetCommonsFrame->setView($this, $frameId)) {
				throw new ForbiddenException('NetCommonsFrame');
			}

			// RssReaderの取得。
			$rssReaderData = $this->RssReader->getContent(
				$this->viewVars['blockId'],
				$this->viewVars['contentEditable']
			);
			$this->set('rssReaderData', $rssReaderData);

			return $this->render('RssReaders.edit', false);
		} else {
			// 更新
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
 * update RssReader status
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function updateStatus() {
		$saveData[$this->RssReader->name] = $this->request->data;
		$result = $this->RssReader->save($saveData);

		return $this->_renderJson(200, '', $result);
	}

}
