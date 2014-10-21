<?php echo $this->Html->script('/rss_readers/js/rss_readers.js'); ?>

<div id="nc-rss-readers-container-<?php echo (int)$frameId; ?>"
	ng-controller="RssReaders"
	ng-init="initialize(
		<?php echo h(json_encode($rssReaderData)); ?>,
		<?php echo (int)$frameId; ?>
	)">

	<div id="nc-rss-readers-manage-modal-<?php echo (int)$frameId; ?>" class="modal fade">
		<div class="ng-scope">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button data-dismiss="modal" class="close" type="button">
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
			</div>
		</div>
	</div>

	<div class="row" ng-show="visibleHeaderBtn">
		<?php echo $this->element('RssReaders/header_button'); ?>
	</div>

	<div id="nc-rss-readers-container-<?php echo (int)$frameId; ?>"
		 ng-show="visibleContainer">

		<div>
			<?php echo $this->element('RssReaders/view'); ?>
		</div>
	</div>

	<div id="nc-rss-readers-manage-<?php echo (int)$frameId; ?>" class="ng-hide"
		 ng-show="visibleManage">

		<?php //echo $this->element('RssReaders/index_manage'); ?>

	</div>
</div>
