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

		// Roleのデータをviewにセット
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
		// Frameのデータをviewにセット
		if (!$this->NetCommonsFrame->setView($this, $frameId)) {
			throw new ForbiddenException('NetCommonsFrame');
		}

		// RssReaderの取得
		$rssReaderData = $this->RssReader->getContent(
			$this->viewVars['blockId'],
			$this->viewVars['contentEditable']
		);

		$rssXmlData = array();
		if (!empty($rssReaderData)) {
			// シリアライズされているRSSのデータを配列に戻す
			$rssSerializeData = $this->RssReader->updateSerializeValue($rssReaderData);
			$rssXmlData = unserialize($rssSerializeData);
		}
		$this->set('rssReaderData', $rssReaderData);
		$this->set('rssXmlData', $rssXmlData);

		// RssReaderFrameSettingの取得
		$rssReaderFrameData =
			$this->RssReaderFrameSetting->getRssReaderFrameSetting($this->viewVars['frameKey']);
		// RssReaderFrameSettingが存在しない場合は初期化する
		if (empty($rssReaderFrameData)) {
			$rssReaderFrameData =
				$this->RssReaderFrameSetting->createRssReaderFrameSetting($this->viewVars['frameKey']);
		}
		$this->set('rssReaderFrameSettingData', $rssReaderFrameData);

		return $this->render('RssReaders/view');
	}

/**
 * update RssReader status
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function updateStatus() {
		$saveData = $this->request->data;
		$result = $this->RssReader->save($saveData);

		return $this->_renderJson(200, '', $result);
	}

/**
 * getUpdateStatusToken method
 *
 * @param int $frameId frames.id
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return CakeResponse A response object containing the rendered view.
 */
	public function getUpdateStatusToken($frameId = 0) {
		return $this->render('RssReaders/get_update_status_token', false);
	}
}
