<?php
/**
 * RssReaders All Test Case
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * RssReaders All Test Case
 *
 * @author Kosuke Miura <k_miura@zenk.co.jp>
 * @package NetCommons\RssReaders\Test
 * @codeCoverageIgnore
 */
class AllRssReadersTest extends CakeTestSuite {

/**
 * All test suite
 *
 * @return CakeTestSuite
 */
	public static function suite() {
		$plugin = preg_replace('/^All([\w]+)Test$/', '$1', __CLASS__);
		$suite = new CakeTestSuite(sprintf('All %s Plugin tests', $plugin));

		$directory = CakePlugin::path($plugin) . 'Test' . DS . 'Case';
		$Folder = new Folder($directory);
		$exceptions = array(
			'RssReadersControllerTestBase.php',
			'RssReadersModelTestBase.php',
			//後で削除
			'RssReaderFrameSettingSaveRssReaderFrameSettingTest.php',
			'RssReaderFrameSettingValidateRssReaderFrameSettingTest.php',
			'RssReaderGetRssReaderTest.php',
			'RssReaderItemGetRssReaderItemsTest.php',
			'RssReaderItemSerializeXmlToArrayTest.php',
			'RssReaderItemUpdateRssReaderItemsTest.php',
			'RssReaderItemValidateRssReaderItemsTest.php',
			'RssReaderSaveRssReaderTest.php',
			'RssReadersModelTestBase.php',
			'RssReaderValidateRssReaderTest.php',
			'RssReaderFrameSettingsControllerEditTest.php',
			'RssReadersControllerEditTest.php',
			'RssReadersControllerGetTest.php',
			'RssReadersControllerTestBase.php',
			'RssReadersControllerViewTest.php',
		);
		$files = $Folder->tree(null, $exceptions, 'files');
		foreach ($files as $file) {
			if (substr($file, -4) === '.php') {
				$suite->addTestFile($file);
			}
		}

		return $suite;
	}
}
