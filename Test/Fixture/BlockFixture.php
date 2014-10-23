<?php
/**
 * BlockFixture
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Summary for BlockFixture
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @package NetCommons\RssReaders\Test
 */
class BlockFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'room_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'key' => array('type' => 'text', 'null' => false, 'default' => null),
		'name' => array('type' => 'text', 'null' => true, 'default' => null),
		'created_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
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
			'room_id' => 1
		),
		array(
			'id' => 2,
			'room_id' => 1
		),
		array(
			'id' => 3,
			'room_id' => 1
		),
		array(
			'id' => 4,
			'room_id' => 1
		)
	);

}
