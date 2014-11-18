<?php
/**
 * RssReaders edit Controller
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
 * @package app\Plugin\RssReadersz\Controller
 */
class RssReaderEditController extends RssReadersAppController {

/**
 * Model name
 *
 * @var    array
 */
	public $uses = array(
		'Frames.Frame',
		'RssReaders.RssReader'
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

		// 編集権限チェック
		if (!$this->viewVars['contentEditable']) {
			throw new ForbiddenException();
		}
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
		// RssReaderが存在しない場合は初期化する
		if (empty($rssReaderData)) {
			$rssReaderData = $this->RssReader->create();
			$rssReaderData[$this->RssReader->name]['cache_time'] = 1800;
		}
		$this->set('rssReaderData', $rssReaderData);

		return $this->render('view', false);
	}

/**
 * edit
 *
 * @param int $frameId frames.id
 * @throws ForbiddenException
 * @return void
 */
	public function edit($frameId = 0) {
		// 更新
		$frameId = $this->request->data['Frame']['id'];
		unset($this->request->data['Frame']);
		$saveData = $this->request->data;

		$result = $this->RssReader->saveRssReader($saveData, $frameId);

		if ($result) {
			$params = array(
				'name' => __d('net_commons', 'Successfully finished.')
			);
			$this->set(compact('params'));
			$this->set('_serialize', 'params');

			return $this->render(false);
		} else {
			throw new ForbiddenException(__d('net_commons', 'Failed to register data.'));
		}
	}

/**
 * get_rss_info
 *
 * @param int $frameId frames.id
 * @throws ForbiddenException
 * @return void
 */
	public function get_rss_info($frameId = 0) {
		$url = Hash::get($this->request->query, 'url');

		try {
			$rss = Xml::build($url);
		} catch (XmlException $e) {
			// Xmlが取得できない場合異常終了
			throw new ForbiddenException(__d('rss_readers', 'Feed Not Found.'));
		}
		$rssType = $rss->getName();

		if ($rssType === 'feed') {
			$title = (string)$rss->title;
			$link = (string)$rss->link->attributes()->href;
			$summary = (string)$rss->subtitle;
		} else {
			$title = (string)$rss->channel->title;
			$link = (string)$rss->channel->link;
			$summary = (string)$rss->channel->description;
		}

		$datas = array(
			'title' => $title,
			'link' => $link,
			'summary' => $summary
		);
		$this->set(compact('datas'));
		$this->set('_serialize', 'datas');

		return $this->render(false);
	}

/**
 * form method
 *
 * @param int $frameId frames.id
 * @throws ForbiddenException
 * @return CakeResponse A response object containing the rendered view.
 */
	public function form($frameId = 0) {
		// Frameのデータをviewにセット
		if (!$this->NetCommonsFrame->setView($this, $frameId)) {
			throw new ForbiddenException('NetCommonsFrame');
		}

		// RssReaderの取得
		$rssReaderData = $this->RssReader->getContent(
			$this->viewVars['blockId'],
			$this->viewVars['contentEditable']
		);
		$rssReaderId = Hash::get($rssReaderData, 'RssReader.id');
		$this->set('rssReaderId', $rssReaderId);

		return $this->render('RssReaderEdit/form', false);
	}
}
