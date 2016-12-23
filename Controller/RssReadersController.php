<?php
/**
 * RssReaders Controller
 *
 * @property RssReader $RssReader
 *
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
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Controller
 */
class RssReadersController extends RssReadersAppController {

/**
 * 使用するModel
 *
 * @var    array
 */
	public $uses = array(
		'RssReaders.RssReaderItem',
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
				'edit,get' => 'content_editable',
				'delete' => 'block_editable',
			),
		),
	);

/**
 * 使用するHelpers
 *
 * @var array
 */
	public $helpers = array(
		'Workflow.Workflow',
	);

/**
 * view
 *
 * @return void
 */
	public function view() {
		//RssReaderデータ取得
		$rssReader = $this->RssReader->getRssReader();
		if (! $rssReader) {
			if (Current::permission('content_editable')) {
				$rssReader = $this->RssReader->createAll();
			} else {
				return $this->setAction('emptyRender');
			}
		}
		$this->set('rssReader', $rssReader['RssReader']);

		//RssReaderFrameSettingデータ取得
		$rssFrameSetting = $this->RssReaderFrameSetting->getRssReaderFrameSetting();
		$this->set('rssReaderFrameSetting', $rssFrameSetting['RssReaderFrameSetting']);

		//RssReaderItemデータ取得
		$rssReaderItems = $this->RssReaderItem->getRssReaderItems(
			$rssReader,
			Hash::get($rssFrameSetting, 'RssReaderFrameSetting.display_number_per_page')
		);
		$this->set('rssReaderItems', $rssReaderItems);

		//新着データを既読にする
		$this->RssReader->saveTopicUserStatus($rssReader);
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if ($this->request->is('post') || $this->request->is('put')) {
			//登録処理
			$data = $this->request->data;
			$data['RssReader']['status'] = $this->Workflow->parseStatus();
			unset($data['RssReader']['id']);

			if ($this->RssReader->saveRssReader($data)) {
				return $this->redirect(NetCommonsUrl::backToIndexUrl());
			}
			$this->NetCommons->handleValidationError($this->RssReader->validationErrors);

		} else {
			//表示処理(初期データセット)
			$rssReader = $this->RssReader->getRssReader();
			if (! $rssReader) {
				$this->request->data = $this->RssReader->createAll(array(
					'RssReader' => array('url' => 'http://', 'link' => 'http://')
				));
			} else {
				if ($rssReader['RssReader']['link'] === '') {
					$rssReader['RssReader']['link'] = 'http://';
				}
			}
			$this->request->data = Hash::merge($this->request->data, $rssReader);
			$this->request->data['Frame'] = Current::read('Frame');
		}

		$comments = $this->RssReader->getCommentsByContentKey(
			$this->request->data['RssReader']['key']
		);
		$this->set('comments', $comments);
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

		try {
			$rss = Xml::build($url);
		} catch (XmlException $ex) {
			$this->NetCommons->renderJson([], __d('rss_readers', 'Not Found site info.'), 400);
			return;
		}

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

		if ($results['title']) {
			$this->NetCommons->renderJson($results);
		} else {
			$this->NetCommons->renderJson(
				[],
				__d('rss_readers', 'Unauthorized pattern for RDF/RSS. Please input the url in RDF/RSS format.'),
				400
			);
		}
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
		if (! $this->request->is('delete')) {
			return $this->throwBadRequest();
		}

		$this->Announcement->deleteRssReader($this->request->data);
		$this->redirect(NetCommonsUrl::backToPageUrl());
	}

}
