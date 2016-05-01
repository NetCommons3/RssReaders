<?php
/**
 * ブロック設定 Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RssReadersAppController', 'RssReaders.Controller');

/**
 * ブロック設定 Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Controller
 */
class RssReaderBlocksController extends RssReadersAppController {

/**
 * layout
 *
 * @var array
 */
	public $layout = 'NetCommons.setting';

/**
 * 使用するModels
 *
 * @var array
 */
	public $uses = array(
		'RssReaders.RssReaderItem',
	);

/**
 * 使用するComponents
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			'allow' => array(
				'index,add,edit,delete' => 'block_editable',
			),
		),
		'Paginator',
		'Workflow.Workflow',
	);

/**
 * 使用するHelpers
 *
 * @var array
 */
	public $helpers = array(
		'Blocks.BlockForm',
		'Blocks.BlockIndex',
		'Blocks.BlockTabs' => array(
			'mainTabs' => array('block_index', 'frame_settings'),
			'blockTabs' => array('block_settings'),
		),
		'Workflow.Workflow',
	);

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->Paginator->settings = array(
			'RssReader' => array(
				'order' => array('RssReader.id' => 'desc'),
				'conditions' => $this->RssReader->getBlockConditions(array(
					'RssReader.is_latest' => true,
				)),
			)
		);

		$rssReaders = $this->Paginator->paginate('RssReader');
		if (! $rssReaders) {
			$this->view = 'Blocks.Blocks/not_found';
			return;
		}
		$this->set('rssReaders', $rssReaders);

		$this->request->data['Frame'] = Current::read('Frame');
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'edit';

		if ($this->request->is('post')) {
			//登録処理
			$data = $this->request->data;
			$data['RssReader']['status'] = $this->Workflow->parseStatus();
			if ($data['RssReader']['url']) {
				$data['RssReaderItem'] = $this->RssReaderItem->serializeXmlToArray($data['RssReader']['url']);
			}

			if ($this->RssReader->saveRssReader($data)) {
				return $this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
			}
			$this->NetCommons->handleValidationError($this->RssReader->validationErrors);

		} else {
			//表示処理(初期データセット)
			$this->request->data = $this->RssReader->createAll();
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if ($this->request->is('put')) {
			//登録処理
			$data = $this->request->data;
			$data['RssReader']['status'] = $this->Workflow->parseStatus();
			if ($data['RssReader']['url']) {
				$data['RssReaderItem'] = $this->RssReaderItem->serializeXmlToArray($data['RssReader']['url']);
			}

			if ($this->RssReader->saveRssReader($data)) {
				return $this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
			}
			$this->NetCommons->handleValidationError($this->RssReader->validationErrors);

		} else {
			//表示処理(初期データセット)
			$rssReader = $this->RssReader->getRssReader();
			if (! $rssReader) {
				return $this->throwBadRequest();
			}
			$this->request->data = Hash::merge($this->request->data, $rssReader);
			$this->request->data['Frame'] = Current::read('Frame');
		}
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
		if ($this->request->is('delete')) {
			if ($this->RssReader->deleteRssReader($this->request->data)) {
				return $this->redirect(NetCommonsUrl::backToIndexUrl('default_setting_action'));
			}
		}
		return $this->throwBadRequest();
	}

}
