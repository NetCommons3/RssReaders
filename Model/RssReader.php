<?php
/**
 * RssReader Model
 *
 * @property Block $Block
 * @property RssReaderItem $RssReaderItem
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RssReadersAppModel', 'RssReaders.Model');

/**
 * RssReader Model
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Model
 */
class RssReader extends RssReadersAppModel {

/**
 * Cache time
 *
 * @var string
 */
	const CACHE_TIME = 'PT1H';

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.OriginalKey',
		'NetCommons.Publishable'
	);

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
	public $hasMany = array(
		'RssReaderItem' => array(
			'className' => 'RssReaderItem',
			'foreignKey' => 'rss_reader_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
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
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('rss_readers', 'RDF/RSS URL')),
					'required' => true,
				),
				'url' => array(
					'rule' => array('url'),
					'message' => sprintf(__d('net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'), __d('rss_readers', 'RDF/RSS URL'), __d('rss_readers', 'URL')),
					'allowEmpty' => false,
					'required' => true,
				)
			),
			'title' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('rss_readers', 'Site Title')),
					'required' => true,
				),
			),
			'link' => array(
				'url' => array(
					'rule' => array('url'),
					'message' => sprintf(__d('net_commons', 'Unauthorized pattern for %s. Please input the data in %s format.'), __d('rss_readers', 'Site Url'), __d('rss_readers', 'URL')),
					'allowEmpty' => true,
				)
			),
		));

		//TestでurlにAPPディレクト配下をセットした時は、URLのフォーマットチェックは除くようにする
		if ($this->useDbConfig === 'test' && isset($this->data['RssReader']['url'])) {
			if (preg_match('/^' . preg_quote(APP, '/') . '/', $this->data['RssReader']['url'])) {
				unset($this->validate['url']['url']);
			}
		}
		return parent::beforeValidate($options);
	}

/**
 * Get rss reader
 *
 * @param int $blockId blocks.id
 * @param int $roomId rooms.id
 * @param bool $contentEditable true can edit the content, false not can edit the content.
 * @return array $rssReader
 */
	public function getRssReader($blockId, $roomId, $contentEditable) {
		$conditions = array(
			'Block.id' => $blockId,
			'Block.room_id' => $roomId,
		);
		if ($contentEditable) {
			$conditions[$this->alias . '.is_latest'] = true;
		} else {
			$conditions[$this->alias . '.is_active'] = true;
		}

		$rssReader = $this->find('first', array(
			'recursive' => 0,
			'conditions' => $conditions,
			//'order' => 'RssReader.id DESC',
		));

		return $rssReader;
	}

/**
 * Save rssReader data
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 * @throws InternalErrorException
 */
	public function saveRssReader($data) {
		$this->loadModels([
			'RssReader' => 'RssReaders.RssReader',
			'RssReaderItem' => 'RssReaders.RssReaderItem',
			'Block' => 'Blocks.Block',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//RssReaderのvalidate
			if (! $this->validateRssReader($data, ['block', 'comment', 'rss_reader_item'])) {
				return false;
			}

			//ブロックのvalidate
			if (! $this->Block->validateBlock($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Block->validationErrors);
				return false;
			}

			//ブロックの登録
			$block = $this->Block->saveByFrameId($data['Frame']['id']);

			//RssReaderの登録
			$this->data['RssReader']['block_id'] = (int)$block['Block']['id'];
			$rssReader = $this->save(null, false);
			if (! $rssReader) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//RSS Itemsの登録
			if (isset($rssReader['RssReaderItem'])) {
				$rssReader['RssReaderItem'] = Hash::insert($rssReader['RssReaderItem'], '{n}.rss_reader_id', $rssReader[$this->alias]['id']);
				if (! $this->RssReaderItem->saveMany($rssReader['RssReaderItem'], ['validate' => false])) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

			//コメントの登録
			if ($this->Comment->data) {
				if (! $this->Comment->save(null, false)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

			$dataSource->commit();
		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return $rssReader;
	}

/**
 * validate rssReader
 *
 * @param array $data received post data
 * @param array $contains Optional validate sets
 * @return bool True on success, false on error
 */
	public function validateRssReader($data, $contains = []) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}

		//RssItemsのvalidate
		if (in_array('rss_reader_item', $contains, true) && isset($data['RssReaderItem'])) {
			if (! $this->RssReaderItem->validateRssReaderItems($data['RssReaderItem'])) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->RssReaderItem->validationErrors);
				return false;
			}
		}

		//コメントのvalidate
		if (in_array('comment', $contains, true) && isset($data['Comment'])) {
			if (! $this->Comment->validateByStatus($data, array('plugin' => $this->plugin, 'caller' => $this->name))) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->Comment->validationErrors);
				return false;
			}
		}

		return true;
	}

/**
 * validateRssReaderAssociated
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
//	public function validateRssReaderAssociated($data) {
//		//RssItemsのvalidate
//		if (isset($data['RssReaderItem']) && ! $this->RssReaderItem->validateRssReaderItems($data['RssReaderItem'])) {
//			$this->validationErrors = Hash::merge($this->validationErrors, $this->RssReaderItem->validationErrors);
//			return false;
//		}
//
//		//コメントのvalidate
//		if (! $this->Comment->validateByStatus($data, array('caller' => $this->name))) {
//			$this->validationErrors = Hash::merge($this->validationErrors, $this->Comment->validationErrors);
//			return false;
//		}
//
//		return true;
//	}

/**
 * saveRssReaderAssociated
 *
 * @param array $data received post data
 * @return bool true on success, exception on error
 * @throws InternalErrorException
 */
//	public function saveRssReaderAssociated($data) {
//		//RSS Itemsの登録
//		if (isset($data['RssReaderItem'])) {
//			$data['RssReaderItem'] = Hash::insert($data['RssReaderItem'], '{n}.rss_reader_id', $data[$this->alias]['id']);
//			if (! $this->RssReaderItem->saveMany($data['RssReaderItem'], ['validate' => false])) {
//				// @codeCoverageIgnoreStart
//				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
//				// @codeCoverageIgnoreEnd
//			}
//		}
//
//		//コメントの登録
//		if ($this->Comment->data) {
//			$this->Comment->data['Comment']['plugin_key'] = 'rss_readers';
//			if (! $this->Comment->save(null, false)) {
//				// @codeCoverageIgnoreStart
//				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
//				// @codeCoverageIgnoreEnd
//			}
//		}
//
//		return true;
//	}

/**
 * Delete RssReader
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function deleteRssReader($data) {
		$this->loadModels([
			'RssReader' => 'RssReaders.RssReader',
			'RssReaderItem' => 'RssReaders.RssReaderItem',
			'Block' => 'Blocks.Block',
			'Comment' => 'Comments.Comment',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		$conditions = array(
			$this->alias . '.key' => $data[$this->alias]['key']
		);
		$rssReaders = $this->find('list', array(
				'recursive' => -1,
				'conditions' => $conditions,
			)
		);
		$rssReaderIds = array_keys($rssReaders);

		try {
			if (! $this->deleteAll(array($this->alias . '.key' => $data[$this->alias]['key']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if (! $this->RssReaderItem->deleteAll(array($this->RssReaderItem->alias . '.rss_reader_id' => $rssReaderIds), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//Blockデータ削除
			$this->Block->deleteBlock($data['Block']['key']);

			//トランザクションCommit
			$dataSource->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

}
