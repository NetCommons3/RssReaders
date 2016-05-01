<?php
/**
 * RssReaderFrameSettingFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for RssReaderFrameSettingFixture
 */
class RssReaderFrameSettingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'rss reader id | RSSリーダーID |  | '),
		'frame_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'frame key | フレームKey | frames.key | ', 'charset' => 'utf8'),
		'display_number_per_page' => array('type' => 'integer', 'null' => false, 'default' => '10', 'length' => 4, 'comment' => 'display number of per 1 page | 1ページあたりの表示件数 |  | '),
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

}
