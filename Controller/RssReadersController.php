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
 * @package app\Plugin\RssReaders\Controller
 */
class RssReadersController extends RssReadersAppController {

/**
 * Model name
 *
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
 * @return CakeResponse
 */
	public function index($frameId = 0) {
		return $this->view($frameId);
	}

/**
 * view
 *
 * @param int $frameId frames.id
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
			// 記事の件数が1件の場合はitem以下の階層が1つ減るので
			// フォーマットを2件以上に合わせる
			if (!empty($rssXmlData) && !isset($rssXmlData['RDF']['item'][0])) {
				$rssXmlItem = $rssXmlData['RDF']['item'];
				unset($rssXmlData['RDF']['item']);
				$rssXmlData['RDF']['item'] = array($rssXmlItem);
			}
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
 * @return void
 */
	public function update_status() {
		$saveData = $this->request->data;
		$this->RssReader->save($saveData);

		$params = array(
			'name' => __d('net_commons', 'Successfully finished.')
		);
		$this->set(compact('params'));
		$this->set('_serialize', 'params');

		return $this->render(false);
	}

/**
 * form method
 *
 * @param int $frameId frames.id
 * @return CakeResponse A response object containing the rendered view.
 */
	public function form($frameId = 0) {
		return $this->render('RssReaders/form', false);
	}
}
