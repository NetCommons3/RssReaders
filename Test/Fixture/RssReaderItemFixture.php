<?php
/**
 * RssReaderItemFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Summary for RssReaderItemFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test
 */
class RssReaderItemFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'rss_reader_id' => '1',
			'title' => 'Title',
			'summary' => 'Summary',
			'link' => 'http://example.com',
			'serialize_value' => 'serialize()',
			'created_user' => 1,
			'created' => '2015-03-14 13:08:48',
			'modified_user' => 1,
			'modified' => '2015-03-14 13:08:48'
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('RssReaders') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new RssReadersSchema())->tables['rss_reader_items'];
		parent::init();
	}

}
