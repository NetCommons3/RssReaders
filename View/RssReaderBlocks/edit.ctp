<?php
/**
 * Blocks edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>
<?php echo $this->Html->script('/rss_readers/js/rss_readers.js', false); ?>

<div id="nc-rss-readers-<?php echo $frameId; ?>" class="modal-body"
		ng-controller="RssReaders"
		ng-init="initialize(<?php echo h(json_encode(['frameId' => $frameId])); ?>)">

	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<?php echo $this->element('Blocks.setting_tabs', $blockSettingTabs); ?>

		<?php echo $this->element('RssReaders.RssReaderBlocks/edit_form'); ?>

		<?php if ($this->request->params['action'] === 'edit') : ?>
			<?php echo $this->element('Blocks.delete_form', array(
					'controller' => 'RssReaderBlocks',
					'action' => 'delete/' . $frameId . '/' . (int)$rssReader['blockId'],
					'callback' => 'RssReaders.RssReaderBlocks/delete_form'
				)); ?>
		<?php endif; ?>
	</div>
</div>
