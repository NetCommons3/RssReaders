<div class="panel panel-default">
	<div class="panel-body">
		<?php
		echo $this->Form->create(
			'RssReader',
			array(
				'id' => 'form-rss-reader-edit-{{frameId}}',
				'name' => 'rssReader'
			)
		);
		?>

		<div class="form-group" name="url-form-group"
       ng-class="rssReader['data[RssReader][url]'].$valid ? 'has-success' : 'has-error'; ">
			<?php
			// RDF/RSSファイルのURL
			echo $this->Form->label('url', __d('rss_readers', 'RDF/RSS URL'));
			echo $this->Form->input(
				'url',
				array(
					'label' => false,
					'type' => 'text',
					'required' => true,
					'placeholder' => 'http://',
					'class' => 'form-control',
					'ng-model' => 'rssReaderData.RssReader.url',
					'ng-pattern' => '/^(https?)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/'
				)
			);
			?>
			<div class="text-right" style="margin-top: 2px;">
				<button type="button" class="btn btn-info btn-xs" ng-show="getRssInfoBtn"
					ng-click="getRssInfo()"
					ng-disabled="rssReader['data[RssReader][url]'].$error.required || rssReader['data[RssReader][url]'].$error.pattern">
					<?php echo __d('rss_readers', 'Get Site Info'); ?>
				</button>
				<button type="button" class="btn btn-info btn-xs" ng-show="loadingGetRssInfoBtn" ng-disabled="true">
					<?php echo __d('rss_readers', 'Loading...'); ?>
				</button>
			</div>
			<span class="help-block">
				<span class="error"
						ng-hide="rssReader['data[RssReader][url]'].$error.required || rssReader['data[RssReader][url]'].$error.pattern">
					{{getRssInfoErrorMessage}}
				</span>
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
					'ng-model' => 'rssReaderData.RssReader.title'
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
					'ng-model' => 'rssReaderData.RssReader.summary'
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
					'placeholder' => 'http://',
					'ng-model' => 'rssReaderData.RssReader.link',
					'ng-pattern' => '/^(https?)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/'
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
					'style' => 'width: 200px;',
					'ng-model' => 'rssReaderData.RssReader.cache_time'
				)
			);
			?>
		</div>
		<div class="has-error">
			<span class="help-block" ng-show="saveRssReaderError">{{saveRssReaderErrorMessage}}</span>
		</div>
		<?php
		echo $this->Form->input(
			'id',
			array(
				'type' => 'hidden',
				'value' => '{{rssReaderData.RssReader.id}}'
			)
		);
		echo $this->element('RssReaders/edit_hidden_form');
		echo $this->Form->end();
		?>
	</div>
</div>

<p class="text-center">
	<button type="button" class="btn btn-default" ng-click="$close();">
		<span class="glyphicon glyphicon-remove"></span>
		<?php echo __d('net_commons', 'Cancel'); ?>
	</button>

	<?php if ($contentPublishable && isset($rssReaderData['RssReader']['status']) &&
					$rssReaderData['RssReader']['status'] === NetCommonsBlockComponent::STATUS_APPROVED): ?>
		<button type="button" class="btn btn-default"
					ng-disabled="rssReader.$invalid || sending"
					ng-click="saveRssReader(<?php echo NetCommonsBlockComponent::STATUS_DISAPPROVED; ?>)">
			<?php echo __d('net_commons', 'Disapproval'); ?>
		</button>
	<?php else: ?>
		<button type="button" class="btn btn-default"
					ng-disabled="rssReader.$invalid || sending"
					ng-click="saveRssReader(<?php echo NetCommonsBlockComponent::STATUS_DRAFTED; ?>)">
			<?php echo __d('net_commons', 'Save temporally'); ?>
		</button>
	<?php endif; ?>

	<?php if ($contentPublishable): ?>
		<button type="button" class="btn btn-primary"
					ng-disabled="rssReader.$invalid || sending"
					ng-click="saveRssReader(<?php echo NetCommonsBlockComponent::STATUS_PUBLISHED; ?>)">
			<?php echo __d('net_commons', 'OK'); ?>
		</button>
	<?php else: ?>
		<button type="button" class="btn btn-primary"
					ng-disabled="rssReader.$invalid || sending"
					ng-click="saveRssReader(<?php echo NetCommonsBlockComponent::STATUS_APPROVED; ?>)">
			<?php echo __d('net_commons', 'OK'); ?>
		</button>
	<?php endif; ?>
</p>
