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

echo $this->NetCommonsHtml->css('/rss_readers/css/style.css');
?>

<?php echo $this->element('Blocks.form_hidden'); ?>

<?php echo $this->NetCommonsForm->hidden('Block.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Block.key'); ?>
<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Frame.key'); ?>

<?php echo $this->NetCommonsForm->hidden('RssReader.id'); ?>
<?php echo $this->NetCommonsForm->hidden('RssReader.block_id'); ?>
<?php echo $this->NetCommonsForm->hidden('RssReader.key'); ?>
<?php echo $this->NetCommonsForm->hidden('RssReader.language_id'); ?>

<?php echo $this->NetCommonsForm->hidden('RssReaderSetting.id'); ?>
<?php echo $this->NetCommonsForm->hidden('RssReaderSetting.use_workflow'); ?>

<div class="form-group" ng-class="{'has-error': urlError}"
		ng-init="urlError='<?php echo $this->Form->error('RssReader.url', null, ['wrap' => false]); ?>'">

	<?php echo $this->NetCommonsForm->input('RssReader.url',
			array(
				'type' => 'text',
				'label' => __d('rss_readers', 'RDF/RSS URL'),
				'div' => false,
				'placeholder' => 'http://',
				'required' => true,
				'error' => false
			)
		); ?>

	<div class="help-block" ng-show="urlError" ng-cloak>
		{{urlError}}
	</div>
</div>

<div class="form-group text-center">
	<button class="btn btn-default btn-sm rss-reader-getbtn" type="button" ng-click="getSiteInfo()">
		<?php echo __d('rss_readers', 'Get Site Info'); ?>
	</button>
</div>

<?php echo $this->NetCommonsForm->input('RssReader.title', array(
		'label' => __d('rss_readers', 'Site Title'),
		'required' => true,
	)); ?>

<?php echo $this->NetCommonsForm->input('RssReader.link', array(
		'type' => 'url',
		'label' => __d('rss_readers', 'Site Url'),
	)); ?>

<?php echo $this->NetCommonsForm->input('RssReader.summary', array(
		'type' => 'textarea',
		'label' => __d('rss_readers', 'Site Explanation'),
		'rows' => 2,
	)); ?>

<?php if (Current::permission('block_editable')) : ?>
	<?php echo $this->element('Blocks.public_type'); ?>
	<?php echo $this->element(
			'Blocks.modifed_info',
			array('displayModified' => (bool)Hash::get($this->request->data, 'RssReader.id'))
		); ?>
<?php endif;

