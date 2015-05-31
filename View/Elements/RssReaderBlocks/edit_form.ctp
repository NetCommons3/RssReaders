<?php
/**
 * Blocks edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->create('Blocks', array('novalidate' => true)); ?>
	<div class="panel panel-default" >
		<div class="panel-body has-feedback">
			<?php echo $this->element('RssReaders/edit_form'); ?>

			<?php echo $this->element('Blocks.public_type'); ?>

			<hr />

			<?php echo $this->element('Comments.form', array(
				'contentStatus' => $rssReader['status']
			)); ?>
		</div>

		<div class="panel-footer text-center">
			<?php echo $this->element('NetCommons.workflow_buttons', array(
				'cancelUrl' => 'rss_readers/rss_reader_blocks/index/' . $frameId,
				'contentStatus' => $rssReader['status']
			)); ?>
		</div>
	</div>
<?php echo $this->Form->end();
