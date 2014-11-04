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
 * @package app.Plugin.RssReaders.Controller
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
 * edit RssReaderFrameSetting
 *
 * @param int $frameId frames.id
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return void
 */
	public function edit($frameId = 0) {
		if ($frameId !== 0) {
			return $this->render('edit', false);
		} else {
			// 更新処理
			$saveData = $this->request->data;
			$result = $this->RssReaderFrameSetting->save($saveData);

			return $this->_renderJson(200, '', $result);
		}
	}
}
