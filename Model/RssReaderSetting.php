<?php
/**
 * RssReaderSetting Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RssReadersAppModel', 'RssReaders.Model');
App::uses('BlockSettingBehavior', 'Blocks.Model/Behavior');

/**
 * RssReaderSetting Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Model
 */
class RssReaderSetting extends RssReadersAppModel {

/**
 * Custom database table name
 *
 * @var string
 */
	public $useTable = 'blocks';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Blocks.BlockRolePermission',
		'Blocks.BlockSetting' => array(
			BlockSettingBehavior::FIELD_USE_WORKFLOW,
		),
	);

/**
 * RssReaderSettingデータ新規作成
 *
 * @return array
 */
	public function createRssReaderSetting() {
		$rssReaderSetting = $this->createAll();
		/** @see BlockSettingBehavior::getBlockSetting() */
		/** @see BlockSettingBehavior::_createBlockSetting() */
		return Hash::merge($rssReaderSetting, $this->getBlockSetting());
	}

/**
 * RssReaderSettingデータ取得
 *
 * @return array
 */
	public function getRssReaderSetting() {
		$rssReaderSetting = $this->find('first', array(
			'recursive' => -1,
			//'conditions' => array('block_key' => Current::read('Block.key')),
			'conditions' => array(
				$this->alias . '.key' => Current::read('Block.key'),
				$this->alias . '.language_id' => Current::read('Language.id'),
			),
		));

		return $rssReaderSetting;
	}

/**
 * RssReaderSettingデータ登録
 *
 * @param array $data リクエストデータ
 * @return bool
 * @throws InternalErrorException
 */
	public function saveRssReaderSetting($data) {
		//トランザクションBegin
		$this->begin();

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		try {
			if (! $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//トランザクションCommit
			$this->commit();

		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

}
