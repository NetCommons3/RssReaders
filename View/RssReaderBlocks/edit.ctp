<?php
/**
 * ブロック編集View
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->script('/rss_readers/js/rss_readers.js');
?>

<article class="block-setting-body"
		ng-controller="RssReaders"
		ng-init="initialize(<?php echo h(json_encode(['frameId' => Current::read('Frame.id')])); ?>)">

	<?php echo $this->BlockTabs->main(BlockTabsHelper::MAIN_TAB_BLOCK_INDEX); ?>

	<div class="tab-content">
		<?php echo $this->BlockTabs->block(BlockTabsHelper::BLOCK_TAB_SETTING); ?>

		<?php echo $this->element('RssReaderBlocks/edit_form'); ?>

		<?php echo $this->Workflow->comments(); ?>

		<?php echo $this->BlockForm->displayDeleteForm(array(
				'callback' => 'RssReaders.RssReaderBlocks/delete_form',
			)); ?>
	</div>
</article>
