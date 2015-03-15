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
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					'required' => true,
				)
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * save edumap
 *
 * @param array $data received post data
 * @return bool true success, false error
 * @throws InternalErrorException
 */
	public function saveRssReaderFrameSetting($data) {
		$this->loadModels([
			'RssReaderFrameSetting' => 'RssReaders.RssReaderFrameSetting',
		]);

		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			//validate処理
			if (! $this->validateRssReaderFrameSetting($data)) {
				return false;
			}

			//登録処理
			if (! $this->save(null, false)) {
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

/**
 * validate edumap
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
	public function validateRssReaderFrameSetting($data) {
		$this->set($data);
		$this->validates();
		return $this->validationErrors ? false : true;
	}
}
