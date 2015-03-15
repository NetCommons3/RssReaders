<?php
/**
 * FrameSettings Controller
 *
 * @property RssReaderFrameSetting $RssReaderFrameSetting
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RssReadersAppController', 'RssReaders.Controller');

/**
 * FrameSettings Controller
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Controller
 */
class FrameSettingsController extends RssReadersAppController {

/**
 * Model name
 *
 * @var    array
 */
	public $uses = array(
		'RssReaders.RssReader',
		'RssReaders.RssReaderFrameSetting'
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('edit')
			),
		),
	);

/**
 * edit action
 *
 * @return void
 */
	public function edit() {
		$this->__initRssReaderFrameSetting();
		if ($this->request->isGet()) {
			CakeSession::write('backUrl', $this->request->referer());
		}

		if ($this->request->isPost()) {
			$this->RssReaderFrameSetting->saveRssReaderFrameSetting($this->data);
			if (! $this->handleValidationError($this->RssReaderFrameSetting->validationErrors)) {
				return;
			}
			if (!$this->request->is('ajax')) {
				$backUrl = CakeSession::read('backUrl');
				CakeSession::delete('backUrl');
				$this->redirect($backUrl);
			}
			return;
		}
	}

/**
 * __initRssReaderFrameSetting method
 *
 * @return void
 * @throws BadRequestException
 */
	private function __initRssReaderFrameSetting() {
		if (! $this->RssReader->getRssReader(
			$this->viewVars['blockId'],
			$this->viewVars['contentEditable']
		)) {
			if ($this->request->is('ajax')) {
				$this->renderJson(
					['error' => ['validationErrors' => ['id' => __d('net_commons', 'Invalid request.')]]],
					__d('net_commons', 'Bad Request'), 400
				);
				return;
			} else {
				throw new BadRequestException(__d('net_commons', 'Bad Request'));
			}
		}

		if (! $rssFrameSetting = $this->RssReaderFrameSetting->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'frame_key' => $this->viewVars['frameKey']
			)
		))) {
			$rssFrameSetting = $this->RssReaderFrameSetting->create(
				['frame_key' => $this->viewVars['frameKey']]
			);
		}

		$results = $this->camelizeKeyRecursive($rssFrameSetting);
		$this->set($results);
	}
}
