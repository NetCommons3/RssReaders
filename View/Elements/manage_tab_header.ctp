<div class="modal-header">
	<button class="close" type="button"
			tooltip="<?php echo __d('net_commons', 'Close'); ?>"
			ng-click="cancel()">
		<span class="glyphicon glyphicon-remove small"></span>
	</button>

	<ul class="nav nav-pills">
		<li <?php echo ($tab === 'rssReader' ? 'class="active"' : ''); ?>>
			<a href="#" ng-click="changeTab('rssReader');">
				<?php echo __d('rss_readers', 'Edit RSS'); ?>
			</a>
		</li>
		<li <?php echo ($tab === 'rssReaderFrameSetting' ? 'class="active"' : ''); ?>>
			<a href="#" ng-click="changeTab('rssReaderFrameSetting');">
				<?php echo __d('rss_readers', 'Change Indication Method'); ?>
			</a>
		</li>
		<li>
			<a href="#">
				<?php echo __d('rss_readers', 'Set Up Email'); ?>
			</a>
		</li>
	</ul>
</div>
