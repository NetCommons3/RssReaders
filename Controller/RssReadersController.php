<?php
/**
 * RssReaders Controller
 *
 * @property RssReader $RssReader
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Xml', 'Utility');
App::uses('RssReadersAppController', 'RssReaders.Controller');

/**
 * RssReaders Controller
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Controller
 */
class RssReadersController extends RssReadersAppController {

/**
 * Model name
 *
 * @var    array
 */
	public $uses = array(
		'Comments.Comment',
		'RssReaders.RssReaderItem',
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
 * helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Token',
		'NetCommons.Date',
	);

/**
 * index
 *
 * @return CakeResponse
 */
	public function index() {
		$this->view = 'RssReaders/view';
		$this->view();
	}

/**
 * view
 *
 * @return void
 */
	public function view() {
		$this->__initRssReader(['rssReaderFrameSetting', 'rssReaderItems']);

		$this->__updateItems();

		if ($this->request->is('ajax')) {
			$tokenFields = Hash::flatten($this->request->data);
			$hiddenFields = array(
				'RssReader.block_id',
				'RssReader.key'
			);
			$this->set('tokenFields', $tokenFields);
			$this->set('hiddenFields', $hiddenFields);
			$this->renderJson();
		} else {
			if ($this->viewVars['contentEditable']) {
				$this->view = 'RssReaders/viewForEditor';
			}
		}
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		$this->__initRssReader(['comments']);

		if ($this->request->isGet()) {
			$this->__getSiteInfo();
		}

		if ($this->request->isPost()) {
			if (! $data = $this->__parseRequestData()) {
				return;
			}

			$rssReader = $this->RssReader->saveRssReader($data);
			if (! $this->handleValidationError($this->RssReader->validationErrors)) {
				$results = $this->camelizeKeyRecursive($data);
				$this->set($results);
				return;
			}
			$this->set('blockId', $rssReader['RssReader']['block_id']);
			if (!$this->request->is('ajax')) {
				$backUrl = CakeSession::read('backUrl');
				CakeSession::delete('backUrl');
				$this->redirect($backUrl);
			}
		}
	}

/**
 * __initRssReader method
 *
 * @param array $contains Optional result sets
 * @return void
 */
	private function __initRssReader($contains = []) {
		if (! $rssReader = $this->RssReader->getRssReader(
			$this->viewVars['blockId'],
			$this->viewVars['contentEditable']
		)) {
			$rssReader = $this->RssReader->create(['id' => null, 'key' => null]);
		}
		$results = array(
			'rssReader' => $rssReader['RssReader'],
			'contentStatus' => $rssReader['RssReader']['status'],
		);

		if (in_array('rssReaderFrameSetting', $contains, true)) {
			if (! $rssFrameSetting = $this->RssReaderFrameSetting->find('first', array(
				'recursive' => -1,
				'conditions' => array(
					'frame_key' => $this->viewVars['frameKey']
				)
			))) {
				$rssFrameSetting = $this->RssReaderFrameSetting->create();
			}
			$rssFrameSetting = $this->camelizeKeyRecursive($rssFrameSetting);
			$this->set($rssFrameSetting);
		}

		if (in_array('rssReaderItems', $contains, true)) {
			$rssReaderItems = $this->RssReaderItem->getRssReaderItems(
				$rssReader['RssReader']['id'],
				$this->viewVars['rssReaderFrameSetting']['displayNumberPerPage']
			);
			$results['rssReaderItems'] = Hash::combine(
				$rssReaderItems, '{n}.RssReaderItem.id', '{n}.RssReaderItem'
			);
		}

		if (in_array('comments', $contains, true)) {
			$results['comments'] = $this->Comment->getComments(
				array(
					'plugin_key' => 'rss_readers',
					'content_key' => $rssReader['RssReader']['key'],
				)
			);
		}

		$results = $this->camelizeKeyRecursive($results);
		$this->set($results);
	}

/**
 * Get site information
 *
 * @return void
 */
	private function __getSiteInfo() {
		$referer = isset($this->request->query['url']) ? CakeSession::read('backUrl') : $this->request->referer();
		CakeSession::write('backUrl', $referer);

		$url = Hash::get($this->request->query, 'url');
		if (! $url) {
			return;
		}

		try {
			$this->viewVars['rssReader']['url'] = $url;
			$rss = Xml::build($url);

		} catch (XmlException $e) {
			// Xmlが取得できない場合異常終了
			$this->RssReader->invalidate('url', __d('rss_readers', 'Feed Not Found.'));
			return;
		}
		$rssType = $rss->getName();

		if ($rssType === 'feed') {
			$this->viewVars['rssReader']['title'] = (string)$rss->title;
			$this->viewVars['rssReader']['link'] = (string)$rss->link->attributes()->href;
			$this->viewVars['rssReader']['summary'] = (string)$rss->subtitle;
		} else {
			$this->viewVars['rssReader']['title'] = (string)$rss->channel->title;
			$this->viewVars['rssReader']['link'] = (string)$rss->channel->link;
			$this->viewVars['rssReader']['summary'] = (string)$rss->channel->description;
		}
	}

/**
 * Update items method
 *
 * @return void
 */
	private function __updateItems() {
		if (! isset($this->viewVars['rssReader']['id'])) {
			return;
		}

		$date = new DateTime();
		$now = $date->format('Y-m-d H:i:s');

		$date = new DateTime($this->viewVars['rssReader']['modified']);
		$date->add(new DateInterval(RssReader::CACHE_TIME));
		$modified = $date->format('Y-m-d H:i:s');

		if ($now < $modified) {
			return;
		}

		try {
			$rssReaderItem = $this->RssReaderItem->serializeXmlToArray($this->viewVars['rssReader']['url']);

		} catch (XmlException $e) {
			// Xmlが取得できない場合異常終了
			$this->RssReader->invalidate('url', __d('rss_readers', 'Feed Not Found.'));
			return;
		}

		$rssReaderItem = Hash::insert(
			$rssReaderItem, '{n}.rss_reader_id', $this->viewVars['rssReader']['id']
		);

		$rssReader = array();
		$callback = ['Inflector', 'underscore'];
		foreach ($this->viewVars['rssReader'] as $key => $value) {
			$rssReader[call_user_func($callback, $key)] = $value;
		}
		$this->RssReaderItem->updateRssReaderItems(array(
			'RssReader' => $rssReader,
			'RssReaderItem' => $rssReaderItem
		));

		$this->__initRssReader(['rssReaderItems']);
	}

/**
 * Parse data from request
 *
 * @return array
 */
	private function __parseRequestData() {
		if (!$status = $this->NetCommonsWorkflow->parseStatus()) {
			return;
		}

		$data = Hash::merge(
			$this->data,
			['RssReader' => ['status' => $status]]
		);
		if (!$rssReader = $this->RssReader->getRssReader(
			isset($data['Block']['id']) ? (int)$data['Block']['id'] : null,
			true
		)) {
			$rssReader = $this->RssReader->create(['key' => Security::hash('rss_reader' . mt_rand() . microtime(), 'md5')]);
		}

		$data = Hash::merge($rssReader, $data);
		if ($data[$this->RssReader->alias]['url']) {
			$data['RssReaderItem'] = $this->RssReaderItem->serializeXmlToArray($data[$this->RssReader->alias]['url']);
		}

		return $data;
	}

}
