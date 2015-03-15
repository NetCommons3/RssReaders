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

<?php echo $this->Form->hidden('id'); ?>

<?php echo $this->Form->hidden('Frame.id', array(
	'value' => $frameId
)); ?>

<?php echo $this->Form->hidden('Block.id', array(
	'value' => $blockId,
)); ?>

<div class="row form-group">
	<div class="col-xs-12">
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
						'class' => 'form-control',
						'value' => (isset($rssReader['url']) ? $rssReader['url'] : ''),
						'placeholder' => 'http://',
					)
				); ?>

			<span class="input-group-btn">
				<button class="btn btn-default" type="button" ng-click="getSiteInfo()">
					<?php echo __d('rss_readers', 'Get Site Info'); ?>
				</button>
			</span>
		</div>
	</div>

	<div class="col-xs-12">
		<?php echo $this->element(
			'RssReaders.errors', [
				'errors' => $this->validationErrors,
				'model' => 'RssReader',
				'field' => 'url',
			]); ?>
	</div>
</div>

<?php echo $this->element('RssReaders/input_field', array(
			'model' => 'RssReader',
			'field' => 'title',
			'label' => __d('rss_readers', 'Site Title') . $this->element('NetCommons.required'),
		)
	); ?>

<?php echo $this->element('RssReaders/input_field', array(
			'model' => 'RssReader',
			'field' => 'link',
			'label' => __d('rss_readers', 'Site Url'),
			'attributes' => array(
				'placeholder' => 'http://',
			),
		)
	); ?>

<?php echo $this->element('RssReaders/input_field', array(
			'model' => 'RssReader',
			'field' => 'summary',
			'label' => __d('rss_readers', 'Site Explanation'),
			'attributes' => array(
				'type' => 'textarea',
				'rows' => 2,
			),
		)
	);
