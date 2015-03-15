<?php
/**
 * FrameSettings edit form element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->hidden('Frame.id', array(
	'value' => (int)$frameId
)); ?>

<?php echo $this->Form->hidden('Block.id', array(
	'value' => (int)$blockId,
)); ?>

<?php echo $this->Form->hidden('RssReaderFrameSetting.id', array(
	'value' => isset($rssReaderFrameSetting['id']) ? (int)$rssReaderFrameSetting['id'] : '',
)); ?>

<?php echo $this->Form->hidden('RssReaderFrameSetting.frame_key', array(
	'value' => isset($rssReaderFrameSetting['frameKey']) ? $rssReaderFrameSetting['frameKey'] : '',
)); ?>

<div class="row form-group">
	<div class="col-xs-12">
		<?php echo $this->Form->label(
				'RssReaderFrameSetting.display_number_per_page',
				__d('rss_readers', 'Event Display')
			); ?>
	</div>
	<div class="col-xs-12 col-sm-4">
		<?php
			echo $this->Form->select(
				'RssReaderFrameSetting.display_number_per_page',
				array(
					1 => __d('rss_readers', '%dcases', 1),
					5 => __d('rss_readers', '%dcases', 5),
					10 => __d('rss_readers', '%dcases', 10),
					20 => __d('rss_readers', '%dcases', 20),
					50 => __d('rss_readers', '%dcases', 50),
					100 => __d('rss_readers', '%dcases', 100)
				),
				array(
					'class' => 'form-control',
					'value' => (int)$rssReaderFrameSetting['displayNumberPerPage'],
					'legend' => false,
					'empty' => false,
				)
			);
		?>
	</div>
</div>
