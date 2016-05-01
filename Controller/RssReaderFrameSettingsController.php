<?php
/**
 * 表示方法変更 Controller
 *
 * @property RssReaderFrameSetting $RssReaderFrameSetting
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RssReadersAppController', 'RssReaders.Controller');

/**
 * 表示方法変更 Controller
 *
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
 * 使用するModel
 *
 * @var    array
 */
	public $uses = array(
		'RssReaders.RssReaderFrameSetting'
	);

/**
 * 使用するComponent
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			'allow' => array(
				'edit' => 'page_editable',
			),
		),
	);

/**
 * 使用するHelpers
 *
 * @var array
 */
	public $helpers = array(
		'Blocks.BlockForm',
		'Blocks.BlockTabs' => array(
			'mainTabs' => array('block_index', 'frame_settings'),
			'blockTabs' => array('block_settings'),
		),
	);

/**
 * edit action
 *
 * @return void
 */
	public function edit() {
		if ($this->request->is('put') || $this->request->is('post')) {
			if ($this->RssReaderFrameSetting->saveRssReaderFrameSetting($this->data)) {
				return $this->redirect(NetCommonsUrl::backToPageUrl());
			}
			$this->NetCommons->handleValidationError($this->RssReaderFrameSetting->validationErrors);

		} else {
			$this->request->data = $this->RssReaderFrameSetting->getRssReaderFrameSetting();
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}
}
