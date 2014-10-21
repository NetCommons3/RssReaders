<?php
/**
 * RssReader Model
 *
 * @property  RssReader $RssReader
 * @author    Kosuke Miura <k_miura@zenk.co.jp>
 * @link      http://www.netcommons.org NetCommons Project
 * @license   http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RssReadersAppModel', 'RssReaders.Model');

/**
 * RssReader Model
 *
 * @author  Kosuke Miura <k_miura@zenk.co.jp>
 * @package app.Plugin.RssReaders.Model
 */
class RssReader extends RssReadersAppModel {

/**
 * RssReaders status published
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @var    int
 */
	const STATUS_PUBLISHED = '1';

/**
 * RssReaders status approved
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @var    int
 */
	const STATUS_APPROVED = '2';

/**
 * RssReaders status drafted
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @var    int
 */
	const STATUS_DRAFTED = '3';

/**
 * RssReaders status disapproved
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @var    int
 */
	const STATUS_DISAPPROVED = '4';

/**
 * belongsTo associations
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @var    array
 */
	public $belongsTo = array(
		'Block' => array(
			'className' => 'Block',
			'foreignKey' => 'block_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * get rss_reader
 *
 * @param int $blockId blocks.id
 * @param boolean $editable false:publish latest rssreader|true:all latest rssreader
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return array $rssReader
 */
	public function getContent($blockId, $editable = 0) {
		$conditions = array(
			'block_id' => $blockId
		);
		if (!$editable) {
			$conditions['status'] = self::STATUS_PUBLISHED;
		}

		$rssReader = $this->find(
			'first',
			array(
				'conditions' => $conditions,
				'order' => $this->name . '.id DESC'
			)
		);

		return $rssReader;
	}

/**
 * save rss_reader
 *
 * @param array $data received post data
 * @param int $frameId frames.id
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @return boolean $result
 */
	public function saveRssReader($data, $frameId) {
		$data['Block']['name'] = $data['RssReader']['title'];
		$result = $this->saveAll($data);

		// 新規登録の場合は、Frames.block_idを更新する。
		if (!strlen($data['RssReader']['id'])) {
			$rssReaderId = $this->getLastInsertID();
			$rssReaderData = $this->findById($rssReaderId);
			$blockId = $rssReaderData['RssReader']['block_id'];

			$frameData = array(
				'Frame' => array(
					'id' => $frameId,
					'block_id' => $blockId
				)
			);
			$this->Frame = ClassRegistry::init('Frame');
			$this->Frame->save($frameData);
		}

		return $result;
	}
}
