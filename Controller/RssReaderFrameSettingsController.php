<?php
/**
 * RssReaderFrameSettings Controller
 *
 * @property RssReaderFrameSetting $RssReaderFrameSetting
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RssReadersAppController', 'RssReaders.Controller');

/**
 * RssReaderFrameSettings Controller
 *
 * @author  Kosuke Miura <k_miura@zenk.co.jp>
 * @package app\Plugin\RssReaders\Controller
 */
class RssReaderFrameSettingsController extends RssReadersAppController {

/**
 * Model name
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @var    array
 */
	public $uses = array(
		'Frames.Frame',
		'RssReaders.RssReaderFrameSetting'
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole'
	);

/**
 * beforeFilter
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @throws ForbiddenException
 * @return void
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
 * view RssReaderFrameSetting
 *
 * @param int $frameId frames.id
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @throws ForbiddenException
 * @return void
 */
	public function view($frameId = 0) {
		return $this->render('view', false);
	}

/**
 * edit RssReaderFrameSetting
 *
 * @param int $frameId frames.id
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @throws ForbiddenException
 * @return void
 */
	public function edit($frameId = 0) {
		// 更新処理
		$saveData = $this->request->data;
		$this->RssReaderFrameSetting->save($saveData);
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
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @throws ForbiddenException
 * @return CakeResponse A response object containing the rendered view.
 */
	public function form($frameId = 0) {
		// Frameのデータをviewにセット。
		if (!$this->NetCommonsFrame->setView($this, $frameId)) {
			throw new ForbiddenException('NetCommonsFrame');
		}

		// RssReaderFrameSettingの取得。
		$rssReaderFrameData =
			$this->RssReaderFrameSetting->getRssReaderFrameSetting($this->viewVars['frameKey']);
			if (!empty($rssReaderFrameData)) {
				$rssReaderFrameId = $rssReaderFrameData['RssReaderFrameSetting']['id'];
			} else {
				$rssReaderFrameId = '';
			}
		$this->set('rssReaderFrameId', $rssReaderFrameId);

		return $this->render('RssReaderFrameSettings/form', false);
	}
}
