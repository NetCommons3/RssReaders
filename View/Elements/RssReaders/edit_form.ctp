<?php
/**
 * RssReaders edit form element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->hidden('Frame.id', array(
		'value' => $frameId,
	)); ?>

<?php echo $this->Form->hidden('Block.id', array(
		'value' => isset($block['id']) ? $block['id'] : $blockId,
	)); ?>

<?php echo $this->Form->hidden('Block.key', array(
		'value' => isset($block['key']) ? $block['key'] : $blockKey,
	)); ?>

<?php echo $this->Form->hidden('Block.language_id', array(
		'value' => $languageId,
	)); ?>

<?php echo $this->Form->hidden('Block.room_id', array(
		'value' => $roomId,
	)); ?>

<?php echo $this->Form->hidden('Block.plugin_key', array(
		'value' => $this->params['plugin'],
	)); ?>

<?php echo $this->Form->hidden('RssReader.id', array(
		'value' => isset($rssReader['id']) ? (int)$rssReader['id'] : null,
	)); ?>

<?php echo $this->Form->hidden('RssReader.key', array(
		'value' => isset($rssReader['key']) ? $rssReader['key'] : null,
	)); ?>

<?php echo $this->Form->hidden('RssReader.language_id', array(
		'value' => $languageId,
	)); ?>

<div class="form-group">
	<?php echo $this->Form->label('RssReader.url',
			__d('rss_readers', 'RDF/RSS URL') . $this->element('NetCommons.required')
		); ?>

	<div class="input-group">
		<?php echo $this->Form->input(
				'RssReader.url',
				array(
					'type' => 'text',
					'label' => false,
					'error' => false,
					'div' => false,
					'class' => 'form-control',
					'value' => isset($rssReader['url']) ? $rssReader['url'] : null,
					'placeholder' => 'http://',
				)
			); ?>

		<span class="input-group-btn">
			<button class="btn btn-default" type="button" ng-click="getSiteInfo()">
				<?php echo __d('rss_readers', 'Get Site Info'); ?>
			</button>
		</span>
	</div>

	<?php echo $this->element(
		'NetCommons.errors', [
			'errors' => $this->validationErrors,
			'model' => 'RssReader',
			'field' => 'url',
		]); ?>

	<div class="has-error" ng-show="urlError" ng-cloak>
		<div class="help-block">
			{{urlError}}
		</div>
	</div>
</div>

<div class="form-group">
	<?php echo $this->Form->input('RssReader.title', array(
			'type' => 'text',
			'label' => __d('rss_readers', 'Site Title') . $this->element('NetCommons.required'),
			'error' => false,
			'class' => 'form-control',
			'value' => isset($rssReader['title']) ? $rssReader['title'] : null
		)); ?>

	<?php echo $this->element(
		'NetCommons.errors', [
			'errors' => $this->validationErrors,
			'model' => 'RssReader',
			'field' => 'title',
		]); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->input('RssReader.link', array(
			'type' => 'text',
			'label' => __d('rss_readers', 'Site Url'),
			'error' => false,
			'class' => 'form-control',
			'value' => isset($rssReader['link']) ? $rssReader['link'] : null,
			'placeholder' => 'http://',
		)); ?>

	<?php echo $this->element(
		'NetCommons.errors', [
			'errors' => $this->validationErrors,
			'model' => 'RssReader',
			'field' => 'link',
		]); ?>
</div>

<div class="form-group">
	<?php echo $this->Form->input('RssReader.summary', array(
			'type' => 'textarea',
			'label' => __d('rss_readers', 'Site Explanation'),
			'error' => false,
			'class' => 'form-control',
			'value' => isset($rssReader['summary']) ? $rssReader['summary'] : null,
			'rows' => 2,
		)); ?>

	<?php echo $this->element(
		'NetCommons.errors', [
			'errors' => $this->validationErrors,
			'model' => 'RssReader',
			'field' => 'summary',
		]); ?>
</div>
