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
		'Blocks.Block',
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
				'contentEditable' => array('edit', 'get')
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
		$this->setAction('view');
	}

/**
 * view
 *
 * @return void
 */
	public function view() {
		$this->__initRssReader();

		//RssReaderFrameSettingデータ取得
		if (! $rssFrameSetting = $this->RssReaderFrameSetting->getRssReaderFrameSetting($this->viewVars['frameKey'])) {
			$rssFrameSetting = $this->RssReaderFrameSetting->create(
				['frame_key' => $this->viewVars['frameKey']]
			);
		}
		$results = $this->camelizeKeyRecursive($rssFrameSetting);
		$this->set($results);

		//Rssの最新データ更新
		$this->__updateItems();

		//RssReaderItemデータ取得
		$rssReaderItems = $this->RssReaderItem->getRssReaderItems(
			$this->viewVars['rssReader']['id'],
			$this->viewVars['rssReaderFrameSetting']['displayNumberPerPage']
		);
		$rssReaderItems = Hash::combine(
			$rssReaderItems, '{n}.RssReaderItem.id', '{n}.RssReaderItem'
		);
		$results = $this->camelizeKeyRecursive(array(
			'rssReaderItems' => $rssReaderItems
		));
		$this->set($results);

		//AJAXの処理
		if ($this->request->is('ajax')) {
			$this->renderJson(array(
				'rssReader' => $this->viewVars['rssReader'],
				'rssReaderFrameSetting' => $this->viewVars['rssReaderFrameSetting'],
				'rssReaderItems' => $this->viewVars['rssReaderItems'],
			));
		}
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		$this->__initRssReader();

		$comments = $this->Comment->getComments(array(
			'plugin_key' => $this->params['plugin'],
			'content_key' => $this->viewVars['rssReader']['key'],
		));

		$data = array();
		if ($this->request->isPost()) {
			if (! $status = $this->NetCommonsWorkflow->parseStatus()) {
				return;
			}

			$data = Hash::merge(
				$this->data,
				['RssReader' => ['status' => $status]]
			);
			if (isset($this->viewVars['rssReader']['key'])) {
				$data['RssReader']['key'] = $this->viewVars['rssReader']['key'];
			}

			if ($data['RssReader']['url']) {
				$data['RssReaderItem'] = $this->RssReaderItem->serializeXmlToArray($data['RssReader']['url']);
			}

			$this->RssReader->saveRssReader($data);
			if ($this->handleValidationError($this->RssReader->validationErrors)) {
				//正常の場合
				$this->redirectByFrameId();
				return;
			}
			$data['comments'] = null;
			unset($data['RssReader']['status']);
		}

		$data = $this->camelizeKeyRecursive(Hash::merge(
			$data,
			array(
				'comments' => $comments,
				'contentStatus' => $this->viewVars['rssReader']['status'],
			)
		));
		$results = Hash::merge($this->viewVars, $data);
		$this->set($results);
	}

/**
 * Get site information
 *
 * @return void
 */
	public function get() {
		$url = Hash::get($this->request->query, 'url');
		if (! $url) {
			return;
		}

		$rss = Xml::build($url);
		$rssType = $rss->getName();

		$results = array();
		if ($rssType === 'feed') {
			$results['title'] = (string)$rss->title;
			$results['link'] = (string)$rss->link->attributes()->href;
			$results['summary'] = (string)$rss->subtitle;
		} else {
			$results['title'] = (string)$rss->channel->title;
			$results['link'] = (string)$rss->channel->link;
			$results['summary'] = (string)$rss->channel->description;
		}
		$this->renderJson($results);
	}

/**
 * __initRssReader
 *
 * @return void
 */
	private function __initRssReader() {
		if (! $rssReader = $this->RssReader->getRssReader(
			$this->viewVars['blockId'],
			$this->viewVars['roomId'],
			$this->viewVars['contentEditable']
		)) {
			$rssReader = $this->RssReader->create(array(
				'id' => null,
				'key' => null,
			));

			$block = $this->Block->create([
				'id' => $this->viewVars['blockId'],
				'key' => $this->viewVars['blockKey'],
			]);

			$rssReader['Block'] = $block['Block'];
		}
		$results = $this->camelizeKeyRecursive($rssReader);
		$this->set($results);
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
			// Xmlが取得できない場合、validationのエラーにする
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
	}

}
