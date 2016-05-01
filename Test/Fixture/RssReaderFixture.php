<?php
/**
 * RssReaderFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * RssReaderFixture
 * @codeCoverageIgnore
 */
class RssReaderFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'language_id' => '2',
			'block_id' => '181',
			'status' => '1',
			'is_active' => 1,
			'is_latest' => 0,
			'key' => 'rss_reader_1',
			'url' => '<?xml version="1.0"?><rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/"><item><title>1</title><link>2</link><dc:date>2014-11-12T17:52:41+09:00</dc:date><description>3</description></item></rdf:RDF>',
			'title' => 'RssReaderタイトル',
			'summary' => 'RssReaderの説明です。',
			'link' => 'http://example.com',
			'created_user' => 1,
			'created' => '2015-03-14 13:04:25',
			'modified_user' => 1,
			'modified' => '2015-03-14 13:04:25'
		),
		array(
			'id' => '2',
			'language_id' => '2',
			'block_id' => '181',
			'status' => '3',
			'is_active' => 0,
			'is_latest' => 1,
			'key' => 'rss_reader_1',
			'url' => '<?xml version="1.0"?><rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/"><item><title>1</title><link>2</link><dc:date>2014-11-12T17:52:41+09:00</dc:date><description>3</description></item></rdf:RDF>',
			'title' => 'RssReader下書き',
			'summary' => '下書きのRssReaderです。',
			'link' => 'http://example.com',
			'created_user' => 1,
			'created' => '2014-10-14 05:37:41',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:37:41'
		),
		array(
			'id' => '3',
			'language_id' => '2',
			'block_id' => '182',
			'status' => '1',
			'is_active' => 1,
			'is_latest' => 1,
			'key' => 'rss_reader_2',
			'url' => '<?xml version="1.0"?><rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/"><item><title>1</title><link>2</link><dc:date>2014-11-12T17:52:41+09:00</dc:date><description>3</description></item></rdf:RDF>',
			'title' => 'RssReader申請中',
			'summary' => '申請中のRssReaderです。',
			'link' => 'http://example.com',
			'created_user' => 1,
			'created' => '2014-10-14 05:37:41',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:37:41'
		),
		array(
			'id' => '4',
			'language_id' => '2',
			'block_id' => '186',
			'status' => '1',
			'is_active' => 1,
			'is_latest' => 1,
			'key' => 'rss_reader_4',
			'url' => 'test',
			'title' => 'Title',
			'summary' => 'Summary',
			'link' => 'http://example.com',
			'created_user' => 1,
			'created' => '2014-10-14 05:37:41',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:37:41'
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('RssReaders') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new RssReadersSchema())->tables['rss_readers'];

		foreach ($this->records as $i => $recode) {
			if ($recode['id'] !== '4') {
				$this->records[$i]['url'] = APP . 'Plugin' . DS . 'RssReaders' . DS . 'Test' . DS . 'Fixture' . DS . 'rss_v1.xml';
			}
			if ($recode['id'] === '3') {
				$this->records[$i]['modified'] = date('Y-m-d H:i:s');
			}
		}
		parent::init();
	}

}
