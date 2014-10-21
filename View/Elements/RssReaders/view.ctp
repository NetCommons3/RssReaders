<div class="panel panel-default">
	<div class="panel-heading">
		<a href="#" style="display:block;"
			 ng-click="changeSiteInformation()">

			サイト情報
			<span class="label label-danger"
						ng-show="visiblePublish">
				申請中
			</span>
		</a>
	</div>
	<div class="panel-body"
		 ng-show="visibleSiteInformation">

		<div class="row">
			<div class="col-md-3"><?php echo __d('rss_readers', 'Site Title'); ?></div>
			<div class="col-md-9"><?php echo h($this->Form->value('RssReader.title')); ?></div>
		</div>

		<hr />

		<div class="row">
			<div class="col-md-3"><?php echo __d('rss_readers', 'Site Explanation'); ?></div>
			<div class="col-md-9"><?php echo h($this->Form->value('RssReader.summary')); ?></div>
		</div>

		<hr />

		<div class="row">

			<div class="col-md-3"><?php echo __d('rss_readers', 'Site Url'); ?></div>
			<div class="col-md-9">
				<a href="<?php echo h($this->Form->value('RssReader.link')); ?>" target="_blank">
					<?php echo h($this->Form->value('RssReader.link')); ?>
				</a>
			</div>
		</div>
	</div>

</div>
