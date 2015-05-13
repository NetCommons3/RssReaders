<?php
/**
 * RssReadersApp Controller
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * RssReadersApp Controller
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Controller
 */
class RssReadersAppController extends AppController {

/**
 * use component
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsFrame',
		'Security'
	);

/**
 * use models
 *
 * @var array
 */
	public $uses = array(
		'RssReaders.RssReader',
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$results = $this->camelizeKeyRecursive(['current' => $this->current]);
		$this->set($results);

		$this->set('userId', (int)$this->Auth->user('id'));
	}

/**
 * initTabs
 *
 * @param string $mainActiveTab Main active tab
 * @param string $blockActiveTab Block active tab
 * @return void
 */
	public function initTabs($mainActiveTab, $blockActiveTab) {
		//タブの設定
		$settingTabs = array(
			'tabs' => array(
				'block_index' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'blocks',
						'action' => 'index',
						$this->viewVars['frameId'],
					)
				),
				'frame_settings' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'rss_reader_frame_settings',
						'action' => 'edit',
						$this->viewVars['frameId'],
					)
				),
			),
			'active' => $mainActiveTab
		);
		$this->set('settingTabs', $settingTabs);

		$blockSettingTabs = array(
			'tabs' => array(
				'block_settings' => array(
					'url' => array(
						'plugin' => $this->params['plugin'],
						'controller' => 'blocks',
						'action' => $this->params['action'],
						$this->viewVars['frameId'],
						$this->viewVars['blockId']
					)
				),
			),
			'active' => $blockActiveTab
		);
		$this->set('blockSettingTabs', $blockSettingTabs);
	}

}
