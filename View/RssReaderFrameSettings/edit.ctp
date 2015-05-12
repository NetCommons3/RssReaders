<?php
/**
 * FrameSettings edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="modal-body">
	<?php echo $this->element('NetCommons.setting_tabs', $settingTabs); ?>

	<div class="tab-content">
		<?php echo $this->element('Blocks.edit_form', array(
				'controller' => 'RssReaderFrameSettings',
				'action' => 'edit' . '/' . $frameId,
				'callback' => 'RssReaders.RssReaderFrameSettings/edit_form',
				'cancelUrl' => '/' . $cancelUrl,
			)); ?>
	</div>
</div>





