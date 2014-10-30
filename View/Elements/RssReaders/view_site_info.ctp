<div class="panel panel-default" id ="nc-rss-readers-site-info-<?php echo h($frameId); ?>">
	<div class="panel-heading">
	<span><?php echo __d('rss_readers', 'Site Info'); ?></span>
		<span class="label label-success ng-hide"
			ng-init="label.publish=<?php echo ($rssReaderData['RssReader']['status'] === RssReader::STATUS_PUBLISHED ? 'true' : 'false'); ?>"
			ng-show="label.publish">
			<?php echo __d('rss_readers', 'Publishing'); ?>
		</span>
	
		<span class="label label-danger ng-hide"
			ng-init="label.approval=<?php echo ($rssReaderData['RssReader']['status'] === RssReader::STATUS_APPROVED ? 'true' : 'false'); ?>"
			ng-show="label.approval">
			<?php echo __d('rss_readers', 'Approving'); ?>
		</span>
	
		<span class="label label-info ng-hide"
			ng-init="label.draft=<?php echo ($rssReaderData['RssReader']['status'] === RssReader::STATUS_DRAFTED ? 'true' : 'false'); ?>"
			ng-show="label.draft">
			<?php echo __d('rss_readers', 'Drafting'); ?>
		</span>
	
		<span class="label label-warning ng-hide"
			ng-init="label.disapproval=<?php echo ($rssReaderData['RssReader']['status'] === RssReader::STATUS_DISAPPROVED ? 'true' : 'false'); ?>"
			ng-show="label.disapproval">
			<?php echo __d('rss_readers', 'Disapprovign'); ?>
		</span>
	</div>
	<div class="panel-body"
		 ng-show="visibleSiteInformation">

		<div class="row">
			<div class="col-md-3"><?php echo __d('rss_readers', 'Site Title'); ?></div>
			<div class="col-md-9"><?php echo h($rssReaderData['RssReader']['title']); ?></div>
		</div>

		<hr />

		<div class="row">
			<div class="col-md-3"><?php echo __d('rss_readers', 'Site Explanation'); ?></div>
			<div class="col-md-9"><?php echo h($rssReaderData['RssReader']['summary']); ?></div>
		</div>

		<hr />

		<div class="row">

			<div class="col-md-3"><?php echo __d('rss_readers', 'Site Url'); ?></div>
			<div class="col-md-9">
				<a href="<?php echo h($rssReaderData['RssReader']['link']); ?>" target="_blank">
					<?php echo h($rssReaderData['RssReader']['link']); ?>
				</a>
			</div>
		</div>
	</div>
</div>
