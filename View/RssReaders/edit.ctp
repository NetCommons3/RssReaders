<div ng-controller="RssReaders.edit"
	ng-init="initialize(
		<?php echo h(json_encode($rssReaderData)); ?>,
		<?php echo h(json_encode($rssReaderFrameData)); ?>,
		<?php echo (int)$frameId; ?>
	)">
	<div class="modal-header">
		<button ng-click="$close();" type="button" class="close"
			tooltip="<?php echo __d('net_commons', 'Close'); ?>">
			<span aria-hidden="true">×</span>
			<span class="sr-only">Close</span>
		</button>
		<h4 id="myModalLabel" class="modal-title">
			<?php echo __d('rss_readers', 'Edit'); ?>
		</h4>
	</div>
	<div class="modal-body">
		<?php echo $this->element('RssReaders/index_manage'); ?>
	</div>
</div>
