<?php 
class RssReaderSchema extends CakeSchema {

	public $connection = 'master';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $rss_reader_frame_settings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'rss reader id | RSSリーダーID |  | '),
		'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'frame key | フレームKey | frames.key | ', 'charset' => 'utf8'),
		'display_number_per_page' => array('type' => 'integer', 'null' => false, 'default' => '10', 'length' => 4, 'comment' => 'display number of per 1 page | 1ページあたりの表示件数 |  | '),
		'display_site_info' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'comment' => 'site information display, 1: display or 0: no display | サイト情報表示の有無  0:表示しない、1:表示する |  | '),
		'display_summary' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'item\'s summary display, 1: display or 0: no display | 概要表示の有無  0:表示しない、1:表示する |  | '),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	public $rss_readers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID |  |  | '),
		'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'block id |  ブロックID | blocks.id | '),
		'status' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し |  | '),
		'url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'RSS URL |  |  | ', 'charset' => 'utf8'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'site name | サイト名 |  | ', 'charset' => 'utf8'),
		'summary' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'site description | サイト説明 |  | ', 'charset' => 'utf8'),
		'link' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'site url | サイトURL |  | ', 'charset' => 'utf8'),
		'serialize_value' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'xml serialize data | XMLのシリアライズデータ |  | ', 'charset' => 'utf8'),
		'cache_time' => array('type' => 'integer', 'null' => false, 'default' => '3600', 'length' => 9, 'comment' => 'cache time | キャッシュ時間 |  | '),
		'is_auto_translated' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ  0:オリジナル、1:自動翻訳 |  | '),
		'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'translation engine | 翻訳エンジン |  | ', 'charset' => 'utf8'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_rss_readers_blocks1_idx' => array('column' => 'block_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

}
