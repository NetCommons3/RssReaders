<div
	ng-controller="RssReaders.edit"
	ng-init="initialize(
		<?php echo h(json_encode($rssReaderData)); ?>
	)">
	<?php echo $this->element('manage_tab_header', array('tab' => 'rssReader')); ?>
	<div class="modal-body">
		<?php echo $this->element('RssReaders/edit_form'); ?>
	</div>
</div>
