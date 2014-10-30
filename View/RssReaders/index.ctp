<?php
echo $this->Html->script('/rss_readers/js/rss_readers.js');
echo $this->Html->css('/rss_readers/css/rss_readers.css');
?>

<div id="nc-rss-readers-container-<?php echo h($frameId); ?>"
	ng-controller="RssReaders"
	ng-init="initialize(
		<?php echo h(json_encode($rssReaderData)); ?>,
		<?php echo h($frameId); ?>
	)">

	<div>
		<?php echo $this->element('RssReaders/header_button'); ?>
	</div>

	<?php if (!empty($rssReaderData)): ?>
	<div id="nc-rss-readers-body-<?php echo h($frameId); ?>">
		<div>
			<?php echo $this->element('RssReaders/view'); ?>
		</div>
	</div>
	<?php endif; ?>
</div>
