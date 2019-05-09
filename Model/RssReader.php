<?php
/**
 * RssReader Model
 *
 * @property Block $Block
 * @property RssReaderItem $RssReaderItem
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RssReadersAppModel', 'RssReaders.Model');

/**
 * RssReader Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Model
 */
class RssReader extends RssReadersAppModel {

/**
 * キャッシュタイム
 *
 * @var string
 * @see http://php.net/manual/ja/dateinterval.construct.php
 */
	const CACHE_TIME = 'PT1H';

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Blocks.Block' => array(
			'name' => 'RssReader.title',
			'loadModels' => array(
				'BlockSetting' => 'Blocks.BlockSetting',
			)
		),
		'NetCommons.OriginalKey',
		'Workflow.WorkflowComment',
		'Workflow.Workflow',
		'Mails.MailQueue' => array(
			'embedTags' => array(
				'X-TITLE' => 'RssReader.title',
				'X-RSS_URL' => 'RssReader.url',
				'X-LINK' => 'RssReader.link',
				'X-SUMMARY' => 'RssReader.summary',
			),
		),
		'Topics.Topics' => array(
			'fields' => array(
				'title' => 'RssReader.title',
				'summary' => 'RssReader.summary',
				'path' => '/:plugin_key/:plugin_key/view/:block_id/:content_key',
				'public_type' => 'Block.public_type',
				'publish_start' => 'Block.publish_start',
				'publish_end' => 'Block.publish_end',
			),
			'search_contents' => array('url', 'link')
		),
		//多言語
		'M17n.M17n',
	);

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
		'Block' => array(
			'className' => 'Blocks.Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	//public $hasMany = array(
	//	'RssReaderItem' => array(
	//		'className' => 'RssReaderItem',
	//		'foreignKey' => 'rss_reader_id',
	//		'dependent' => false,
	//		'conditions' => '',
	//		'fields' => '',
	//		'order' => '',
	//		'limit' => '',
	//		'offset' => '',
	//		'exclusive' => '',
	//		'finderQuery' => '',
	//		'counterQuery' => ''
	//	)
	//);

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
		$this->validate = ValidateMerge::merge($this->validate, array(
			'block_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					//'required' => true,
					'on' => 'update', // Limit validation to 'create' or 'update' operations
				)
			),

			//key to set in OriginalKeyBehavior.

			//status to set in PublishableBehavior.

			'url' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(
						__d('net_commons', 'Please input %s.'), __d('rss_readers', 'RDF/RSS URL')
					),
					'required' => true,
				),
				'url' => array(
					'rule' => array('url'),
					'message' => sprintf(
						__d('net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'),
						__d('rss_readers', 'RDF/RSS URL'),
						__d('net_commons', 'URL')
					),
					'allowEmpty' => false,
					'required' => true,
				)
			),
			'title' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(
						__d('net_commons', 'Please input %s.'), __d('rss_readers', 'Site Title')
					),
					'required' => true,
				),
			),
			'link' => array(
				'url' => array(
					'rule' => array('url'),
					'message' => sprintf(
						__d('net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'),
						__d('rss_readers', 'Site Url'),
						__d('net_commons', 'URL')
					),
					'allowEmpty' => true,
				)
			),
		));

		if ($this->data['RssReader']['url'] === 'http://') {
			$this->data['RssReader']['url'] = '';
		}
		if ($this->data['RssReader']['link'] === 'http://') {
			$this->data['RssReader']['link'] = '';
		}

		if (isset($this->data['RssReaderItem'])) {
			$this->loadModels([
				'RssReaderItem' => 'RssReaders.RssReaderItem',
			]);
			if (! $this->RssReaderItem->validateMany($this->data['RssReaderItem'])) {
				$this->validationErrors = Hash::merge(
					$this->validationErrors,
					$this->RssReaderItem->validationErrors
				);
				return false;
			}
		}

		//TestでurlにAPPディレクト配下をセットした時は、URLのフォーマットチェックは除くようにする
		//if ($this->useDbConfig === 'test' && isset($this->data['RssReader']['url'])) {
		//	if (preg_match('/^' . preg_quote(APP, '/') . '/', $this->data['RssReader']['url'])) {
		//		unset($this->validate['url']['url']);
		//	}
		//}

		return parent::beforeValidate($options);
	}

/**
 * Called after each successful save operation.
 *
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return void
 * @throws InternalErrorException
 * @link http://book.cakephp.org/2.0/ja/models/callback-methods.html#aftersave
 * @see Model::save()
 */
	public function afterSave($created, $options = array()) {
		$this->loadModels([
			'RssReaderSetting' => 'RssReaders.RssReaderSetting',
		]);

		if (Hash::get($this->data, 'RssReaderItem')) {
			$this->loadModels([
				'RssReaderItem' => 'RssReaders.RssReaderItem',
			]);

			//既存データの削除
			$conditions = array('RssReaderItem.rss_reader_id' => $this->data[$this->alias]['id']);
			if (! $this->RssReaderItem->deleteAll($conditions, true, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$this->data['RssReaderItem'] = Hash::insert(
				$this->data['RssReaderItem'], '{n}.{s}.rss_reader_id', $this->data[$this->alias]['id']
			);
			if (! $this->RssReaderItem->saveMany($this->data['RssReaderItem'], ['validate' => false])) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		//RssReaderSetting登録
		if (isset($this->data['RssReaderSetting'])) {
			$this->RssReaderSetting->set($this->data['RssReaderSetting']);
			$this->RssReaderSetting->save(null, false);
		}

		parent::afterSave($created, $options);
	}

/**
 * RssReaderデータの取得
 *
 * @return array $rssReader
 */
	public function getRssReader() {
		$this->loadModels([
			'RssReaderSetting' => 'RssReaders.RssReaderSetting',
		]);

		if (Current::permission('content_editable')) {
			$conditions[$this->alias . '.is_latest'] = true;
		} else {
			$conditions[$this->alias . '.is_active'] = true;
		}
		$rssReader = $this->find('first', array(
			'recursive' => 0,
			'conditions' => $this->getBlockConditionById($conditions),
		));
		if (!$rssReader) {
			return $rssReader;
		}

		return Hash::merge($rssReader, $this->RssReaderSetting->getRssReaderSetting());
	}

/**
 * RssReaderデータの登録
 *
 * @param array $data リクエストデータ
 * @return bool
 * @throws InternalErrorException
 */
	public function saveRssReader($data) {
		$this->loadModels([
			'RssReaderItem' => 'RssReaders.RssReaderItem',
		]);

		//トランザクションBegin
		$this->begin();

		if ($data['RssReader']['url']) {
			$xmlData = $this->RssReaderItem->serializeXmlToArray($data['RssReader']['url']);
		}
		if (! $xmlData) {
			// Xmlが取得できない場合、validationのエラーにする
			$this->invalidate('url', __d('rss_readers', 'Feed Not Found.'));
			return false;
		}

		$data['RssReaderItem'] = $xmlData;

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		try {
			$rssReader = $this->save(null, false);
			if (! $rssReader) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return $rssReader;
	}

/**
 * RssReaderデータの削除
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteRssReader($data) {
		$this->loadModels([
			'RssReaderItem' => 'RssReaders.RssReaderItem',
		]);

		//トランザクションBegin
		$this->begin();

		$conditions = array(
			$this->alias . '.key' => $data[$this->alias]['key']
		);
		$result = $this->find('list', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));
		$rssReaderIds = array_keys($result);

		try {
			//RssReaderデータ削除
			$this->contentKey = $data[$this->alias]['key'];
			$conditions = array($this->alias . '.key' => $data[$this->alias]['key']);
			if (! $this->deleteAll($conditions, false, true)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//RssReaderItemデータ削除
			$conditions = array($this->RssReaderItem->alias . '.rss_reader_id' => $rssReaderIds);
			if (! $this->RssReaderItem->deleteAll($conditions, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//blockデータ削除
			$this->deleteBlock($data['Block']['key']);

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

}
