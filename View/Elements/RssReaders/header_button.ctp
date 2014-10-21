<div class="text-right col-xs-12">
	<button class="btn btn-danger"
				ng-click="showPublish()"
				ng-show="visiblePublish">
		<span class="">
			<?php echo __d('rss_readers', 'Release'); ?>
		</span>
	</button>

	<?php if (Page::isSetting()) : ?>
	<button class="btn btn-primary"
			ng-click="showManage()"
			ng-hide="visibleManage"
		tooltip="<?php echo __d('rss_readers', 'Manage'); ?>">
		<span class="glyphicon glyphicon-cog">
		</span>
		<span class="hidden">
			<?php echo __d('rss_readers', 'Manage'); ?>
		</span>
	</button>
	<?php endif; ?>
</div>
