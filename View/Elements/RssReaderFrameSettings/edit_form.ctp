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

<?php echo $this->NetCommonsForm->hidden('Frame.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Frame.key'); ?>
<?php echo $this->NetCommonsForm->hidden('RssReaderFrameSetting.id'); ?>
<?php echo $this->NetCommonsForm->hidden('RssReaderFrameSetting.frame_key'); ?>

<?php echo $this->NetCommonsForm->displayNumber('RssReaderFrameSetting.display_number_per_page', array(
		'label' => __d('rss_readers', 'Event Display'),
		'unit' => array(
			'single' => __d('rss_readers', '%d case'),
			'multiple' => __d('rss_readers', '%d cases')
		),
	));
