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
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	//The Associations below have been created with all possible keys, those that are not needed can be removed

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
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('rss_readers', 'Title')),
					'required' => true,
				),
			),
			'link' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('rss_readers', 'Url')),
					'required' => true,
				),
				'url' => array(
					'rule' => array('url'),
					'message' => sprintf(__d('net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'), __d('rss_readers', 'Url'), __d('rss_readers', 'URL')),
					'required' => true,
				)
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * Get rss items
 *
 * @param int $rssReaderId rss_readers.id
 * @param int $limit Db select limit
 * @return array $rssReaderItems
 */
	public function getRssReaderItems($rssReaderId, $limit = null) {
		$conditions = array(
			'rss_reader_id' => $rssReaderId,
		);

		$rssReaderItems = $this->find('all', array(
			'recursive' => -1,
			'conditions' => $conditions,
			'order' => 'RssReaderItem.last_updated DESC, RssReaderItem.id',
			'limit' => $limit
		));

		return $rssReaderItems;
	}

/**
 * Validate RssReaderItems
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
	public function validateRssReaderItems($data) {
		$this->validateMany($data);
		return $this->validationErrors ? false : true;
	}

/**
 * Serialize to array data from xml
 *
 * @param array $url url
 * @return array Xml serialize array data
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
			$summary = Hash::get($item, $summaryKey);
			$data[] = array(
				'title' => $item['title'],
				'link' => Hash::get($item, $linkKey),
				'summary' => $summary ? strip_tags($summary) : '',
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
		$this->loadModels([
			'RssReader' => 'RssReaders.RssReader',
			'RssReaderItem' => 'RssReaders.RssReaderItem',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//Itemsのvalidate
			if (! $this->validateRssReaderItems($data['RssReaderItem'])) {
				return false;
			}
			//RssReaderのvalidate
			if (! $this->RssReader->validateRssReader($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->RssReader->validationErrors);
				return false;
			}

			//既存データの削除
			if (! $this->deleteAll(['rss_reader_id' => $data[$this->RssReader->alias]['id']], true, false)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}
			//RSS Itemsの登録
			if (! $this->saveMany($data['RssReaderItem'], ['validate' => false])) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}
			//RssReaderの登録
			if (! $this->RssReader->save($data, false)) {
				// @codeCoverageIgnoreStart
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				// @codeCoverageIgnoreEnd
			}

			$dataSource->commit();
		} catch (Exception $ex) {
			// @codeCoverageIgnoreStart
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
			// @codeCoverageIgnoreEnd
		}

		return true;
	}

}
