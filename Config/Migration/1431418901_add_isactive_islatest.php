<?php
class AddIsActiveIsLatest extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_isActive_isLatest';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(),
			'create_field' => array(
				'rss_readers' => array(
					'is_active' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し |  | ', 'after' => 'status'),
					'is_latest' => array('type' => 'boolean', 'null' => true, 'default' => '0', 'comment' => 'Is active, 0:deactive 1:acive | アクティブなコンテンツかどうか 0:アクティブでない 1:アクティブ | | ', 'after' => 'is_active'),
				),
			),
			'drop_field' => array(
				'rss_readers' => array('is_first_auto_translation', 'is_auto_translated', 'translation_engine'),
			),
		),
		'down' => array(
			'drop_table' => array(),
			'drop_field' => array(
				'rss_readers' => array('is_active', 'is_latest'),
			),
			'create_field' => array(
				'rss_readers' => array(
					'is_first_auto_translation' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => ''),
					'is_auto_translated' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ  0:オリジナル、1:自動翻訳 |  | '),
					'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'translation engine | 翻訳エンジン |  | ', 'charset' => 'utf8'),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
