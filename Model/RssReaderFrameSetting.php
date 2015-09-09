<?php
/**
 * RssReaderFrameSetting Model
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersAppModel', 'RssReaders.Model');

/**
 * RssReaderFrameSetting Model
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Model
 */
class RssReaderFrameSetting extends RssReadersAppModel {

/**
 * belongsTo associations
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @var array
 */
	public $belongsTo = array(
		'Frame' => array(
			'className' => 'Frames.Frame',
			'foreignKey' => 'frame_key',
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
			'frame_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
				)
			),
			'display_number_per_page' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * Get RssReaderFrameSetting
 *
 * @param string $frameKey frames.key
 * @return array $rssFrameSetting
 */
	public function getRssReaderFrameSetting($frameKey) {
		$rssFrameSetting = $this->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'frame_key' => $frameKey
			)
		));

		return $rssFrameSetting;
	}

/**
 * save RssReaderFrameSetting
 *
 * @param array $data received post data
 * @return bool true success, false error
 * @throws InternalErrorException
 */
	public function saveRssReaderFrameSetting($data) {
		$this->loadModels([
			'RssReaderFrameSetting' => 'RssReaders.RssReaderFrameSetting',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//validate処理
			if (! $this->validateRssReaderFrameSetting($data)) {
				return false;
			}

			//登録処理
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$dataSource->commit();
		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}

		return true;
	}

/**
 * validate RssReaderFrameSetting
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
	public function validateRssReaderFrameSetting($data) {
		$this->set($data);
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}
		return true;
	}
}
