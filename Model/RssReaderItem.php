<?php
/**
 * RssReaderItem Model
 *
 * @property RssReader $RssReader
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RssReadersAppModel', 'RssReaders.Model');

/**
 * RssReaderItem Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Model
 */
class RssReaderItem extends RssReadersAppModel {

/**
 * バリデーションルール
 * __d()を使うため、[self::beforeValidate()](#method_beforeValidate)でセットする
 *
 * @var array
 */
	public $validate = array();

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'RssReader' => array(
			'className' => 'RssReader',
			'foreignKey' => 'rss_reader_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge($this->validate, array(
			'rss_reader_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					//'required' => true,
				),
			),

			'title' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(
						__d('net_commons', 'Please input %s.'), __d('rss_readers', 'Title')
					),
					'required' => true,
				),
			),
			'link' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(
						__d('net_commons', 'Please input %s.'), __d('rss_readers', 'Url')
					),
					'required' => true,
				),
				'url' => array(
					'rule' => array('url'),
					'message' => sprintf(
						__d('net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'),
						__d('rss_readers', 'Url'),
						__d('net_commons', 'URL')
					),
					'required' => true,
				)
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * RssReaderItemデータの取得
 * ※最終取得日時が古い場合、RSSを取得し直す
 *
 * @param array $rssReader RssReaderItemデータ
 * @param int $limit 取得Limit
 * @return array $rssReaderItems
 */
	public function getRssReaderItems($rssReader, $limit = null) {
		if (! Hash::get($rssReader, 'RssReader.id')) {
			return array();
		}

		$this->updateItems($rssReader);

		$conditions = array(
			'rss_reader_id' => $rssReader['RssReader']['id'],
		);

		$rssReaderItems = $this->find('all', array(
			'recursive' => -1,
			'conditions' => $conditions,
			'order' => array('RssReaderItem.last_updated' => 'desc', 'RssReaderItem.id' => 'asc'),
			'limit' => $limit
		));

		return $rssReaderItems;
	}
/**
 * RssReader最終更新日時がキャッシュ時間より超えていた場合、RSSを取得し直す
 *
 * @param array $rssReader RssReaderデータ
 * @return void
 */
	public function updateItems($rssReader) {
		if (! isset($rssReader['RssReader']['id'])) {
			return;
		}

		$date = new DateTime();
		$now = $date->format('Y-m-d H:i:s');

		$date = new DateTime($rssReader['RssReader']['modified']);
		$date->add(new DateInterval(RssReader::CACHE_TIME));
		$modified = $date->format('Y-m-d H:i:s');

		if ($now < $modified) {
			return;
		}

		try {
			$rssReaderItem = $this->serializeXmlToArray($rssReader['RssReader']['url']);

		} catch (XmlException $ex) {
			// Xmlが取得できない場合、validationのエラーにする
			$this->RssReader->invalidate('url', __d('rss_readers', 'Feed Not Found.'));
			return;
		}

		$rssReaderItem = Hash::insert(
			$rssReaderItem, '{n}.rss_reader_id', $rssReader['RssReader']['id']
		);

		$this->updateRssReaderItems(
			array('RssReader' => $rssReader['RssReader'], 'RssReaderItem' => $rssReaderItem)
		);
	}

/**
 * XMLからArrayにシリアライズする
 *
 * @param array $url URL
 * @return array XMLの配列データ
 */
	public function serializeXmlToArray($url) {
		$xmlData = Xml::toArray(Xml::build($url));

		// rssの種類によってタグ名が異なる
		if (isset($xmlData['feed'])) {
			$items = Hash::get($xmlData, 'feed.entry');
			$dateKey = 'published';
			$linkKey = 'link.@href';
			$summaryKey = 'summary';
		} elseif (Hash::get($xmlData, 'rss.@version') === '2.0') {
			$items = Hash::get($xmlData, 'rss.channel.item');
			$dateKey = 'pubDate';
			$linkKey = 'link';
			$summaryKey = 'description';
		} else {
			$items = Hash::get($xmlData, 'RDF.item');
			$dateKey = 'dc:date';
			$linkKey = 'link';
			$summaryKey = 'description';
		}
		if (! isset($items[0]) && is_array($items)) {
			$items = array($items);
		}

		$data = array();
		foreach ($items as $item) {
			$date = new DateTime($item[$dateKey]);
			$summary = Hash::get($item, $summaryKey, '');
			$data[] = array(
				'title' => $item['title'],
				'link' => Hash::get($item, $linkKey),
				'summary' => strip_tags($summary),
				'last_updated' => $date->format('Y-m-d H:i:s'),
				'serialize_value' => serialize($item)
			);
		}
		return $data;
	}

/**
 * updateRssReaderItems
 *
 * @param array $data received post data
 * @return bool true on success, exception on error
 * @throws InternalErrorException
 */
	public function updateRssReaderItems($data) {
		//トランザクションBegin
		$this->begin();

		//バリデーション
		if (! $this->validateMany($data[$this->alias])) {
			return false;
		}

		try {
			//既存データの削除
			$conditions = array($this->alias . '.rss_reader_id' => $data[$this->RssReader->alias]['id']);
			if (! $this->deleteAll($conditions, true, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if (! $this->saveMany($data[$this->alias], ['validate' => false])) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//RssReaderの登録
			$this->RssReader->id = $data[$this->RssReader->alias]['id'];

			$date = new DateTime();
			$now = $date->format('Y-m-d H:i:s');

			if (! $this->RssReader->saveField('modified', $now)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		$this->setSlaveDataSource();

		return true;
	}

}
