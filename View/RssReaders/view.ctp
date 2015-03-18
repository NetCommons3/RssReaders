<?php
/**
 * RssReaders view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Html->script('/rss_readers/js/rss_readers.js', false); ?>

<div id="nc-rss-readers-<?php echo (int)$frameId; ?>"
		ng-controller="RssReaders"
		ng-init="initialize(<?php echo h(json_encode(['frameId' => $frameId])); ?>)">

	<div class="form-group">
		<?php echo $this->element('RssReaders/site_info_button'); ?>
	</div>

	<?php echo $this->element('RssReaders/view_site_info'); ?>

	<?php echo $this->element('RssReaders/view_items'); ?>
</div>

