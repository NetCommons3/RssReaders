<?php
/**
 * RssReaderFrameSetting Model
 *
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('RssReadersAppModel', 'RssReaders.Model');

/**
 * Summary for RssReaderFrameSetting Model
 */
class RssReaderFrameSetting extends RssReadersAppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';

}
