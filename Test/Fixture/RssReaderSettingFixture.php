<?php
/**
 * RssReaderSettingixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * RssReaderSettingFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\RssReaders\Test
 */
class RssReaderSettingFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'block_key' => 'Lorem ipsum dolor sit amet',
			'use_workflow' => 1,
			'created_user' => 1,
			'created' => '2016-06-28 08:30:22',
			'modified_user' => 1,
			'modified' => '2016-06-28 08:30:22'
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('RssReaders') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new RssReadersSchema())->tables['rss_reader_settings'];
		parent::init();
	}

}
