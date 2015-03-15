<?php
/**
 * RssReaderFixture
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
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
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 6, 'comment' => 'language id | 言語ID | languages.id | '),
		'block_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'block id |  ブロックID | blocks.id | '),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => 'public status, 1: public, 2: public pending, 3: draft during 4: remand | 公開状況  1:公開中、2:公開申請中、3:下書き中、4:差し戻し |  | '),
		'key' => array('type' => 'string', 'null' => false, 'collate' => 'utf8_general_ci', 'comment' => 'key | キー |  | ', 'charset' => 'utf8'),
		'url' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'RSS URL |  |  | ', 'charset' => 'utf8'),
		'title' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'site name | サイト名 |  | ', 'charset' => 'utf8'),
		'summary' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'site description | サイト説明 |  | ', 'charset' => 'utf8'),
		'link' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'site url | サイトURL |  | ', 'charset' => 'utf8'),
		'is_first_auto_translation' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_auto_translated' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'translation type. 0:original , 1:auto translation | 翻訳タイプ  0:オリジナル、1:自動翻訳 |  | '),
		'translation_engine' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'translation engine | 翻訳エンジン |  | ', 'charset' => 'utf8'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'created user | 作成者 | users.id | '),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'created datetime | 作成日時 |  | '),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => '0', 'comment' => 'modified user | 更新者 | users.id | '),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'modified datetime | 更新日時 |  | '),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'language_id' => 2,
			'block_id' => 1,
			'status' => 1,
			'key' => 'rss_reader_1',
			'url' => '<?xml version="1.0"?><rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/"><item><title>1</title><link>2</link><dc:date>2014-11-12T17:52:41+09:00</dc:date><description>3</description></item></rdf:RDF>',
			'title' => 'RssReaderタイトル',
			'summary' => 'RssReaderの説明です。',
			'link' => 'http://example.com',
			'is_auto_translated' => 0,
			'translation_engine' => '',
			'created_user' => 1,
			'created' => '2015-03-14 13:04:25',
			'modified_user' => 1,
			'modified' => '2015-03-14 13:04:25'
		),
		array(
			'id' => 2,
			'language_id' => 2,
			'block_id' => 2,
			'status' => 2,
			'key' => 'rss_reader_2',
			'url' => '<?xml version="1.0"?><rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/"><item><title>1</title><link>2</link><dc:date>2014-11-12T17:52:41+09:00</dc:date><description>3</description></item></rdf:RDF>',
			'title' => 'RssReader申請中',
			'summary' => '申請中のRssReaderです。',
			'link' => 'http://example.com',
			'is_auto_translated' => 0,
			'translation_engine' => '',
			'created_user' => 1,
			'created' => '2014-10-14 05:37:41',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:37:41'
		),
		array(
			'id' => 3,
			'language_id' => 2,
			'block_id' => 3,
			'status' => 3,
			'key' => 'rss_reader_3',
			'url' => '<?xml version="1.0"?><rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/"><item><title>1</title><link>2</link><dc:date>2014-11-12T17:52:41+09:00</dc:date><description>3</description></item></rdf:RDF>',
			'title' => 'RssReader下書き',
			'summary' => '下書きのRssReaderです。',
			'link' => 'http://example.com',
			'is_auto_translated' => 0,
			'translation_engine' => '',
			'created_user' => 1,
			'created' => '2014-10-14 05:37:41',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:37:41'
		),
		array(
			'id' => 4,
			'language_id' => 2,
			'block_id' => 4,
			'status' => 4,
			'key' => 'rss_reader_4',
			'url' => '<?xml version="1.0"?><rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/"><item><title>1</title><link>2</link><dc:date>2014-11-12T17:52:41+09:00</dc:date><description>3</description></item></rdf:RDF>',
			'title' => 'RssReader差し戻し',
			'summary' => '差し戻しのRssReaderです。',
			'link' => 'http://example.com',
			'is_auto_translated' => 0,
			'translation_engine' => '',
			'created_user' => 1,
			'created' => '2014-10-14 05:37:41',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:37:41'
		)
	);

}
