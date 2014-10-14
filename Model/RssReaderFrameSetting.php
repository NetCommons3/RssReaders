<?php
/**
 * RssReaderFrameSetting Model
 *
 *
* @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
* @link     http://www.netcommons.org NetCommons Project
* @license  http://www.netcommons.org/license.txt NetCommons License
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
