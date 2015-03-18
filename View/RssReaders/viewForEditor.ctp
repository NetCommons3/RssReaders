<?php
/**
 * RssReaders view for editor template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('/rss_readers/js/rss_readers.js', false); ?>

<div id="nc-rss-readers-<?php echo (int)$frameId; ?>"
		ng-controller="RssReaders"
		ng-init="initialize(<?php echo h(json_encode(['frameId' => $frameId])); ?>)">

	<div class="row form-group">
		<div class="col-xs-6">
			<?php echo $this->element('RssReaders/site_info_button'); ?>
		</div>

		<div class="col-xs-6 text-right">
			<span class="nc-tooltip" tooltip="<?php echo __d('net_commons', 'Edit'); ?>">
				<a href="<?php echo $this->Html->url('/rss_readers/rss_readers/edit/' . $frameId) ?>" class="btn btn-primary">
					<span class="glyphicon glyphicon-edit"> </span>
				</a>
			</span>

			<?php if (Page::isSetting()) : ?>
				<span>
					<a href="<?php echo $this->Html->url('/rss_readers/frame_settings/edit/' . $frameId) ?>" class="btn btn-default">
						<span class="glyphicon glyphicon-cog"> </span>
					</a>
				</span>
			<?php endif; ?>
		</div>
	</div>

	<?php echo $this->element('RssReaders/view_site_info'); ?>

	<?php echo $this->element('RssReaders/view_items'); ?>
</div>
