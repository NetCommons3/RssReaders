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

<?php echo $this->NetCommonsForm->hidden('Block.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Block.key'); ?>
<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Frame.key'); ?>

<?php echo $this->NetCommonsForm->hidden('RssReader.id'); ?>
<?php echo $this->NetCommonsForm->hidden('RssReader.block_id'); ?>
<?php echo $this->NetCommonsForm->hidden('RssReader.key'); ?>
<?php echo $this->NetCommonsForm->hidden('RssReader.language_id'); ?>

<div class="form-group" ng-class="{'has-error': urlError}">
	<?php echo $this->NetCommonsForm->label('RssReader.url',
				__d('rss_readers', 'RDF/RSS URL'), ['required' => true]); ?>

	<div class="input-group">
		<?php echo $this->NetCommonsForm->input('RssReader.url', array('type' => 'url', 'div' => false)); ?>
		<span class="input-group-btn">
			<button class="btn btn-default" type="button" ng-click="getSiteInfo()" ng-class="{'btn-danger': urlError}">
				<?php echo __d('rss_readers', 'Get Site Info'); ?>
			</button>
		</span>
	</div>

	<div class="help-block" ng-show="urlError" ng-cloak>
		{{urlError}}
	</div>
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
	));
