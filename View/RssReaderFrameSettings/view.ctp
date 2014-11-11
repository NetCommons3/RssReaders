<div
	ng-controller="RssReaderFrameSettings.edit"
	ng-init="initialize(
		<?php echo h(json_encode($rssReaderFrameSettingData)); ?>
	)">
	<?php echo $this->element('manage_tab_header', array('tab' => 'rssReaderFrameSetting')); ?>
	<div class="modal-body">
		<?php echo $this->element('RssReaderFrameSettings/edit_form'); ?>
	</div>
</div>
