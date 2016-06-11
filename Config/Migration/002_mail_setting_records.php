<?php
/**
 * メール設定データのMigration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('MailsMigration', 'Mails.Config/Migration');

/**
 * メール設定データのMigration
 *
 * @package NetCommons\Mails\Config\Migration
 */
class RssReaderMailSettingRecords extends MailsMigration {

/**
 * プラグインキー
 *
 * @var string
 */
	const PLUGIN_KEY = 'rss_readers';

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'mail_setting_records';

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
		'MailSetting' => array(
			//コンテンツ通知 - 設定
			array(
				'plugin_key' => self::PLUGIN_KEY,
				'block_key' => null,
				'is_mail_send' => false,
				'is_mail_send_approval' => true,
			),
		),
		'MailSettingFixedPhrase' => array(
			//コンテンツ通知 - 定型文
			// * 英語
			array(
				'language_id' => '1',
				'plugin_key' => self::PLUGIN_KEY,
				'block_key' => null,
				'type_key' => 'contents',
				'mail_fixed_phrase_subject' => '[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-TITLE}({X-ROOM})',
				'mail_fixed_phrase_body' => '{X-PLUGIN_NAME}にリンクが追加されたのでお知らせします。
ルーム名: {X-ROOM}
RDF/RSSのURL: {X-RSS_URL}
RDF/RSSのサイト名: {X-TITLE}
RDF/RSSのサイトURL: {X-LINK}
RDF/RSSのサイト説明: {X-SUMMARY}
登録者: {X-USER}
登録日時: {X-TO_DATE}

この内容を確認するには、下記アドレスへ
{X-URL}',
			),
			// * 日本語
			array(
				'language_id' => '2',
				'plugin_key' => self::PLUGIN_KEY,
				'block_key' => null,
				'type_key' => 'contents',
				'mail_fixed_phrase_subject' => '[{X-SITE_NAME}-{X-PLUGIN_NAME}]{X-TITLE}({X-ROOM})',
				'mail_fixed_phrase_body' => '{X-PLUGIN_NAME}にリンクが追加されたのでお知らせします。
ルーム名: {X-ROOM}
RDF/RSSのURL: {X-RSS_URL}
RDF/RSSのサイト名: {X-TITLE}
RDF/RSSのサイトURL: {X-LINK}
RDF/RSSのサイト説明: {X-SUMMARY}
登録者: {X-USER}
登録日時: {X-TO_DATE}

この内容について確認するには、下記アドレスへ
{X-URL}',
			),
		),
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
		return parent::updateAndDelete($direction, self::PLUGIN_KEY);
	}
}
