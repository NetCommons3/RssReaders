<?php
/**
 * Add plugin migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * Add plugin migration
 *
 * @package NetCommons\PluginManager\Config\Migration
 */
class PluginRecords extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'plugin_records';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(),
		'down' => array(),
	);

/**
 * plugin data
 *
 * @var array $migration
 */
	public $records = array(
		'Plugin' => array(
			//日本語
			array(
				'language_id' => '2',
				'key' => 'rss_readers',
				'namespace' => 'netcommons/rss-readers',
				'name' => 'RSSリーダー',
				'type' => 1,
				'default_action' => 'rss_readers/view',
				'default_setting_action' => 'rss_reader_blocks/index',
			),
			//英語
			array(
				'language_id' => '1',
				'key' => 'rss_readers',
				'namespace' => 'netcommons/rss-readers',
				'name' => 'RSS Readers',
				'type' => 1,
				'default_action' => 'rss_readers/view',
				'default_setting_action' => 'rss_reader_blocks/index',
			),
		),
		'PluginsRole' => array(
			array(
				'role_key' => 'room_administrator',
				'plugin_key' => 'rss_readers',
			)
		),
		'PluginsRoom' => array(
			array(
				'room_id' => '1',
				'plugin_key' => 'rss_readers',
			)
		)
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		$this->loadModels([
			'Plugin' => 'PluginManager.Plugin',
		]);

		if ($direction === 'down') {
			$this->Plugin->uninstallPlugin($this->records['Plugin'][0]['key']);
			return true;
		}

		foreach ($this->records as $model => $records) {
			if ($model === 'Plugin') {
				$weight = $this->Plugin->getMaxWeight($records[0]['type']) + 1;
				$keys = array_keys($records);
				foreach ($keys as $i) {
					$records[$i]['weight'] = $weight;
				}
			}
			if (!$this->updateRecords($model, $records)) {
				return false;
			}
		}
		return true;
	}
}
