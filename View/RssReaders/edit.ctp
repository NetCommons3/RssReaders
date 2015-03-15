<?php
/**
 * RssReaders edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>
<?php echo $this->Html->meta(
		array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, user-scalable=no'),
		null,
		array('inline' => false)
	); ?>

<?php echo $this->Html->script('/rss_readers/js/rss_readers.js', false); ?>

<div id="nc-rss-readers-<?php echo (int)$frameId; ?>"
		ng-controller="RssReaders"
		ng-init="initialize(<?php echo h(json_encode(['frameId' => $frameId])); ?>)">

	<?php $this->start('title'); ?>
	<?php echo __d('rss_readers', 'Plugin name'); ?>
	<?php $this->end(); ?>

	<?php $this->startIfEmpty('tabs'); ?>
	<li ng-class="{active:tab.isSet(0)}">
		<a href="" role="tab" data-toggle="tab">
			<?php echo __d('rss_readers', 'Rss readers edit'); ?>
		</a>
	</li>
	<?php $this->end(); ?>

	<div class="modal-header">
		<?php $title = $this->fetch('title'); ?>
		<?php if ($title) : ?>
			<?php echo $title; ?>
		<?php else : ?>
			<br />
		<?php endif; ?>
	</div>

	<div class="modal-body">
		<?php $tabs = $this->fetch('tabs'); ?>
		<?php if ($tabs) : ?>
			<ul class="nav nav-tabs" role="tablist">
				<?php echo $tabs; ?>
			</ul>
			<br />
			<?php $tabId = $this->fetch('tabIndex'); ?>
			<div class="tab-content" ng-init="tab.setTab(<?php echo (int)$tabId; ?>)">
		<?php endif; ?>

		<?php echo $this->Form->create('RssReader', array(
			'name' => 'form',
			'novalidate' => true
		)); ?>

			<div class="panel panel-default">
				<div class="panel-body has-feedback">
					<?php echo $this->element('RssReaders/edit_form'); ?>

					<hr />

					<?php echo $this->element('Comments.form'); ?>

				</div>

				<div class="panel-footer text-center">
					<?php echo $this->element('NetCommons.workflow_buttons'); ?>
				</div>
			</div>

			<?php echo $this->element('Comments.index'); ?>

		<?php echo $this->Form->end(); ?>
	</div>

</div>
