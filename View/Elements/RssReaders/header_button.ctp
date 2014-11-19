<p class="text-right">
	<?php if ($contentPublishable) : ?>
	<button type="button" class="btn btn-warning"
			tooltip="<?php echo __d('net_commons', 'Accept'); ?>"
			ng-controller="RssReaders.edit"
			ng-show="(rssReaderData.RssReader.status === '<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>')"
			ng-click="initialize(
				<?php echo h(json_encode($rssReaderData)); ?>,
				<?php echo h($blockId); ?>,
				<?php echo h($roomId); ?>,
				<?php echo h($languageId); ?>); updateStatus('<?php echo NetCommonsBlockComponent::STATUS_PUBLISHED ?>')">
		<span class="glyphicon glyphicon-ok"></span>
	</button>
	<?php endif; ?>

	<?php if ($contentEditable) : ?>
	<button class="btn btn-primary"
			ng-click="showManage()"
			tooltip="<?php echo __d('rss_readers', 'Manage'); ?>">
		<span class="glyphicon glyphicon-cog">
		</span>
		<span class="hidden">
			<?php echo __d('rss_readers', 'Manage'); ?>
		</span>
	</button>
	<?php endif; ?>
</p>
