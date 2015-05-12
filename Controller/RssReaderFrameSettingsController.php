<?php
/**
 * RssReaderFrameSettings Controller
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
 * RssReaderFrameSettings Controller
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Controller
 */
class RssReaderFrameSettingsController extends RssReadersAppController {

/**
 * layout
 *
 * @var array
 */
	public $layout = 'NetCommons.setting';

/**
 * Model name
 *
 * @var    array
 */
	public $uses = array(
		'RssReaders.RssReaderFrameSetting'
	);

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsWorkflow',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'contentEditable' => array('edit')
			),
		),
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		$results = $this->camelizeKeyRecursive($this->NetCommonsFrame->data);
		$this->set($results);

		//タブの設定
		$this->initTabs('frame_settings', '');
	}

/**
 * edit action
 *
 * @return void
 */
	public function edit() {
		if (! $this->NetCommonsFrame->validateFrameId()) {
			$this->throwBadRequest();
			return false;
		}

		if (! $rssFrameSetting = $this->RssReaderFrameSetting->getRssReaderFrameSetting($this->viewVars['frameKey'])) {
			$rssFrameSetting = $this->RssReaderFrameSetting->create(
				['frame_key' => $this->viewVars['frameKey']]
			);
		}
		$results = $this->camelizeKeyRecursive($rssFrameSetting);
		$this->set($results);

		if ($this->request->isPost()) {
			$this->RssReaderFrameSetting->saveRssReaderFrameSetting($this->data);
			if ($this->handleValidationError($this->RssReaderFrameSetting->validationErrors)) {
				$this->redirectByFrameId();
				return;
			}
		}
	}

/**
 * __initRssReaderFrameSetting method
 *
 * @return void
 * @throws BadRequestException
 */
//	private function __initRssReaderFrameSetting() {
//		if (! $rssFrameSetting = $this->RssReaderFrameSetting->find('first', array(
//			'recursive' => -1,
//			'conditions' => array(
//				'frame_key' => $this->viewVars['frameKey']
//			)
//		))) {
//			$rssFrameSetting = $this->RssReaderFrameSetting->create(
//				['frame_key' => $this->viewVars['frameKey']]
//			);
//		}
//
//		$results = $this->camelizeKeyRecursive($rssFrameSetting);
//		$this->set($results);
//	}
}
