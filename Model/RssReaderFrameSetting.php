<?php
/**
 * RssReaderFrameSetting Model
 *
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersAppModel', 'RssReaders.Model');

/**
 * Summary for RssReaderFrameSetting Model
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
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';

/**
 * get RssReader frame setting
 *
 * @param int $frameKey frames.key
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return array RssReaderFrameData
 */
	public function getRssReaderFrameSetting($frameKey) {
		$conditions = array(
			'frame_key' => $frameKey
		);
		$rssReaderFrameData = $this->find(
			'first',
			array(
				'conditions' => $conditions,
				'order' => $this->name . '.id DESC'
			)
		);

		return $rssReaderFrameData;
	}
}
