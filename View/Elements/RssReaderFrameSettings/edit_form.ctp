<div class="panel">
	<div class="panel-body">
		<?php
		echo $this->Form->create(
			'RssReaderFrameSetting',
			array(
				'name' => 'rssReaderFrameSetting'
			)
		);
		?>
		<div class='form-group'>
			<?php
			// 表示件数
			echo $this->Form->label(
				'RssReaderFrameSetting.display_number_per_page',
				__d('rss_readers', 'Event Display')
			);
			echo $this->Form->input(
				'RssReaderFrameSetting.display_number_per_page',
				array(
					'label' => false,
					'type' => 'select',
					'options' => array(
						1 => __d('rss_readers', '%dcases', 1),
						5 => __d('rss_readers', '%dcases', 5),
						10 => __d('rss_readers', '%dcases', 10),
						20 => __d('rss_readers', '%dcases', 20),
						50 => __d('rss_readers', '%dcases', 50),
						100 => __d('rss_readers', '%dcases', 100)
					),
					'class' => 'form-control',
					'style' => 'width: 200px;',
					'ng-model' => 'edit.data.RssReaderFrameSetting.display_number_per_page'
				)
			);
			?>
		</div>
		<div class='form-group'>
			<?php
			echo $this->Form->input(
				'RssReaderFrameSetting.display_site_info',
				array(
					'label' => __d('rss_readers', 'Display Site Info'),
					'type' => 'checkbox',
					'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
					'ng-model' => 'edit.data.RssReaderFrameSetting.display_site_info'
				)
			);
			?>
		</div>
		<div class='form-group'>
			<?php
			echo $this->Form->input(
				'RssReaderFrameSetting.display_summary',
				array(
					'label' => __d('rss_readers', 'Display Summary'),
					'type' => 'checkbox',
					'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;'),
					'ng-model' => 'edit.data.RssReaderFrameSetting.display_summary'
				)
			);
			?>
		</div>
		<div class="has-error">
			<span class="help-block" ng-show="saveRssReaderFrameError">
				{{saveRssReaderErrorMessage}}
			</span>
		</div>
		<?php
		echo $this->Form->input(
			'RssReaderFrameSetting.id',
			array(
				'type' => 'hidden',
				'value' => '{{edit.data.RssReaderFrameSetting.id}}'
			)
		);
		echo $this->Form->input(
			'RssReaderFrameSetting.frame_key',
			array(
				'type' => 'hidden',
				'value' => '{{edit.data.RssReaderFrameSetting.frame_key}}'
			)
		);
		echo $this->Form->end();
		?>
	</div>
</div>
<p class="text-center">
	<button type="button" class="btn btn-default" ng-click="$close();">
		<span class="glyphicon glyphicon-remove"></span>
		<?php echo __d('net_commons', 'Cancel'); ?>
	</button>
	<button type="button" class="btn btn-primary"
		ng-click="saveRssReaderFrameSettig()" ng-disabled="sending">
		<?php echo __d('net_commons', 'OK'); ?>
	</button>
</p>
