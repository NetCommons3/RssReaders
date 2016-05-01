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

<div class="inline-block">
	<?php echo sprintf(__d('net_commons', 'Delete all data associated with the %s.'), __d('rss_readers', 'RDF/RSS')); ?>
</div>
<?php echo $this->Form->hidden('Block.id'); ?>
<?php echo $this->Form->hidden('Block.key'); ?>
<?php echo $this->Form->hidden('RssReader.key'); ?>

<?php echo $this->Button->delete(
		__d('net_commons', 'Delete'),
		sprintf(__d('net_commons', 'Deleting the %s. Are you sure to proceed?'), __d('rss_readers', 'RDF/RSS')),
		array('addClass' => 'pull-right')
	);
