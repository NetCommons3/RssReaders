<?php
/**
 * RssReaderFixture
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for RssReaderFixture
 */
class RssReaderFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
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

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'block_id' => 1,
			'status' => 1,
			'url' => '<?xml version="1.0"?><rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/"><item><title>1</title><link>2</link><dc:date>2014-11-12T17:52:41+09:00</dc:date><description>3</description></item></rdf:RDF>',
			'title' => 'RssReaderタイトル',
			'summary' => 'RssReaderの説明です。',
			'link' => 'http://example.com',
			'serialize_value' => 'a:1:{s:3:"RDF";a:1:{s:4:"item";a:2:{i:0;a:4:{s:5:"title";s:1:"1";s:4:"link";s:1:"2";s:11:"description";s:1:"3";s:7:"dc:date";s:25:"2014-11-12T17:52:41+09:00";}i:1;a:4:{s:5:"title";s:1:"1";s:4:"link";s:1:"2";s:11:"description";s:1:"3";s:7:"dc:date";s:25:"2014-11-12T17:52:41+09:00";}}}}',
			'cache_time' => 259200,
			'is_auto_translated' => 0,
			'translation_engine' => '',
			'created_user' => 1,
			'created' => '2014-10-14 05:37:41',
			'modified_user' => 1,
			'modified' => '9999-12-31 00:00:00'
		),
		array(
			'id' => 2,
			'block_id' => 2,
			'status' => 2,
			'url' => '<?xml version="1.0"?><rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/"><item><title>1</title><link>2</link><dc:date>2014-11-12T17:52:41+09:00</dc:date><description>3</description></item></rdf:RDF>',
			'title' => 'RssReader申請中',
			'summary' => '申請中のRssReaderです。',
			'link' => 'http://example.com',
			'serialize_value' => '',
			'cache_time' => 1800,
			'is_auto_translated' => 0,
			'translation_engine' => '',
			'created_user' => 1,
			'created' => '2014-10-14 05:37:41',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:37:41'
		),
		array(
			'id' => 3,
			'block_id' => 3,
			'status' => 3,
			'url' => '<?xml version="1.0"?><rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/"><item><title>1</title><link>2</link><dc:date>2014-11-12T17:52:41+09:00</dc:date><description>3</description></item></rdf:RDF>',
			'title' => 'RssReader下書き',
			'summary' => '下書きのRssReaderです。',
			'link' => 'http://example.com',
			'serialize_value' => '',
			'cache_time' => 1800,
			'is_auto_translated' => 0,
			'translation_engine' => '',
			'created_user' => 1,
			'created' => '2014-10-14 05:37:41',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:37:41'
		),
		array(
			'id' => 4,
			'block_id' => 4,
			'status' => 4,
			'url' => '<?xml version="1.0"?><rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/"><item><title>1</title><link>2</link><dc:date>2014-11-12T17:52:41+09:00</dc:date><description>3</description></item></rdf:RDF>',
			'title' => 'RssReader差し戻し',
			'summary' => '差し戻しのRssReaderです。',
			'link' => 'http://example.com',
			'serialize_value' => '',
			'cache_time' => 1800,
			'is_auto_translated' => 0,
			'translation_engine' => '',
			'created_user' => 1,
			'created' => '2014-10-14 05:37:41',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:37:41'
		)
	);

}
