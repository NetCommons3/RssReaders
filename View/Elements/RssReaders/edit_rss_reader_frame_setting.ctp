<div class="panel">
	<div class="panel-body">
		<?php
		echo $this->Form->create(
			'RssReaderFrameSetting',
			array(
				'id' => 'form-rss-reader-frame-setting-edit' . $frameId,
				'name' => 'rssReaderFrameSetting'
			)
		);
		?>
		<div class='form-group'>
			<?php
			// 表示件数
			echo $this->Form->label('url', __d('rss_readers', 'Event Display'));
			echo $this->Form->input(
				'display_number_per_page',
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
					'style' => 'width: 200px;'
				)
			);
			?>
		</div>
		<div class='form-group'>
			<?php
			echo $this->Form->input(
				'display_site_info',
				array(
					'label' => __d('rss_readers', 'Display Site Info'),
					'type' => 'checkbox',
					'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;')
				)
			);
			?>
		</div>
		<div class='form-group'>
			<?php
			echo $this->Form->input(
				'display_summary',
				array(
					'label' => __d('rss_readers', 'Display Summary'),
					'type' => 'checkbox',
					'div' => array('class' => 'bold', 'style' => 'margin-left: 0px;')
				)
			);
			?>
		</div>
		<?php
		echo $this->Form->hidden('id');
		echo $this->Form->hidden('frame_key');
		echo $this->Form->end();
		?>
	</div>
</div>
<p class="text-center">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		<?php echo __d('rss_readers', 'Cancel'); ?>
	</button>
	<button type="button" class="btn btn-primary" data-dismiss="modal"
		ng-click="saveRssReaderFrameSettig()">
		<?php echo __d('rss_readers', 'Setting'); ?>
	</button>
</p>
