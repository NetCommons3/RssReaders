<div class="panel panel-default">
	<div class="panel-body">
		<?php
		echo $this->Form->create(
			'RssReader',
			array(
				'id' => 'form-rss-reader-edit-' . $frameId,
				'name' => 'rssReader'
			)
		);
		?>

		<div class='form-group'
			ng-class="rssReader['data[RssReader][url]'].$valid ? 'has-success' : 'has-error'; ">
			<?php
			// RDF/RSSファイルのURL
			echo $this->Form->label('url', __d('rss_readers', 'RDF/RSS URL'));
			echo $this->Form->input(
				'url',
				array(
					'label' => false,
					'type' => 'text',
					'class' => 'form-control',
					'ng-model' => 'url',
					'required' => true,
					'ng-pattern' => '/^(https?)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/',
					'placeholder' => 'http://'
				)
			);
			?>
			<div class="text-right" style="margin-top: 2px;">
				<button type="button" class="btn btn-info btn-xs" ng-click="getRssInfo()">
					<?php echo __d('rss_readers', 'Get Site Info'); ?>
				</button>
			</div>
			<span class="help-block">
				<span class="error"
						ng-show="rssReader['data[RssReader][url]'].$error.required">
					<?php echo __d('rss_readers', 'Required field.');?>
				</span>
				<span class="error"
					  ng-show="rssReader['data[RssReader][url]'].$error.pattern">
					<?php echo __d('rss_readers', 'Invalid URL format.');?>
				</span>
			</span>
		</div>

		<div class='form-group'>
			<?php
			// サイト名
			echo $this->Form->label('title', __d('rss_readers', 'Site Title'));
			echo $this->Form->input(
				'title',
				array(
					'label' => false,
					'type' => 'text',
					'class' => 'form-control',
					'ng-model' => 'title'
				)
			);
			?>
		</div>

		<div class='form-group'>
			<?php
			// 説明
			echo $this->Form->label('summary', __d('rss_readers', 'Site Explanation'));
			echo $this->Form->input(
				'summary',
				array(
					'label' => false,
					'type' => 'textarea',
					'rows' => 2,
					'class' => 'form-control',
					'ng-model' => 'summary'
				)
			);
			?>
		</div>

		<div class='form-group'
			ng-class="rssReader['data[RssReader][link]'].$valid ? 'has-success' : 'has-error'; ">
			<?php
			// サイトURL
			echo $this->Form->label('link', __d('rss_readers', 'Site Url'));
			echo $this->Form->input(
				'link',
				array(
					'label' => false,
					'type' => 'text',
					'class' => 'form-control',
					'ng-model' => 'link',
					'ng-pattern' => '/^(https?)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/',
					'placeholder' => 'http://'
				)
			);
			?>
			<span class="help-block">
				<span class="error"
					  ng-show="rssReader['data[RssReader][link]'].$error.pattern">
					<?php echo __d('rss_readers', 'Invalid URL format.');?>
				</span>
			</span>
		</div>

		<div class='form-group'>
			<?php
			// キャッシュ時間
			echo $this->Form->label('cache_time', __d('rss_readers', 'Chache Time'));
			echo $this->Form->input(
				'cache_time',
				array(
					'label' => false,
					'type' => 'select',
					'options' => array(
						'1800' => __d('rss_readers', '%dminutes', 30),
						'3600' => __d('rss_readers', '%dhours', 1),
						'21600' => __d('rss_readers', '%dhours', 6),
						'43200' => __d('rss_readers', '%dhours', 12),
						'86400' => __d('rss_readers', '%ddays', 1),
						'259200' => __d('rss_readers', '%ddays', 3),
						'604800' => __d('rss_readers', '%dweeks', 1),
						'2592000' => __d('rss_readers', '%dmonths', 1)
					),
					'class' => 'form-control',
					'style' => 'width: 200px;'
				)
			);
			?>
		</div>
		<?php
		echo $this->Form->hidden('id');
		echo $this->Form->hidden('Block.id');
		echo $this->Form->hidden('Block.room_id', array('value' => (int)$roomId));
		echo $this->Form->hidden('Block.language_id', array('value' => (int)$languageId));
		echo $this->Form->hidden('Frame.id', array('value' => (int)$frameId));
		echo $this->Form->end();
		?>
	</div>
</div>

<p class="text-center">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		<?php echo __d('rss_readers', 'Cancel'); ?>
	</button>
	<button type="button" class="btn btn-default" data-dismiss="modal"
				ng-disabled="rssReader.$invalid"
				ng-click="saveRssReader(<?php echo RssReader::STATUS_DRAFTED; ?>)">
		<?php echo __d('rss_readers', 'Draft'); ?>
	</button>
	<button type="button" class="btn btn-primary" data-dismiss="modal"
				ng-disabled="rssReader.$invalid"
				ng-click="saveRssReader(<?php echo RssReader::STATUS_PUBLISHED; ?>)">
		<?php echo __d('rss_readers', 'Release'); ?>
	</button>
</p>
