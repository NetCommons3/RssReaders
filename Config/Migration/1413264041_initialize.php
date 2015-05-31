<?php
/**
 * Migration file
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * RssReaders CakeMigration
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Config
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class Initialize extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'Initialize';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'rss_reader_frame_settings' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'rss reader id | RSSリーダーID |  | '),
					'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'frame key | フレームKey | frames.key | ', 'charset' => 'utf8'),
					'display_number_per_page' => array('type' => 'integer', 'null' => false, 'default' => '10', 'length' => 4, 'comment' => 'display number of per 1 page | 1ページあたりの表示件数 |  | '),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'rss_readers' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'language_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 6, 'comment' => 'language id | 言語ID | languages.id | '),
					'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'block id |  ブロックID | blocks.id | '),
					'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し |  | '),
					'key' => array('type' => 'string', 'null' => false, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => 'key | キー |  | ', 'charset' => 'utf8'),
					'url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'RSS URL |  |  | ', 'charset' => 'utf8'),
					'title' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'site name | サイト名 |  | ', 'charset' => 'utf8'),
					'summary' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'site description | サイト説明 |  | ', 'charset' => 'utf8'),
					'link' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'site url | サイトURL |  | ', 'charset' => 'utf8'),
					'is_first_auto_translation' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => ''),
					'is_auto_translated' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ  0:オリジナル、1:自動翻訳 |  | '),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'translation engine | 翻訳エンジン |  | ', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'rss_reader_items' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
					'rss_reader_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index', 'comment' => 'rss reader id |  RSS Reader ID | rss_readers.id | '),
					'title' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'item title | タイトル |  | ', 'charset' => 'utf8'),
					'summary' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'item description | 概要 |  | ', 'charset' => 'utf8'),
					'link' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'item url | リンク |  | ', 'charset' => 'utf8'),
					'last_updated' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'last updated datetime | 最新更新日時 |  | '),
					'serialize_value' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'xml serialize data | XMLのシリアライズデータ |  | ', 'charset' => 'utf8'),
					'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
					'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
					'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
					'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'rss_reader_frame_settings', 'rss_reader_items', 'rss_readers'
			),
		),
	);

/**
 * recodes
 *
 * @var array $migration
 */
	public $records = array(
		'Plugin' => array(
			array(
				'language_id' => 2,
				'key' => 'rss_readers',
				'namespace' => 'netcommons/rss_readers',
				'name' => 'RSSリーダー',
				'type' => 1,
				'default_action' => 'rss_readers/view',
				'default_setting_action' => 'rss_reader_blocks/index',
			)
		),
		'PluginsRole' => array(
			array(
				'role_key' => 'room_administrator',
				'plugin_key' => 'rss_readers'
			)
		),
		'PluginsRoom' => array(
			array(
				'room_id' => '1',
				'plugin_key' => 'rss_readers'
			)
		)
	);

/**
 * Before migration callback
 *
 * @param string $direction up or down direction of migration process
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction up or down direction of migration process
 * @return bool Should process continue
 */
	public function after($direction) {
		if ($direction === 'down') {
			return true;
		}
		foreach ($this->records as $model => $records) {
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}
		return true;
	}

/**
 * Update model records
 *
 * @param string $model model name to update
 * @param string $records records to be stored
 * @param string $scope ?
 * @return bool Should process continue
 */
	public function updateRecords($model, $records, $scope = null) {
		$Model = $this->generateModel($model);
		foreach ($records as $record) {
			$Model->create();
			if (!$Model->save($record, false)) {
				return false;
			}
		}
		return true;
	}
}
