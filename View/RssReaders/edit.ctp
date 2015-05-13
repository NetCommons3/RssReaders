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

<?php echo $this->Html->script('/rss_readers/js/rss_readers.js', false); ?>

<div id="nc-rss-readers-<?php echo $frameId; ?>"
		ng-controller="RssReaders"
		ng-init="initialize(<?php echo h(json_encode(['frameId' => $frameId])); ?>)">

	<?php echo $this->Form->create('RssReadears', array(
			'name' => 'form',
			'novalidate' => true,
		)); ?>

		<div class="modal-body">
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
		</div>

	<?php echo $this->Form->end(); ?>
</div>
