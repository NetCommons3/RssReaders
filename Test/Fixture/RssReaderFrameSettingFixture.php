<?php
/**
 * RssReaderFrameSettingFixture
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
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
			'id' => 1,
			'frame_key' => 'd6c512c3cb0e3cde4892ffbc1bf05b6dd0da70f22ce1404907d36b30cebe1553',
			'display_number_per_page' => 1,
			'created_user' => 1,
			'created' => '2014-10-14 05:39:46',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:39:46'
		),
		array(
			'id' => 2,
			'frame_key' => 'dijgidoa9302ut30jg0a8du0jij0ge02j84892jikijglijgr00ajoifjbnir04',
			'display_number_per_page' => 5,
			'created_user' => 1,
			'created' => '2014-10-14 05:39:46',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:39:46'
		),
		array(
			'id' => 3,
			'frame_key' => 'plao00193u93z0o849jgkr049u48jiojgirajozmpqepoririwmcmndklfj39zf',
			'display_number_per_page' => 5,
			'created_user' => 1,
			'created' => '2014-10-14 05:39:46',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:39:46'
		),
		array(
			'id' => 4,
			'frame_key' => 'idiug930foajhjhufoaosstsrsr3838ghdshai9302jgjydhhenijij40gjg00',
			'display_number_per_page' => 5,
			'created_user' => 1,
			'created' => '2014-10-14 05:39:46',
			'modified_user' => 1,
			'modified' => '2014-10-14 05:39:46'
		)
	);

}
