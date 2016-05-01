<?php
/**
 * ブロック編集Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->NetCommonsForm->create('RssReader'); ?>
	<div class="panel panel-default">
		<div class="panel-body has-feedback">
			<?php echo $this->element('Blocks.form_hidden'); ?>
			<?php echo $this->element('RssReaders.RssReaders/edit_form'); ?>
			<?php echo $this->element('Blocks.public_type'); ?>

			<hr />

			<?php echo $this->Workflow->inputComment('RssReader.status', false); ?>
		</div>

		<?php echo $this->Workflow->buttons('RssReader.status', NetCommonsUrl::backToIndexUrl('default_setting_action')); ?>
	</div>
<?php echo $this->NetCommonsForm->end();
