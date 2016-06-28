<?php
/**
 * RssReaderFrameSettingFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Summary for RssReaderFrameSettingFixture
 */
class RssReaderFrameSettingFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'frame_key' => 'frame_181',
			'display_number_per_page' => 1,
			'created_user' => 1,
			'created' => '2014-10-14 05:39:46',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:39:46'
		),
		array(
			'id' => 2,
			'frame_key' => 'frame_182',
			'display_number_per_page' => 5,
			'created_user' => 1,
			'created' => '2014-10-14 05:39:46',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:39:46'
		),
		array(
			'id' => 3,
			'frame_key' => 'frame_183',
			'display_number_per_page' => 5,
			'created_user' => 1,
			'created' => '2014-10-14 05:39:46',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:39:46'
		),
		array(
			'id' => 4,
			'frame_key' => 'frame_184',
			'display_number_per_page' => 5,
			'created_user' => 1,
			'created' => '2014-10-14 05:39:46',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:39:46'
		)
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('RssReaders') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new RssReadersSchema())->tables['rss_reader_frame_settings'];
		parent::init();
	}

}
