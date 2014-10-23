<p class="text-right">
	<?php if ($contentPublishable) : ?>
	<button class="btn btn-danger"
		ng-show="(rssReaderData.RssReader.status === '<?php echo RssReader::STATUS_APPROVED ?>')"
		ng-click="updateStatus('<?php echo RssReader::STATUS_PUBLISHED ?>')">
		<span class="">
			<?php echo __d('rss_readers', 'Publish'); ?>
		</span>
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
